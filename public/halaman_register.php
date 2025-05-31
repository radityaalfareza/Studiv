<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
</head>
<body>
    <h2>Form Registrasi</h2>
    <form action="proses_register.php" method="post" autocomplete="off">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required minlength="3" maxlength="50"
               pattern="^[a-zA-Z0-9_]+$" title="Hanya huruf, angka, dan underscore (_)">
        <br><br>

        <label for="email">Email (tanpa simbol aneh):</label><br>
        <input type="text" id="email" name="email" required
               pattern="^[a-zA-Z0-9_@.]+$" title="Hanya huruf, angka, underscore, @, dan titik">
        <br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required minlength="6">
        <br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
