<?php include 'connection.php'; ?>

<?php
session_start();

//check if user logged out
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
     header('Location: index.php');
}

//check if user is logged in
if (!isset($_SESSION['user_id'])) {
 header('Location: login.php');
}

//get user id from session
$id =  $_SESSION['user_id'];

//get user data from the databse
$sql = "SELECT * from users WHERE user_id ="."$id;";
$result = mysqli_query($conn, $sql); 
$user = $result->fetch_assoc();

//error to be displayed to user
$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //get form data
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

    //form validation
    if (empty($firstname)){
        $error = "firstname is empty";
    }
    elseif (empty($lastname)){
        $error = "lastname is empty";
    }
    elseif (empty($email)) {
        $error = "email is empty";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    else{
        // update user data
        $sql = "UPDATE users SET firstname = '".$firstname."', lastname = '".$lastname."', address = '".$address."', email = '".$email."' WHERE (user_id = '".$id."')";
        $result = mysqli_query($conn, $sql);
        if($result == 1){
            echo "<script>alert('updated successfully');window.location.href = 'profile.php';</script>";
        }
        elseif($result == null){
            echo "<script>alert('this email alredy exist')</script>";
        }
        else{
            echo "<script>alert('some thing went wrong')</script>";
        }
    }
}


?>

<?php include 'header.php'; ?>
<section style="margin-top: 105px;min-height: calc(100vh - 217px);">
    <h3 class="main-title text-center">My Profile</h3>
    <form class="login-box container pt-5 mt-5" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <a href='profile.php?logout=true'>
            <button type="button" class="btn btn-secondary w-100 mb-5">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Logout
            </button>
        </a>

        <!-- name input -->
        <div class="row justify-content-between form-outline">
            <div class=" mb-4 col-md-6">
                <label class="form-label text-dark " for="firstname">First name</label>
                <input value="<?php echo $user['firstname']?>" name="firstname" required type="text" id="firstname"
                    class="form-control text-capitalize" />
            </div>
            <div class="col-md-6">
                <label class="form-label text-dark" for="lastname">Last name</label>
                <input value="<?php echo $user['lastname']?>" name="lastname" required type="text" id="lastname"
                    class="form-control text-capitalize" />
            </div>
        </div>

        <!-- email input -->
        <div class="form-outline mb-4">
            <label class="form-label text-dark" for="email-input">Email</label>
            <input value="<?php echo $user['email']?>" name="email" required minlength="3" type="email" id="email-input"
                class="form-control" />
        </div>

        <!-- Address input -->
        <div class="form-outline mb-4">
            <label class="form-label text-dark" for="address-input">Address</label>
            <input value="<?php echo $user['address']?>" name="address" minlength="3" type="text" id="address-input"
                class="form-control" />
        </div>
        <div class="d-flex flex-column mb-4 text-center">
            <p style="color: red;">
                <?php
                    echo $error;
                ?>
            </p>
            <!-- Submit button -->
            <button type="submit" value="Submit" class="mx-auto btn btn-warning mb-5">Save changes</button>
        </div>
    </form>
</section>

<?php include 'footer.php' ?>