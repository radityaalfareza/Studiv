<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['account_id'])) {
    header("Location: ../../halaman_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>&lt;script&gt;alert()&lt;/script&gt;</title> <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
      body { font-family: "Roboto", sans-serif; }
    </style>
  </head>
  <body class="bg-gray-100 min-h-screen flex flex-col">
      <header class="bg-white shadow sticky top-0 z-50">
        <?php
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: ../../halaman_login.php");
            exit;
        }
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <a href="../../beranda.php">
                    <img alt="Studiv" src="../../img/logo studiv.svg" width="180" class="cursor-pointer" />
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
                        <a href="../../create_post.php"> Create Post</a>
                    </span>
                </button>
            </nav>
            <div class="relative" x-data="{ open: false }">
                <button aria-haspopup="true" aria-expanded="false" aria-label="User menu"
                    class="flex items-center space-x-2  rounded" id="user-menu-button" type="button"
                    onclick="toggleDropdown()">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                        <?php
                        require_once "../../config/koneksi.php";
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
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../../profile.php"
                            role="menuitem" tabindex="-1" id="menu-item-0">
                            Profile
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../../notifikasi.php"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            Notification
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../../bookmark.php"
                            role="menuitem" tabindex="-1" id="menu-item-2">
                            Bookmark
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700" href="../../setting.php"
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
    <main class="flex-grow max-w-4xl mx-auto px-4 py-8">
      <article class="bg-white rounded-md shadow-md p-6 mb-8" style="width:100vh;">
        <div class="text-xs text-gray-500 mb-3 flex items-center justify-between">
          <div>
            <a class="font-semibold text-blue-600 hover:underline" href="/s/technology.php">Technology</a>
            <span>• Posted by reza</span>
          </div>
          <button id="shareButton" class="ml-4 px-3 py-1.5 border border-gray-300 text-gray-600 rounded hover:bg-gray-50 text-sm">
            <i class="fas fa-share-alt mr-1"></i> Share
          </button>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 mb-4">&lt;script&gt;alert()&lt;/script&gt;</h1>
        <p class="text-gray-700 mb-4">adad</p>
        
      </article>
      <section>
        <form id="comment-form" class="mb-6 space-y-4">
          <textarea
            aria-label="Add a comment"
            class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-y"
            id="new-comment"
            name="new-comment"
            placeholder="Add a comment..."
            rows="3"
            required
          ></textarea>
          <div class="flex justify-end space-x-2">
            <button
              class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              type="submit"
            >
              Comment
            </button>
          </div>
          <input type="hidden" id="reply-to" name="reply-to" value="" />
        </form>
        <ul id="comments-list" class="space-y-6">
          <?php
          // ID post langsung disimpan di variabel ini agar mudah akses komentar
          $postId = 109;
          require_once '../../function/render_comment.php';
          ?>
        </ul>
      </section>
    </main>
    <script>
      const postId = <?php echo json_encode(109); ?>;
      const commentForm = document.getElementById('comment-form');
      const commentInput = document.getElementById('new-comment');
      const replyToInput = document.getElementById('reply-to');
      const commentsList = document.getElementById('comments-list');

      commentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const comment = commentInput.value.trim();
        if (!comment) {
          alert('Komentar tidak boleh kosong');
          return;
        }
        const replyTo = replyToInput.value || '';

        fetch('../../function/submit_comment.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({
            postId: postId,
            commentBody: comment,
            replyTo: replyTo
          }),
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const div = document.createElement('div');
            div.className = 'bg-white rounded-md shadow p-4 mb-4';
            div.innerHTML =
              '<div class="flex items-start space-x-3">' +
                '<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">' +
                  data.comment.username.charAt(0).toUpperCase() +
                '</div>' +
                '<div class="flex-1">' +
                  '<div class="flex justify-between">' +
                    '<span class="font-semibold text-blue-600">' + data.comment.username + '</span>' +
                    '<span class="text-sm text-gray-500">' + data.comment.created_at + '</span>' +
                  '</div>' +
                  '<p class="text-gray-700 mt-2">' + data.comment.body.replace(/\n/g, '<br>') + '</p>' +
                '</div>' +
              '</div>';
            commentsList.appendChild(div);
            commentInput.value = '';
            replyToInput.value = '';
            commentInput.placeholder = 'Add a comment...';
          } else {
            alert('Gagal menambahkan komentar: ' + (data.error || 'Unknown error'));
          }
        })
        .catch(() => window.location.reload());
      });

      // --- Fitur Salin URL (Tombol Share) ---
      const shareButton = document.getElementById('shareButton');

      // Mengambil URL saat ini dari browser
      const postUrl = window.location.href; 
      
      shareButton.addEventListener('click', async () => {
          try {
              await navigator.clipboard.writeText(postUrl);
              // Opsional: Berikan feedback ke pengguna
              alert('URL post berhasil disalin!');
          } catch (err) {
              console.error('Gagal menyalin URL: ', err);
              // Fallback untuk browser lama atau jika navigator.clipboard tidak didukung
              const textArea = document.createElement("textarea");
              textArea.value = postUrl;
              document.body.appendChild(textArea);
              textArea.focus();
              textArea.select();
              try {
                  document.execCommand('copy');
                  alert('URL post berhasil disalin! (Fallback)');
              } catch (err) {
                  console.error('Fallback: Gagal menyalin URL: ', err);
                  alert('Gagal menyalin URL. Silakan salin secara manual: ' + postUrl);
              }
              document.body.removeChild(textArea);
          }
      });
      // --- Akhir Fitur Salin URL ---
    </script>
  </body>
</html>