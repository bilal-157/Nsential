@extends('admin.layout')
@section('title', 'Edit User')
@section('content')

<h1 class="text-2xl font-bold text-ivory mb-4">Edit User</h1>

<form action="{{ route('admin.users.update', $user) }}" method="POST"
      class="bg-panel border border-hairline p-6 rounded-lg max-w-lg space-y-4">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium text-mist mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
               class="w-full bg-card border border-hairline rounded-md px-3 py-2 text-ivory focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
    </div>

    <div>
        <label class="block text-sm font-medium text-mist mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
               class="w-full bg-card border border-hairline rounded-md px-3 py-2 text-ivory focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
    </div>

    <div>
        <label class="block text-sm font-medium text-mist mb-1">Role</label>
        <select name="role"
                class="w-full bg-card border border-hairline rounded-md px-3 py-2 text-ivory focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
            @foreach(['admin','author','user'] as $role)
            <option value="{{ $role }}" @selected($user->role === $role) class="bg-card text-ivory">{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>

    @error('email') <p class="text-pink text-sm">{{ $message }}</p> @enderror

    <button class="text-void font-semibold px-4 py-2 rounded-md transition-opacity hover:opacity-90"
            style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
        Save
    </button>
</form>

@endsection