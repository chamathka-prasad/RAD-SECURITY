<?php

$rememberEmail = "";
if (isset($_COOKIE["email_user"])) {
  $rememberEmail = $_COOKIE["email_user"];
}
$rememberPassword = "";
if (isset($_COOKIE["password_user"])) {
  $rememberPassword = $_COOKIE["password_user"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>User Login Robotic Assistance Devices</title>
  <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assetss/images/logotitle.jpg" />
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assetss/css/login.css">
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
  <canvas id="robotCanvas"></canvas>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">

        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="assetss/images/login.png" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper robot">
                <img src="assetss/images/logo.webp" alt="logo" class=" logo">
              </div>
              <p class="login-card-description">Sign into your account</p>

              <form>
                <div class="alert  sr-only alert-danger d-none" id="infoMessage" role="alert">
                </div>
                <div class="form-group">
                  <label for="email" class="sr-only">Username</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="username" value="<?php echo $rememberEmail ?>">
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
    const canvas = document.getElementById('robotCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];
    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 5 + 1;
        this.speedX = Math.random() * 3 - 1.5;
        this.speedY = Math.random() * 3 - 1.5;
      }
      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
      }
      draw() {
        ctx.fillStyle = '#00ffcc';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function init() {
      for (let i = 0; i < 100; i++) {
        particles.push(new Particle());
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach(particle => {
        particle.update();
        particle.draw();
      });
      requestAnimationFrame(animate);
    }

    init();
    animate();
  </script>
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

        fetch("userSignin.php", {
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

              if (value.user_type == "designer"||value.user_type == "designer_head") {
                window.location = "./designer";
              }
              if (value.user_type == "finance"||value.user_type == "finance_head") {
                window.location = "./finance";
              }
              if (value.user_type == "admin") {
                window.location = "./admin";
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
</body>

</html>