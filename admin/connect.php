<?php

$host='localhost:3307';
$vt='eticaret';
$kullanici='root';
$ksifre='';
$connect=@mysqli_connect($host,$kullanici,$ksifre,$vt) or exit('Bağlantı hatası:'.mysqli_connect_errno());
mysqli_set_charset($connect,"UTF8");

?>