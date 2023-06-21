<?php
session_start();

// Giriş yapılmışsa yönlendir
if (!isset($_SESSION['OK'])) {
   header('Location: admin/admingrs.php'); // Kullanıcıyı giriş yapma sayfasına yönlendir
   exit;
}

include 'connect.php';

// Üye sayısını almak için 
$memberCountQuery = "SELECT COUNT(*) AS total_members FROM kullanicibilgileri";
$memberCountResult = $connect->query($memberCountQuery);
if ($memberCountResult->num_rows > 0) {
    $memberCountRow = $memberCountResult->fetch_assoc();
    $memberCount = $memberCountRow["total_members"];
} else {
    $memberCount = 0;
}

// Ürün miktarını almak için 
$productCountQuery = "SELECT COUNT(*) AS total_products FROM products";
$productCountResult = $connect->query($productCountQuery);
if ($productCountResult->num_rows > 0) {
    $productCountRow = $productCountResult->fetch_assoc();
    $productCount = $productCountRow["total_products"];
} else {
    $productCount = 0;
}

// Veritabanı bağlantısını kapatma
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Admin panel</title>
   <link rel="stylesheet" type="text/css" href="admin/css/admindashboard.css" />
   <style>
      .card {
         background-color: #000f20;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         padding: 20px;
         width: 300px;
         margin: 20px;
         display: inline-block;
      }

      .card h2 {
         font-size: 24px;
         margin-bottom: 10px;
         color: #d9fcf7;
      }

      .card p {
         font-size: 18px;
         margin-bottom: 20px;
         color: #d9fcf7;
      }

      .card .member-count {
         font-size: 36px;
         font-weight: bold;
         color: #27ae60;
         
      }

      .card .btn {
         display: block;
         width: 100%;
         padding: 10px;
         text-align: center;
         background-color: #27ae60;
         color: #fff;
         font-weight: bold;
         border-radius: 4px;
         text-decoration: none;
      }
   </style>
</head>

<body>
   <header id="navbar">
      <nav class="navbar-container container">
         <a href="dashboard.php" class="home-link">
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
               <li class="navbar-item"><a class="navbar-link" href="../e-ticaret/admin/admin_page.php">Ürün Ekle</a></li>
               <li class="navbar-item"><a class="navbar-link" href="../e-ticaret/admin/admin_urun.php">Ürün Listesi</a></li>
               <li class="navbar-item"><a class="navbar-link" href="../e-ticaret/admin/admin_uyebilgi.php">Üye Listesi</a></li>
               <li class="navbar-item"><a class="navbar-link" href="../e-ticaret/admin/logout.php">Çıkış yap</a></li>
            </ul>
         </div>
      </nav>
   </header>
   <script src="index.js"></script>
   <div> <br/><br/><br/><br/></div>

   <div class="card">
      <h2>Üye Bilgileri</h2>
      <p>Toplam Üye Sayısı:</p>
      <p class="member-count"><?php echo $memberCount; ?></p>
      <a href="../e-ticaret/admin/admin_uyebilgi.php" class="btn">Detayları Gör</a>
   </div>
   <div class="card">
      <h2>Ürün Bilgileri</h2>
      <p>Toplam Ürün Sayısı:</p>
      <p class="member-count"><?php echo $productCount; ?></p>
      <a href="../e-ticaret/admin/admin_urun.php" class="btn">Detayları Gör</a>
   </div>

   <script>
      // Veri tabanından üye sayısını almak için 
      var memberCount = <?php echo $memberCount; ?>;
      var productCount = <?php echo $productCount; ?>;

      // Üye sayısını ve ürün sayısını kartların içeriğine yerleştirme
      document.querySelector('.member-count').textContent = memberCount;
      document.querySelectorAll('.member-count')[1].textContent = productCount;

      // Kartlara gölge ekleme
      var cards = document.querySelectorAll('.card');
      cards.forEach(function(card) {
         card.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.3)';
      });

      // buton tıklandığında yönlendirme 
      var buttons = document.querySelectorAll('.btn');
      buttons.forEach(function(button) {
         button.addEventListener('click', function() {
            var cardName = button.parentNode.querySelector('h2').textContent.toLowerCase().replace(' ', '_');
            var url = cardName + '.php';
            window.location.href = url;
         });
      });
      
      
  
   </script>
</body>

</html>
