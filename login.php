<?php 
session_start(); 
include("db_connect.php");
if (isset($_POST['uname']) && isset($_POST['upass'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$upass = validate($_POST['upass']);

	if (empty($uname)) {
		header("Location: ./index.php?error=Username is required");
	    exit();
	}else if(empty($upass)){
        header("Location: ./index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT cname, cid FROM customer WHERE cname='$uname' AND cid='$upass'";
		$result = mysqli_query($db, $sql);
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            echo ($row['cname'] . $row['cid']);
            if ($row['cname'] === $uname && $row['cid'] === $upass) {
            	$_SESSION['id'] = $row['cid'];
            	header("Location: ./landing_page.php");
		        exit();
            }else{
				header("Location: ./index.php?error=Incorrect username or password");
		        exit();
			}
		}else{
			header("Location: ./index.php?error=Incorrect username or password");
	        exit();
		}
	}
	
}else{
	header("Location: ./landing_page.php");
	exit();
}
?>
