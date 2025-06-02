<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Forgot Password
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    </style>
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
    <!-- Forgot Password Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-white rounded-md shadow-md p-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
                Reset password
            </h1>
            <form class="space-y-6" action="proses/proses_reset_password.php" method="post">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                        Password Baru
                    </label>
                    <input
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="password" name="password" required="" type="password" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                        Konfirmasi Password
                    </label>
                    <input
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="password" name="confirm_password" required="" type="password" />
                </div>
                <div>
                    <button
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-semibold text-lg"
                        type="submit">
                        Send Reset Link
                    </button>
                </div>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Ingat Passwordmu?
                <a class="font-medium text-blue-600 hover:text-blue-700" href="halaman_login.php">
                    Log In
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









