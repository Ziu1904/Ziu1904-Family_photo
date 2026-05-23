@extends('layouts.admin')

@section('title', 'Users Management')
@section('page_title', 'Users Management')

@section('content')
<div style="margin-bottom: 20px; text-align: right;">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary-admin">Create User</a>
</div>

<div class="table-admin">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>School</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->school ?? '-' }}</td>
                    <td>
                        <span class="badge" style="background: {{ $user->role === 'admin' ? '#667eea' : ($user->role === 'manager' ? '#17a2b8' : '#28a745') }}; color: white;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ optional($user->created_at)->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary btn-sm-admin">View</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning btn-sm-admin">Edit</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-sm-admin" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #999;">
                        No users found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $users->links() }}
</div>
@endsection
