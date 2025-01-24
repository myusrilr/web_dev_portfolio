<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/custom.css">
</head>

<body>
  <div class="container" id="signup">
    <h1 class="form-title">Register</h1>
    <form method="post" action="register.php">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="username" id="username" placeholder="username" required>
        <label for="username">Username</label>
      </div>
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="re_password" id="re_password" placeholder="Retype Password" required>
        <label for="re_password">Re-Password</label>
      </div>
      <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>
    <div class="links">
      <p>Already Have Account ?</p>
      <a href="index.php" id="signInButton">Sign In</a>
    </div>
  </div>
</html>