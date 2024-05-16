<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the incoming data
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_code = mysqli_real_escape_string($conn, $_POST['product_code']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Check for duplicate barcode
    $query = "SELECT * FROM product WHERE product_code = '$product_code' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo 'duplicate';
        exit();
    } else {
        // Insert data into the database
        $insert_query = "INSERT INTO product (description, product_name, product_price, product_code, category) 
                         VALUES ('$description', '$product_name', '$product_price', '$product_code', '$category')";

        if (mysqli_query($conn, $insert_query)) {
            echo 'success';
            exit();
        } else {
            echo 'error';
            exit();
        }
    }
} else {
    // If the request method is not POST, redirect to an error page or display an error message
    echo 'Invalid request method';
    exit();
}
?>
