<?php 
    include "includes/checkInstallation.php";
    include "includes/connect.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Photo Gallery</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/thumbnail-gallery.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
    <?php include "includes/functions.php"; ?>
</head>
<body>
    <!-- Page Content -->
    
    <div class="container">
        <div class="row">
        <?php
        if(isset($_GET["view"]) && ($_GET["view"] == "album")){
            $albID = $_GET["albID"];
            $albName = $_GET["albName"];
        ?>
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $albName; ?></h1>
            </div>
            <?php 
            $qry = "SELECT * FROM tbl_photos WHERE AID=".$albID." ORDER BY PID DESC";
            $res = mysql_query($qry);
            if(mysql_num_rows($res) > 0){
                while($arr = mysql_fetch_array($res)){
                    $img = "UPLOADS/".$albName."/thumbs/".$arr["file_name"];
                    $fullImg = "UPLOADS/".$albName."/".$arr["file_name"];
                    ?>
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <a class="fancybox-thumbs thumbnail" data-fancybox-group="thumb" href="<?php echo $fullImg; ?>">
                            <img class="img-responsive" src="<?php echo $img; ?>" alt="">
                        </a>
                    </div>
                    <?php 
                }
            }
            else{
                echo "No photos found";
            }
        }
        else{
        ?>
            <div class="col-lg-12">
                <h1 class="page-header">Thumbnail Gallery</h1>
            </div>
            <?php 
            $qry = "SELECT * FROM tbl_gallery ORDER BY AID DESC";
            $res = mysql_query($qry);
            if(mysql_num_rows($res) > 0){
                while($arr = mysql_fetch_array($res)){
                    if($arr["CID"] != 0){
                        $coverImg = "UPLOADS/".$arr["album_name"]."/thumbs/".getCoverImg($arr["CID"]);
                    }
                    else{
                        $coverImg = "images/400x300.png";
                    }
                    ?>
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <a class="thumbnail" href="index.php?view=album&albID=<?php echo $arr["AID"]; ?>&albName=<?php echo $arr["album_name"]; ?>">
                            <img class="img-responsive" src="<?php echo $coverImg; ?>" alt="">
                            <div class="gallery-title"><?php echo $arr["album_name"]; ?></div>
                        </a>
                    </div>
                    <?php 
                }
            }
            else{
                echo "No albums found";
            }
        }
        ?>
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
    
    <script>
    $(document).ready(function(){
        $('.fancybox-thumbs').fancybox({
            prevEffect : 'none',
            nextEffect : 'none',

            closeBtn  : true,
            arrows    : true,
            nextClick : false,

            helpers : {
                thumbs : {
                    width  : 400,
                    height : 300
                }
            }
        });
    });
    </script>
</body>

</html>
