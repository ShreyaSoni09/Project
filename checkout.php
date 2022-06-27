<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
<style>
     body{
         background-color: red; /* For browsers that do not support gradients */
  background-image: linear-gradient(90deg, #ffd89b 10%, #19547b 55%, #19547b 1%);
}

</style>
    <title>Checkout Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark pl-5 mb-0" style="border-radius: 0%;">
        <a class="navbar-brand" href="home.php" style="font-size: 25px;">BookHub</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item pr-4" style="font-size: 28px;">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item pl-4" style="font-size: 28px;">
                    <a class="nav-link" href="store.php">Collection</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php
    session_start();
    require("mysqli_connect.php");
    $errors = false;

    $firstNameErr = "";
    $lastNameErr = "";
    $emailErr = "";
    $addressErr = "";
    $cityErr = "";
    $stateErr = "";
    $countryErr = "";
    $postalcodeErr = "";

    if (isset($_POST['qty'])) {
        $qty = $_POST['qty'];
        $_SESSION['qty'] = $_POST['qty'];
        $qty = $_SESSION['qty'];
    }

    $totalPrice = $_SESSION['qty'] * $_SESSION['price'];
    // gives validation to each field
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstname"]) || !isset($_POST["firstname"])) {
            $firstNameErr = "<span style=color:red;> * First name is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["lastname"]) || !isset($_POST["lastname"])) {
            $lastNameErr = "<span style=color:red;> * Last name is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["email"]) || !isset($_POST["email"])) {
            $emailErr = "<span style=color:red;> * Email is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["address"]) || !isset($_POST["address"])) {
            $addressErr = "<span style=color:red;> * Adress is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["city"]) || !isset($_POST["city"])) {
            $cityErr = "<span style=color:red;> * City is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["state"]) || !isset($_POST["state"])) {
            $stateErr = "<span style=color:red;> * State is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["country"]) || !isset($_POST["country"])) {
            $countryErr = "<span style=color:red;> * Country is required.<br> </span>";
            $errors = true;
        }

        if (empty($_POST["postalcode"]) || !isset($_POST["postalcode"])) {
            $postalcodeErr = "<span style=color:red;> * Postal code is required.<br> </span>";
            $errors = true;
        } else {
            if ($errors == false) {
                $email = mysqli_real_escape_string($dbc, $_POST["email"]);
                $paymentmethod = mysqli_real_escape_string($dbc, $_POST["payment"]);
                $firstName = mysqli_real_escape_string($dbc, $_POST["firstname"]);
                $lastName = mysqli_real_escape_string($dbc, $_POST["lastname"]);
                $address = mysqli_real_escape_string($dbc, $_POST["address"]);
                $city = mysqli_real_escape_string($dbc, $_POST["city"]);
                $state = mysqli_real_escape_string($dbc, $_POST["state"]);
                $country = mysqli_real_escape_string($dbc, $_POST["country"]);
                $postalcode = mysqli_real_escape_string($dbc, $_POST["postalcode"]);
                $bookid = $_SESSION["id"];
                $qty = $_SESSION["qty"];
                $date = date('Y-m-d');
                $insertQuery = "INSERT INTO bookdb.order (bookid, order_date, email, quantity, total, paymentmethod, firstname, lastname, address, city, state, country, postalcode) VALUES ($bookid, '$date', '$email', $qty, $totalPrice, '$paymentmethod', '$firstName', '$lastName', '$address', '$city', '$state', '$country', '$postalcode')";

                if (mysqli_query($dbc, $insertQuery)) {
                    $updateStockQuery = "UPDATE bookinventory SET stock = stock - " . $_SESSION['qty'] . " WHERE bookid = $bookid";
                    $updateresult = mysqli_query($dbc, $updateStockQuery);

                    $updateStockPriceQuery = "UPDATE bookinventory SET totalprice = stock * " . $_SESSION['price'] . "WHERE bookid = $bookid";
                    $updateresult2 = mysqli_query($dbc, $updateStockPriceQuery);
                    header('Location:home.php');
                } else {
                    echo 'Try again<br>' . mysqli_error($dbc);
                }
            }
        }
    }
    ?>
    <!-- main form here -->
    <div class="bg">
     <h1 style="text-align: center;">
                <i class="fas fa-shipping-fast"></i>
                Shipping Details
            </h1>
    <div class="container" style="margin: 20px 0px 50px 420px;">
        <form method="POST">
            <div class="form-row pl-5">
                <div class="form-group col-md-3">
                    <label>First Name</label>
                    <input id="input" type="text" class="form-control" name="firstname" placeholder="First name" size="20" maxlength="40" value="<?php if (isset($_POST["firstname"])) echo $_POST["firstname"]; ?>"><span><?php echo $firstNameErr; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Last Name</label>
                    <input id="input" type="text" class="form-control" name="lastname" placeholder="Last name" size="20" maxlength="40" value="<?php if (isset($_POST["lastname"])) echo $_POST["lastname"]; ?>"><span><?php echo $lastNameErr; ?>
                </div>
            </div>

            <div class="form-row pl-5">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input id="input" type="email" class="form-control" name="email" placeholder="Email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>"><span><?php echo $emailErr; ?>
                </div>
            </div>

            <div class="form-row pl-5">
                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input id="input" type="text" class="form-control" name="address" placeholder="1234 Main St" value="<?php if (isset($_POST["address"])) echo $_POST["address"]; ?>"><span><?php echo $addressErr; ?>
                </div>
            </div>

            <div class="form-row pl-5">
                <div class="form-group col-md-3">
                    <label>City</label>
                    <input id="input" type="text" class="form-control" name="city" placeholder="City" value="<?php if (isset($_POST["city"])) echo $_POST["city"]; ?>"><span><?php echo $cityErr; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>State</label>
                    <input id="input" type="text" class="form-control" name="state" placeholder="State" value="<?php if (isset($_POST["state"])) echo $_POST["state"]; ?>"><span><?php echo $stateErr; ?>
                </div>
            </div>
            <div class="form-row pl-5">
                <div class="form-group col-md-3">
                    <label>Country</label>
                    <input id="input" type="text" class="form-control" name="country" placeholder="Country" value="<?php if (isset($_POST["country"])) echo $_POST["country"]; ?>"><span><?php echo $countryErr; ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Postal Code</label>
                    <input id="input" type="text" class="form-control" name="postalcode" placeholder="Postal code" value="<?php if (isset($_POST["postalcode"])) echo $_POST["postalcode"]; ?>"><span><?php echo $postalcodeErr; ?>
                </div>
            </div>

            <div class="form-row pl-5">
                <label>Payment method</label>

                <div class="custom-control custom-radio custom-control-inline">
                    <input id="input" class="form-check-input" type="radio" name="payment" value="card" checked>
                    <label class="form-check-label" style="margin-left: 20px;">Credit card/Debit card</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input id="input" class="form-check-input" type="radio" name="payment" value="cash">
                    <label class="form-check-label" style="margin-left: 20px;">Cash on delivery</label>
                </div>
            </div>

            <div class="form-group pl-5">
                <br>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="submit" disabled='disabled' style='background-color: #343a40;'>CheckOut</button>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- afterr placing the order-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Order placed successfully!!!</h4>
                            </div>
                            <div class="modal-body">
                                <h4>Hope you Like our books!!!!.</h4>
                                <h4>You'll most likely receive your order on <mark><?php echo date('d/m/Y', strtotime('+10 days')); ?></mark>.</h4>
                            </div>
                            <div class="modal-footer">
                                <button type='submit' class='btn btn-lg btn-primary'>OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
    <div class="text-center"  style="background-color: #343a40; padding: 1em 0px;">
    <h1 class="credit" style="color: white;"> <span> OnlineBookHub | Shreya Soni |Copyright &copy; 2022 | all rights reserved! </span> </h1>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#input').on('input change', function() {
            if ($(this).val() != '') {
                $('#submit').prop('disabled', false);
            } else {
                $('#submit').prop('disabled', true);
            }
        });
    });
</script>

</html>