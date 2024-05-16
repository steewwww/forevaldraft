<?php 

session_start();

  require("config.php");
  require("function.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php   include ("header.php")?>
    <!-- CSS -->
    <link rel="stylesheet" href="CSS\login.css">
    
        <style>.error-message {
            background-color: #ffcccc; /* Light red background */
            color: #cc0000; /* Dark red text color */
            padding: 10px; /* Add some padding */
            margin-bottom: 10px; /* Add some space below the error message */
        }
        </style>
  </head>
  <body>
    <div class="bg-img">
      <div class="content">
        <header>Login Form</header>
        <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
       <?php endif; ?>
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
            <input type="submit" value="LOGIN" >
          </div>
        </form>
        <div class="login" >
          
        <span>Don't have an account? <a href="signup.php" class="link signup-link">Signup</a></span>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>
