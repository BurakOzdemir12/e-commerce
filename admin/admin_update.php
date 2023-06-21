<?php

include 'connect.php';

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_stock)) {
        $message[] = 'Please fill out all fields';
    } else {
        if (!empty($product_image)) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $update_data = "UPDATE products SET name='$product_name', price='$product_price', stock='$product_stock', image='$product_image' WHERE id = '$id'";
        } else {
            $update_data = "UPDATE products SET name='$product_name', price='$product_price', stock='$product_stock' WHERE id = '$id'";
        }

        $upload = mysqli_query($connect, $update_data);

        if ($upload) {
            header('location:admin_page.php');
        } else {
            $message[] = 'Could not update the product';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="admin-product-form-container centered">

            <?php

            $select = mysqli_query($connect, "SELECT * FROM products WHERE id = '$id'");
            while ($row = mysqli_fetch_assoc($select)) {

            ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">Ürün Güncelleme</h3>
                    <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Ürün adını giriniz">
                    <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Ürün fiyatını giriniz">
                    <input type="number" min="0" class="box" name="product_stock" value="<?php echo $row['stock']; ?>" placeholder="Ürün stokunu giriniz">
                    <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="Update Product" name="update_product" class="btn">
                    <a href="../admin/admin_page.php" class="btn">Go Back</a>
                </form>

            <?php
            };
            ?>

        </div>
    </div>

</body>

</html>
