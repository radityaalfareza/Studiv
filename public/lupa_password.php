<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('gambar/background.svg');
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 5%; 
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #1d4ed8;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #1e40af;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 1rem;
        }

        .social-buttons button {
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-center {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: right;">
            <a href="halaman-login.html" style="color: #1d4ed8; font-weight: bold;">Kembali</a>
            <h2 style="text-align: left;">Lupa Password</h2>
        </div>
        <form action="proses_lupa_password.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="contoh@email.com" required />
            </div>
            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
