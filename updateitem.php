<?php  
	session_start();  
    $con = mysqli_connect("localhost","root","","inventory_system") or die("Error");
    $username = $_SESSION['username'];
    $upitem = $_SESSION['itemName'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Item</title>
	<link rel="stylesheet" type="text/css" href="StaffD-style.css">
</head>
<body>
	<form method="post">
	<label>Item</label><br>
	<input type="text" name="item" value="<?php echo $upitem; ?>" READONLY><br>
	<label>Stock</label><br>
	<input type="text" name="stock" required><br>
	<label>Price Per Stock</label><br>
	<input type="text" name="price" required><br>
	<input type="submit" name="btnupdate" value="Update">
	</form>
</body>
</html>
<?php 
	if(isset($_POST['btnupdate'])){
	$item = $_POST['item'];
	$stock = $_POST['stock'];
	$price = $_POST['price'];
    $update = "UPDATE `items` SET `stocks`='$stock',`pricePerStock`='$price',`userName`='$username' WHERE `itemName`='$upitem'";
    $resultadd = mysqli_query($con, $update);
    echo "<script>alert('Successfully Updated a Stock');  window.location.href = 'staffDashboard.php';</script>";
}
 ?>