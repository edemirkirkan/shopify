<!DOCTYPE HTML>
<?php
    require_once('db_connect.php');
    $sql = 'SELECT * FROM customer';
?>
<html lang="en" >
<html>
<head>
  <style>
    .login-page { width: 360px; padding: 8% 0 0; margin: auto; }
    .form { position: relative; z-index: 1; background: #6FC3E6; max-width: 360px; border-radius: 30px;
      margin: 0 auto 100px; padding: 45px; padding-top: 20px; text-align: center;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); }
    .form input { outline: 0; background: #f2f2f2; width: 100%; border: 0; margin: 0 0 15px;
      padding: 15px; box-sizing: border-box; font-size: 14px; border-radius:10px; }
    .form button { font-size: 14px; font-weight: bold; letter-spacing: .1em; outline: 0;
      background: #DA6A6A; width: 100%; border: 0; border-radius:30px; margin: 0px 0px 8px; padding: 15px; 
      color: #FFFFFF; -webkit-transition: all 0.3 ease; transition: all 0.3 ease; cursor: pointer; transition: all 0.2s; }
    .form button:hover,.form button:focus { background: #da6a6aac; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); 
      transform: translateY(-4px); }
    .form button:active { transform: translateY(2px); box-shadow: 0 2.5px 5px rgba(0, 0, 0, 0.2); }
    .form .register-form { display: none; }
    .container { position: relative; z-index: 1; max-width: 300px; margin: 0 auto; }
    .form .message { margin: 6px 6px; color: #DA6A6A; font-size: 11px; text-align: center; 
      font-weight: bold; font-style: normal; }
    body { background: rgb(2,0,36); background: radial-gradient(circle, rgba(2,0,36,1) 0%, rgba(218,106,106,1) 35%, rgba(0,212,255,1) 100%);
      font-family: "Roboto", sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: 
      grayscale; min-height: 100%; margin: 0; overflow: hidden; }
    a { font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size: 40px; text-align: center; 
      font-weight: bold; font-style: normal; color: #DA6A6A; }
    html { height: 100%; margin: 0; overflow: hidden;}
  </style>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopify Login</title>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body class="body">
<div class="login-page">
  <div class="form">
    <form method="post" action="login.php">
      <a>SHOPIFY</a>
      <br>
      <lottie-player src="https://assets4.lottiefiles.com/datafiles/XRVoUu3IX4sGWtiC3MPpFnJvZNq7lVWDCa8LSqgS/profile.json"  background="transparent"  speed="1"  style="justify-content: center;" loop  autoplay></lottie-player>
      <br>
      <input type="text" name="uname" placeholder="Username"/>
      <input type="password" name="upass" id="password" placeholder="Password"/>
      <br>
      <?php if (isset($_GET['error'])) { ?>
     		<p class="message"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
      <br>
      <button>LOGIN</button>
    </form>

  </div>
</div>
</body>
</html>
