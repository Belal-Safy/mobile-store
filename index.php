<?php
include 'connection.php';
session_start();

//get some random phones from databse
$sql = "SELECT product_id, name, image FROM products ORDER BY RAND() LIMIT 8";
$result = $conn->query($sql);
?>
<?php include 'header.php' ?>

<section id="intro" data-nav="intro" name="intro">
    <div class="row intro-box w-100 align-items-center">
        <img data-aos="zoom-in-up" data-aos-delay="100" data-aos-duration="3000"
            class="col-12 col-sm-6 mx-auto aos-init aos-animate" src="images/smartphone.png">
        <div class="col-12 col-sm-6 info1">
            <h3>Shop safely. Shop fast</h3>
            <h2>Discover the latest phones at the best prices for the greatest savings and convenience in buying
            </h2>
            <p>
                Your phone is the largest store to buy everything related to phones. quality, speed and safety
                while shopping
            </p>
            <a href="index.php#last-phones"> <button>Learn more</button></a>
        </div>
    </div>
</section>

<section id="features" data-nav="features" name="features" class="pt-5" style="min-height:calc(100vh - 80px);">
    <div class="row justify-content-center align-items-center mt-5" style="min-height:calc(100vh - 170px);">
        <div class="col-12 col-xl-7 ">
            <h1 class="w-100">Why are we the best choice?</h1>
            <ul data-aos="flip-down" data-aos-delay="100" data-aos-duration="1500"
                class="row w-100 justify-content-center aos-init aos-animate">
                <li class="col-12 feature">
                    <div class="feature-expand">
                        <h2>Delivery speed</h2>
                        <p>Your order will arrive in 2-5 days</p>
                    </div>
                </li>
                <li class="col-12 feature">
                    <div class="feature-expand">
                        <h2>Protection and safety</h2>
                        <p>Protection during electronic payment</p>
                    </div>
                </li>
                <li class="col-12 feature">
                    <div class="feature-expand">
                        <h2>Wide selection</h2>
                        <p>We have the latest phones</p>
                    </div>
                </li>
                <li class="col-12 feature">
                    <div class="feature-expand">
                        <h2>Technical Support</h2>
                        <p>24/7 technical support to solve your problems</p>
                    </div>
                </li>
            </ul>
        </div>

        <img data-aos="fade-up" data-aos-delay="100" data-aos-duration="1500"
            class="col-12 col-xl-5 aos-init aos-animate" src="images/phone-chat.svg" alt="">
    </div>
</section>
<section id="last-phones" class="phones-gallary" data-nav="last-phones" name="last-phones">
    <h3 class="main-title">Recently Added Phones</h3>
    <div data-aos="zoom-in-up" data-aos-delay="100" data-aos-duration="1200" class="container aos-init aos-animate">
        <div class="row w-100">
            <?php 
            //display phones
            while($row = $result->fetch_assoc()) {
                echo '
                        <div class="col-12 col-sm-6 col-lg-3">
                        <a href="phone.php?id='.$row['product_id'].'">
                            <img src="images/phones/'.$row['image'].'" alt="'.$row['name'].'" class="m-2">
                            <p>'.$row['name'].'</p>
                        </a>
                        </div>
                ';
            }
            $conn->close();
            ?>
        </div>
</section>

<div class="sale">
    <span>SALE 25%</span>
</div>

<?php include 'footer.php' ?>