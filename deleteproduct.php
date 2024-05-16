<?php
include("config.php");

if(isset($_POST['delete_product']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM product WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted"); </script>';
        header("Location:adminproduct.php");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}

?>