<?php
// Initialize the session

session_start();
 
    /* Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
    }*/
 
// Include config file
include 'config.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT idUser, username, password FROM user WHERE username = ?";
        
       /* tes koneksi 
        $stmt = mysqli_prepare($link, $sql);
        if ($stmt === FALSE) {
          die($mysqli->error);
        }   
        $stmt->execute();
        */

         if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                     // Bind result variables
                   mysqli_stmt_bind_result($stmt, $idUser, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                         if($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: profile.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                     } 
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
               }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt); 
        }
    }



    // Close connection
    mysqli_close($link);
    
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Vietgram | Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Vietgram, like Instagram but with Pho" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <main id="login">
            <div class="login__column">
                <img src="images/phoneImage.png" class="login__phone" />
            </div>
            <div class="login__column">
                <div class="login__box">
                    <img src="images/loginLogo.png" class="login__logo" />
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="login__form <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo  $username; ?>" required>
                <span class="help-block"><?php echo "<div style=\"color: red;\">" . $username_err ."</div>"; ?></span>
            </div>    
            <div class="login__form <?php echo (!empty($password_err)) ? 'has-error' : '' ?>" >
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                <span class="help-block"><?php echo "<div style=\"color: red;\">" . $password_err ."</div>"; ?></span>
            </div>
            <div class="login__form">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
        </form>
                    <span class="login__divider">or</span>
                    <a href="#" class="login__link">
                        <i class="fa fa-money"></i>
                        Log in with Facebook
                    </a>
                    <a href="#" class="login__link login__link--small">Forgot password</a>
                </div>
                <div class="login__box">
                    <span>Don't have an account?</span> <a href="#">Sign up</a>
                </div>
                <div class="login__box--transparent">
                    <span>Get the app.</span>
                    <div class="login__appstores">
                        <img src="images/ios.png" class="login__appstore" alt="Apple appstore logo" title="Apple appstore logo" />
                        <img src="images/android.png" class="login__appstore" alt="Android appstore logo" title="Android appstore logo" />
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="footer__column">
                <nav class="footer__nav">
                    <ul class="footer__list">
                        <li class="footer__list-item"><a href="#" class="footer__link">About Us</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Support</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Blog</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Press</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Api</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Jobs</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Privacy</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Terms</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Directory</a></li>
                        <li class="footer__list-item"><a href="#" class="footer__link">Language</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer__column">
                <span class="footer__copyright">© 2017 Vietgram</span>
            </div>
        </footer>
    </body>
</html>