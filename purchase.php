<?php include 'connection.php'; ?>
<?php include 'functions.php'; ?>

<?php
session_start();

//check if user is logged in
if (!isset($_SESSION['user_id'])) {
 header('Location: login.php');
}

//error to be displayed to user
$error = null;
if(isset($_GET['error'])){
    $error = $_GET['error'];
}

//get user id from the session
$id =  $_SESSION['user_id'];

// get cart of the user
$sql = "SELECT cart, firstname, lastname, address from users WHERE user_id ="."$id;";
$result = mysqli_query($conn, $sql); 
$user = $result->fetch_assoc();
$cart = $user['cart'];
$cart = json_decode($cart ,true);

//check if cart is empty
if(count($cart) == 0){
     header('Location: cart.php');
}

//compute total price
$toatl_price = toFixed(getTotalPrice($cart, $conn),2);

$name = $user['firstname']." ".$user['lastname'];
$address = $user['address'];

?>

<?php include 'header.php'; ?>

<section style="margin-top: 105px;min-height: calc(100vh - 217px);">
    <div class="container-sm mt-5 pt-5">
        <div class="mb-4">
            <h2>Confirm order and pay</h2>
            <span>please make the payment, enter your card details and address.</span>
        </div>

        <div class="d-flex row justify-content-around">
            <!-- visa card details -->
            <form id="purchase" class=" col-12 col-md-7" id="form1" method="post" action="process-order.php">
                <div class="card p-3">
                    <h4 class="text-uppercase">Payment details</h4>
                    <div class="inputbox mt-3">
                        <input id="name_on_card" value="<?php echo $name ?>" required minlength="2" type="text"
                            name="name_on_card" class="form-control card-input">
                        <span>Name on card</span>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="inputbox mt-3 mr-2">
                                <input id="card_number" required minlength="16" maxlength="16" type="text"
                                    name="card_number" class="form-control card-input">
                                <span>Card Number</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="d-flex flex-row">
                                <div class="inputbox mt-3 mr-2">
                                    <input id="expiry" onfocus="(this.type='month')" onblur=" this.type='' " required
                                        name="expiry" class="form-control card-input">
                                    <span>Expiry</span>
                                </div>
                                <div class="inputbox mt-3 mr-2">
                                    <input id="cvv" type="number" required minlength="3" maxlength="3" name="cvv"
                                        class="form-control card-input">
                                    <span>CVV</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-4">
                        <h4 class="text-uppercase">Billing Address</h4>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input id="street" value="<?php echo $address ?>" required minlength="2" type="text"
                                        name="street" class="form-control card-input">
                                    <span>Street Address</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input id="city" type="text" required minlength="2" name="city"
                                        class="form-control card-input">
                                    <span>City</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input id="state" type="text" required minlength="2" name="state"
                                        class="form-control card-input">
                                    <span>State/Province</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input id="zip" type="number" required minlength="5" maxlength="9" name="zip"
                                        class="form-control card-input">
                                    <span>Zip code</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 mb-4 d-flex align-items-center flex-column justify-content-center">
                    <p style="color: red;">
                        <?php
                    echo $error;
                ?>
                    </p>
                    <a>
                        <button type="submit" value="Submit" class="btn btn-warning px-3">Pay
                            $<?php echo $toatl_price ?></button>
                    </a>
                </div>
            </form>

            <!-- oreder details -->
            <div class="col-12 col-md-4">
                <div class="card p-3 yellow text-white mb-3">
                    <span>You have to pay</span>
                    <div class="d-flex flex-row align-items-end">
                        <h1 class="mb-0 text-dark">$<?php echo $toatl_price ?></h1>
                    </div>
                    <div class="hightlight">
                        <span>FREE Shipping is available if you're ordering items for delivery within Egypt.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include 'footer.php' ?>