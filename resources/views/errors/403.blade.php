<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><i class="fa-solid fa-triangle-exclamation mr-1"></i>Forbidden - 403</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .fade-in { animation: fade 0.4s ease-in-out; }
        @keyframes fade { from { opacity: 0 } to { opacity: 1 } }
    </style>
    </head>
<body class="bg-primary-100 text-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4 fade-in">
        <div class="bg-white shadow rounded-lg p-8 max-w-lg w-full text-center">
            <div class="text-6xl font-extrabold text-primary-800"><i class="fa-solid fa-triangle-exclamation"></i> 403</div>
            <h1 class="mt-4 text-2xl font-semibold">Sorry, you don’t have permission to access this page</h1>
            <p class="mt-2 text-gray-600">It looks like you’re trying to reach a page that requires special privileges.</p>
            <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/" class="px-4 py-2 rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-house mr-1"></i>Back to home</a>
                @auth
                    <a href="/profile" class="px-4 py-2 rounded border border-gray-300"><i class="fa-solid fa-user mr-1"></i>Go to my profile</a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>


