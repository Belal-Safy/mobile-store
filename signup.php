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
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $question = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);

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
    elseif(empty($password)){
        $error = "password is empty";
    }
    elseif(empty($question)){
        $error = "question is empty";
    }
    elseif(empty($answer)){
        $error = "answer is empty";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    elseif (!preg_match("/^(?=.*?[A-Za-z])(?=.*?[0-9]).{5,16}$/",$password)) {
        $error = "password should be minimum five characters and maximum 16 characters, at least one letter and one number";
    }
    else{
        include 'connection.php';
        //add new user to the database
        $sql = "INSERT INTO users (firstname, lastname, address, email, password, recovery_question, recovery_answer) VALUES ('".$firstname."', '".$lastname."', '".$address."', '".$email."', '".$_POST['password']."', '".$question."', '".$answer."')";
        $result = mysqli_query($conn, $sql);
        if($result == 1){
            echo "<script>alert('Signed up successfully');window.location.href = 'login.php';</script>";
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


<?php include 'header.php' ?>

<section style="margin-top: 105px;padding: 10px;">
    <div class="d-flex flex-column justify-content-center background">
        <form class="login-box container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <img src="images/logo.png" alt="logo">
            <h3 class="mb-5 text-center text-dark">Welcome to our <span>Mobile Shop</span></h3>

            <!-- name input -->
            <div class="row justify-content-between form-outline">
                <div class=" mb-4 col-md-6">
                    <label class="form-label text-dark" for="new-first">First name</label>
                    <input value="<?php if(!isset($firstname)) $firstname =null; echo $firstname ?>" autofocus
                        name="firstname" required type="text" id="new-first" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark" for="new-last">Last name</label>
                    <input value="<?php if(!isset($lastname)) $lastname =null; echo $lastname ?>" name="lastname"
                        required type="text" id="new-last" class="form-control" />
                </div>
            </div>

            <!-- email input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="email-input">Email</label>
                <input value="<?php if(!isset($email)) $email =null; echo $email ?>" name="email" required minlength="3"
                    type="email" id="email-input" class="form-control" />
            </div>

            <!-- Address input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="address-input">Address</label>
                <input value="<?php if(!isset($address)) $address =null; echo $address ?>" autofocus name="address"
                    minlength="3" type="text" id="address-input" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="new-">Password</label>
                <input name="password" required minlength="3" type="password" id="new-password" class="form-control" />
            </div>

            <!-- question input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="new-question">Recovery question</label>
                <select name="question" required id="new-question" class="form-select"
                    aria-label="Default select example">
                    <option
                        <?php if(isset($question))if($question == 'What is the name of your favorite pet ?') echo 'selected' ?>
                        value="What is the name of your favorite pet ?">What is the name of your favorite pet ?
                    </option>
                    <option
                        <?php if(isset($question))if($question == 'What is your favorite color ?') echo 'selected' ?>
                        value="What is your favorite color ?">What is your favorite color ?</option>
                    <option
                        <?php if(isset($question))if($question == 'What is the name of your first school ?') echo 'selected' ?>
                        value="What is the name of your first school ?">What is the name of your first school ?
                    </option>
                    <option
                        <?php if(isset($question))if($question == 'What is your favorite movie ?') echo 'selected' ?>
                        value="What is your favorite movie ?">What is your favorite movie ?</option>
                    <option <?php if(isset($question))if($question == 'Who is your favorite hero ?') echo 'selected' ?>
                        value="Who is your favorite hero ?">Who is your favorite hero ?</option>
                </select>
            </div>
            <!-- answer input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="new-answer">Answer</label>
                <input value="<?php if(!isset($answer)) $answer =null; echo $answer ?>" name="answer" required
                    type="text" id="new-answer" class="form-control" />
            </div>

            <div class="d-flex flex-column mb-4 text-center">
                <p style="color: red;">
                    <?php
                    echo $error;
                ?>
                </p>
                <!-- Submit button -->
                <button type="submit" value="Submit" class="mx-auto btn btn-warning ">Signup</button>
            </div>
        </form>
    </div>

</section>

<!-- page footer -->
<?php include 'footer.php'; $conn->close();
?>