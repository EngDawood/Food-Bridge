@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold"><i class="fa-solid fa-comments mr-2"></i>Feedback</h1>
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-gauge mr-1"></i>Dashboard</a>
 </div>

@if(session('status'))
    <div class="mb-4 bg-green-100 text-green-800 px-3 py-2 rounded">{{ session('status') }}</div>
@endif

<form method="post" action="{{ route('admin.feedback.store') }}" class="bg-white p-4 rounded shadow mb-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <label class="block mb-1"><i class="fa-solid fa-user mr-1"></i>From</label>
            <select name="from_user_id" class="border rounded px-3 py-2 w-full">
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
            @error('from_user_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block mb-1"><i class="fa-solid fa-user mr-1"></i>To</label>
            <select name="to_user_id" class="border rounded px-3 py-2 w-full">
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
            @error('to_user_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block mb-1"><i class="fa-solid fa-star mr-1"></i>Rating</label>
            <input type="number" name="rating" min="1" max="5" class="border rounded px-3 py-2 w-full" value="{{ old('rating', 5) }}" />
            @error('rating')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="md:col-span-4">
            <label class="block mb-1"><i class="fa-solid fa-comment mr-1"></i>Comment (optional)</label>
            <input type="text" name="comment" class="border rounded px-3 py-2 w-full" value="{{ old('comment') }}" />
            @error('comment')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="mt-3">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded"><i class="fa-solid fa-plus mr-1"></i>Add feedback</button>
    </div>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-right"><i class="fa-solid fa-hashtag mr-1"></i>#</th>
                <th class="p-2 text-right"><i class="fa-solid fa-user mr-1"></i>From</th>
                <th class="p-2 text-right"><i class="fa-solid fa-user mr-1"></i>To</th>
                <th class="p-2 text-right"><i class="fa-solid fa-star mr-1"></i>Rating</th>
                <th class="p-2 text-right"><i class="fa-solid fa-comment mr-1"></i>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedback as $f)
            <tr class="border-t">
                <td class="p-2">{{ $f->id }}</td>
                <td class="p-2">{{ $f->fromUser->name ?? '-' }}</td>
                <td class="p-2">{{ $f->toUser->name ?? '-' }}</td>
                <td class="p-2">{{ $f->rating }}/5</td>
                <td class="p-2">{{ $f->comment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $feedback->links() }}</div>
@endsection


