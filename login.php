<?php include 'connection.php'; ?>

<?php 
session_start();
//check if user is logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

//error to be displayed to user
$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    //form validation
    if (empty($email)) {
        $error = "Email is empty";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    elseif(empty($password)){
        $error = "password is empty";
    }
    elseif (!preg_match("/^(?=.*?[A-Za-z])(?=.*?[0-9]).{5,16}$/",$password)) {
        $error = "incorrect password";
    }
    else{
        include 'connection.php';
        //check email and password
        $sql = "SELECT user_id from users where email='".$email."' and password ='".$_POST['password']."'";
        $result = mysqli_query($conn, $sql); 
        $user = $result->fetch_assoc();
        if($user == null){
            $error = "incorrect email or password";
        }
        else{
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
             header('Location: index.php');
        }
    }
}
?>

<?php include 'header.php'; ?>

<section style="margin-top: 105px;padding: 10px;">
    <div class="d-flex flex-column justify-content-center">

        <form class="login-box container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <img src="images/logo.png" alt="logo">
            <h3 class="mb-5 text-center text-dark">Welcome to our <span>Mobile Shop</span>,<br> please login to
                continue...
            </h3>
            <!-- email input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="email-input">Email</label>
                <input value="<?php if(!isset($email)) $email =null; echo $email ?>" autofocus name="email" required
                    minlength="5" type="email" id="email-input" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="password-input">Password</label>
                <input name="password" required minlength="3" type="password" id="password-input"
                    class="form-control" />
            </div>

            <div class="d-flex flex-column mb-4 text-center">
                <p style="color: red;">
                    <?php
                    echo $error;
                ?>
                </p>

                <!-- forgotten password -->
                <a type="button" href="forgotten-password.php" class="link-warning mb-4">Forgot
                    password?</a>
                <!-- Submit button -->
                <button type="submit" value="Submit" class="mx-auto btn btn-warning">Sign in</button>
            </div>
            <!-- Register button -->
            <div class="text-center">
                <p class="text-dark">Not a member? <a href="signup.php" class="link-warning">Register</a></p>
            </div>
        </form>
    </div>

</section>

<!-- page footer -->
<?php include 'footer.php'; $conn->close();
?>