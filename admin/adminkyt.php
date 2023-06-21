<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../admin/css/admindashboard.css" />
  </head>
  <body>
    <header id="navbar">
      <nav class="navbar-container container">
        <a href="../dashboard.php" class="home-link">
          <div class="navbar-logo"></div>
         TavukShopping Admin Panel
        </a>
        <button type="button" class="navbar-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="navbar-menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
        <div id="navbar-menu" class="detached">
            <ul class="navbar-links">
               <li class="navbar-item"><a class="navbar-link" href="admin_page.php">Ürün Ekle</a></li>
               <li class="navbar-item"><a class="navbar-link" href="admin_urun.php">Ürün Listesi</a></li>
               <li class="navbar-item"><a class="navbar-link" href="admin_uyebilgi.php">Üye Listesi</a></li>
               <li class="navbar-item"><a class="navbar-link" href="admingrs.php">Çıkış yap</a></li>
            </ul>
         </div>
      </nav>
  </header>
  <script src="index.js"></script>
 </body>
 <div><br/></div>
</html>
<?php
include("connect.php"); 

$mesaj = ""; // Kayıt mesajını saklamak için değişken

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = strtoupper($_POST['mail']);
    $parola = $_POST['password'];
    $reparola = $_POST['repassword'];
    $number = preg_match('@[0-9]@', $parola);

    // Mail Doğrulama
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mesaj = "Geçersiz e-posta adresi";
    }

    // Parola Doğrulama
    elseif (!$parola) {
        $mesaj = "Lütfen şifrenizi girin.";
    } elseif (!$number || strlen(trim($parola)) < 6) {
        $mesaj = "Şifre en az 6 karakter uzunluğunda olmalı ve en az bir rakam içermelidir.";
    }

    elseif ($parola != $reparola) {
        $mesaj = "Şifreler birbirleriyle aynı olmalıdır.";
    }

    else {
        mysqli_report(MYSQLI_REPORT_OFF);
        $cnn = $connect;
        
        // Veritabanında aynı kullanıcı var mı kontrolü
        $kSorgu = 'SELECT COUNT(*) FROM admin WHERE mail = ?';
        $kStmt = mysqli_stmt_init($cnn);
        mysqli_stmt_prepare($kStmt, $kSorgu) or exit('Sorgu hatası: ' . mysqli_stmt_errno($kStmt));
        mysqli_stmt_bind_param($kStmt, 's', $mail) or exit('Bağlantı hatası');
        mysqli_stmt_execute($kStmt) or exit('Sorgu hatası: ' . mysqli_stmt_errno($kStmt));
        mysqli_stmt_bind_result($kStmt, $kullanici_sayisi);
        mysqli_stmt_fetch($kStmt);
        mysqli_stmt_close($kStmt);
        
        if ($kullanici_sayisi > 0) {
            $mesaj = "E-posta veya şifrenizi kontrol edin.";
        }
        
        else {
            // Kullanıcıyı veritabanına ekle
            $sorgu = 'INSERT INTO admin (mail, password) VALUES (?, ?)';
            $stmt = mysqli_stmt_init($cnn);
            mysqli_stmt_prepare($stmt, $sorgu) or exit('Sorgu hatası: ' . mysqli_stmt_errno($stmt));
            mysqli_stmt_bind_param($stmt, 'ss', $mail, $parola) or exit('Bağlantı hatası');
            mysqli_stmt_execute($stmt) or exit('Sorgu hatası: ' . mysqli_stmt_errno($stmt));
    
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $mesaj = "Kayıt başarıyla tamamlandı.";
            }
    
            mysqli_stmt_close($stmt);
            mysqli_close($cnn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kayıt</title>
    <style>
          body {
            background-color: #000f20;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        form {
            width: 300px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-family: cursive;
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #000f20;
            color: #fff;
            font-weight: bold;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }
        
        .message {
            text-align: center;
            margin-top: 20px;
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="adminkyt.php" method="post">
        <h2>Admin Kayıt</h2>
        E-POSTA: <input type="text" name="mail"><br/>
        Şifre: <input type="password" name="password"><br/>
        Şifre Tekrarı: <input type="password" name="repassword"><br/>
        <input type="submit" name="kaydet" value="Kayıt Ol">
    </form>
    <div class="message"><?php echo $mesaj; ?></div>
</body>
</html>
