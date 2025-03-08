<?php

$rememberEmail = "";
if (isset($_COOKIE["email_manu"])) {
  $rememberEmail = $_COOKIE["email_manu"];
}
$rememberPassword = "";
if (isset($_COOKIE["password_manu"])) {
  $rememberPassword = $_COOKIE["password_manu"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Template</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assetss/css/login.css">

  <style>
    body {
      margin: 0;
      overflow: hidden;
      background: #0a0a0a;
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
    }
  </style>
</head>

<body>
  <canvas id="robotMaze"></canvas>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">

          <div class="col-md-6">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="../../assetss/images/logo.webp" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Manufacturer Login</p>

              <form>
                <div class="alert  sr-only alert-danger d-none" id="infoMessage" role="alert">
                </div>
                <div class="form-group">
                  <label for="email" class="sr-only">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="email" value="<?php echo $rememberEmail ?>">
                </div>
                <div class="form-group mb-2">
                  <label for="password" class="sr-only">Password</label>
                  <input type="password" name="password" id="password" class="form-control" placeholder="password" value="<?php echo $rememberPassword ?>">
                </div>
                <div class="custom-control custom-checkbox login-card-check-box">
                  <input type="checkbox" class="custom-control-input" id="rememberPassword">
                  <label class="custom-control-label" for="rememberPassword">Remember me</label>
                </div>
                <input name="login" id="login" class="btn btn-block login-btn mb-4 mt-3" type="button" value="Login"
                  onclick="userSignin()">
              </form>
              <a href="#!" class="forgot-password-link">Forgot password?</a>

              </p>
              <!-- <nav class="login-card-footer-nav">
                <a href="#!">Terms of use.</a>
                <a href="#!">Privacy policy</a>
              </nav> -->
            </div>
          </div>
          <div class="col-md-5">
            <img src="../../assetss/images/login.png" alt="login" class="login-card-img">
          </div>
        </div>
      </div>
      <!-- <div class="card login-card">
        <img src="assetss/images/login.jpg" alt="login" class="login-card-img">
        <div class="card-body">
          <h2 class="login-card-title">Login</h2>
          <p class="login-card-description">Sign in to your account to continue.</p>
          <form action="#!">
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-prompt-wrapper">
              <div class="custom-control custom-checkbox login-card-check-box">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember me</label>
              </div>              
              <a href="#!" class="text-reset">Forgot password?</a>
            </div>
            <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
          </form>
          <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
        </div>
      </div> -->
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script>
    function userSignin() {

      let emailField = document.getElementById("email");
      let passwordField = document.getElementById("password");
      let msg = document.getElementById("infoMessage");
      let rememberPassword = document.getElementById("rememberPassword");

      let email = emailField.value;
      let password = passwordField.value;

      if (email.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Username is Empty";
        emailField.classList = "form-control border-danger";
        passwordField.classList = "form-control";
      } else if (password.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Password is Empty";
        passwordField.classList = "form-control border-danger";
        emailField.classList = "form-control";

      } else {

        var send = {
          email: email,
          password: password,
          rememberPassword: rememberPassword.checked,
        }

        fetch("manufacturerSignin.php", {
            method: "POST",
            headers: {

              "Content-Type": "application/json;charset=UTF-8"
            },
            body: JSON.stringify(send),

          })
          .then(function(resp) {

            try {
              let response = resp.json();
              return response;
            } catch (error) {
              msg.classList = "alert alert-danger";
              msg.innerHTML = "Something wrong please try again";
              emailField.classList = "form-control";
              passwordField.classList = "form-control";
            }

          })
          .then(function(value) {

            if (value.type == "error") {
              msg.classList = "alert alert-danger";
              msg.innerHTML = "Incorrect Username or Password";
              emailField.classList = "form-control";
              passwordField.classList = "form-control";
            } else if (value.type == "success") {
              // window.location = "userDashBoard.php";

              if (value.user_type = "manufacturer") {
                window.location = "../";
              }
            } else {
              msg.classList = "alert alert-danger";
              msg.innerHTML = "Something wrong please try again";
              emailField.classList = "form-control";
              passwordField.classList = "form-control";
            }

          })
          .catch(function(error) {
            console.log(error);
          });
      }



    }

    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const fieldType = passwordField.getAttribute('type');
      if (fieldType === 'password') {
        passwordField.setAttribute('type', 'text');
      } else {
        passwordField.setAttribute('type', 'password');
      }
    }
  </script>
  <script>
    const canvas = document.getElementById('robotMaze');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    function getRandomColor() {
      return `hsl(${Math.random() * 360}, 100%, 60%)`;
    }

    class MazePath {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.length = Math.random() * 50 + 30;
        this.direction = Math.random() > 0.5 ? 'horizontal' : 'vertical';
        this.speed = Math.random() * 2 + 1;
        this.color = getRandomColor();
      }
      update() {
        if (this.direction === 'horizontal') {
          this.x += this.speed;
          if (this.x > canvas.width || this.x < 0) {
            this.speed *= -1;
            this.color = getRandomColor();
          }
        } else {
          this.y += this.speed;
          if (this.y > canvas.height || this.y < 0) {
            this.speed *= -1;
            this.color = getRandomColor();
          }
        }
      }
      draw() {
        ctx.strokeStyle = this.color;
        ctx.lineWidth = 3;
        ctx.beginPath();
        if (this.direction === 'horizontal') {
          ctx.moveTo(this.x, this.y);
          ctx.lineTo(this.x + this.length, this.y);
        } else {
          ctx.moveTo(this.x, this.y);
          ctx.lineTo(this.x, this.y + this.length);
        }
        ctx.stroke();
      }
    }

    const mazePaths = [];

    function init() {
      for (let i = 0; i < 100; i++) {
        mazePaths.push(new MazePath());
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      mazePaths.forEach(path => {
        path.update();
        path.draw();
      });
      requestAnimationFrame(animate);
    }

    init();
    animate();
  </script>
</body>

</html>