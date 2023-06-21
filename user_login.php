<?php
include 'connect.php';
session_start();
$email = $sifre= "";
$email_err =$errorMessage  =$sifre_err = $login_err = "";

    if (isset($_POST["login"]))
    {
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];

        // check if credentials are okay, and email is verified
        $sql = "SELECT * FROM kullanicibilgileri WHERE email = '" . $email . "' ";
        $result = mysqli_query($connect, $sql);
 
        if (mysqli_num_rows($result) == 0)
        {
            die("Email Bulunamadı.");
        }
 
        $user = mysqli_fetch_object($result);
 
        if (!password_verify($sifre, $user->sifre))
        {
            $errorMessage = '<p style="color: #ff0000; font-weight: bold;">Hatalı şifre girdiniz. Lütfen tekrar deneyin.</p>';
            die(" $errorMessage <script>setTimeout(function(){window.location.href='user_login.php';}, 1500);</script>" );
             
           
        }
       //   $sifre_err= '<p style="color: #ff0000; font-weight: bold;">Hatalı Şifre Girdiniz. Stoktaki ürün sayısı: ';
        elseif ($user->email_verified_at == null)
        {
            die("Lütfen Emailinizi Doğrulayın <a href='email-verification.php?email=" . $email . "'>from here</a>");
        }
 else{
    $_SESSION['user_id'] = $user->id;
    header('location:index.html');
       // echo "Giriş Başarılı  <script>setTimeout(function(){window.location.href='index.html';}, 2000);</script>";
    
    }
   
    exit();

   
    } 
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Giriş Yap</title>
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
              body{ font: 14px sans-serif; align-items: center; display: flex;
                justify-content: center; height: 100vh;}
              .wrapper{ width: 360px; padding: 20px;  }
          </style>
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
    
<form method="POST">
<div class="wrapper">
<div class="form-group">
    <input type="email" name="email" class="form-control "placeholder="E-Mail Giriniz" required />
</div>
<div class="form-group">
    <input type="password" name="sifre" class="form-control "placeholder="Şifre Giriniz" required />
    <?php echo"$errorMessage "?>
    </div> 
    <div class="form-group">
    <input type="submit"  name="login" class="btn btn-primary" value="Giriş Yap"> 
    </div>         

</div>
 </form>
  </body>
   </html>
