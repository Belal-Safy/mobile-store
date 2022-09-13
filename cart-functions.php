<?php include 'connection.php'; ?>
<?php include 'functions.php'; ?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scope'])) {
        session_start();
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT cart from users WHERE user_id =" .$user_id;
        $result = mysqli_query($conn, $sql); 
        $cart = $result->fetch_assoc()['cart'];
        $product_id = $_POST['product_id'];
        switch ($_POST['scope']) {
            case 'add':
                $quantity = $_POST['quantity'];
                $cart = array_values(removeElementWithValue(json_decode($cart, true), "product_id", $product_id));
                array_push($cart, array("product_id"=>$product_id, "quantity"=>$quantity));
                $new_cart = json_encode($cart,true);
                $sql = "UPDATE users SET cart = '".$new_cart."' WHERE user_id =" .$user_id;
                mysqli_query($conn, $sql);
                echo 200;
                break;
                
            case 'delete':
                $new_cart_arr = array_values(removeElementWithValue(json_decode($cart, true), "product_id", $product_id));
                $new_cart = json_encode($new_cart_arr,true);
                $sql = "UPDATE users SET cart = '".$new_cart."' WHERE user_id =" .$user_id;
                mysqli_query($conn, $sql);
                echo 200;
                break;

            case 'update':
                $quantity = $_POST['quantity'];
                $new_cart_arr = array_values(updateElementWithValue(json_decode($cart, true), "product_id", $product_id, $quantity));
                $new_cart = json_encode($new_cart_arr,true);
                $sql = "UPDATE users SET cart = '".$new_cart."' WHERE user_id =" .$user_id;
                mysqli_query($conn, $sql);
                echo 200;
                break;
            default:
                break;
        }

    }

?>