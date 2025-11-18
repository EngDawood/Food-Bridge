@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-plus mr-2"></i>Create report</h1>

<form method="post" action="{{ route('admin.reports.store') }}" class="bg-white p-4 rounded shadow max-w-2xl">
    @csrf

    <div class="mb-3">
        <label class="block mb-1"><i class="fa-solid fa-user-shield mr-1"></i>Admin</label>
        <select name="admin_id" class="border rounded px-3 py-2 w-full">
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
            @endforeach
        </select>
        @error('admin_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="block mb-1"><i class="fa-solid fa-file-alt mr-1"></i>Title</label>
        <input type="text" name="title" class="border rounded px-3 py-2 w-full" value="{{ old('title') }}" />
        @error('title')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="block mb-1"><i class="fa-solid fa-align-right mr-1"></i>Content</label>
        <textarea name="content" rows="6" class="border rounded px-3 py-2 w-full">{{ old('content') }}</textarea>
        @error('content')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded"><i class="fa-solid fa-floppy-disk mr-1"></i>Save</button>
        <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded border">Cancel</a>
    </div>
</form>
@endsection


