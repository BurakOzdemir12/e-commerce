<?php
include 'connect.php';

// Ürün bilgilerini almak için veritabanı sorgusu
$productQuery = "SELECT * FROM products";
$productResult = $connect->query($productQuery);
$productCount = $productResult->num_rows;

// Veritabanı bağlantısını kapatma
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Ürünler</title>
   <link rel="stylesheet" type="text/css" href="../admin/css/admindashboard.css" />
   <style>
   table {
      width: calc(100% - 20px); /* Yanlardan 10 piksel daraltma */
      margin: 20px auto; /* Ortala */
      border-collapse: collapse;
      border: 1px solid #000f20;
      border-radius: 10px;
   }

   th,
   td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
   }

   th {
      background-color: #000f20;
      color: #d9fcf7;
   }

   @media screen and (max-width: 600px) {
      table {
         border: none;
         border-radius: 0;
      }

      th,
      td {
         border-bottom: none;
         padding: 8px;
      }

      th {
         display: none;
      }

      td:before {
         content: attr(data-label);
         font-weight: bold;
         display: block;
         margin-bottom: 5px;
      }
   }
   </style>
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
         </div>
      </nav>
   </header>
   <script src="index.js"></script>
 <div> <br/><br/></div>
   <h2 style="text-align: center; margin-top: 20px;">Ürünler</h2>

   <table>
      <thead>
         <tr>
            <th>ID</th>
            <th>Ürün Adı</th>
            <th>Fiyat</th>
            <th>Stok</th>
         </tr>
      </thead>
      <tbody>
         <?php
         if ($productCount > 0) {
            while ($row = $productResult->fetch_assoc()) {
               echo "<tr>";
               echo "<td>" . $row['id'] . "</td>";
               echo "<td>" . $row['name'] . "</td>";
               echo "<td>" . $row['price'] . "</td>";
               echo "<td>" . $row['stock'] . "</td>";
               echo "</tr>";
            }
         } else {
            echo "<tr><td colspan='4'>Ürün bulunamadı.</td></tr>";
         }
         ?>
      </tbody>
   </table>

   <script src="../admin/js/navbar.js"></script>
</body>

</html>
