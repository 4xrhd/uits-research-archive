<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Department;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function archive(Request $request)
    {
        $query = Submission::with('user')
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhereJsonContains('authors', $search)
                  ->orWhereJsonContains('research_domains', $search);
            });
        }

        // Filters
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('archive_type', $request->type);
        }

        if ($request->filled('department') && $request->department !== 'all') {
            $query->where('department', $request->department);
        }

        if ($request->filled('domain') && $request->domain !== 'all') {
            $query->whereJsonContains('research_domains', $request->domain);
        }

        if ($request->filled('session') && $request->session !== 'all') {
            $query->where('academic_session', $request->session);
        }

        $submissions = $query->paginate(12);
        $departments = Department::orderBy('name')->get();
        $domains = Domain::orderBy('name')->get();
        $sessions = Submission::where('status', 'Approved')
            ->whereNotNull('academic_session')
            ->distinct()
            ->orderBy('academic_session', 'desc')
            ->pluck('academic_session');

        return view('archive', compact('submissions', 'departments', 'domains', 'sessions'));
    }

    public function show($id)
    {
        $submission = Submission::with('user')->findOrFail($id);
        
        // Only show if approved or user is owner/admin
        if ($submission->status !== 'Approved' && 
            (!auth()->check() || 
             (auth()->id() !== $submission->user_id && auth()->user()->role !== 'admin'))) {
            abort(403, 'This submission is not public yet.');
        }

        return view('archive.show', compact('submission'));
    }

    public function search(Request $request)
    {
        $results = Submission::where('status', 'Approved')
            ->where(function($query) use ($request) {
                $search = $request->q;
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('abstract', 'like', "%{$search}%")
                      ->orWhereJsonContains('authors', $search)
                      ->orWhereJsonContains('research_domains', $search);
            })
            ->limit(10)
            ->get(['id', 'title', 'archive_type', 'department']);

        return response()->json($results);
    }
}
