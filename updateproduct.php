<?php

include("config.php");

if (isset($_POST['update_product'])) {
    $id = $_POST['update_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $product_price = $_POST['product_price'];
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];

    $query = "UPDATE product SET 
                `product_name` = '$product_name',
                `description` = '$description',
                `product_price` = '$product_price',
                `product_code` = '$product_code',
                `category` = '$category'
              WHERE `id` = '$id'";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header('Location: adminproduct.php');
    } else {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}

?>
