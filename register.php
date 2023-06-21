<!-- install phpmailer -->

<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'connect.php';
//Load Composer's autoloader
require 'vendor/autoload.php';
$email=  $isim=$sifre=$sifre_onayla=$soyisim ="";
$email_err=$isim_err =$sifre_err=$sifre_onayla_err=$soyisim_err="";

if($_SERVER["REQUEST_METHOD"] == "POST") {

   
//mysqli_stmt_close($stmt);
   }


if (isset($_POST["submit"]))
{
    $isim = $_POST["isim"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Enable verbose debug output
        $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

        //Send using SMTP
        $mail->isSMTP();

        //Set the SMTP server to send through
        $mail->Host = 'smtp.gmail.com';

        //Enable SMTP authentication
        $mail->SMTPAuth = true;

        //SMTP username
        $mail->Username = 'qburak.ozdemir.0640@gmail.com';

        //SMTP password
        $mail->Password = 'repmoujmjvwaxhep';

        //Enable TLS encryption;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('qburak.ozdemir.0640@gmail.com', 'TavukShopping');

        //Add a recipient
        $mail->addAddress($email);

        //Set email format to HTML
        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $mail->Subject = 'Email verification';
        $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();
        echo 'Doğrulama Kodu gönderildi Girmiş olduğunuz email adresini kontrol ediniz';

       // $encrypted_password = password_hash($sifre, PASSWORD_DEFAULT);

// isim girişi
       if(empty(trim($_POST["isim"]))){
        $isim_err = "Lütfen bir isim giriniz.";
 }elseif(!preg_match('/[a-zA-Z]+/', trim($_POST["isim"]))){
    $isim_err = "isim formatı sadece harfler'i içerir.";
}else{
$isim= trim($_POST["isim"]);    }
       
// soyisim girişi
       if(empty(trim($_POST["soyisim"]))){
        $soyisim_err = "Lütfen bir Soyisim giriniz.";
 }elseif(!preg_match('/[a-zA-Z]+/', trim($_POST["soyisim"]))){
    $soyisim_err = "Soyisim formatı sadece harfler'i içerir.";
}else{
$soyisim= trim($_POST["soyisim"]);    }


if(empty(trim($_POST["sifre"]))){
    $sifre_err = "Lütfen şifrenizi giriniz.";     
} elseif(strlen(trim($_POST["sifre"])) < 6){
    $sifre_err = "Şifre En Az 6 Karakterden oluşmalıdır.";
} else{
    $sifre = trim($_POST["sifre"]);
}

// şifre onayla kısmını tanımladık
if(empty(trim($_POST["sifre_onayla"]))){
    $sifre_onayla_err = "Lütfen Şifreyi onaylayın.";     
} else{
    $sifre_onayla = trim($_POST["sifre_onayla"]);
    if(empty($sifre_err) && ($sifre != $sifre_onayla)){
        $sifre_onayla_err = "Şifreler Aynı Değil.";
    }
}

if(empty($isim_err)&&empty($soyisim_err) && empty($sifre_err) && empty($sifre_onayla_err)){
                 
    
    


            $param_isim = $isim;
            $param_soyisim = $soyisim;
            $encrypted_password = password_hash($sifre, PASSWORD_DEFAULT); // Creates a password hash
            $param_sifre=$encrypted_password;
            // insert in users table
            $sql2 = "INSERT INTO kullanicibilgileri( isim,soyisim,sifre,email, verification_code, email_verified_at) VALUES ( '" . $param_isim . "','" . $param_soyisim . "','".$encrypted_password."','" . $email . "', '" . $verification_code . "', NULL)";
                        
            mysqli_query($connect, $sql2);
            //mysqli_stmt_execute($stmt) or exit('Sorgu çalıştırma hatası:'. mysqli_stmt_errno($stmt));
            header("Location: email-verification.php?email=" . $email);
            exit();

            if(mysqli_stmt_execute($stmt)){
            //login sayfasına yollar
                header("location: user_login.php");
            } else{
                     echo "Oops! Bir Şeyler tersgitti. Lütfen Tekrar Deneyin.";
                 }
                  
                // Close statement
                mysqli_stmt_close($stmt);
                
                      }
                      
                      // Close connection
                      mysqli_close($connect);

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
                             


//, '" . $encrypted_password . "'


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
<div class="wrapper">
              <h2>Üye Ol</h2>
              <p>Lütfen Üye olmak için bilgilerinizi giriniz.</p>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control " placeholder="Email Giriniz" required>
                      <span class="invalid-feedback"></span>
                  </div> 
                  <div class="form-group">
                      <label>İsim</label>
                      <input type="text" name="isim" class="form-control  <?php echo (!empty($isim_err)) ? 'is-invalid' : ''; ?>" placeholder="İsim Giriniz" value="<?php echo $isim; ?>">
                      <span class="invalid-feedback"><?php echo $isim_err; ?></span>
                  </div>    
                  <div class="form-group">
                      <label>Soyisim</label>
                      <input type="text" name="soyisim" class="form-control <?php echo (!empty($soyisim_err)) ? 'is-invalid' : ''; ?>" placeholder="Soyisim Giriniz" value="<?php echo $soyisim; ?>">
                      <span class="invalid-feedback"><?php echo $soyisim_err; ?></span>
                  </div>   
                  <div class="form-group">
                      <label>Şifre</label>
                      <input type="password" name="sifre" class="form-control <?php echo (!empty($sifre_err)) ? 'is-invalid' : ''; ?>" placeholder="Şifre Giriniz" value="<?php echo $sifre; ?>">
                      <span class="invalid-feedback"><?php echo $sifre_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label>Şifre Tekrar</label>
                      <input type="password" name="sifre_onayla" class="form-control <?php echo (!empty($sifre_onayla_err)) ? 'is-invalid' : ''; ?>" placeholder="Tekrar Şifre Giriniz" value="<?php echo $sifre_onayla; ?>">
                      <span class="invalid-feedback"><?php echo $sifre_onayla_err; ?></span>
                  </div>
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                      <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                  </div>
                  <p>Hesabınız Var mı? <a href="user_login.php">Giriş Yap</a>.</p>
              </form>
          </div>    
</body>
</html>
