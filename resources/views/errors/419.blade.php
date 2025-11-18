@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow text-center">
    <h1 class="text-2xl font-bold mb-4 text-red-600"><i class="fa-solid fa-triangle-exclamation mr-2"></i>419 - Page Expired</h1>
    <p class="mb-4 text-gray-600">Your session has expired. Please refresh the page and try again.</p>
    <div class="flex gap-2 justify-center">
        <a href="{{ url()->previous() ?: '/' }}" class="px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white rounded">
            <i class="fa-solid fa-arrow-left mr-1"></i>Go Back
        </a>
        <a href="/" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">
            <i class="fa-solid fa-home mr-1"></i>Go Home
        </a>
    </div>
</div>
@endsection

