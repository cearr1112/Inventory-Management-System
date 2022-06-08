<!DOCTYPE html>
<html>
    <head>
        <title>Supplier Dashboard</title>
        <link rel="stylesheet" type="text/css" href="SupplierDashboard-style.css">
	    <h1>SUPPLIER DASHBOARD</h1>
    </head>  
    <body>
    
        <div>
            <label style="padding-left: 900px;">Welcome <?php session_start(); print_r($_SESSION["username"])?>!</label></br>
            <button style="width: auto;" onclick="location.href='logout.php';" value="logout">Logout</button>
        </div>
        <div class="row">
        <div class="column">
        <h2>ITEM REQUEST</h2>
        <table>
            <tr>
            <tr>
                <th>Request ID</th>
                <th>Item Name</th>
                <th>Quantity Request</th>
                <th>Payment</th>
                <th>Username</th>
            </tr>
            <?php
                $sname= "localhost";
                $username= "root";
                $password = "";
                
                $db_name = "inventory_system";
                
                $conn = mysqli_connect($sname, $username, $password, $db_name);
                if($conn){
                    $query = "SELECT * FROM itemrequests";
                    $requests = mysqli_query($conn,$query);//returned results refer here
                    $check = mysqli_num_rows($requests);//result counter
                    if($check == 0){//if empty
                        //setonly 1 row of N/A if the table is empty
                            echo "
                                <tr>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>";
                    }
                    else{
                        while($row = mysqli_fetch_assoc($requests)){
                            echo "
                                <tr>
                                    <td>".$row['requestID']."</td>
                                    <td>".$row['itemName']."</td>
                                    <td>".$row['quantityRequest']."</td>
                                    <td>".$row['payment']."</td>
                                    <td>".$row['userName']."</td>
                                </tr>";
                        }
                    }
                }
                else{
                    echo "<script>alert('Connection failed');</script>";
                }
            ?>
        </table></br>
        <form method = "post">
                <select name ="dropdownItemRequest" id="dropdown_selectedItemRequest">
                    <option value="----SELECT----">----SELECT----</option>
                    <?php
                        if($conn){
                            $list = "SELECT * FROM itemrequests";
                            $sql = mysqli_query($conn,$list);
                            while ($data = mysqli_fetch_assoc($sql)) {
                                if(!empty($_POST['dropdownItemRequest']) && $_POST['dropdownItemRequest'] == $data['dropdownItemRequest']){
                                    $selectedRequest = 'selected ="selected"';
                                }
                                else{
                                    $selectedRequest = '';
                                }
                                ?>
                                <option value = "<?php echo $data['itemName']; ?>" $selectedRequest><?php echo $data['itemName']; ?>
                                </option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <button type="submit" name = "deliver" style="margin-right: 135px;">Deliver Request</button>
        </form> 
        </div>
        
        <div class="column">
        <h2>DELIVERIES</h2>
        <table>
            <tr>
                <th>Delivery ID</th>
                <th>Request ID</th>
                <th>Item Name</th>
                <th>Quantity Delivered</th>
                <th>Staff Username</th>
                <th>Supplier Username</th>
                <th>Payment Change</th>
            </tr>
            <?php
                if($conn){
                    $query = "SELECT * FROM deliveryitem";
                    $deliveries = mysqli_query($conn,$query);
                    $check = mysqli_num_rows($deliveries);
                    if($check == 0){
                        echo "
                                <tr>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>";
                    }
                    else{
                        while($row = mysqli_fetch_assoc($deliveries)){
                            echo "
                                <tr>
                                    <td>".$row['deliveryID']."</td>
                                    <td>".$row['requestID']."</td>
                                    <td>".$row['itemName']."</td>
                                    <td>".$row['quantityDelivered']."</td>
                                    <td>".$row['staff_userName']."</td>
                                    <td>".$row['supplier_userName']."</td>
                                    <td>".$row['paymentChange']."</td>
                                </tr>";
                        }
                    }
                }else{
                    echo "<script>alert('Connection failed');</script>";
                }
            ?>
            </table> </br>
            <form method = "post">
                <select name ="dropdownDeliveries" id="dropdown_selectedDeliveries">
                    <option value="----SELECT----">----SELECT----</option>
                    <?php
                        if($conn){
                            $list = "SELECT * FROM deliveryitem";
                            $sql = mysqli_query($conn,$list);
                            while ($data = mysqli_fetch_assoc($sql)) {
                                if(!empty($_POST['dropdownDeliveries']) && $_POST['dropdownDeliveries'] == $data['dropdownDeliveries']){
                                    $selectedDelivery = 'selected ="selected"';
                                }
                                else{
                                    $selectedDelivery = '';
                                }
                                ?>
                                <option value = "<?php echo $data['itemName']; ?>" $selectedRequest><?php echo $data['itemName']; ?>
                                </option>
                                <?php
                            }
                        }
                    ?>
                </select> 
                <button type="submit" name="cancelDelivery">Cancel Delivery</button>
            </form> 
            </div>
        </div>
    </body>
</html>

<?php
    if($conn){
        if(isset($_POST['deliver'])){
            $postSelected_request = $_POST['dropdownItemRequest'];
            $must_select_req = "Must select a request to deliver";
            //to be continued in implementing the selected itemrequest to deliver
            try{
                if($postSelected_request != null){
                    if(str_contains($postSelected_request, "----SELECT----")){
                        throw new Exception($must_select_req);
                    }
                    else{
                        $requestID = 0;
                        $itemName = "";
                        $quantityDelivered = 0;
                        $payment = 0;;
                        $staffUserName = "";
                        $supplierUsername = $_SESSION["username"];
                        $getRequest = "SELECT * FROM itemrequests WHERE itemName = '".$postSelected_request."'";
                        $gotRequest = mysqli_query($conn,$getRequest);
                        while($row = mysqli_fetch_assoc($gotRequest)){
                            $requestID = $row['requestID'];
                            $itemName = $row['itemName'];
                            $quantityDelivered = $row['quantityRequest'];
                            $payment = $row['payment'];
                            $staffUserName = $row['userName'];
                        }
                        $getPrice = "SELECT pricePerStock FROM items WHERE itemName = '".$postSelected_request."'";
                        $gotPrice = mysqli_query($conn, $getPrice);
                        $priceHolder = 0;
                        while($prices = mysqli_fetch_assoc($gotPrice)){
                            $priceHolder = $prices['pricePerStock'];
                        }
                        $expectedPay = $quantityDelivered * $priceHolder;
                        $paymentChange = $payment - $expectedPay;
                        
                        $insertDelivery = "INSERT INTO deliveryitem VALUES(NULL, '".$requestID."', '".$itemName."', '".$quantityDelivered."', '".$staffUserName."', '".$supplierUsername."', '".$paymentChange."')";
                        //$deleteRequest = "DELETE FROM itemrequests WHERE itemName = '".$postSelected_request."'";
                        mysqli_query($conn, $insertDelivery) or die(mysqli_error($conn));
                        echo "<script>alert('Successfully Delivered');  window.location.href = 'supplierDashboard.php';</script>";
                        //mysqli_query($conn, $deleteRequest);
                        
                    }
                }else{
                    throw new Exception($must_select_req);
                }
            }catch(Exception $e){
                echo "<script>alert('".$e->getMessage()."');</script>";
            }
            
        }
        else if(isset($_POST['cancelDelivery'])){
            $postSelected_delivery = $_POST['dropdownDeliveries'];
            $must_select_del = "Must select a delivery to cancel.";
            //to be continued in implementing the selected delivery to cancel
            try{
                if(str_contains($postSelected_delivery, "----SELECT----")){
                    throw new Exception($must_select_del);
                }
                $deleteDelivery = "DELETE FROM deliveryitem WHERE itemName = '".$postSelected_delivery."'";
                if(mysqli_query($conn, $deleteDelivery)){
                    echo "<script>alert('Successfully Deleted');  window.location.href = 'supplierDashboard.php'; </script>";
                }
            }catch(Exception $e){
                echo "<script>alert('".$e->getMessage()."');</script>";
            }
            
        }
    }
?>
