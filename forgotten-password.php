<?php include 'connection.php'; ?>

<?php 
session_start();
//check if user is logged in
if (isset($_SESSION['user_id'])) {
    header('Location: '.'http://localhost/mobile-store/index.php');
}
//error to be displayed to user
$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //get form data
    $email = $_POST['email'];
    $password = $_POST['new_password'];
    $question = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);
    
    //form validation
    if (empty($email)) {
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
        //change password
        $sql = "UPDATE users SET password = '". $_POST['new_password']."' where email='".$email."' and recovery_question ='".$question."' and recovery_answer = '".$answer."'";
        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn) == 1){
            echo "<script>alert('password was resetted successfully');window.location.href = 'login.php';</script>";
        }
        elseif(mysqli_affected_rows($conn) == 0){
            $error = 'incorrect email or answer';
        }
        else{
            $error = 'some thing went wrong';
        }
    }
}
?>

<?php include 'header.php'; ?>

<section style="margin-top: 105px;padding: 10px;">
    <div class="d-flex flex-column justify-content-center">
        <form class="login-box container py-3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="mb-3 text-center text-dark">Reset password</h1>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="email">Email</label>
                <input value="<?php if(!isset($email)) $email =null; echo $email ?>" required minlength="3" name="email"
                    type="email" id="email" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="new-password">New password</label>
                <input required minlength="3" name="new_password" type="password" id="new-password"
                    class="form-control" />
            </div>

            <!-- recovery question input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="question">Recovery question</label>
                <select required class="form-select" name="question" id="question" aria-label="Default select example">
                    <option value="What is the name of your favorite pet ?">What is the name of your favorite pet ?
                    </option>
                    <option value="What is your favorite color ?">What is your favorite color ?</option>
                    <option value="What is the name of your first school ?">What is the name of your first school ?
                    </option>
                    <option value="What is your favorite movie ?">What is your favorite movie ?</option>
                    <option value=">Who is your favorite hero ?">Who is your favorite hero ?</option>
                </select>
            </div>
            <!-- answer input -->
            <div class="form-outline mb-4">
                <label class="form-label text-dark" for="answer">Answer</label>
                <input required name="answer" type="text" id="answer" class="form-control" />
            </div>

            <div class="text-center">
                <p style="color: red;">
                    <?php
                    echo $error;
                ?>
                </p>
                <button id="reset" type="submit" class="px-4 py-2 btn btn-warning">Reset password</button>
                </a>
            </div>
        </form>
    </div>

</section>

<!-- page footer -->
<?php include 'footer.php' ?>