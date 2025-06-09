<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Post ID tidak ditemukan.");
}

$post_id = intval($_GET['id']);
$account_id = $_SESSION['account_id'];

// Ambil data post dari DB
$query = "SELECT * FROM post WHERE id = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("Post tidak ditemukan.");
}

// Cek apakah owner post sama dengan user yang login
if ($post['owner'] != $account_id) {
    // Bisa redirect atau langsung tampilkan pesan error
    header("HTTP/1.1 403 Forbidden");
    die("Anda tidak memiliki izin untuk mengedit post ini.");
}

$post_id = intval($_GET['id']);
$account_id = $_SESSION['account_id'];

$query = "SELECT * FROM post WHERE id = ? AND owner = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $account_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Post tidak ditemukan atau bukan milik Anda.";
    exit;
}

$post = mysqli_fetch_assoc($result);
?>

<!-- HTML mulai dari sini -->
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
      body { font-family: "Roboto", sans-serif; }
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
            <form class="hidden sm:flex flex-1 max-w-xl mx-4" style="margin-top: auto; margin-bottom: auto;" method="GET" action="beranda.php">
                <label class="sr-only" for="search">
                    Search Studiv
                </label>
                <div class="relative w-full" margin="auto" style="display:none">
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

    <!-- Edit Post Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
      <div class="max-w-3xl w-full bg-white rounded-md shadow-md p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Edit Post</h1>
        <form class="space-y-6" action="function/update_post.php" method="POST" novalidate>
          <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="subreddit">Select a community</label>
            <select
              class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              id="subreddit"
              name="subreddit"
              required
            >
              <?php
              $communities = ['Technology', 'Movies', 'Gaming', 'Funny', 'Science'];
              foreach ($communities as $comm) {
                  $selected = ($post['community'] === $comm) ? 'selected' : '';
                  echo "<option value=\"$comm\" $selected>$comm</option>";
              }
              ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="title">Post Title</label>
            <input
              autocomplete="off"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              id="title"
              maxlength="300"
              name="title"
              placeholder="Enter a title for your post"
              required
              type="text"
              value="<?= htmlspecialchars($post['title']) ?>"
            />
            <p class="mt-1 text-xs text-gray-500">Max 300 characters</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="text-body">Text (required)</label>
            <textarea
              class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-y"
              id="text-body"
              name="text-body"
              rows="6"
              required><?= htmlspecialchars($post['body']) ?></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="image-url">Image URL (optional)</label>
            <input
              autocomplete="off"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              id="image-url"
              name="image-url"
              placeholder="https://contoh.com/image.jpg"
              type="url"
              value="<?= htmlspecialchars($post['image_url'] ?? '') ?>"
            />
          </div>

          <div>
            <button
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-semibold text-lg"
              type="submit"
            >
              Update Post
            </button>
          </div>
        </form>
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
