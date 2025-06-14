<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Login
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    </style>
    <script>
    function onFormSubmit(e) {
        var response = grecaptcha.getResponse();
        if (response.length === 0) {
            alert("Please complete the reCAPTCHA.");
            e.preventDefault();
        }
    }

    window.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('login-form');
        if (form) {
            form.addEventListener('submit', onFormSubmit);
        }
    });
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <img alt="Studiv" src="../img/logo studiv.svg" width="180" />
            </div>
        </div>
    </header>
    <!-- Login Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-white rounded-md shadow-md p-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
                Log In to Studiv
            </h1>
            <form id="login-form" class="space-y-6" action="proses/proses_login.php" method="POST" novalidate>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="username">
                        Username
                    </label>
                    <input autocomplete="username"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="username" name="username" placeholder="Masukkan username" required="" type="text" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                        Password
                    </label>
                    <input autocomplete="current-password"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="password" name="password" placeholder="Masukkan password" required="" type="password" />
                </div>
                <div class="g-recaptcha" data-sitekey="6LeZnFkrAAAAABz6EVqOwgiiadtg28Vk8BDcizmd"></div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="remember"
                            name="remember" type="checkbox" />
                        <label class="ml-2 block text-sm text-gray-900" for="remember">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a class="font-medium text-blue-600 hover:text-blue-700" href="lupa_password.php">
                            Forgot password?
                        </a>
                    </div>
                </div>
                <div>
                    <button
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-semibold text-lg"
                        type="submit">
                        Log In
                    </button>
                </div>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Baru di Studiv?
                <a class="font-medium text-blue-600 hover:text-blue-700" href="halaman_register.php">
                    Sign Up
                </a>
            </p>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
            <p>
                © 2025 Teknologi Rekayasa Perangkat Lunak PNM.
            </p>
        </div>
    </footer>
</body>

</html>