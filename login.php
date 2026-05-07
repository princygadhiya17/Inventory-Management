<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login.css" />
  <!-- Font Awesome CDN link for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>
  <div class="wrapper">
    <div class="title"><span>Login Form</span></div>
    <form action="login_process.php" method="POST">
      <div class="row">
        <i class="fas fa-user"></i>
        <input type="email" name="email" placeholder="Email" required />
      </div>
      <div class="row">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required />
      </div>
     
      <div class="row button">
        <input type="submit" name="login" value="Login" />
      </div>
      <div class="signup-link">Not a member? <a href="#">Signup now</a></div>
    </form>
  </div>
</body> 
</html>