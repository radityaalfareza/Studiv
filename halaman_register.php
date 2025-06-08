<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <!-- reCAPTCHA v2 Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

    <!-- Register Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-white rounded-md shadow-md p-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Buat Akun</h1>
            <form class="space-y-6" action="proses/proses_register.php" method="post" autocomplete="off">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="username">Username</label>
                    <input autocomplete="username" pattern="^[a-zA-Z0-9_]+$"
                        title="Hanya huruf, angka, dan underscore (_)"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="username" name="username" placeholder="Pilih username" required type="text" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email address</label>
                    <input autocomplete="email" pattern="^[a-zA-Z0-9_@.]+$"
                        title="Hanya huruf, angka, underscore, @, dan titik"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="email" name="email" placeholder="you@contoh.com" required type="email" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                    <input autocomplete="new-password"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        id="password" name="password" placeholder="Buat password" required type="password" />
                </div>

                <!-- ✅ Hidden input untuk reCAPTCHA token -->
                    <form action="?" method="POST">
                    <div class="g-recaptcha" data-sitekey="your_site_key"></div>
                    <br/>
                    <input type="submit" value="Submit">
                    </form>

                <div>
                    <button
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-semibold text-lg"
                        type="submit">
                        Sign Up
                    </button>
                </div>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah Punya Akun?
                <a class="font-medium text-blue-600 hover:text-blue-700" href="halaman_login.php">Log In</a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
            <p>© 2025 Teknologi Rekayasa Perangkat Lunak PNM.</p>
        </div>
    </footer>
</body>

</html>
