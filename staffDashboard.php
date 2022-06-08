<!DOCTYPE html>
<?php
    session_start();  
    $con = mysqli_connect("localhost","root","","inventory_system") or die("Error");
?>
<html>

<head>
    <title>Staff Dashboard</title>

    <link rel="stylesheet" type="text/css" href="StaffD-style.css">
    <h1>STAFF DASHBOARD</h1>
</head>

<body>
    <div>
        <label style="float: center;">Welcome <?php echo  $_SESSION['username']; ?>!</label>

            <button  style="width: auto;" onclick="location.href='logout.php';"onclick="location.href='logout.php';" value="logout">Logout</button>

        <div>
            <label style="float:left;">

                <div class="row">
                <div class="column">
                    <h2>ITEM <button onclick="location.href='additem.php';" name="btnadd" style="margin-right: 5px;" value="Add">Add</button></h2></label>

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
                                if($con){
                                    $query = "SELECT * FROM `items` ";
                                    $requests = mysqli_query($con,$query);//returned results
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
                    </table>
                    <br>

                    <form method="post">
                        <input type="submit" name="btnreq"style="background: #5f9cd2; color: black; border-radius: 5px;"value="Request"> 
                        <input type="submit" name="btnupdate" style="background: #5f9cd2; color: black; border-radius: 5px;" value="Upadate">
                        <input type="submit"name="btndelete" style="background: #5f9cd2; color: black; border-radius: 5px;"value="Delete">
                        <select name="dropdown1" id="dropdown_selected">
                        <option value="">-SELECT-</option>
                        <?php  
                            
                            if($con){
                                $list = "select itemName, pricePerStock from items";
                                $sql = mysqli_query($con,$list);
                                while ($data = mysqli_fetch_assoc($sql)) {
                                if(!empty($_POST['dropdown']) && $_POST['dropdown'] == $data['dropdown']){
                                    $selected = 'selected ="selected"';
                                }
                                else{
                                    $selected = '';
                                }
                                    
                                
                                ?>
                                <option value = "<?php echo $data['itemName']; ?>" $selected><?php echo $data['itemName']; ?></option>

                                <?php
                                }

                            }

                                
                        ?>
                    </select>
                    <?php
                        
                            if(isset($_POST['btnupdate'])){
                               $_SESSION['itemName'] = $_POST['dropdown1'];   
                               header("location: updateitem.php"); 
                            }else if (isset($_POST['btndelete'])) {
                                $_SESSION['itemName'] = $_POST['dropdown1']; 
                                $delitems = $_SESSION['itemName'];
                                $delete = "DELETE FROM `items` WHERE `itemName`='$delitems'";
                                $resultdel = mysqli_query($con,$delete);
                            }else if (isset($_POST['btnreq'])){
                                $_SESSION['itemName'] = $_POST['dropdown1'];   
                                header("location: itemrequest.php");
                            } 
                        ?>

                    </form>
                </div>
            <br> 
            <br>
            &nbsp;&nbsp;&nbsp;
                <div>
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
                                <!--INSERT PHP CODE HERE-->
                                <tr>
                                <?php  
                                if($con){
                                    $query = "SELECT * FROM `itemrequests` ";
                                    $requests = mysqli_query($con,$query);//returned results
                                    $check = mysqli_num_rows($requests);//result counter
                                    if($check == 0){//if empt
                                        //setonly 1 row of N/A if the table is empty;
                                    }else{
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
                            ?>      

                                    </form>
                            </table></br></br>

                            <form method="post">
                            <input type="submit" name="btncancel" style="background: #5f9cd2; color: black; border-radius: 5px;"value="Cancel">

                            <select name="dropdown3" id="dropdown_selected">
                            <option value="">-SELECT-</option>
                            <?php  
                            
                            if($con){
                                $list3 = "select itemName from itemrequests";
                                $sql3 = mysqli_query($con,$list3);
                                while ($data = mysqli_fetch_assoc($sql3)) {
                                if(!empty($_POST['dropdown']) && $_POST['dropdown'] == $data['dropdown']){
                                    $selected = 'selected ="selected"';
                                }
                                else{
                                    $selected = '';
                                }
                                ?>
                                <option value = "<?php echo $data['itemName']; ?>" $selected><?php echo $data['itemName']; ?></option>
                                <?php
                            }
                            }
                        ?>
                            </select>
                            <?php  
                                if (isset($_POST['btncancel'])) {
                                    $_SESSION['itemName'] = $_POST['dropdown3']; 
                                    $delitems = $_SESSION['itemName'];
                                    $delete = "DELETE FROM `itemrequests` WHERE `itemName`='$delitems'";
                                    $resultdel = mysqli_query($con,$delete);
                                }
                            ?>
                            </form>
        </div>         
    </div>
</body>
</html>

