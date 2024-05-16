<?php 
session_start();

include("config.php");
include("function.php");



	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$email = $_POST['email'];
		$password = $_POST['password'];

		if(!empty($email) && !empty($password) && !is_numeric($email))
		{

			//save to database
			$user_id = random_num(10);
			$query = "insert into users (user_id,email,password) values ('$user_id','$email','$password')";

			mysqli_query($conn, $query);

			header("Location: login.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> CvSU ONLINE CANVASSING </title>

        <!-- favicon -->
        <link rel="icon" href="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" type="image/gif" sizes="18x16">

        <!-- CSS -->
        <link rel="stylesheet" href="CSS\login.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>

  </head>
  <body>
    <div class="bg-img">
      <div class="content">
        <header>Signup</header>
        <form method="post" >
          <div class="field">
            <span class="fa fa-user"></span>
            <input type="text" required placeholder="Email" name="email">
          </div>
          <div class="field space">
            <span class="fa fa-lock"></span>
            <input type="password" class="pass-key" required placeholder="Password" name="password">
            <span class="show">SHOW</span>
          </div>
          <div class="pass">
            <a href="#">Forgot Password?</a>
          </div>
          <div class="field">
            <input type="submit" value="LOGIN">
          </div>
        </form>
        <div class="login">
          
        <span>Already have an account? <a href="login.php">Login</a></span>
                    </div>
                </div>

                <div class="line"></div>
    <script>
      const pass_field = document.querySelector('.pass-key');
      const showBtn = document.querySelector('.show');
      showBtn.addEventListener('click', function(){
       if(pass_field.type === "password"){
         pass_field.type = "text";
         showBtn.textContent = "HIDE";
         showBtn.style.color = "#3498db";
       }else{
         pass_field.type = "password";
         showBtn.textContent = "SHOW";
         showBtn.style.color = "#222";
       }
      });
    </script>


  </body>
</html>