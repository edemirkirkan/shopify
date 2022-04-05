<?php 
    include("profile.php");
    if (isset($_POST['pid']) and isset($_POST['quantity'])) {
        $pid_query = "SELECT * FROM buy WHERE pid = '" . $_POST['pid'] . "' and cid = '" . $_SESSION['id'] . "'";
        $pid_result = mysqli_query($db, $pid_query);
        if (mysqli_num_rows($pid_result)==0) {
            echo header("Location: profile.php?error=Entered product id does not match any of the product id from previous orders. Please enter a valid product id.");
            exit();
        }   
        $quantity_query = "SELECT quantity FROM buy WHERE pid = '" . $_POST['pid'] . "' and cid = '" . $_SESSION['id'] . "'";
        $quantity= mysqli_fetch_array(mysqli_query($db, $quantity_query));
        if ($_POST['quantity'] > $quantity['quantity']) {
            echo header("Location: profile.php?error=Entered quantity is more than you have. Please enter a valid quantity.");
            exit();
        }   
        $update_wallet = "UPDATE customer SET wallet = wallet + " . $_POST['quantity'] . " * (SELECT price FROM product WHERE pid = '". $_POST['pid'] . "') WHERE cid = '" . $_SESSION['id'] . "'";
        $update_quantity = "UPDATE buy SET quantity = quantity - " . $_POST['quantity'] . " WHERE cid = '" . $_SESSION['id'] . 
        "' and pid = '" . $_POST['pid'] . "'";
        $update_stock = "UPDATE product SET stock = stock + " . $_POST['quantity'] . " WHERE pid = '" . $_POST['pid'] . "'";
        if (mysqli_query($db, $update_wallet) and mysqli_query($db, $update_quantity) and mysqli_query($db, $update_stock)) {
            echo header("Location: profile.php?success=Return operation sucessfully completed. You may consider explore the store again.");
            exit();
        }
        else {
            echo header("Location: profile.php");
            exit();
        }
    }  
    else {
        echo header("Location: profile.php");
    }    
?> 