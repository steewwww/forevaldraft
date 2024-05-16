<?php
require 'navbar.php';
require 'config.php';

if(isset($_POST["submit"])) {
  $signatoryName = $_POST["signatoryName"];
  $signatoryRole = $_POST["signatoryRole"]; // Added line for role input

  if($_FILES["signatoryImage"]["error"] == 4){
    echo "<script> alert('Image Does Not Exist'); </script>";
  } else {
    $fileName = $_FILES["signatoryImage"]["name"];
    $fileSize = $_FILES["signatoryImage"]["size"];
    $tmpName = $_FILES["signatoryImage"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) {
      echo "<script> alert('Invalid Image Extension'); </script>";
    } else if($fileSize > 1000000) {
      echo "<script> alert('Image Size Is Too Large'); </script>";
    } else {
      $newImageName = uniqid();
      $newImageName .= '.' . $imageExtension;

      move_uploaded_file($tmpName, 'img/' . $newImageName);
      $query = "INSERT INTO signatories (id, signatoryName, signatoryRole, signatoryImage) 
                VALUES ('', '$signatoryName', '$signatoryRole', '$newImageName')";
      mysqli_query($conn, $query);

      echo "<script>
              alert('Successfully Added');
              document.location.href = 'signatory.php';
            </script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Upload Image File</title>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    form {
      width: 400px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #fff;
    }
  </style>
</head>
<body>
  <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
    <label for="signatoryName">Name : </label>
    <input type="text" name="signatoryName" id="signatoryName" required value=""> <br>

    <!-- Added input for signatoryRole -->
    <label for="signatoryRole">Role : </label>
    <input type="text" name="signatoryRole" id="signatoryRole" required value=""> <br>

    <label for="signatoryImage">Image : </label>
    <input type="file" name="signatoryImage" id="signatoryImage" accept=".jpg, .jpeg, .png" value=""> <br> <br>

    <button type="submit" name="submit">Submit</button>
  </form>
  <br>
</body>
</html>
