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
 <div><br/><br/><br/><br/><br/><br/> </div>
</html>
<?php
include 'connect.php';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;
    $product_stock = $_POST['product_stock'];

    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($product_stock)) {
        $message[] = 'Please fill out all fields';
    } else {
        $insert = "INSERT INTO products(name, price, image, stock) VALUES('$product_name', '$product_price', '$product_image', '$product_stock')";
        $upload = mysqli_query($connect, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
} elseif (isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['new_stock'];

    // Stok güncelleme işlemi
    $updateQuery = "UPDATE products SET stock = stock + '$new_stock' WHERE id = '$product_id'";
    $executeUpdate = mysqli_query($connect, $updateQuery);

    if ($executeUpdate) {
        $message[] = "Stock updated successfully";
    } else {
        $message[] = "Failed to update stock";
    }
} elseif (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM products WHERE id = '$id'");
    header('location: admin_page.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Add a new product</h3>
                <input type="text" placeholder="Enter product name" name="product_name" class="box">
                <input type="number" placeholder="Enter product price" name="product_price" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="number" placeholder="Enter stock quantity" name="product_stock" class="box">
                <input type="submit" class="btn" name="add_product" value="Add product">
            </form>
        </div>

        <?php
        $select = mysqli_query($connect, "SELECT * FROM products");
        ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Product image</th>
                        <th>Product name</th>
                        <th>Product price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?>/-</td>
                        <td>
                            <?php echo $row['stock']; ?>
                        </td>
                        <td>
                            <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Edit </a>
                            <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Delete </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Stok güncelleme formunu açan JavaScript kodu -->
        <script>
            function openUpdateForm(productId) {
                var newStock = prompt("Enter new stock quantity:");

                if (newStock !== null && newStock.trim() !== "") {
                    var form = document.createElement('form');
                    form.method = 'post';
                    form.action = '<?php echo $_SERVER['PHP_SELF']; ?>';

                    var productIdField = document.createElement('input');
                    productIdField.type = 'hidden';
                    productIdField.name = 'product_id';
                    productIdField.value = productId;
                    form.appendChild(productIdField);

                    var newStockField = document.createElement('input');
                    newStockField.type = 'hidden';
                    newStockField.name = 'new_stock';
                    newStockField.value = newStock;
                    form.appendChild(newStockField);

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    </div>
</body>
</html>
