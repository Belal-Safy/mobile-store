<?php include 'connection.php'; ?>
<?php include 'functions.php'; ?>

<?php
session_start();
//check if user isn't logged in
if (!isset($_SESSION['user_id'])) {
 header('Location: login.php');
}
$id = $_SESSION['user_id'];

// get cart of the user
$sql = "SELECT cart from users WHERE user_id ="."$id;";

$result = mysqli_query($conn, $sql); 
$cart = $result->fetch_assoc()['cart'];
$cart = json_decode($cart ,true);
$cart = array_reverse($cart);
?>

<?php include 'header.php'; ?>

<section style="margin-top: 105px;min-height: calc(100vh - 217px);">
    <h3 class="main-title text-center">Cart</h3>
    <div id="cart-empty"
        class="<?php if(count($cart) > 0) echo 'd-none' ?> d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-5">
            <h3>Cart is empty</h3>
            <a href="index.php#last-phones"><button class="btn btn-warning">start shopping now</button></a>

        </div>
    </div>
    <div id="cart-exist" class="<?php if(count($cart) == 0) echo 'd-none' ?> d-flex flex-column align-items-center">
        <?php
            foreach($cart as $value) {
                $id = $value['product_id'];
                $quantity = $value['quantity'];
                $sql = "SELECT name, image, price FROM products where product_id = $id";
                $result = $conn->query($sql);
                $product = $result->fetch_assoc();
echo '
<div class="row cart-box">
<div class="col-sm-3 d-flex flex-column justify-content-center align-items-center">
<a href="phone.php?id='.$id.'">
<img src="images/phones/'.$product['image'].'" alt="">
</a>
</div>
<div class="col-sm-9 mt-3 mt-sm-0">
<h4 class="text-nowrap">'.$product['name'].'</h4>
<div class="buy">
<div class="price d-flex justify-content-between flex-lg-column ">
<h2>$'.toFixed($product['price']*0.75,2).'<span class="badge percentage badge-secondary ">25%</span></h2>
<h5 class="mt-2 ">$'.$product['price'].'</h5>
</div>
<div class="row justify-content-lg-start justify-content-md-between ">
<div class="col-sm-5">
<div class="nice-number mx-2 ">
    <button class="btn bg-secondary rounded-left" onclick="stepdown('.$id.')">-</button>
    <input product_id ='.$id.' id="quantity-'.$id.'" class="bg-secondary number-input border-0" min="1" type="number" value="'.$quantity.'">
    <button class="btn bg-secondary rounded-right" onclick="stepup('.$id.')">+</button>
</div>
        <button class="btn btn-sm bg-warning text-white mt-2 mx-auto d-block" onclick="updateItem('.$id.')" style="font-size:13px;">change</button>
</div>
<div class="col-sm-7 mt-2 mt-md-0">
    <button type="button" class="btn btn-danger float-sm-end text-nowrap"
        onclick="removeItem('.$id.')">Remove from cart</button>
    </div>
    </div>
    </div>
    </div>
    </div>
    ';
    }
    ?>
    </div>
    <a href="purchase.php" class="text-decoration-none"> <button type="button"
            class=" <?php if(count($cart) == 0) echo 'd-none' ?> btn btn-warning mx-auto d-block my-5">process</button></a>

</section>

<?php include 'footer.php' ?>

<script>
function removeItem(id) {
    $.ajax({
        method: "POST",
        url: "cart-functions.php",
        data: {
            product_id: id,
            scope: 'delete'
        },
        success: function(res) {
            if (res == 200)
                location.reload();
            else
                alert(res);
        }
    })
}

function updateItem(id) {
    let quantity = $(`#quantity-${id}`).val();
    $.ajax({
        method: "POST",
        url: "cart-functions.php",
        data: {
            product_id: id,
            quantity: quantity,
            scope: 'update'
        },
        success: function(res) {
            if (res == 200)
                alert("Changed successfully");
            else
                alert("some thing went wrong");
        }
    })
}

function stepdown(id) {
    let val = $(`#quantity-${id}`).val();
    if (val > 1) {
        $(`#quantity-${id}`).val(parseInt(val) - 1);
    }
}

function stepup(id) {
    $(`#quantity-${id}`).val(parseInt($(`#quantity-${id}`).val()) + 1);
}
</script>