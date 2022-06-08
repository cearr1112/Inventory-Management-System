<?php  
	session_start();  
    $con = mysqli_connect("localhost","root","","inventory_system") or die("Error");
    $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Item</title>
	<style>

	</style>
	<link rel="stylesheet" type="text/css" href="StaffD-style.css">
</head>
<body>
	<form method="post">
	<label>Item</label><br>
	<input type="text" name="item" required><br>
	<label>Stock</label><br>
	<input type="text" name="stock" required><br>
	<label>Price Per Stock</label><br>
	<input type="text" name="price" required><br>
	<input type="submit" name="btnadd" value="Add" style="background: #5f9cd2; color: black; border-radius: 5px;">
	</form>
</body>
</html>
<?php 
	if(isset($_POST['btnadd'])){
	$item = $_POST['item'];
	$stock = $_POST['stock'];
	$price = $_POST['price'];
    $add = "insert into items values('$item','$stock','$price','$username')";
    $resultadd = mysqli_query($con, $add);
    echo "<script>alert('Successfully Added an Item');  window.location.href = 'staffDashboard.php';</script>";
}
 ?>