<?php
include 'connection.php';
session_start();

//get brand from url
$brand =  $_GET['brand'];

// get product data from database
$sql = "SELECT product_id, name, image FROM products WHERE brand ="." '$brand';";
$result = $conn->query($sql);
?>


<?php include 'header.php' ?>
<section id="category" class="phones-gallary" data-nav="last-phones" name="last-phones" style="margin-top: 40px;">
    <h3 class="main-title text-capitalize"><?php echo $brand?> Phones</h3>
    <div class="container">
        <div class="row w-100">

            <?php 
            while($phone = $result->fetch_assoc()) {
                echo '
                        <div class="col-12 col-sm-6 col-lg-3">
                        <a href="phone.php?id='.$phone['product_id'].'">
                            <img src="images/phones/'.$phone['image'].'" alt="'.$phone['name'].'" class="m-2">
                            <p>'.$phone['name'].'</p>
                        </a>
                        </div>
                ';
            }
            $conn->close();
            ?>

        </div>

</section>

<?php include 'footer.php' ?>