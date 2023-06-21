<?php
include 'connect.php';
if (isset($_POST["verify_email"]))
{
    $email = $_POST["email"];
    $verification_code = $_POST["verification_code"];

    // connect with database
  //  $conn = mysqli_connect("localhost:8889", "root", "root", "test");

    // mark email as verified
    $sql = "UPDATE kullanicibilgileri SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
    $result  = mysqli_query($connect, $sql);

    if (mysqli_affected_rows($connect) == 0)
    {
        die("Verifikasyon Kodu Hatası .");
    }

    echo "<p>Artık Giriş Yapabilirsiniz.</p> 
    
    ";
    
    echo "<script>setTimeout(function(){window.location.href='user_login.php';}, 3000);</script>";
    exit();
}
/** 

*/
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
              body{ font: 14px sans-serif; }
              .wrapper{ width: 360px; padding: 20px; }
          </style>
</head>
<body>
<form method="POST">
<div class="wrapper">
    <div class="form-group">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
    </div>
    <div class="form-group">
    <input type="text"  name="verification_code"   placeholder="Verifikasyon Kodunu Buraya Girin" required />
    </div>
    <input type="submit" class="btn btn-primary" name="verify_email" value="E-Mail Doğrula">
    </div>
    </div>
    
    
                  
                  </form>
</body>
</html>