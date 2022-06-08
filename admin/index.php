<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Panel</title>
    <?php include 'link.php'; ?>
  </head>
  <body class="bg-secondary">
    <div class="loader"></div>
    <?php
    $message = "";
    if(isset($_COOKIE['admin_email']) && ($_COOKIE['admin_name']) )
    {
      $_SESSION['admin_email']=$_COOKIE['admin_email'];
      $_SESSION['admin_name']=$_COOKIE['admin_name'];
      ?>
        <script>
          window.location.href="dashboard.php";
        </script>
        <?php
    }
    
    if (isset($_POST['login'])) {	
      $email=$_POST['email'];
      $pass=$_POST['password'];
      $password=($pass);
      $login = $db -> query("SELECT * FROM admin WHERE admin_email='$email' AND password='$password'");
      if ($login -> num_rows > 0) {
        $user = $login -> fetch_assoc();
        $message='<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong><i class="fa fa-check"></i> Login </strong> <p>Successfully </p>
            </div>';
        $email_id=$_SESSION['admin_email']=$user['admin_email'];
        $names=$_SESSION['admin_name']=$user['admin_name'];
        if(!empty($_POST["remember"])) {
          setcookie ("admin_email",$email_id);
          setcookie ("admin_name", $names);
          ?>
          <script>
            window.location.href="dashboard.php";
          </script>
          <?php
        }else{
          ?>
          <script>
            window.location.href="dashboard.php";
          </script>
          <?php
        }	
      }
      else{
        $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong><i class="fa fa-warning"></i> Error </strong> <p> Invalid credentials</p>
            </div>';
      }
    }
    ?>
    <div id="logreg-forms">
      <div><img src="../images/logo/logo.png" class="image-fluid w-100"></div>
        <form class="form-signin" method="POST">
          <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
          <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required="" autofocus="">
          <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required="">
          
          <button class="btn btn-primary btn-block" type="submit" name="login"><i class="fa fa-sign-in"></i> Sign in</button>
          
           <span><input id="remember" name="remember" type="checkbox" value="remember"></span>  <label for="remember" class="text-info"><span> Remember me </span></label> <span><a href="" id="forgot_pswd"><i class="fa fa-key"></i> Forget password?</a></span>
          <hr>
         <?php echo $message; ?>
        </form>           
    </div>
  </body>
</html>
<?php
$db = $database->close();
?>