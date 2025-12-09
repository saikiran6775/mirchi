<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
             <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
                                            <div class="card-header card-no-border pb-0">
                                                <div class="card-options">
                                                    <a class="card-options-collapse" href="#"
                                                        data-bs-toggle="card-collapse"><i
                                                            class="fe fe-chevron-up"></i></a>
                                                    <a class="card-options-remove" href="#"
                                                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row mx-4 custom-gap">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Sold Date</label>
                                                            <input type="text" class="form-control" id="date"
                                                                name="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Name of the Seller</label>
                                                            <select class="form-select" id="seller" name="seller"
                                                                required>
                                                                <option value="">Select Seller</option>
                                                                <?php
                                                                    $sql = "SELECT * FROM  sales  WHERE status = '1' ORDER BY id DESC LIMIT 1";
                                                                    $res = mysqli_query($conn, $sql);
                                                                    if ($res && mysqli_num_rows($res) > 0) {
                                                                        $rows = mysqli_fetch_array($res);
                                                                        $seller_id = $rows['seller_name'];
                                                                        $result = mysqli_query($conn, "SELECT id, seller_name FROM  sales WHERE status=1");
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            $selected = ($row['id'] == $seller_id) ? 'selected' : ''; 
                                                                            echo "<option value='{$row['id']}' {$selected}>{$row['seller_name']}</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                        <div class="row mx-4 custom-gap">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Farmer Name</label>
                                                            <input type="text" class="form-control" id="farmer_name"
                                                                name="farmer_name" 
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">PVT.Mark</label>
                                                            <input type="text" class="form-control" id="bag_batch"
                                                                name="bag_batch" 
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                             
                                                  <div class="row mx-4 custom-gap">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">commission</label>
                                                            <input type="text" class="form-control" id="commission"
                                                                name="commission" 
                                                                required>
                                                        </div>
                                                    </div>
                                                         <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Expenditure</label>
                                                            <input type="text" name="expenditure" class="form-control"
                                                                id="expenditure">
                                                        </div>
                                                    </div>      
                                                </div>
                                                   <div class="row mx-4 custom-gap">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Rate Per Kg</label>
                                                            <input type="text" class="form-control" id="rate_per_kg"
                                                                name="rate_per_kg" 
                                                                required>
                                                        </div>
                                                    </div>
                                                         <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Lot Number</label>
                                                            <input type="text" name="desire_no_bag" class="form-control"
                                                                id="fieldCount" oninput="handleKeyPress(this)"
                                                                onkeyup="checkLotNumber(this)">
                                                            <div id="lotNoMessage" class="mt-2">
                                                                <?php if (isset($lotNoMessage)) echo $lotNoMessage; ?>
                                                            </div>
                                                        </div>
                                                    </div>      
                                                </div>

                                                <div class="row mx-4 custom-gap">
                                                  <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Of Gunny Bags</label>
                                                            <input type="text" class="form-control" id="no_of_bags"
                                                                name="no_of_bags" oninput="handleKeyPress(this)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <label class="form-label">Enter Weights</label>
                                                    <div id="weights-calculation"
                                                        class="weights-caluculation mx-4 mb-5"></div>
                                                </div>

                                                <div class="row mx-4 custom-gap">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Gross Weight</label>
                                                            <input type="text" class="form-control" id="grosswt"
                                                                name="grosswt" 
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Gross Amount</label>
                                                            <input type="text" class="form-control" id="gross_amount"
                                                                name="grossamount" 
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mx-4 custom-gap">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Gunny Bag Cost (each)</label>
                                                            <?php
                                                            $sql = "SELECT * FROM gunny_bag"; 
                                                            $result = mysqli_query($conn, $sql);
                                                            if ($result && mysqli_num_rows($result) > 0) {
                                                                $row = mysqli_fetch_array($result);
                                                                $gunny_bag_rate = $row['gunny_bag']; 
                                                            } else {
                                                                $gunny_bag_rate = ""; 
                                                            }
                                                            ?>
                                                            <input type="number" class="form-control"
                                                                id="gunnies_bag_rate" name="gunnies_bag_rate"
                                                                value="<?php echo $gunny_bag_rate; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Net Weight</label>
                                                            <input type="number" class="form-control" id="net_weight"
                                                                name="net_weight" 
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mx-4 custom-gap">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Total Gunny Bags Amount</label>
                                                            <input type="number" class="form-control"
                                                                id="gunnies_bag_total" name="gunnies_bag_total"
                                                               readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Total Amount</label>
                                                            <input type="number" class="form-control" id="total_amount"
                                                                name="total_amount"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="response" class="text-success"></div>
                                                <div class="card-footer text-center">
                                                    <input type="hidden" name="id" value="">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                    <button type="button" onclick="goBack()"
                                                        class="btn btn-outline-primary">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                     
</body>
</html>