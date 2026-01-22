@extends('layouts.admin')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-12">
            <div><h1 class="text-4xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1></div>
            <div class="space-x-3">
                <a href="{{ route('admin.members.edit', $user->id) }}" class="inline-block bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">Edit</a>
                <form action="{{ route('admin.members.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white font-bold py-2 px-6 rounded-lg">Delete</button>
                </form>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Info</h2>
                <div><p class="text-sm text-gray-600">Name</p><p>{{ $user->first_name }} {{ $user->last_name }}</p></div>
                <div><p class="text-sm text-gray-600">Email</p><p>{{ $user->email }}</p></div>
                <div><p class="text-sm text-gray-600">Phone</p><p>{{ $user->phone }}</p></div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Membership</h2>
                <div><p class="text-sm text-gray-600">Tier</p><p>{{ ucfirst($user->membership_tier) }}</p></div>
                <div><p class="text-sm text-gray-600">Status</p><p>{{ ucfirst($user->membership_status) }}</p></div>
                <div><p class="text-sm text-gray-600">Joined</p><p>{{ $user->created_at->format('M d, Y') }}</p></div>
            </div>
        </div>
        <div><a href="{{ route('admin.members.index') }}">Back</a></div>
    </div>
</div>
@endsection