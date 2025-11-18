<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><i class="fa-solid fa-circle-xmark mr-1"></i>Page not found - 404</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{ transform: translateY(0) } 50%{ transform: translateY(-6px) } }
    </style>
</head>
<body class="bg-primary-100 text-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white shadow rounded-lg p-8 max-w-lg w-full text-center">
            <div class="text-6xl font-extrabold text-primary-800 float"><i class="fa-solid fa-circle-xmark"></i> 404</div>
            <h1 class="mt-4 text-2xl font-semibold">Sorry, we couldn’t find that page</h1>
            <p class="mt-2 text-gray-600">The page may have been removed or the link might be incorrect.</p>
            <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/" class="px-4 py-2 rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-house mr-1"></i>Back to home</a>
                <a href="javascript:history.back()" class="px-4 py-2 rounded border border-gray-300"><i class="fa-solid fa-arrow-left mr-1"></i>Go back</a>
            </div>
        </div>
    </div>
</body>
</html>


