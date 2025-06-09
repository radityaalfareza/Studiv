<?php
session_start();
require_once 'config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
<?php
require_once "config/koneksi.php";

$owner_id = $_SESSION['account_id']; // Ganti sesuai kebutuhan

// Ambil data akun
$query_account = "SELECT username, bio, created_at FROM account WHERE id = $owner_id";
$result_account = mysqli_query($link, $query_account);
$account = mysqli_fetch_assoc($result_account);

// Ambil data post
$query_posts = "SELECT p.*, (SELECT COUNT(*) FROM comment WHERE comment_at = p.id) AS comment_count FROM post p WHERE p.owner = $owner_id ORDER BY p.created_at DESC";
$result_posts = mysqli_query($link, $query_posts);

// Ambil data comment
$query_comments = "SELECT c.*, p.title, p.location, p.community, p.created_at as post_created_at FROM comment c JOIN post p ON c.comment_at = p.id WHERE c.owner = $owner_id ORDER BY c.created_at DESC";
$result_comments = mysqli_query($link, $query_comments);

$community_links = [
    "Funny" => "/s/funny.php",
    "Gaming" => "/s/gaming.php",
    "Movies" => "/s/movies.php",
    "Science" => "/s/science.php",
    "Technology" => "/s/technology.php"
];
$community_images = [
    "Technology" => "https://imgs.search.brave.com/zPLEmnXUkNTGq2-f6qUw6V4QGyvtMvn_xTyz6qqCLQI/rs:fit:200:200:1:0/g:ce/aHR0cHM6Ly9jZG4u/YnJpdGFubmljYS5j/b20vNjEvMjU3NDYx/LTA1MC04NDRGQzVD/NS9TcG90LWZvdXIt/bGVnZ2VkLXJvYm90/LUJvc3Rvbi1EeW5h/bWljcy5qcGc",
    "Movies" => "https://imgs.search.brave.com/BLUlyNmCP1YDqkAHXMF21_I4J1mpKDbuISpmATCL6lc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTMz/NzIxNDI4My92ZWN0/b3IvcmVhbGlzdGlj/LXBvcGNvcm4tY2lu/ZW1hLW1vdmllLXdh/dGNoaW5nLWNvbmNl/cHQtb25saW5lLWZp/bG1zaG93LWVudGVy/dGFpbm1lbnQtM2Qt/Y2luZW1hdGljLmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz1L/MjJTZzZvZHNmYjBj/S2ZQUHNQc1RILUtt/a1YxNDRHeEFpOUdJ/MV9NSWFVPQ",
    "Gaming" => "https://imgs.search.brave.com/7umtls4WgPf5dhNCIe9QCAYWKiugsZuO2r2xqCJ2BzM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvZ2FtaW5nLXps/M3ZuZ3hwdnYwNGEz/MGouanBn",
    "Funny" => "https://imgs.search.brave.com/xXprWLbNAmO7Znn3XGC8PVBafLbriVYwSNDBxAxedCs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTUx/NjM1MDMyL3ZlY3Rv/ci9wb3AtYXJ0LWNv/bWljLWJvb2stc3R5/bGUtbW91dGgtb2Yt/bWFuLWxhdWdoaW5n/LW91dC1sb3VkLXZl/Y3Rvci1pbGx1c3Ry/YXRpb24uanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPW1SVDMw/S2R3ZkFhYUxtZ2Jn/LS1EQU5QUXNWT19O/ZUU1V29maXltZHR4/ams9",
    "Science" => "https://imgs.search.brave.com/tI00v0HeilDMXp_AF3eAXNwM_LPuvwDlKIxTTtPR7Oo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzUzLzY0LzQ5/LzM2MF9GXzUzNjQ0/OTI2XzBtdlVDSXhD/Q1R2SWE3QkFJRnVV/YTN4c2FOQTlsYmVi/LmpwZw"
];
?>
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
            <form class="hidden sm:flex flex-1 max-w-xl mx-4" style="margin-top: auto; margin-bottom: auto;" >
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
                        <?php echo strtoupper(substr($account['username'], 0, 1)); ?>
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
    <!-- Profile Content -->
    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-md shadow-md p-6" style="width: 50vw;">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                <div class="flex items-center space-x-2">
                    <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-6xl font-bold">
                        <?php echo strtoupper(substr($account['username'], 0, 1)); ?>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-gray-900"><?php echo htmlspecialchars($account['username']); ?></h1>
                    <p class="text-gray-600 mt-1">Joined <?php echo date("F Y", timestamp: strtotime($account['created_at'])); ?></p>
                    <p class="mt-3 text-gray-700 max-w-xl">
                        <?php echo isset($account['bio']) && !is_null($account['bio']) ? nl2br(htmlspecialchars($account['bio'])) : ''; ?>
                    </p>
                    <div class="mt-4 flex justify-center md:justify-start space-x-4">
                        <a href="setting.php" class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700">Settings</a>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <div class="relative mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Recent Posts</h2>
                    <a href="all_posts.php" class="px-3 py-1 bg-blue-600 text-white text-s rounded hover:bg-blue-700 absolute top-0 right-0 text-l text-blue-600 hover:underline">
                        See all posts
                    </a>
                </div>

                <div class="space-y-4">
                    <?php while ($post = mysqli_fetch_assoc($result_posts)) : ?>
                        <article class="relative border border-gray-200 rounded-md p-4 hover:shadow-lg cursor-pointer">
                            <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                                <img class="w-5 h-5 rounded-full" src="<?php echo $community_images[$post['community']] ?? ''; ?>" alt="community">
                                <a class="font-semibold text-blue-600 hover:underline" href="<?php echo $community_links[$post['community']] ?? '#'; ?>">
                                    <?php echo htmlspecialchars($post['community']); ?>
                                </a>
                                <span>• <?php echo date("M d, Y", strtotime($post['created_at'])); ?></span>
                            </div>

                            <a href="<?php echo htmlspecialchars($post['location']); ?>" class="text-lg font-semibold text-gray-900">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>

                            <p class="mt-1 text-gray-700 text-sm"><?php echo htmlspecialchars($post['body']); ?></p>

                            <div class="mt-3 flex items-center space-x-6 text-gray-500 text-sm">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-arrow-up"></i>
                                    <span><?php echo $post['vote']; ?></span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="far fa-comment"></i>
                                    <span><?php echo $post['comment_count']; ?> Comments</span>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="mt-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Comments</h2>
                <div class="space-y-4">
                    <?php while ($comment = mysqli_fetch_assoc($result_comments)) : ?>
                        <article class="border border-gray-200 rounded-md p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                                <img class="w-5 h-5 rounded-full" src="<?php echo $community_images[$comment['community']] ?? ''; ?>" alt="community">
                                <a class="font-semibold text-blue-600 hover:underline" href="<?php echo $community_links[$comment['community']] ?? '#'; ?>">
                                    <?php echo htmlspecialchars($comment['community']); ?>
                                </a>
                                <span>• <?php echo date("M d, Y", strtotime($comment['post_created_at'])); ?></span>
                            </div>
                            <a href="<?php echo htmlspecialchars($comment['location']); ?>" class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($comment['title']); ?></a>
                            <p class="text-gray-700 text-sm"><?php echo htmlspecialchars($comment['body']); ?></p>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
            <p>© 2025 Teknologi Rekayasa Perangkat Lunak PNM.</p>
        </div>
    </footer>
</body>

</html>