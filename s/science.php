<?php
session_start();
require_once '../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['account_id'])) {
    header("Location: ../halaman_login.php");
    exit;
}
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Studiv
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

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <?php
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: ../halaman_login.php");
            exit;
        }
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <a href="../beranda.php">
                    <img alt="Studiv" src="../img/logo studiv.svg" width="180" class="cursor-pointer" />
                </a>
            </div>
            <form class="hidden sm:flex flex-1 max-w-xl mx-4" style="margin-top: auto; margin-bottom: auto;">
                <label class="sr-only" for="search">
                    Search Studiv
                </label>
                <div class="relative w-full" margin="auto">
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
                        <a href="../create_post.php"> Create Post</a>
                    </span>
                </button>
            </nav>
            <div class="relative" x-data="{ open: false }">
                <button aria-haspopup="true" aria-expanded="false" aria-label="User menu"
                    class="flex items-center space-x-2  rounded" id="user-menu-button" type="button"
                    onclick="toggleDropdown()">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                        <?php   
                        require_once "../config/koneksi.php";
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
    <main
        class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6">
        <!-- Posts Feed -->
        <section class="flex-1 bg-white rounded-md shadow-md p-4" style="width:100vh;">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">
                    Science
                </h1>
            </div>
            <!-- Menampilkan semua post yang berada pada tabel post -->
<?php
require_once '../config/koneksi.php'; // atau sesuaikan path
$community_links = [
    "Funny" => "/s/funny.php",
    "Gaming" => "/s/gaming.php",
    "Movies" => "/s/movies.php",
    "Science" => "/s/science.php",
    "Technology" => "/s/technology.php"
];
// Mapping community ke URL gambar
$community_images = [
    "Technology" => "https://imgs.search.brave.com/zPLEmnXUkNTGq2-f6qUw6V4QGyvtMvn_xTyz6qqCLQI/rs:fit:200:200:1:0/g:ce/aHR0cHM6Ly9jZG4u/YnJpdGFubmljYS5j/b20vNjEvMjU3NDYx/LTA1MC04NDRGQzVD/NS9TcG90LWZvdXIt/bGVnZ2VkLXJvYm90/LUJvc3Rvbi1EeW5h/bWljcy5qcGc",
    "Movies" => "https://imgs.search.brave.com/BLUlyNmCP1YDqkAHXMF21_I4J1mpKDbuISpmATCL6lc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTMz/NzIxNDI4My92ZWN0/b3IvcmVhbGlzdGlj/LXBvcGNvcm4tY2lu/ZW1hLW1vdmllLXdh/dGNoaW5nLWNvbmNl/cHQtb25saW5lLWZp/bG1zaG93LWVudGVy/dGFpbm1lbnQtM2Qt/Y2luZW1hdGljLmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz1L/MjJTZzZvZHNmYjBj/S2ZQUHNQc1RILUtt/a1YxNDRHeEFpOUdJ/MV9NSWFVPQ",
    "Gaming" => "https://imgs.search.brave.com/7umtls4WgPf5dhNCIe9QCAYWKiugsZuO2r2xqCJ2BzM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvZ2FtaW5nLXps/M3ZuZ3hwdnYwNGEz/MGouanBn",
    "Funny" => "https://imgs.search.brave.com/xXprWLbNAmO7Znn3XGC8PVBafLbriVYwSNDBxAxedCs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTUx/NjM1MDMyL3ZlY3Rv/ci9wb3AtYXJ0LWNv/bWljLWJvb2stc3R5/bGUtbW91dGgtb2Yt/bWFuLWxhdWdoaW5n/LW91dC1sb3VkLXZl/Y3Rvci1pbGx1c3Ry/YXRpb24uanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPW1SVDMw/S2R3ZkFhYUxtZ2Jn/LS1EQU5QUXNWT19O/ZUU1V29maXltZHR4/ams9",
    "Science" => "https://imgs.search.brave.com/tI00v0HeilDMXp_AF3eAXNwM_LPuvwDlKIxTTtPR7Oo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzUzLzY0LzQ5/LzM2MF9GXzUzNjQ0/OTI2XzBtdlVDSXhD/Q1R2SWE3QkFJRnVV/YTN4c2FOQTlsYmVi/LmpwZw"
];

// Ambil semua post dan join dengan akun pemiliknya
$query = "
SELECT 
post.id, post.title, post.body, post.vote, post.community, post.created_at, post.location,
account.username,
(SELECT COUNT(*) FROM comment WHERE comment.comment_at = post.id) AS comment_count
FROM post
JOIN account ON post.owner = account.id
WHERE post.community = 'Science'
ORDER BY post.created_at DESC
";

$stmt = mysqli_prepare($link, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Loop menampilkan post
while ($post = mysqli_fetch_assoc($result)) {
    $img_url = $community_images[$post['community']] ?? 'default_image_url.jpg'; // fallback

    echo '
    <article class="border border-gray-200 rounded-md mb-4 hover:shadow-lg transition-shadow duration-150">
        <div class="flex p-3">
            <div class="flex flex-col items-center mr-4 select-none w-12" data-post-id="' . $post['id'] . '">
                <button aria-label="Upvote" class="text-gray-400 hover:text-blue-600 vote-btn" data-vote-type="up">
                    <i class="fas fa-arrow-up fa-lg"></i>
                </button>
                <span class="font-semibold text-gray-700 mt-1 vote-count" id="vote-count-' . $post['id'] . '">
                    ' . $post['vote'] . '
                </span>
                <button aria-label="Downvote" class="text-gray-400 hover:text-blue-600 vote-btn" data-vote-type="down">
                    <i class="fas fa-arrow-down fa-lg"></i>
                </button>
            </div>
            <div class="flex-1">
                <div class="flex items-center space-x-2 text-xs text-gray-500 mb-1">
                    <img alt="Community icon" class="w-5 h-5 rounded-full" src="' . htmlspecialchars($img_url) . '" />
                    <a class="font-semibold text-blue-600 hover:underline" href="' . htmlspecialchars($community_links[$post['community']] ?? '#') . '">' . htmlspecialchars($post['community']) . '</a>
                    <span>• Posted by ' . htmlspecialchars($post['username']) . ' ' . $post['created_at'] . '</span>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 hover:text-blue-600 cursor-pointer">
                    <a href="' . htmlspecialchars($post['location']) . '">' . htmlspecialchars($post['title']) . '</a>
                </h2>
                <p class="mt-1 text-gray-700 text-sm">' . htmlspecialchars($post['body']) . '</p>
                <div class="mt-3 flex items-center space-x-6 text-gray-500 text-sm select-none">
                    <form method="get" action="' . htmlspecialchars($post['location']) . '" style="display:inline; margin-bottom:0; ">
                        <button type="submit" class="flex items-center space-x-1 hover:text-red-600">
                            <i class="far fa-comment"></i>
                            <span>' . $post['comment_count'] . '</span>
                        </button>
                    </form>
                    <button class="flex items-center space-x-1 hover:text-green-600">
                        <i class="fas fa-share"></i>
                        <span>Share</span>
                    </button>
                    <form method="post" action="../function/simpan_bookmark.php" style="display:inline; margin-bottom:0; ">
                        <button type="submit" class="flex items-center space-x-1 hover:text-red-600">
                            <input type="hidden" name="post_id" value="' . $post['id'] . '">
                            <input type="hidden" name="account_id" value="4">
                            <i class="far fa-bookmark"></i>
                            <span>Bookmark</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </article>';
}
mysqli_stmt_close($stmt);
?>


        </section>
        <!-- Sidebar -->
        <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">
            <!-- Popular Communities -->
            <section class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-lg font-bold mb-3">
                    Popular Communities
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                        <img alt="Subreddit icon with white T letter on blue background" class="w-8 h-8 rounded-full"
                            height="32"
                            src="https://imgs.search.brave.com/zPLEmnXUkNTGq2-f6qUw6V4QGyvtMvn_xTyz6qqCLQI/rs:fit:200:200:1:0/g:ce/aHR0cHM6Ly9jZG4u/YnJpdGFubmljYS5j/b20vNjEvMjU3NDYx/LTA1MC04NDRGQzVD/NS9TcG90LWZvdXIt/bGVnZ2VkLXJvYm90/LUJvc3Rvbi1EeW5h/bWljcy5qcGc"
                            width="32" />
                        <div>
                            <a class="font-semibold text-blue-600 hover:underline" href="/s/technology.php">
                                Technology
                            </a>
                            <p class="text-xs text-gray-500">
                                12 members
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                        <img alt="Subreddit icon with white M letter on blue background" class="w-8 h-8 rounded-full"
                            height="32"
                            src="https://imgs.search.brave.com/BLUlyNmCP1YDqkAHXMF21_I4J1mpKDbuISpmATCL6lc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTMz/NzIxNDI4My92ZWN0/b3IvcmVhbGlzdGlj/LXBvcGNvcm4tY2lu/ZW1hLW1vdmllLXdh/dGNoaW5nLWNvbmNl/cHQtb25saW5lLWZp/bG1zaG93LWVudGVy/dGFpbm1lbnQtM2Qt/Y2luZW1hdGljLmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz1L/MjJTZzZvZHNmYjBj/S2ZQUHNQc1RILUtt/a1YxNDRHeEFpOUdJ/MV9NSWFVPQ"
                            width="32" />
                        <div>
                            <a class="font-semibold text-blue-600 hover:underline" href="/s/movies.php">
                                Movies
                            </a>
                            <p class="text-xs text-gray-500">
                                8 members
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                        <img alt="Subreddit icon with white G letter on green background" class="w-8 h-8 rounded-full"
                            height="32"
                            src="https://imgs.search.brave.com/7umtls4WgPf5dhNCIe9QCAYWKiugsZuO2r2xqCJ2BzM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvZ2FtaW5nLXps/M3ZuZ3hwdnYwNGEz/MGouanBn"
                            width="32" />
                        <div>
                            <a class="font-semibold text-blue-600 hover:underline" href="/s/gaming.php">
                                Gaming
                            </a>
                            <p class="text-xs text-gray-500">
                                15 members
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                        <img alt="Subreddit icon with white F letter on blue background" class="w-8 h-8 rounded-full"
                            height="32"
                            src="https://imgs.search.brave.com/xXprWLbNAmO7Znn3XGC8PVBafLbriVYwSNDBxAxedCs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTUx/NjM1MDMyL3ZlY3Rv/ci9wb3AtYXJ0LWNv/bWljLWJvb2stc3R5/bGUtbW91dGgtb2Yt/bWFuLWxhdWdoaW5n/LW91dC1sb3VkLXZl/Y3Rvci1pbGx1c3Ry/YXRpb24uanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPW1SVDMw/S2R3ZkFhYUxtZ2Jn/LS1EQU5QUXNWT19O/ZUU1V29maXltZHR4/ams9"
                            width="32" />
                        <div>
                            <a class="font-semibold text-blue-600 hover:underline" href="/s/funny.php">
                                Funny
                            </a>
                            <p class="text-xs text-gray-500">
                                22 members
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                        <img alt="Subreddit icon with white S letter on blue background" class="w-8 h-8 rounded-full"
                            height="32"
                            src="https://imgs.search.brave.com/tI00v0HeilDMXp_AF3eAXNwM_LPuvwDlKIxTTtPR7Oo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzUzLzY0LzQ5/LzM2MF9GXzUzNjQ0/OTI2XzBtdlVDSXhD/Q1R2SWE3QkFJRnVV/YTN4c2FOQTlsYmVi/LmpwZw"
                            width="32" />
                        <div>
                            <a class="font-semibold text-blue-600 hover:underline" href="/s/science.php">
                                Science
                            </a>
                            <p class="text-xs text-gray-500">
                                10 members
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <?php
require_once '../config/koneksi.php'; // atau sesuaikan path
// Ambil 5 post dengan vote terbanyak
$query = "SELECT id, title, vote, community, image_url, location FROM post ORDER BY vote DESC LIMIT 5";
$result = mysqli_query($link, $query);

echo '
<section class="bg-white rounded-md shadow-md p-4">
    <h2 class="text-lg font-bold mb-3">Trending Posts</h2>
    <ul class="space-y-4">';

while ($row = mysqli_fetch_assoc($result)) {
    echo '
        <li class="flex space-x-3 cursor-pointer hover:bg-gray-50 rounded p-2">
            ';

    // Tampilkan gambar jika ada
    if (!empty($row['image_url'])) {
        echo '
            <img alt="Post Image"
                class="w-16 h-16 rounded-md object-cover flex-shrink-0"
                src="' . htmlspecialchars($row['image_url']) . '"
                width="64" height="64" />';
    }

    echo '
            <div>
                <a class="font-semibold text-gray-900 hover:text-blue-600" href="' . $row['location'] . '">
                    ' . htmlspecialchars($row['title']) . '
                </a>
                <p class="text-xs text-gray-500 mt-1">
                    ' . htmlspecialchars($row['community']) . ' • ' . $row['vote'] . ' upvotes
                </p>
            </div>
        </li>';
}

echo '
    </ul>
</section>';
        mysqli_close($link);

?>

            <!-- Create Post Button for Mobile -->
            <div class="lg:hidden fixed bottom-6 right-6">
                <button aria-label="Create Post"
                    class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 ">
                    <i class="fas fa-plus fa-lg">
                    </i>
                </button>
            </div>
        </aside>
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
    <script>
    document.querySelectorAll('.vote-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const voteType = this.dataset.voteType; // 'up' atau 'down'
            const postDiv = this.closest('[data-post-id]');
            const postId = postDiv.dataset.postId;
            const voteCountSpan = postDiv.querySelector('.vote-count');

            try {
                const response = await fetch('../function/vote.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `post_id=${encodeURIComponent(postId)}&vote_type=${encodeURIComponent(voteType)}`
                });

                const data = await response.json();

                if (data.success) {
                    voteCountSpan.textContent = data.new_vote;
                } else {
                    alert('Terjadi kesalahan: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                alert('Gagal menghubungi server.');
                console.error('Fetch error:', error);
            }
        });
    });
    </script>

</body>

</html>