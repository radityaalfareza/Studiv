<?php
session_start();
require_once '../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
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
                <a href="../beranda.php">
                    <img alt="Studiv" src="../img/logo studiv.svg" width="180" class="cursor-pointer" />
                </a>
            </div>
            <form class="hidden sm:flex flex-1 max-w-xl mx-4" style="margin-top: auto; margin-bottom: auto;" method="GET" action="funny.php">
                <label class="sr-only" for="search">
                    Search Studiv
                </label>
                <div class="relative w-full" margin="auto">
                    <input class="block w-full pl-10 pr-4 py-2 rounded-md border border-gray-300  focus:border-blue-500"
                        id="search" name="search" placeholder="Search Studiv" type="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
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
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../profile.php"
                            role="menuitem" tabindex="-1" id="menu-item-0">
                            Profile
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../notifikasi.php"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            Notification
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../bookmark.php"
                            role="menuitem" tabindex="-1" id="menu-item-2">
                            Bookmark
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../setting.php"
                            role="menuitem" tabindex="-1" id="menu-item-3">
                            Settings
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../?logout=1"
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
        <section class="flex-1 bg-white rounded-md shadow-md p-4" style="width:100vh;">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">
                    Funny
                </h1>
            </div>
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
$search_query = $_GET['search'] ?? '';

$query = "
SELECT 
    post.id, post.title, post.body, post.vote, post.community, post.created_at, post.location,
    account.username,
    (SELECT COUNT(*) FROM comment WHERE comment.comment_at = post.id) AS comment_count
FROM post
JOIN account ON post.owner = account.id
WHERE post.community = 'Funny'
";

$params = [];
$types = "";

// Jika ada search query, tambahkan kondisi AND
if (!empty($search_query)) {
    $query .= " AND post.title LIKE ?";
    $params[] = '%' . $search_query . '%';
    $types .= "s";
}

$query .= " ORDER BY post.created_at DESC";

$stmt = mysqli_prepare($link, $query);

if (!empty($search_query)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


// Loop menampilkan post
while ($post = mysqli_fetch_assoc($result)) {
    $img_url = $community_images[$post['community']] ?? 'default_image_url.jpg'; // fallback

    // Cek apakah user sudah vote post ini
    $user_vote = null;
    if (isset($_SESSION['account_id'])) {
        $vote_check_stmt = mysqli_prepare($link, "SELECT vote_type FROM vote WHERE account_id = ? AND post_id = ?");
        mysqli_stmt_bind_param($vote_check_stmt, "ii", $_SESSION['account_id'], $post['id']);
        mysqli_stmt_execute($vote_check_stmt);
        mysqli_stmt_bind_result($vote_check_stmt, $user_vote_val);
        if (mysqli_stmt_fetch($vote_check_stmt)) {
            $user_vote = $user_vote_val; // 'up' atau 'down'
        }
        mysqli_stmt_close($vote_check_stmt);
    }

    $upvote_class = ($user_vote === 'up') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600';
    $downvote_class = ($user_vote === 'down') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600';


    echo '
    <article class="border border-gray-200 rounded-md mb-4 hover:shadow-lg transition-shadow duration-150">
        <div class="flex p-3">
            <div class="flex flex-col items-center mr-4 select-none w-12" data-post-id="' . $post['id'] . '">
                <button aria-label="Upvote" class="' . $upvote_class . ' vote-btn" data-vote-type="up">
                    <i class="fas fa-arrow-up fa-lg"></i>
                </button>
                <span class="font-semibold text-gray-700 mt-1 vote-count" id="vote-count-' . $post['id'] . '">
                    ' . $post['vote'] . '
                </span>
                <button aria-label="Downvote" class="' . $downvote_class . ' vote-btn" data-vote-type="down">
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
                    <form method="get" action="' . htmlspecialchars($post['location']) . '" style="display:inline; margin-bottom:0;">
                        <button type="submit" class="flex items-center space-x-1 hover:text-red-600">
                            <i class="far fa-comment"></i>
                            <span>' . $post['comment_count'] . '</span>
                        </button>
                    </form>
                    <button class="flex items-center space-x-1 hover:text-green-600">
                        <i class="fas fa-share"></i>
                        <span>Share</span>
                    </button>';
    
    if (isset($_SESSION['account_id'])) {
        echo '
        <form method="post" action="../function/simpan_bookmark.php" style="display:inline; margin-bottom:0;">
            <input type="hidden" name="post_id" value="' . $post['id'] . '">
            <input type="hidden" name="account_id" value="' . htmlspecialchars($_SESSION['account_id']) . '">
            <button type="submit" class="flex items-center space-x-1 hover:text-red-600">
                <i class="far fa-bookmark"></i>
                <span>Bookmark</span>
            </button>
        </form>';
    }

    echo '
                </div>
            </div>
        </div>
    </article>';
}

mysqli_stmt_close($stmt);
?>

        </section>
        <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">
            <section class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-lg font-bold mb-3">
                    Popular Communities
                </h2>
                <ul class="space-y-3">
                    <?php
                    // Array of communities and their corresponding images
                    $popular_communities = [
                        "Technology" => "https://imgs.search.brave.com/zPLEmnXUkNTGq2-f6qUw6V4QGyvtMvn_xTyz6qqCLQI/rs:fit:200:200:1:0/g:ce/aHR0cHM6Ly9jZG4u/YnJpdGFubmljYS5j/b20vNjEvMjU3NDYx/LTA1MC04NDRGQzVD/NS9TcG90LWZvdXIt/bGVnZ2VkLXJvYm90/LUJvc3Rvbi1EeW5h/bWljcy5qcGc",
                        "Movies" => "https://imgs.search.brave.com/BLUlyNmCP1YDqkAHXMF21_I4J1mpKDbuISpmATCL6lc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTMz/NzIxNDI4My92ZWN0/b3IvcmVhbGlzdGlj/LXBvcGNvcm4tY2lu/ZW1hLW1vdmllLXdh/dGNoaW5nLWNvbmNl/cHQtb25saW5lLWZp/bG1zaG93LWVudGVy/dGFpbm1lbnQtM2Qt/Y2luZW1hdGljLmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz1L/MjJTZzZvZHNmYjBj/S2ZQUHNQc1RILUtt/a1YxNDRHeEFpOUdJ/MV9NSWFVPQ",
                        "Gaming" => "https://imgs.search.brave.com/7umtls4WgPf5dhNCIe9QCAYWKiugsZuO2r2xqCJ2BzM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvZ2FtaW5nLXps/M3ZuZ3hwdnYwNGEz/MGouanBn",
                        "Funny" => "https://imgs.search.brave.com/xXprWLbNAmO7Znn3XGC8PVBafLbriVYwSNDBxAxedCs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTUx/NjM1MDMyL3ZlY3Rv/ci9wb3AtYXJ0LWNv/bWljLWJvb2stc3R5/bGUtbW91dGgtb2Yt/bWFuLWxhdWdoaW5n/LW91dC1sb3VkLXZl/Y3Rvci1pbGx1c3Ry/YXRpb24uanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPW1SVDMw/S2R3ZkFhYUxtZ2Jn/LS1EQU5QUXNWT19O/ZUU1V29maXltZHR4/ams9",
                        "Science" => "https://imgs.search.brave.com/tI00v0HeilDMXp_AF3eAXNwM_LPuvwDlKIxTTtPR7Oo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzUzLzY0LzQ5/LzM2MF9GXzUzNjQ0/OTI2XzBtdlVDSXhD/Q1R2SWE3QkFJRnVV/YTN4c2FOQTlsYmVi/LmpwZw"
                    ];

                    foreach ($popular_communities as $community_name => $image_url) {
                        // Query to get the total number of posts for the current community
                        $query_count = "SELECT COUNT(*) AS total_posts FROM post WHERE community = ?";
                        $stmt_count = mysqli_prepare($link, $query_count);
                        mysqli_stmt_bind_param($stmt_count, "s", $community_name);
                        mysqli_stmt_execute($stmt_count);
                        $result_count = mysqli_stmt_get_result($stmt_count);
                        $row_count = mysqli_fetch_assoc($result_count);
                        $total_posts = $row_count['total_posts'];
                        mysqli_stmt_close($stmt_count);
                    ?>
                        <li class="flex items-center space-x-3 hover:bg-gray-50 rounded p-2 cursor-pointer">
                            <img alt="Community icon for <?php echo htmlspecialchars($community_name); ?>" class="w-8 h-8 rounded-full"
                                height="32"
                                src="<?php echo htmlspecialchars($image_url); ?>"
                                width="32" />
                            <div>
                                <a class="font-semibold text-blue-600 hover:underline" href="/s/<?php echo strtolower($community_name); ?>.php">
                                    <?php echo htmlspecialchars($community_name); ?>
                                </a>
                                <p class="text-xs text-gray-500">
                                    <?php echo $total_posts; ?> Posts
                                </p>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
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

            <div class="lg:hidden fixed bottom-6 right-6">
                <button aria-label="Create Post"
                    class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 ">
                    <i class="fas fa-plus fa-lg">
                    </i>
                </button>
            </div>
        </aside>
    </main>
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
        button.addEventListener('click', async function () {
            const voteType = this.dataset.voteType;
            const postDiv = this.closest('[data-post-id]');
            const postId = postDiv.dataset.postId;
            const voteCountSpan = postDiv.querySelector('.vote-count');

            try {
                const response = await fetch('../function/vote.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `post_id=${encodeURIComponent(postId)}&vote_type=${encodeURIComponent(voteType)}`,
                    credentials: 'include'
                });

                const text = await response.text();
                let data;

                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error("Gagal parse JSON dari server:");
                    console.error("Teks mentah dari server:", text); // ⬅️ inilah yang benar
                    alert('Format response server tidak valid.');
                    return;
                }

if (data.success) {
    // Update vote count
    voteCountSpan.textContent = data.new_vote;

    // Update warna tombol
    const upBtn = postDiv.querySelector('button[data-vote-type="up"]');
    const downBtn = postDiv.querySelector('button[data-vote-type="down"]');

    if (voteType === 'up') {
        // Kalau vote up sekarang aktif, tombol up warna biru, tombol down abu
        upBtn.classList.add('text-blue-600');
        upBtn.classList.remove('text-gray-400', 'hover:text-blue-600');

        downBtn.classList.remove('text-blue-600');
        downBtn.classList.add('text-gray-400', 'hover:text-blue-600');
    } else {
        // Kalau vote down sekarang aktif, tombol down warna biru, tombol up abu
        downBtn.classList.add('text-blue-600');
        downBtn.classList.remove('text-gray-400', 'hover:text-blue-600');

        upBtn.classList.remove('text-blue-600');
        upBtn.classList.add('text-gray-400', 'hover:text-blue-600');
    }

    // Kalau vote dihapus (klik tombol yang sama kedua kali), reset warna tombol
    if (data.vote_cleared) {
        upBtn.classList.remove('text-blue-600');
        upBtn.classList.add('text-gray-400', 'hover:text-blue-600');

        downBtn.classList.remove('text-blue-600');
        downBtn.classList.add('text-gray-400', 'hover:text-blue-600');
    }
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