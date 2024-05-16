<?php
include("config.php");

// Add proper authentication and authorization checks before performing any database operations

// Clear data from the 'cart' table
$clearQuery = "DELETE FROM comments";
if (mysqli_query($conn, $clearQuery)) {
    echo "Data cleared successfully";
} else {
    echo "Error: " . $clearQuery . "<br>" . mysqli_error($conn);
}

// Redirect to the main page or any appropriate location
header("Location: print.php");
exit();
?>
