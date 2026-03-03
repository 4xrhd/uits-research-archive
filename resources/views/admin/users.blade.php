@extends('layouts.app')

@section('content')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary text-white rounded p-2 me-2">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="fw-bold">Admin Panel</div>
                <small class="text-muted" style="font-size: 0.7rem;">User Management</small>
            </div>
        </a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('archive') }}">Public Archive</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">User Management</h2>
            <p class="text-muted">Manage system users and their roles</p>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request()->has('role') || request('role') == 'all' ? 'active' : '' }}" 
               href="{{ route('admin.users', ['role' => 'all']) }}">
                <i class="bi bi-people me-1"></i>All Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('role') == 'admin' ? 'active' : '' }}" 
               href="{{ route('admin.users', ['role' => 'admin']) }}">
                <i class="bi bi-shield-lock me-1"></i>Admins
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('role') == 'faculty' ? 'active' : '' }}" 
               href="{{ route('admin.users', ['role' => 'faculty']) }}">
                <i class="bi bi-person-badge me-1"></i>Faculty
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('role') == 'student' ? 'active' : '' }}" 
               href="{{ route('admin.users', ['role' => 'student']) }}">
                <i class="bi bi-person me-1"></i>Students
            </a>
        </li>
    </ul>

    <!-- Users List -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Joined</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center mt-2 mb-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                        @if($user->id === auth()->id())
                                        <span class="badge bg-info mt-1">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif($user->role === 'faculty')
                                    <span class="badge bg-info text-dark">Faculty</span>
                                @else
                                    <span class="badge bg-secondary">Student</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                @if($user->id !== auth()->id())
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        @if($user->role !== 'admin')
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-shield-lock me-2 text-danger"></i> Make Admin
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
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-person-badge me-2 text-info"></i> Make Faculty
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
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-person me-2 text-secondary"></i> Make Student
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i> Delete User
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <button class="btn btn-sm btn-outline-secondary disabled" title="You cannot modify your own account here">
                                    Current User
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->count() == 0)
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <p class="mt-3 text-muted">No users found.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
