<?php
include 'connect.php';

session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:user_login.php');
 };
  /**
 if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:user_login.php');
 };
*/

 if(isset($_GET['logout'])){
    unset($_SESSION['user_id']);
    session_destroy();
    
    // Cookie'yi silmek için süresini geçmiş bir tarih ayarlayın
    setcookie('session_name', '', time() - 3600, '/');

    header('location:index.html');
    exit;
}


if(isset($_POST['update_cart'])){
    $update_quantity = $_POST['product_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($connect, "UPDATE cart SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'cart quantity updated successfully!';
 }
 if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($connect, "DELETE FROM cart WHERE id = '$remove_id'") or die('query failed');
    header('location:cart.php');
 }
   
 if(isset($_GET['delete_all'])){
    mysqli_query($connect, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
 }
?>





  

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>


    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">Hakkımızda</a>
                    <a class="text-body mr-3" href="">Bizimle İletişime Geçin</a>
                    <a class="text-body mr-3" href="">Destek</a>
                    <a class="text-body mr-3" href="">S.S.S</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                    <?php
                    if(isset($user_id)){
      $select_user = mysqli_query($connect, "SELECT * FROM `kullanicibilgileri` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
    
         ?>

                  <a class="text-body mr-3" >İsim: <?php echo $fetch_user['isim']; ?> </a>
                  <a class="text-body mr-3" >Email: <?php echo$fetch_user['email']; ?> </a>  
                  
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Hesabım</button>
                        <div class="dropdown-menu dropdown-menu-right">

                        
                            <button onclick="window.location.href='user_login.php';" class="dropdown-item" type="button">Giriş</button>
                            <button onclick="window.location.href='register.php';" class="dropdown-item" type="button">Kayıt Ol</button>
                            <button onclick="window.location.href= 'cart.php?logout=<?php echo $user_id; ?>'" onclick="return confirm('are your sure you want to logout?');" class="dropdown-item">Çıkış Yap</button>
                            
                        </div>
                    </div> 
                    <?php  }; } ?>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">TL</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">USD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">TR</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">EN</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">BEY</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Aramak İstediğiniz Ürünü Yazın...">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Müşteri Destek</p>
                <h5 class="m-0">+031 52 6991</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Kategoriler</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Giyim <i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                <a href="" class="dropdown-item">Erkek Giyim</a>
                                <a href="" class="dropdown-item">Kadın Giyim</a>
                                <a href="" class="dropdown-item">Bebek Giyim</a>
                            </div>
                        </div>
                        <a href="" class="nav-item nav-link">Gömlekler</a>
                        <a href="" class="nav-item nav-link">Kotlar</a>
                        <a href="" class="nav-item nav-link">Mayolar</a>
                        <a href="" class="nav-item nav-link">Spor Giyim</a>
                        <a href="" class="nav-item nav-link">Takım Elbiseler</a>
                        <a href="" class="nav-item nav-link">Smokinler</a>
                        <a href="" class="nav-item nav-link">Ceketler</a>
                        <a href="" class="nav-item nav-link">Kumaş Pantolonlar</a>
                        <a href="" class="nav-item nav-link">Ayakkabılar</a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">BEY</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.html" class="nav-item nav-link active">Ana Sayfa</a>
                            <a href="shop.php" class="nav-item nav-link">Ürünlerimiz</a>
                            <!-- <a href="detail.php" class="nav-item nav-link">Ürün Detayları</a>-->
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Sayfalar<i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.php" class="dropdown-item">Sepetim</a>
                                    <a href="checkout.php" class="dropdown-item">Ödeme</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">İletişim</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Ana Sayfa</a>
                    <a class="breadcrumb-item text-dark" href="#">Mağaza</a>
                    <span class="breadcrumb-item active">Sepetim</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    
       <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Ürünler</th>
                            <th>Tutar</th>
                            <th>Miktar</th>
                            <th>Toplam Tutar</th>
                            <th>Sepetten Çıkar</th>
                        </tr>
                    </thead>
                    <?php


         $cart_query = mysqli_query($connect, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                $sub_total = $fetch_cart['price'] * $fetch_cart['quantity']; // Ürünün toplamını hesaplayın
                $grand_total += $sub_total; // Genel toplama ekleyin
            
      ?>
                    <tbody class="align-middle">
                        <tr>
                            <td class="align-middle"><img src="admin/uploaded_img/" alt="" style="width: 50px;"> <?php echo $fetch_cart['name']; ?> </td>
                            <td class="align-middle">$<?php echo $fetch_cart['price']; ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 120px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                   <input type="number" name="product_quantity" class="form-control form-control-sm bg-secondary border-0 text-center" min="1" value="<?php echo $fetch_cart['quantity'] ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <input type="hidden" name="id" value="<?php echo $fetch_cart['id']; ?>">
                            <td class="align-middle"> $<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>

                    <td class="align-middle">
                         <form  action="">
                                <input type="hidden" name="remove" value="<?php echo $fetch_cart['id']; ?>">
                                    <button type="submit" onclick="return confirm('Ürünü sepetten kaldırmak istiyor musunuz?');" class="delete-btn btn btn-sm btn-danger">
                                        <i class="fa fa-times"></i>
                        </button>
                            </form>
                                </td>
                                    </tr>
                        
                       
                    </tbody><?php } ?>
                </table>
            </div>
            
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Kupon Kodu">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Kupon Uygula</button>
                        </div>
                    </div>
                </form>
              
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Sipariş Özeti</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Ürünlerin Toplamı</h6> 
                            <?php while($fetch_cart = mysqli_fetch_assoc($cart_query)){ 
                               foreach ($cart_query as $fetch_cart) { 
                                ?>
                            <h6>$<?php echo $fetch_cart['price'];  ?></h6><?php ?><?php  } }?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Kargo Tutarı</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <?php 
                  
                   // $grand_total += $sub_total;  
        ?>
      
  
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Toplam Tutar</h5>
                            
                            <h5>$<?php echo $grand_total+10; ?></h5>  <?php       }
                      ?>
                        </div>
                        <?php
         $cart_query = mysqli_query($connect, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
                        <form   action="">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" name="product_quantity" class="form-control form-control-sm bg-secondary border-0 text-center" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
           
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" name="update_cart" >Sepeti Güncelle</button>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" >Sepeti Onayla</button>
                        </form> <?php }}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Cart End -->
    

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">BEY Shop</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>BTYO, DAÜ, Famagusta/Cyprus</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+031 52 6991
                </p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Hemen Alışveriş Yap</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Ana Sayfa</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Ürünlerimiz</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Alışveriş Detayı</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Kartlar</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Sepetim</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Bizimle İletişime Geç</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Hesabım</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Ana Sayfa</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Ürünlerimiz</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Alışveriş Detayı</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Kartlar</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Sepetim</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Bizimle İletişime Geç</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">HABERLER</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Kayıt Ol</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Bizi Takip Et</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>