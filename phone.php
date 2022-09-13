<?php
include 'connection.php';
include 'functions.php';
session_start();

//get phone id from url
$id =  $_GET['id'];

//get phone data from the database
$sql = "SELECT * from products WHERE product_id ="."$id;";

$result = mysqli_query($conn, $sql); 
$phone = $result->fetch_assoc();

?>

<?php include 'header.php' ?>

<section id="phone" class="d-flex flex-column justify-content-center align-items-center">
    <div class="box container-fluid  <?php if($phone == null) echo 'd-none'?>" style="max-width: 700px;">
        <h1 class="text-center mb-5"><?php echo $phone['name'] ?> </h1>
        <div class="row w-100 align-items-center m-auto">
            <div class="col-lg-3 text-center mb-5 mb-lg-0">
                <img src="images/phones/<?php echo $phone['image']?>" alt="">
            </div>
            <div class="col-lg-9">
                <div class="row specifications">
                    <ul class="col-sm-7 mb-0">
                        <li>
                            <i class="fa-solid fa-microchip"></i>
                            <span> <?php echo $phone['processor'] ?> </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-camera"></i>
                            <span> <?php echo $phone['camera'] ?> MP Camera </span>
                        </li>
                        <li>
                            <i class="fas fa-mobile-android"></i>
                            <span> <?php echo $phone['display'] ?> inches IPS LCD Display </span>
                        </li>
                    </ul>
                    <ul class="col-sm-5 ">
                        <li>
                            <i class="fa-solid fa-memory"></i>
                            <span> <?php echo $phone['ram'] ?> GB RAM </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-sd-card"></i>
                            <span> <?php echo $phone['storage'] ?> GB Storage </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-battery-three-quarters"></i>
                            <span> <?php echo $phone['battery'] ?>mAh Battery </span>
                        </li>
                    </ul>
                </div>
                <div class="buy">
                    <div class="price d-flex justify-content-between flex-lg-column ">
                        <h2>$<?php echo toFixed($phone['price']*0.75,2) ?> <span
                                class="badge percentage badge-secondary ">25%</span></h2>
                        <h5 class="mt-2 ">$<?php echo $phone['price']?></h5>
                    </div>

                    <div class="row justify-content-lg-start justify-content-md-between ">
                        <div class="col-md-5 nice-number justify-content-center">
                            <button class="btn bg-secondary rounded-left "
                                onclick="this.parentNode.querySelector( 'input[type=number]').stepDown() ">-</button>
                            <input class="bg-secondary number-input border-0" min="1" type="number" value="1">
                            <button class="btn bg-secondary rounded-right "
                                onclick="this.parentNode.querySelector( 'input[type=number]').stepUp() ">+</button>
                        </div>
                        <div class="col-md-6 mt-4 pt-2 ">
                            <button type="button" onclick="addProduct(<?php echo $phone['product_id'] ?>)"
                                class="d-flex align-items-center justify-content-center btn rounded-lg  btn-warning add-btn"
                                style="width: 100%;">
                                <i class="nav-link btn fa-regular fa-shopping-cart "></i>
                                <span style="font-size: 20px ">Add to cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($phone == null) echo 'There\'s no phone with this id'?>
</section>
<?php
$conn->close();
?>
<?php include 'footer.php';?>

<script>
function addProduct(id) {
    <?php
    if (!isset($_SESSION['user_id'])) {
        echo " window.location.href = 'login.php';";
    }
    else{
        echo "
            let quantity = $('.number-input').val();
            $.ajax({
                method: 'POST',
                url: 'cart-functions.php',
                data: {
                    product_id: id,
                    quantity: quantity,
                    scope: 'add'
                },
                success: function(res) {
                    if (res == 200)
                        alert('added successfully');
                    else
                        alert(res);
                }
            })
        ";
    }
    ?>
}
</script>