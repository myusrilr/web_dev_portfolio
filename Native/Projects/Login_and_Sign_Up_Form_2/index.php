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
  <div class="container" id="signIn">
    <h1 class="form-title">Sign In</h1>
    <form method="post" action="register.php">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="username" id="username" placeholder="username" required style="background-color: #9EDF9C;">
        <label for="username">Username</label>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
      <p class="recover">
        <a href="#">Recover Password</a>
      </p>
      <input type="submit" class="btn" value="Sign In" name="signIn">
    </form>
    <div class="links">
      <p>Don't have account yet?</p>
      <a href="signup.php" id="signupbtn">Sign Up</a>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>