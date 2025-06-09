<?php
session_start();
require_once 'config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit;
}

$account_id = $_SESSION['account_id'];

$sql = "
SELECT 
    p.id, p.title, p.body, p.vote, p.created_at, p.image_url, p.community, p.location,
    a.username,
    (SELECT COUNT(*) FROM comment WHERE comment_at = p.id) AS comment_count
FROM 
    bookmark b
JOIN post p ON b.post_id = p.id
JOIN account a ON p.owner = a.id
WHERE 
    b.account_id = ?
ORDER BY b.created_at DESC
";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'i', $account_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Bookmark</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Bookmarks Content -->
    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Bookmarked Posts</h1>
        <section class="bg-white rounded-md shadow-md divide-y divide-gray-200" style="width: 50vw;">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <article class="p-4 hover:bg-gray-50 cursor-pointer flex flex-col md:flex-row md:items-start md:space-x-4">
                <?php if (!empty($row['image_url'])): ?>
                    <img src="<?= htmlspecialchars($row['image_url']) ?>"
                        class="w-full md:w-48 h-32 md:h-24 rounded-md object-cover flex-shrink-0 mb-3 md:mb-0" alt="Post image" />
                <?php endif; ?>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 text-xs text-gray-500 mb-1">
                        <img src="<?= $community_images[$row['community']] ?? '#' ?>" class="w-5 h-5 rounded-full"
                            alt="Community icon" />
                        <a href="<?= htmlspecialchars($community_links[$row['community']]) ?>" class="font-semibold text-blue-600 hover:underline"><?= htmlspecialchars($row['community']) ?></a>
                        <span>• Posted by <?= htmlspecialchars($row['username']) ?> <?= $row['created_at'] ?></span>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                        <a href="<?= htmlspecialchars($row['location']) ?>"><?= htmlspecialchars($row['title']) ?></a>
                    </h2>
                    <p class="mt-1 text-gray-700 text-sm"><?= htmlspecialchars($row['body']) ?></p>
                    <div class="mt-3 flex items-center space-x-6 text-gray-500 text-sm select-none">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-arrow-up"></i>
                            <span><?= $row['vote'] ?></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="far fa-comment"></i>
                            <span><?= $row['comment_count'] ?> Comments</span>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($result) === 0): ?>
            <div class="p-6 text-center text-gray-500">No bookmarked posts found.</div>
            <?php endif; ?>
        </section>
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
