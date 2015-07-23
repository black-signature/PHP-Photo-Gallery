<?php session_start();
if(isset($_POST["SignIn"]) && $_POST["SignIn"] == "SignIn"){
    $admin = "admin";
    $pass = "password";
    
    if($_POST["username"] == $admin && $_POST["password"] == $pass){
        $_SESSION["signed_in"] = true; 
        header("Location: index.php");
    }
    else{
        $error = '<div class="alert alert-danger">Invalid Credentials</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Photo Gallery - Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/login-styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../js/jquery-2.1.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>   
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">
                    <?php 
                    if(isset($error)){
                        echo $error;
                    }
                    else{
                        ?>
                            Please Use The Below Form To Sign In
                        <?php
                    }
                    ?>
                </h1>
                <div class="account-wall">
                    <img class="profile-img" src="../images/login.jpg" />
                    <form class="form-signin" method="POST">
                        <input type="text" class="form-control" name="username" placeholder="Email" required autofocus>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="SignIn" value="SignIn">Sign in</button>
                        <!--<label class="checkbox pull-left">
                            <input type="checkbox" value="remember-me">
                            Remember me
                        </label>
                        <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span> -->
                    </form>
                </div>
                <!-- <a href="#" class="text-center new-account">Create an account </a> -->
            </div>
        </div>
    </div>
</body>
</html>