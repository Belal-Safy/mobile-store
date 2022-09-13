<?php include 'connection.php'; ?>
<?php include 'functions.php'; ?>

<?php
session_start();
//check if user isn't logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

//get user id from session
$id =  $_SESSION['user_id'];
$sql = "SELECT firstname, lastname from users WHERE user_id ="."$id;";
$result = mysqli_query($conn, $sql); 
$user = $result->fetch_assoc();
$name = $user['firstname'] . " " . $user['lastname'];

//check if page was accessed by post method or not
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('Location: '.'http://localhost/mobile-store/cart.php');
}

//get form data
$name_on_card = $_POST['name_on_card'];
$card_number = $_POST['card_number'];
$cvv = $_POST['cvv'];
$expiry = $_POST['expiry'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];

//form validation
if (empty($name_on_card) || empty($card_number) || empty($cvv) || empty($expiry) || empty($street) || empty($city) || empty($state) || empty($zip)) {
    $error = "all fields are required";
    header('Location: '.'http://localhost/mobile-store/purchase.php?error='.$error);
}

else{
    include 'connection.php';
    // get cart of the user
    $sql = "SELECT cart from users WHERE user_id ="."$id;";
    $result = mysqli_query($conn, $sql); 
    $cart = $result->fetch_assoc()['cart'];
    $cart_arr = json_decode($cart ,true);

    //check if cart is empty
    if(count($cart_arr) == 0){
         header('Location: cart.php');
    }
    
    //compute total price
    $toatl_price = toFixed(getTotalPrice($cart_arr, $conn),2) ;
    
    //record order in database
    $sql = "INSERT INTO orders (user_id, products, Total_price, address) VALUES ('".$id."', '".$cart."', '".$toatl_price."','".$state .", ". $city .", ". $street."')";
    $result = mysqli_query($conn, $sql); 
    if($result == 1){
        $sql = "UPDATE users SET  cart = '[]' WHERE (user_id = '".$id."')";
        $result = mysqli_query($conn, $sql); 
    }
    else{
        die("something went wrong");
    }
}

?>

<?php include 'header.php'; ?>

<section style="margin-top: 105px;">
    <div class="d-flex flex-column justify-content-center" style="min-height: calc(100vh - 105px);">
        <div class="text-center">
            <h1>Success! 🥳</h1>
            <p>Thank you, <?php echo $name ?>!</p>
            <p>
                Your order is confirmed
            </p>
            <p>Please allow 1-3 business day(s) for shipping</p>

            <a class="m-auto d-block mt-5" href="index.php"><button class="btn btn-warning px-3">Back to
                    Home page</button></a>
        </div>
    </div>
</section>

<!-- page footer -->
<?php include 'footer.php'; $conn->close();
?>