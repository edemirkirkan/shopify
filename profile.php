<?php 
include("db_connect.php");
session_start();
if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<script>
    function openReturn() {
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";  
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }   
        }
    }
</script>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="landing_page.css" rel="stylesheet">
    <title>Shopify Profile</title>
</head>
<body> 
    <nav class="sticky-top navbar-custom">
        <div class="nav-container-left">
          <a class="link-custom header-title">Shopify</a>
          <?php
            $wallet_query = "SELECT wallet FROM customer WHERE cid = '" . $_SESSION['id'] . "'";
            $wallet = mysqli_fetch_array(mysqli_query($db, $wallet_query));
            echo "<div class='textstyle'>Balance $" . $wallet['wallet'] . "</div>";
            ?>
        </div>
        <div class="nav-container-right">
            <a class="link-custom" href='landing_page.php'>Store</a>
            <a class="link-custom active-link" href='profile.php'>Profile</a>
            <a class="link-custom" href='logout.php'>Logout</a>
        </div>
    </nav>
    <?php 
        $name_query = "SELECT cname FROM customer WHERE cid = '" . $_SESSION['id'] . "'";
        if ($name = mysqli_fetch_array(mysqli_query($db, $name_query))) {
            echo "<div class='textstyle'>
            Welcome " . $name['cname'] . ". Your previous orders listed below for you. You can return any order by using return button.</div>";
        }
        $product_query = "SELECT B.pid, P.pname, B.quantity FROM product P, buy B WHERE B.pid=P.pid and B.cid='" .$_SESSION['id'] . "'";
        $result = mysqli_query($db, $product_query);
        echo "<table class='styled-table'><tr><th>Product ID</th><th>Product</th><th>Quantity</tr>"; 
        while($row = mysqli_fetch_array($result)){  
            if($row['quantity'] > 0) {
                echo "<form name='form' action=''><tr><td>" . $row['pid'] . "</td><td>"
                 . $row['pname'] . "</td><td>" . $row['quantity'] . "</tr><td></form>"; 
            } 
        }
        echo "</table>";
    ?>
    <br><br>
    <div style="text-align: center;">
    <button id="myBtn" style='width: 90px; height: 40px;'>Return<span class='material-icons'>&#xe850</span></button>
    <br><br>
    </div>
    <?php if (isset($_GET['error'])) { ?>
     		<div class="alert alert-danger textstyle" role="alert"><?php echo $_GET['error']; ?></div>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <div style="color:#53A551;" class="alert alert-success textstyle" role="alert"><?php echo $_GET['success'];?></div>
    <?php } ?>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p style="font-weight: normal;" class='textstyle'>You can return your orders 
    below by specifying its <b>product id</b> and <b>quantity</b>.</p>
    <form style="text-align:center;" name='form' action='return.php' method='post'>
    <br>
    <a>Product ID</a>
    <input type='text' class='center-block' placeholder='P100' required='required' required pattern="P[1-9][0-9][0-9]" name='pid'>
    <br> <br>
    <a>Quantity</a>
    <input type='number' class='center-block' min='1' placeholder='0' required='required' name='quantity'>
    <br> <br>
    <button id='submit' style='width: 90px; height: 40px;'>Submit<span class='material-icons'>&#xe86c</span></button>
    </form>
    <script> openReturn() </script>
    </div>
   </div>



</body>
<div class="footer">© Ege Demirkırkan | CS353 HW4 Programming Assignment</div>
</html>
<?php   
} else{
     header("Location: index.php");
     exit();
}
?>

