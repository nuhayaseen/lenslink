@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-people me-2 text-gold"></i>Users</h4>
        <p class="text-muted small mb-0">Manage all platform users</p>
    </div>
    <form method="GET" class="d-flex align-items-center gap-2">
        <label class="form-label mb-0 small text-muted">Filter by role:</label>
        <select name="role" class="form-select form-select-sm"
                style="width:160px" onchange="this.form.submit()">
            <option value="">All roles</option>
            <option value="admin"
                {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="photographer"
                {{ request('role') === 'photographer' ? 'selected' : '' }}>Photographer</option>
            <option value="client"
                {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
        </select>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted small">{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:36px;height:36px;font-size:14px">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $user->phone ?? '—' }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger rounded-pill">
                                <i class="bi bi-shield-fill me-1"></i>Admin
                            </span>
                        @elseif($user->role === 'photographer')
                            <span class="badge rounded-pill"
                                  style="background:var(--primary);color:var(--accent)">
                                <i class="bi bi-camera2 me-1"></i>Photographer
                            </span>
                        @else
                            <span class="badge bg-info text-dark rounded-pill">
                                <i class="bi bi-person me-1"></i>Client
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success rounded-pill">
                                <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger rounded-pill">
                                <i class="bi bi-circle me-1" style="font-size:8px"></i>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="small text-muted">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.users.toggle', $user) }}"
                                  method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm
                                    {{ $user->is_active
                                        ? 'btn-outline-warning'
                                        : 'btn-outline-success' }}"
                                    title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'pause' : 'play' }}-fill"></i>
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            @if($user->role !== 'admin')
                            <form action="{{ route('admin.users.delete', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Permanently delete {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-people d-block fs-2 mb-2"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection