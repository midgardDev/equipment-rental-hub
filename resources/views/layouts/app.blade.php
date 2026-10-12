<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Rental Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="url"],
    input[type="date"],
    select,
    textarea {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus,
    input[type="url"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    /* Checkbox styling */
    input[type="checkbox"] {
        width: auto;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        cursor: pointer;
    }
</style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="w-full px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-blue-600">Rental Hub</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('items.index') }}" class="text-gray-700 hover:text-blue-600">Browse Items</a>
                    
                    @auth
                        <span class="text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                        <a href="{{ route('bookings.index') }}" class="text-gray-700 hover:text-blue-600">My Bookings</a>
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="px-4 py-8 flex-1 w-full">
        @if(session('success'))
            <div id="success-alert"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center shadow-md transition-all duration-500">
            <span> {{ session('success') }}</span>
            <button onclick="document.getElementById('success-alert').remove()"
            class="text-green-700 hover:text-green-900 font-bold text-xl leading-none">
            &times
</button>
</div>
@endif

@if(session('error'))
<div id="error-alert"
class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center shadow-md transition-all duration-500">
<span>{{ session('error') }}</span>
<button onclick="document.getElementById('error-alert').remove()"
class="text-red-700 hover:text-red-900 font-bold text-xl leading-none">
&times
</button>
</div>
@endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-auto">
        <div class="px-4 py-4 text-center text-gray-600">
            &copy; {{ date('Y') }} Equipment Rental Hub. 
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['success-alert', 'error-alert'].forEach(function(id) {
                const alert = document.getElementById(id);
                if (alert) {
                    setTimeout(function() {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-20px)';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 4000);
                }
            });
        });
        </script>
</body>
</html>