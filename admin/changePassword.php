<?php error_reporting(0);
    include "includes/checkAdminInstallation.php";
    include "includes/checkLoggedIn.php";
    include "../includes/connect.php"; 
    include "includes/adminMsgMap.php";
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <?php include "includes/templates/adminHead.php"; ?>
</head>
<body class="gallery-admin-body">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"><h2 class="page-header">Change Password</h2></div>
            <div class="col-lg-6">
                <?php 
                if(isset($_GET["t"]) && isset($_GET["s"])){
                    if($_GET["s"] == "true"){
                        ?>
                        <div class="alert alert-success"><?php echo $msgMap[ $_GET["t"] ][ $_GET["s"] ]; ?></div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="alert alert-danger"><?php echo $msgMap[ $_GET["t"] ][ $_GET["s"] ]; ?></div>
                        <?php
                    }
                }
                ?>
                <form method="POST" action="API/galleryFormActions.php">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_new_password" class="form-control" required>
                    </div>
                    <input type="hidden" name="form_param" value="change_password" />
                    <button type="submit" name="Submit" value="Submit" class="btn btn-success">Submit &raquo;</button>
                    <button type="submit" name="Submit" value="Submit" class="btn btn-danger" onclick="history.go(-1);">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>