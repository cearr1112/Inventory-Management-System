<?php  
	session_start();  
    $conn = mysqli_connect("localhost","root","","inventory_system") or die("Error");
    // $price =$_SESSION['pricePerStock'];
    $item = $_SESSION['itemName'];
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Request Item</title>
	<style>

	</style>
	<link rel="stylesheet" type="text/css" href="StaffD-style.css">
</head>
<body>
	
	<form method="post">
			                    <table>
                        <!--INSERT PHP CODE HERE-->

                        <tr>
                            <tr>
                                <th>Item Name</th>
                                <th>Stock</th>
                                <th>Price Per Stock</th>
                                <th>Username</th>
                            </tr>
				<?php  
                                if($conn){
                                    $query = "SELECT * FROM `items` WHERE `itemName` = '$item' ";
                                    $requests = mysqli_query($conn,$query);//returned results
                                    $check = mysqli_num_rows($requests);//result counter
                                    if($check == 0){//if empt
                                        //setonly 1 row of N/A if the table is empty;
                                    }else{
                                        while($row = mysqli_fetch_assoc($requests)){
                                            echo "
                                        <tr>
                                            <td>".$row['itemName']."</td>
                                            <td>".$row['stocks']."</td>
                                            <td>".$row['pricePerStock']."</td>
                                            <td>".$row['userName']."</td>
                                        </tr>";
                                        }
                                    }
                                }
                            ?>            
                        </div>
                    </table></br>
	
	<label>Quantity</label></br>
	<input type="text" name="quantity" placeholder="Input Quantity">
    <input type="text" name="payment" placeholder="Input Payment">
	<button type="submit" name="btnreq" style="margin-right: 135px;">Request Item</button>
	</form>

	<?php
		if(isset($_POST['btnreq'])){
                if($conn){
                    $quantity = $_POST['quantity'];
                    $payment = $_POST['payment'];
                    $upitem = $_SESSION['itemName'];
                    $username = $_SESSION['username'];
                    $price = 0;
                    echo "<script>alert('".$upitem."');</script";
                    try{
                        if($quantity != null || $payment != null) {
                            $searchPrice = "SELECT pricePerStock FROM items WHERE itemName = '".$upitem."'";
                                $foundPrice = mysqli_query($conn, $searchPrice);
                                while($data = mysqli_fetch_assoc($foundPrice)){
                                    $price = $data['pricePerStock'];
                                }
                                $expectedpayment = $quantity*$price;
                            if($payment < $expectedpayment){
                                throw new Exception("Invalid payment! Payment must be correct.");
                            }else{
                                $add = "INSERT INTO itemrequests VALUES (NULL,'".$upitem."','".$quantity."','".$payment."','".$username."')";
                                mysqli_query($conn, $add);
                                
                                echo "<script>alert('Successfully Requested'); window.location.href = 'staffDashboard.php';</script>";
                            }
                        }else{
                            throw new Exception("Quantity or payment must not be empty");
                        }
                    }catch(Exception $e){
                        echo "<script>alert('".$e->getMessage()."');</script>";
                    }	
                }else{
                    echo "<script>alert('Connection failed');</script>";
                }
		}  
	?>