@extends('layouts.admin')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-12">Edit Member</h1>
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('admin.members.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">First Name</label>
                        <input type="text" name="first_name" value="{{ $user->first_name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Last Name</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                        <select name="membership_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="active" @if($user->membership_status === 'active') selected @endif>Active</option>
                            <option value="expired" @if($user->membership_status === 'expired') selected @endif>Expired</option>
                            <option value="suspended" @if($user->membership_status === 'suspended') selected @endif>Suspended</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Tier</label>
                        <select name="membership_tier" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="standard" @if($user->membership_tier === 'standard') selected @endif>Standard</option>
                            <option value="premium" @if($user->membership_tier === 'premium') selected @endif>Premium</option>
                            <option value="lifetime" @if($user->membership_tier === 'lifetime') selected @endif>Elite</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Save Changes</button>
                    <a href="{{ route('admin.members.show', $user->id) }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-2 px-4 rounded-lg text-center">Cancel</a>
                </div>
            </form>
        </div>
        <div class="mt-8"><a href="{{ route('admin.members.index') }}" class="text-gray-600 hover:text-gray-800">Back to Members</a></div>
    </div>
</div>
@endsection