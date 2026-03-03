<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Department;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $domains = Domain::orderBy('name')->get();
        
        return view('submissions.create', compact('departments', 'domains'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'archive_type' => 'required|in:Research,Article,Capstone,Thesis',
            'author_role' => 'required|in:Student,Faculty',
            'department' => 'required|string',
            'batch' => 'nullable|string|max:100',
            'academic_session' => 'nullable|string|max:100',
            'research_domains' => 'nullable|array',
            'custom_domain' => 'nullable|string|max:200',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string|max:200',
            'external_links' => 'nullable|array',
            'external_links.*' => 'nullable|url',
            'pdf_url' => 'nullable|url',
            'drive_links' => 'nullable|array',
            'drive_links.*' => 'nullable|url',
            'abstract' => 'nullable|string',
            'author_comments' => 'nullable|string',
        ]);

        // Add custom domain to research domains
        $domains = $validated['research_domains'] ?? [];
        if (!empty($validated['custom_domain'])) {
            $domains[] = $validated['custom_domain'];
        }

        // Filter out empty values
        $authors = array_filter($validated['authors']);
        $externalLinks = array_filter($validated['external_links'] ?? []);
        $driveLinks = array_filter($validated['drive_links'] ?? []);

        $submission = Submission::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'archive_type' => $validated['archive_type'],
            'author_role' => $validated['author_role'],
            'department' => $validated['department'],
            'batch' => $validated['batch'],
            'academic_session' => $validated['academic_session'],
            'research_domains' => $domains,
            'authors' => $authors,
            'external_links' => $externalLinks,
            'pdf_url' => $validated['pdf_url'],
            'drive_links' => $driveLinks,
            'abstract' => $validated['abstract'],
            'author_comments' => $validated['author_comments'],
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Submission created successfully! It will be reviewed by an administrator.');
    }

    public function show($id)
    {
        $submission = Submission::with('user')->findOrFail($id);
        
        // Check permission
        if (Auth::id() !== $submission->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('submissions.show', compact('submission'));
    }

    public function edit($id)
    {
        $submission = Submission::findOrFail($id);
        
        // Only owner or admin can edit
        if (Auth::id() !== $submission->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $departments = Department::orderBy('name')->get();
        $domains = Domain::orderBy('name')->get();
        
        return view('submissions.edit', compact('submission', 'departments', 'domains'));
    }

    public function update(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        // Only owner or admin can edit
        if (Auth::id() !== $submission->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'archive_type' => 'required|in:Research,Article,Capstone,Thesis',
            'author_role' => 'required|in:Student,Faculty',
            'department' => 'required|string',
            'batch' => 'nullable|string|max:100',
            'academic_session' => 'nullable|string|max:100',
            'research_domains' => 'nullable|array',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string|max:200',
            'external_links' => 'nullable|array',
            'external_links.*' => 'nullable|url',
            'pdf_url' => 'nullable|url',
            'drive_links' => 'nullable|array',
            'drive_links.*' => 'nullable|url',
            'abstract' => 'nullable|string',
            'author_comments' => 'nullable|string',
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
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Submission updated successfully!');
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        
        // Only owner or admin can delete
        if (Auth::id() !== $submission->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $submission->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Submission deleted successfully!');
    }
}
