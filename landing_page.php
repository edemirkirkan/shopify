<?php 
include("db_connect.php");
session_start();
if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="landing_page.css" rel="stylesheet">
    <title>Shopify</title>
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
            <a class="link-custom active-link" href='landing_page.php'>Store</a>
            <a class="link-custom" href='profile.php'>Profile</a>
            <a class="link-custom" href='logout.php'>Logout</a>
        </div>
    </nav>
    
    <?php 
        $name_query = "SELECT cname FROM customer WHERE cid = '" . $_SESSION['id'] . "'";
        if ($name = mysqli_fetch_array(mysqli_query($db, $name_query))) {
            echo "<div class='textstyle'>
            Welcome " . $name['cname'] . ". Products available in the store are listed below for you!</div>";
        }
        $product_query = "SELECT * FROM product";
        $result = mysqli_query($db, $product_query);
        echo "<table class='styled-table'><tr><th>Product</th><th>Price</th><th>Stock</th><th>Amount</th><th><span class='material-icons'>&#xe854</span></th></tr>"; 
        while($row = mysqli_fetch_array($result)){  
            if($row['stock'] > 0) {
                echo "<form name='form' action='' method='post'><tr><td>" . $row['pname'] . "</td><td>" . $row['price'] . "</td><td>" . $row['stock'] . "</td><td>" .  
                "<input type='number' min='1' max='". $row['stock'] . "' placeholder='Quantity' required='required' name='amount'>" . "</td><td>" . 
                "<button name='pid' value=" . $row['pid'] . ">Buy<span class='material-icons'>&#xf04b</span></button>" . "</td></tr> </form>"; 
            } 
        }
        echo "</table>";
        if (isset($_POST['pid']) and isset($_POST['amount'])) {
            $sql_price = "SELECT price FROM product WHERE pid = '" . $_POST['pid'] . "'"; 
            if ($price = mysqli_fetch_array(mysqli_query($db, $sql_price))) {
                $new_wallet = $wallet['wallet'] - ($price['price'] * $_POST['amount']);
            } 
            if ($new_wallet < 0) {
                echo "<div class='alert alert-danger textstyle' role='alert'>
                Insufficient balance!
                You can deposit money into your account from profile. </div>";
            }
            else {
                $sql_wallet = "UPDATE customer SET wallet = " . $new_wallet . " WHERE cid = '" . $_SESSION['id'] . "'";
                $sql_stock = "UPDATE product SET stock = stock - " .  $_POST['amount']  . " WHERE pid = '" . $_POST['pid'] . "'";
                $insert_buy = "INSERT INTO buy VALUES ('" . $_SESSION['id'] . "', '" . $_POST['pid'] . "', " . $_POST['amount'] . ")";
                $update_buy = "UPDATE buy SET quantity = quantity + " .$_POST['amount'] . " WHERE cid = '" . $_SESSION['id'] . "' and pid = '" . $_POST['pid'] . "'";
                if (mysqli_query($db, $sql_stock) and mysqli_query($db, $sql_wallet)) {
                    $db->query($update_buy);
                    if ($db->affected_rows == 0) {
                        $db->query($insert_buy);
                    }
            ?>
                    <script type="text/javascript">
                    alert("Product successfully bought! You can see your past orders from profile section.");
                    window.location.href = "landing_page.php";
                    </script>
            <?php
                 }
            }
        }    
    ?>
</body>
<div class="footer">© Ege Demirkırkan | CS353 HW4 Programming Assignment</div>
</html>
<?php   
} else{
     header("Location: index.php");
     exit();
}
?>

