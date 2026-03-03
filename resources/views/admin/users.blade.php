@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1">User Management</h2>
            <p class="text-muted">Manage system users, roles, and platform permissions.</p>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-5">
        <a href="{{ route('admin.users', ['role' => 'all']) }}" 
           class="btn {{ !request()->has('role') || request('role') == 'all' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4">
            Total Users
        </a>
        <a href="{{ route('admin.users', ['role' => 'admin']) }}" 
           class="btn {{ request('role') == 'admin' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4">
            Administrators
        </a>
        <a href="{{ route('admin.users', ['role' => 'faculty']) }}" 
           class="btn {{ request('role') == 'faculty' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4">
            Faculty
        </a>
        <a href="{{ route('admin.users', ['role' => 'student']) }}" 
           class="btn {{ request('role') == 'student' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4">
            Students
        </a>
    </div>

    <!-- Users List Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3 border-0 small text-uppercase text-muted fw-bold">User Identity</th>
                            <th scope="col" class="py-3 border-0 small text-uppercase text-muted fw-bold">Platform Role</th>
                            <th scope="col" class="py-3 border-0 small text-uppercase text-muted fw-bold">Registration</th>
                            <th scope="col" class="text-end pe-4 py-3 border-0 small text-uppercase text-muted fw-bold">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                        @if($user->id === auth()->id())
                                        <span class="badge bg-light text-primary border border-primary-subtle mt-1 small">Current Account</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Administrator</span>
                                @elseif($user->role === 'faculty')
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-3 py-2 rounded-pill">Faculty Staff</span>
                                @else
                                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Student Member</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark small">{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-end pe-4">
                                @if($user->id !== auth()->id())
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-light btn-sm rounded-3 dropdown-toggle px-3" data-bs-toggle="dropdown">
                                        Manage
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border shadow border-0 rounded-4 mt-2">
                                        @if($user->role !== 'admin')
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="dropdown-item py-2">
                                                    <i class="bi bi-shield-check me-2 text-danger"></i> Assign Admin
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($user->role !== 'faculty')
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="role" value="faculty">
                                                <button type="submit" class="dropdown-item py-2">
                                                    <i class="bi bi-person-workspace me-2 text-info"></i> Make Faculty
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($user->role !== 'student')
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="role" value="student">
                                                <button type="submit" class="dropdown-item py-2">
                                                    <i class="bi bi-person-lines-fill me-2 text-secondary"></i> Revoke to Student
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Terminate this user access permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger py-2">
                                                    <i class="bi bi-person-x me-2"></i> Delete Permanently
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->count() == 0)
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3">
                    <i class="bi bi-people fs-1 text-muted"></i>
                </div>
                <h5 class="fw-bold">No accounts found</h5>
                <p class="text-muted">Adjust your filters to see more results.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
