@extends('admin.layout')
@section('title', 'Users')
@section('content')

<h1 class="text-2xl font-bold text-ivory mb-4">Users</h1>

<form method="GET" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
           class="bg-card border border-hairline rounded-md px-3 py-1.5 text-sm w-full sm:w-64 text-ivory placeholder-mist/50 focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
</form>

<div class="bg-panel border border-hairline rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-card text-left">
                <tr>
                    <th class="p-3 text-mist font-medium sticky left-0 z-10 bg-card">Actions</th>
                    <th class="p-3 text-mist font-medium whitespace-nowrap">Name</th>
                    <th class="p-3 text-mist font-medium whitespace-nowrap">Email</th>
                    <th class="p-3 text-mist font-medium whitespace-nowrap">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t border-hairline hover:bg-card/50 transition-colors group">
                    <td class="p-3 sticky left-0 z-10 bg-panel group-hover:bg-[#1b1638] transition-colors">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-md bg-cyan/10 border border-cyan/20 text-cyan hover:bg-cyan/20 transition-colors"
                               title="Edit">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-md bg-pink/10 border border-pink/20 text-pink hover:bg-pink/20 transition-colors"
                                        title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @else
                            <span class="w-8 h-8 flex items-center justify-center rounded-md bg-card border border-hairline text-mist/40"
                                  title="You can't delete your own account">
                                <i class="fas fa-trash text-xs"></i>
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="p-3 text-ivory whitespace-nowrap">{{ $user->name }}</td>
                    <td class="p-3 text-mist whitespace-nowrap">{{ $user->email }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded-full bg-violet/15 text-violet border border-violet/20 text-xs">{{ $user->role }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<p class="mt-2 text-xs text-mist/60 sm:hidden">
    <i class="fas fa-arrows-left-right mr-1"></i> Scroll sideways to see email and role
</p>

<div class="mt-4 text-mist [&_a]:text-cyan [&_a:hover]:text-violet [&_span:not(.sr-only)]:text-mist [&_.dark\:bg-gray-800]:bg-transparent">
    {{ $users->links() }}
</div>

@endsection