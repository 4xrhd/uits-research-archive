cat > resources/views/admin/show.blade.php << 'EOF'
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Submission Details</h1>
                <div>
                    <a href="{{ route('admin.submissions') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Submission Details -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Submission Information</h6>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-3">{{ $submission->title }}</h4>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Type:</strong> 
                                        <span class="badge badge-info">{{ $submission->archive_type }}</span>
                                    </p>
                                    <p><strong>Author Role:</strong> {{ $submission->author_role }}</p>
                                    <p><strong>Department:</strong> {{ $submission->department }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> 
                                        @if($submission->status == 'Approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($submission->status == 'Rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </p>
                                    <p><strong>Submitted:</strong> {{ $submission->created_at->format('M d, Y H:i') }}</p>
                                    @if($submission->reviewed_at)
                                        <p><strong>Reviewed:</strong> {{ $submission->reviewed_at->format('M d, Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($submission->abstract)
                                <div class="mb-3">
                                    <h6>Abstract</h6>
                                    <p>{{ $submission->abstract }}</p>
                                </div>
                            @endif

                            @if($submission->author_comments)
                                <div class="mb-3">
                                    <h6>Author Comments</h6>
                                    <p>{{ $submission->author_comments }}</p>
                                </div>
                            @endif

                            @if($submission->admin_remarks)
                                <div class="mb-3">
                                    <h6>Admin Remarks</h6>
                                    <p>{{ $submission->admin_remarks }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Author & Actions -->
                <div class="col-md-4">
                    <!-- Author Info -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Submitted By</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $submission->user->name }}</p>
                            <p><strong>Email:</strong> {{ $submission->user->email }}</p>
                            <p><strong>Role:</strong> {{ ucfirst($submission->user->role) }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                        </div>
                        <div class="card-body">
                            @if($submission->status == 'Pending')
                                <a href="{{ route('admin.submissions.review', $submission->id) }}" 
                                   class="btn btn-warning btn-block mb-2">
                                    <i class="fas fa-check"></i> Review Submission
                                </a>
                            @endif
                            
                            <form action="{{ route('admin.submissions.destroy', $submission->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block" 
                                        onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete Submission
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Files & Links -->
                    @if($submission->pdf_url || $submission->drive_links)
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Files & Links</h6>
                            </div>
                            <div class="card-body">
                                @if($submission->pdf_url)
                                    <a href="{{ $submission->pdf_url }}" target="_blank" 
                                       class="btn btn-outline-primary btn-block mb-2">
                                        <i class="fas fa-file-pdf"></i> View PDF
                                    </a>
                                @endif
                                
                                @if($submission->drive_links && is_array(json_decode($submission->drive_links, true)))
                                    @foreach(json_decode($submission->drive_links, true) as $link)
                                        <a href="{{ $link }}" target="_blank" 
                                           class="btn btn-outline-secondary btn-block mb-2">
                                            <i class="fas fa-link"></i> Drive Link
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF