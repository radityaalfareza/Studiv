<?php
require_once "config/koneksi.php";
session_start();

if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit();
}

$owner_id = $_SESSION['account_id'];

// Ambil status notifikasi user dari tabel account
$query_notif = "SELECT notification FROM account WHERE id = ?";
$stmt_notif = mysqli_prepare($link, $query_notif);
mysqli_stmt_bind_param($stmt_notif, "i", $owner_id);
mysqli_stmt_execute($stmt_notif);
$result_notif = mysqli_stmt_get_result($stmt_notif);
$row_notif = mysqli_fetch_assoc($result_notif);

$notification_status = $row_notif['notification'];

$notifications = [];

if ($notification_status != 0) {
    // Ambil notifikasi komentar pada post milik owner
    $query_comments = "
    SELECT a.username, c.body, c.created_at, p.community 
    FROM comment c
    JOIN post p ON c.comment_at = p.id
    JOIN account a ON c.owner = a.id
    WHERE p.owner = ?
    ORDER BY c.created_at DESC
    ";

    $stmt_comments = mysqli_prepare($link, $query_comments);
    mysqli_stmt_bind_param($stmt_comments, "i", $owner_id);
    mysqli_stmt_execute($stmt_comments);
    $result_comments = mysqli_stmt_get_result($stmt_comments);

    while ($row = mysqli_fetch_assoc($result_comments)) {
        $notifications[] = [
            'type' => 'comment',
            'username' => $row['username'],
            'body' => $row['body'],
            'community' => $row['community'],
            'timestamp' => $row['created_at']
        ];
    }

    // Ambil notifikasi upvote
    $query_upvotes = "
    SELECT a.username, p.community, p.updated_at 
    FROM post p
    JOIN account a ON p.owner = a.id
    WHERE p.owner = ? AND p.vote > 0
    ORDER BY p.updated_at DESC
    ";

    $stmt_upvotes = mysqli_prepare($link, $query_upvotes);
    mysqli_stmt_bind_param($stmt_upvotes, "i", $owner_id);
    mysqli_stmt_execute($stmt_upvotes);
    $result_upvotes = mysqli_stmt_get_result($stmt_upvotes);

    while ($row = mysqli_fetch_assoc($result_upvotes)) {
        $notifications[] = [
            'type' => 'upvote',
            'username' => $row['username'],
            'community' => $row['community'],
            'timestamp' => $row['updated_at']
        ];
    }
}

// Ambil semua post milik owner
$query_posts = "SELECT * FROM post WHERE owner = ? ORDER BY created_at DESC";
$stmt_posts = mysqli_prepare($link, $query_posts);
mysqli_stmt_bind_param($stmt_posts, "i", $owner_id);
mysqli_stmt_execute($stmt_posts);
$result_posts = mysqli_stmt_get_result($stmt_posts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>My Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style> body { font-family: 'Roboto', sans-serif; } </style>
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
                <label class="sr-only" for="search">Search Studiv</label>
                <div class="relative w-full" margin="auto">
                    <input class="block w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:border-blue-500"
                        id="search" placeholder="Search Studiv" type="search" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
            <nav class="flex items-center space-x-4">
                <button aria-label="Create Post"
                    class="hidden sm:inline-flex items-center space-x-2 px-3 py-1.5 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 ">
                    <i class="fas fa-plus"></i>
                    <span class="font-semibold">
                        <a href="create_post.php"> Create Post</a>
                    </span>
                </button>
            </nav>
            <div class="relative" x-data="{ open: false }">
                <button aria-haspopup="true" aria-expanded="false" aria-label="User menu"
                    class="flex items-center space-x-2 rounded" id="user-menu-button" type="button"
                    onclick="toggleDropdown()">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                        <?php   
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

    <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">My Posts</h1>
        
        <article class="bg-white rounded-md shadow-md p-6 hover:shadow-lg transition-shadow duration-200" style="width:50vw;">
        <?php if (mysqli_num_rows($result_posts) === 0): ?>
            <div class="p-6 text-center text-gray-500">
                You have no posts.
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php while ($post = mysqli_fetch_assoc($result_posts)): ?>
                        <header class="mb-2 flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($post['title']); ?></h2>
                            <div style="width: 7vw;">
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>"
                                    class="text-l text-blue-600 hover:underline" style="margin-right: 1vw;">Edit</a>
                                <a href="delete_post.php?post_id=<?php echo $post['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this post?');"
                                    class="text-l text-red-600 hover:underline">Delete</a>
                            </div>
                        </header>
                        <p class="text-gray-700 mb-3"><?= nl2br(htmlspecialchars($post['body'])); ?></p>
                        <?php if (!empty($post['image_url'])): ?>
                            <img src="<?= htmlspecialchars($post['image_url']); ?>" alt="Post Image" class="w-full rounded-md mb-3" />
                        <?php endif; ?>
                        <footer class="text-sm text-gray-500 flex flex-col space-y-1">
                            <span>Community: <?= htmlspecialchars($post['community']); ?></span>
                            <span>Votes: <?= intval($post['vote']); ?></span>
                            <span>Posted: <?= $post['created_at']; ?></span>
                        </footer>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm text-gray-500 text-center">
            © 2025 Teknologi Rekayasa Perangkat Lunak PNM.
        </div>
    </footer>
</body>
</html>
