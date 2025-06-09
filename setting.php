<?php
session_start();
require_once "config/koneksi.php";

if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit;
}

$user_id = $_SESSION['account_id'];

// Ambil data user saat ini
$query = mysqli_prepare($link, "SELECT username, email, bio, notification FROM account WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $username, $email, $bio, $notification);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Tangani submit form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Account setting
    if (isset($_POST['username']) && isset($_POST['email'])) {
        $new_username = trim($_POST['username']);
        $new_email = trim($_POST['email']);
        $stmt = mysqli_prepare($link, "UPDATE account SET username=?, email=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssi", $new_username, $new_email, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Ganti password jika diisi dan cocok
        if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirm-password']) {
            $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($link, "UPDATE account SET password=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "si", $hashed, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        header("Location: setting.php?success=1");
        exit;
    }

    // Profile setting
    if (isset($_POST['display-name'])) {
        $display_name = trim($_POST['display-name']);
        $bio_update = trim($_POST['bio']);
        $disable_notification = isset($_POST['disable-notification']) ? 1 : 0;

        $stmt = mysqli_prepare($link, "UPDATE account SET username=?, bio=?, notification=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssii", $display_name, $bio_update, $disable_notification, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: setting.php?profile_updated=1");
        exit;
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>body { font-family: 'Roboto', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <?php
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: halaman_login.php");
            exit;
        }
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <a href="beranda.php">
                    <img alt="Studiv" src="../img/logo studiv.svg" width="180" class="cursor-pointer" />
                </a>
            </div>
            <form class="hidden sm:flex flex-1 max-w-xl mx-4" style="margin-top: auto; margin-bottom: auto;">
                <label class="sr-only" for="search">
                    Search Studiv
                </label>
                <div class="relative w-full" margin="auto" style="display:none">
                    <input class="block w-full pl-10 pr-4 py-2 rounded-md border border-gray-300  focus:border-blue-500"
                        id="search" placeholder="Search Studiv" type="search" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search">
                        </i>
                    </div>
                </div>
            </form>
            <nav class="flex items-center space-x-4">
                <button aria-label="Create Post"
                    class="hidden sm:inline-flex items-center space-x-2 px-3 py-1.5 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 ">
                    <i class="fas fa-plus">
                    </i>
                    <span class="font-semibold">
                        <a href="create_post.php"> Create Post</a>
                    </span>
                </button>
            </nav>
            <div class="relative" x-data="{ open: false }">
                <button aria-haspopup="true" aria-expanded="false" aria-label="User menu"
                    class="flex items-center space-x-2  rounded" id="user-menu-button" type="button"
                    onclick="toggleDropdown()">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                        <?php   
                        require_once "config/koneksi.php";
                        $owner_id = $_SESSION['account_id']; // Ganti sesuai kebutuhan
                        $query_account = "SELECT username FROM account WHERE id = $owner_id";
                        $result_account = mysqli_query($link, $query_account);
                        $account = mysqli_fetch_assoc($result_account);
                        echo strtoupper(substr($account['username'], 0, 1));
                        ?>
                    </div>
                    <i class="fas fa-caret-down text-gray-600"></i>
                </button>
                <div aria-labelledby="user-menu-button"
                    class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
                    id="dropdown-menu" role="menu" tabindex="-1">
                    <div class="py-1" role="none">
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="profile.php"
                            role="menuitem" tabindex="-1" id="menu-item-0">
                            Profile
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="notifikasi.php"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            Notification
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="bookmark.php"
                            role="menuitem" tabindex="-1" id="menu-item-2">
                            Bookmark
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="setting.php"
                            role="menuitem" tabindex="-1" id="menu-item-3">
                            Settings
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="?logout=1"
                            role="menuitem" tabindex="-1" id="menu-item-4">
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script>
        const dropdownButton = document.getElementById('user-menu-button');
        const dropdownMenu = document.getElementById('dropdown-menu');

        function toggleDropdown() {
            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                dropdownButton.setAttribute('aria-expanded', 'true');
                document.addEventListener('click', outsideClickListener);
            } else {
                dropdownMenu.classList.add('hidden');
                dropdownButton.setAttribute('aria-expanded', 'false');
                document.removeEventListener('click', outsideClickListener);
            }
        }

        function outsideClickListener(event) {
            if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownButton.setAttribute('aria-expanded', 'false');
                document.removeEventListener('click', outsideClickListener);
            }
        }
        </script>
    </header>

    <!-- setting Content -->
    <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded-md shadow-md mt-6" style="width:50vw">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Settings</h1>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button class="whitespace-nowrap py-4 px-1 border-b-2 border-blue-600 text-sm font-semibold text-blue-600 focus:outline-none" data-tab-target="account" aria-current="page">Account</button>
                <button class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent text-sm font-semibold text-gray-500 hover:text-blue-600 hover:border-blue-600 focus:outline-none" data-tab-target="profile">Profile</button>
            </nav>
        </div>

        <!-- Account Tab -->
        <section id="account" class="tab-panel block">
            <form class="space-y-6" action="" method="POST">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Account setting</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($username) ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Change Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500" placeholder="New password" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="confirm-password">Confirm New Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500" placeholder="Confirm new password" />
                </div>
                <div>
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </section>

        <!-- Profile Tab -->
        <section id="profile" class="tab-panel hidden">
            <form class="space-y-6" action="" method="POST">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Profile settings</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="display-name">Display Name</label>
                    <input type="text" name="display-name" id="display-name" value="<?= htmlspecialchars($username) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="bio">Bio</label>
                    <textarea name="bio" id="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($bio ?? '') ?></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="disable-notification" id="disable-notification" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" <?= $notification ? 'checked' : '' ?> />
                    <label for="disable-notification" class="ml-2 block text-sm text-gray-900">Enable notification</label>
                </div>
                <div>
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">Save Profile</button>
                </div>
            </form>
        </section>
    </main>

    <script>
    const tabs = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('border-blue-600', 'text-blue-600');
                t.classList.add('border-transparent', 'text-gray-500', 'hover:text-blue-600', 'hover:border-blue-600');
                t.setAttribute('aria-current', 'false');
            });

            tabPanels.forEach(panel => panel.classList.add('hidden'));

            tab.classList.add('border-blue-600', 'text-blue-600');
            tab.setAttribute('aria-current', 'page');
            const target = tab.getAttribute('data-tab-target');
            document.getElementById(target).classList.remove('hidden');
        });
    });
    </script>
</body>
</html>
