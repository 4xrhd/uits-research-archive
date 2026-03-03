<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Submission::count(),
            'pending' => Submission::where('status', 'Pending')->count(),
            'approved' => Submission::where('status', 'Approved')->count(),
            'rejected' => Submission::where('status', 'Rejected')->count(),
            'by_type' => [
                'Research' => Submission::where('archive_type', 'Research')->count(),
                'Article' => Submission::where('archive_type', 'Article')->count(),
                'Capstone' => Submission::where('archive_type', 'Capstone')->count(),
                'Thesis' => Submission::where('archive_type', 'Thesis')->count(),
            ]
        ];

        $recentSubmissions = Submission::with('user')
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions'));
    }

    public function submissions(Request $request)
    {
        $query = Submission::with('user')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(20);
        
        return view('admin.submissions', compact('submissions'));
    }

    public function review(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);
        
        $submission->update([
            'status' => $validated['status'],
            'admin_remarks' => $validated['remarks'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::user()->name,
        ]);

        return redirect()->back()
            ->with('success', "Submission {$validated['status']} successfully!");
    }

    public function editSubmission($id)
    {
        $submission = Submission::with('user')->findOrFail($id);
        $departments = \App\Models\Department::orderBy('name')->get();
        $domains = \App\Models\Domain::orderBy('name')->get();
        
        return view('admin.edit-submission', compact('submission', 'departments', 'domains'));
    }

    public function updateSubmission(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'archive_type' => 'required|in:Research,Article,Capstone,Thesis',
            'author_role' => 'required|in:Student,Faculty',
            'department' => 'required|string',
            'batch' => 'nullable|string|max:100',
            'academic_session' => 'nullable|string|max:100',
            'research_domains' => 'nullable|array',
            'authors' => 'required|array|min:1',
            'external_links' => 'nullable|array',
            'pdf_url' => 'nullable|url',
            'drive_links' => 'nullable|array',
            'abstract' => 'nullable|string',
            'author_comments' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected',
            'admin_remarks' => 'nullable|string',
        ]);

        $submission->update([
            'title' => $validated['title'],
            'archive_type' => $validated['archive_type'],
            'author_role' => $validated['author_role'],
            'department' => $validated['department'],
            'batch' => $validated['batch'],
            'academic_session' => $validated['academic_session'],
            'research_domains' => $validated['research_domains'] ?? [],
            'authors' => array_filter($validated['authors']),
            'external_links' => array_filter($validated['external_links'] ?? []),
            'pdf_url' => $validated['pdf_url'],
            'drive_links' => array_filter($validated['drive_links'] ?? []),
            'abstract' => $validated['abstract'],
            'author_comments' => $validated['author_comments'],
            'status' => $validated['status'],
            'admin_remarks' => $validated['admin_remarks'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::user()->name,
        ]);

        return redirect()->route('admin.submissions')
            ->with('success', 'Submission updated successfully!');
    }

    public function statistics()
    {
        $stats = [
            'total_submissions' => Submission::count(),
            'total_users' => User::count(),
            'submissions_by_month' => Submission::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get(),
            'submissions_by_department' => Submission::select('department', DB::raw('COUNT(*) as count'))
                ->where('status', 'Approved')
                ->groupBy('department')
                ->orderBy('count', 'desc')
                ->get(),
        ];

        return view('admin.statistics', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    public function toggleUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,faculty,student',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', "User role updated to {$validated['role']} successfully!");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        try {
            // This might fail if user has submissions and no ON DELETE CASCADE
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cannot delete user because they have associated records (like submissions).');
        }
    }
}
