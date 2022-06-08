<?php  
	session_start();  
    $conn = mysqli_connect("localhost","root","","inventory_system") or die("Error");
    // $price =$_SESSION['pricePerStock'];
    $item = $_SESSION['itemName'];
?>
<!DOCTYPE html>
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
	<input type="submit" name="btnreq" style="margin-right: 50px;" value="Request">
	</form>

	<?php

		if(isset($_POST['btnreq'])){
			$quantity = $_POST['quantity'];
            $payment = $_POST['payment'];
			$upitem = $_SESSION['itemName'];
			$username = $_SESSION['username'];
                if($conn){
                    try{
                        if($quantity != null || $payment != null) {
                            $searchPrice = "SELECT pricePerStock FROM items WHERE itemName = '".$upitem."'";
                                $foundPrice = mysqli_query($conn, $searchPrice);
                                $price = 0;
                                while($data = mysqli_fetch_assoc($foundPrice)){
                                    $price = $data['pricePerStock'];
                                }
                                $expectedpayment = $quantity*$price;
                            if($payment < $expectedpayment){
                                throw new Exception("Invalid payment! Payment must be correct.");
                            }else{
                                $add = "INSERT INTO itemrequests(requestID, itemName, quantityRequest, payment, userName) VALUES (NULL,'".$upitem."','".$quantity."','".$payment."','".$username."')";
                                $resultadd = mysqli_query($conn, $add);
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
</body>
</html>
