<?php 
include "../admin/includes/adminMsgMap.php";

if(isset($_POST["Submit"]) && $_POST["Submit"] == "Next"){
    $dbHost = $_POST["db_host"];
    $dbUser = $_POST["db_user"];
    $dbPass = $_POST["db_password"];
    $dbName = $_POST["db_name"];
    
    if(mysql_connect($dbHost, $dbUser, $dbPass)){
        if(mysql_select_db($dbName)){
            // Create connect.php
            $connectionFile = fopen("../includes/connect.php", "w");
            $connection = '<?php $conn = mysql_connect("'.$dbHost.'","'.$dbUser.'","'.$dbPass.'"); if(!$conn){ die("<h1>Could not establish a database connection</h1>"); } else { mysql_select_db("'.$dbName.'"); } ?>';
            fwrite($connectionFile, $connection);
            fclose($connectionFile);
            
            include "../includes/connect.php";
            
            $tableSetupAdmin =  "CREATE TABLE IF NOT EXISTS `tbl_admin` (
                                  `id` int(8) NOT NULL AUTO_INCREMENT,
                                  `username` varchar(32) NOT NULL,
                                  `password` varchar(32) NOT NULL,
                                  `type` varchar(16) NOT NULL,
                                  `status` int(8) NOT NULL,
                                  PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

            $tableSetupConfig = "CREATE TABLE IF NOT EXISTS `tbl_config` (
                                  `id` int(8) NOT NULL AUTO_INCREMENT,
                                  `config_name` varchar(16) NOT NULL,
                                  `config_value` varchar(16) NOT NULL,
                                  PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

            $tableSetupGallery = "CREATE TABLE IF NOT EXISTS `tbl_gallery` (
                                  `AID` int(8) NOT NULL AUTO_INCREMENT,
                                  `CID` int(8) NOT NULL,
                                  `album_name` varchar(32) NOT NULL,
                                  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  PRIMARY KEY (`AID`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

            $tableSetupPhotos = "CREATE TABLE IF NOT EXISTS `tbl_photos` (
                                  `PID` int(8) NOT NULL AUTO_INCREMENT,
                                  `AID` int(8) NOT NULL,
                                  `file_name` text NOT NULL,
                                  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `cover_status` tinyint(1) NOT NULL DEFAULT '0',
                                  PRIMARY KEY (`PID`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
            
            
            if(mysql_query($tableSetupAdmin) && mysql_query($tableSetupConfig) && mysql_query($tableSetupGallery) && mysql_query($tableSetupPhotos)){
                header("Location: install.php?s=true&t=instSuccess");
            }
            else{
                header("Location: install.php?s=true&t=instDBTblFailed");
            }
        }
        else{
            header("Location: install.php?s=false&t=inDBNE");
        }
    }
    else{
        header("Location: install.php?s=false&t=inDBConF");
    }
}
else if(isset($_POST["Submit"]) && $_POST["Submit"] == "Next_Create_Admin"){
    include "../includes/connect.php";
    
    $admin = $_POST["admin_username"];
    $adminPass = $_POST["admin_password"];
    $adminConfPass = $_POST["admin_confirm_password"];
    
    if($admin != "" && $adminPass != "" && $adminConfPass != ""){
        if($adminPass == $adminConfPass){
            $qryCheck = "SELECT id FROM tbl_admin WHERE username = '".$admin."'";
            $resCheck = mysql_query($qryCheck);
            if(mysql_num_rows($resCheck) == 0){
                $qry = "INSERT INTO tbl_admin(username, password, type, status) VALUES ('".$admin."', '".md5($adminPass)."', 'admin', 1)";
                if(mysql_query($qry)){
                    //Create installed file..
                    $installFile = fopen("../installed", "w");
                    $installationDetails = "Installed on : ".date("d-m-y, h:i:s a")."\n";
                    fwrite($installFile, $installationDetails);
                    fclose($installFile);
                    
                    header("Location: install.php?s=true&t=instComplete");
                }
            }
            else{
                header("Location: install.php?s=false&t=adminExists");
            }
        }
        else{
            header("Location: install.php?s=false&t=passMismatch");
        }
    }
    else{
        header("Location: install.php?s=false&t=credBlank");
    }
}
else if(isset($_POST["Submit"]) && $_POST["Submit"] == "Finish"){
    header("Location: ../admin/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PHP Gallery Installer</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>PHP Gallery Installer</h2>
                <div class="lead">
                    This will initialize all the tables and default set-up required for the gallery to function.
                </div>
                
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
                <form method="POST">
                    <?php 
                    if(isset($_GET["t"]) && isset($_GET["s"])){
                        if($_GET["s"] == "true" && $_GET["t"] == "instSuccess"){
                            ?>
                            <div class="form-group">
                                <label>Admin Username</label>
                                <input type="text" name="admin_username" class="form-control" placeholder="Admin User" required>
                            </div>
                            <div class="form-group">
                                <label>Admin Password</label>
                                <input type="password" name="admin_password" class="form-control" placeholder="Admin Password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Admin Password</label>
                                <input type="password" name="admin_confirm_password" class="form-control" placeholder="Admin Confirm Password" required>
                            </div>
                            <input type="hidden" name="form_param" value="create_admin" />
                            <button type="submit" name="Submit" value="Next_Create_Admin" class="btn btn-success">Next &raquo;</button>
                            <?php 
                        }
                        else if($_GET["s"] == "false" && ($_GET["t"] == "credBlank" || $_GET["t"] == "passMismatch")){
                            ?>
                            <div class="form-group">
                                <label>Admin Username</label>
                                <input type="text" name="admin_username" class="form-control" placeholder="Admin User" required>
                            </div>
                            <div class="form-group">
                                <label>Admin Password</label>
                                <input type="password" name="admin_password" class="form-control" placeholder="Admin Password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Admin Password</label>
                                <input type="password" name="admin_confirm_password" class="form-control" placeholder="Admin Confirm Password" required>
                            </div>
                            <input type="hidden" name="form_param" value="create_admin" />
                            <button type="submit" name="Submit" value="Next_Create_Admin" class="btn btn-success">Next &raquo;</button>
                            <?php
                        }
                        else if($_GET["s"] == "true" && $_GET["t"] == "instComplete"){
                            ?>
                            <button type="submit" name="Submit" value="Finish" class="btn btn-success">Finish</button>
                            <?php
                        }
                        else{
                            ?>
                            <div class="form-group">
                                <label>Database Host</label>
                                <input type="text" name="db_host" class="form-control" placeholder="Database Host" value="localhost" required>
                            </div>
                            <div class="form-group">
                                <label>Database Name</label>
                                <input type="text" name="db_name" class="form-control" placeholder="Database Name" required>
                            </div>
                            <div class="form-group">
                                <label>Database User</label>
                                <input type="text" name="db_user" class="form-control" placeholder="Database User" required>
                            </div>
                            <div class="form-group">
                                <label>Database Password</label>
                                <input type="password" name="db_password" class="form-control" placeholder="Database Password">
                            </div>
                            <input type="hidden" name="form_param" value="install" />
                            <button type="submit" name="Submit" value="Next" class="btn btn-success">Next &raquo;</button>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <div class="form-group">
                            <label>Database Host</label>
                            <input type="text" name="db_host" class="form-control" placeholder="Database Host" value="localhost" required>
                        </div>
                        <div class="form-group">
                            <label>Database Name</label>
                            <input type="text" name="db_name" class="form-control" placeholder="Database Name" required>
                        </div>
                        <div class="form-group">
                            <label>Database User</label>
                            <input type="text" name="db_user" class="form-control" placeholder="Database User" required>
                        </div>
                        <div class="form-group">
                            <label>Database Password</label>
                            <input type="password" name="db_password" class="form-control" placeholder="Database Password">
                        </div>
                        <input type="hidden" name="form_param" value="install" />
                        <button type="submit" name="Submit" value="Next" class="btn btn-success">Next &raquo;</button>
                        <?php
                    }
                    ?>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-2.1.0.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>