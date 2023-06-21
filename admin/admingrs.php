<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = strtoupper(filter_input(INPUT_POST, 'mail'));
    $parola = filter_input(INPUT_POST, 'password');

    if (strlen(trim($mail)) == 0) {
        $hata = 'Mail zorunludur.';
    }
    if (strlen(trim($parola)) == 0) {
        $hata = 'Şifre zorunludur';
    }

    $cnn = $connect;

    $sorgu = 'SELECT password, is_main_admin FROM admin WHERE mail = ?';

    // Veritabanı bağlantı adımları
    $stmt = mysqli_stmt_init($cnn);

    mysqli_stmt_prepare($stmt, $sorgu) or exit('Sorgu hatası: ' . mysqli_stmt_errno($stmt));
    mysqli_stmt_bind_param($stmt, 's', $mail) or exit("Parametre bağlama hatası");
    mysqli_stmt_execute($stmt) or exit('Sorgu çalıştırma hatası:' . mysqli_stmt_errno($stmt));

    mysqli_stmt_bind_result($stmt, $storedPassword, $isMainAdmin) or exit('Sonuç depolama hatası:' . mysqli_stmt_errno($stmt));

    // Kullanıcı adı doğrulama
    if (!mysqli_stmt_fetch($stmt)) {
        $hata = 'Hatalı giriş';
    }

    if ($parola != $storedPassword) {
        $hata = 'Hatalı giriş';
    }

    // Kullanıcı bilgileri doğrulandı
    if (!isset($hata)) {
        $_SESSION["OK"] = 'ok';
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($cnn);

        echo '<script>alert("Giriş başarılı! Yönlendiriliyorsunuz...");</script>';
        if ($isMainAdmin) {
            echo '<script>setTimeout(function () {window.location.href = "../admindashboard.php";}, 2000);</script>';
        } else {
            echo '<script>setTimeout(function () {window.location.href = "../dashboard.php";}, 2000);</script>';
        }
        exit;
    } else {
        echo '<script>alert("Giriş başarısız! Lütfen tekrar deneyin.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <style>
        body {
            background-color: #000f20;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        h1 {
            font-family: cursive;
            color: white;
            text-align: center;
            margin-top: 100px;
            font-size: 30px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f4f4f4;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form p {
            font-size: 14px;
            color: red;
            margin: 0 0 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #000f20;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #001c39;
        }
    </style>
</head>

<body>
    <h1>Admin Giriş</h1>
    <?php if (isset($hata)): ?>
    <p><?php echo $hata; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="mail">E-MAİL:</label>
        <input type="text" name="mail" id="mail"><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br><br>
        <input type="submit" name="kaydet" value="Giriş yap">
    </form>
</body>

</html>
