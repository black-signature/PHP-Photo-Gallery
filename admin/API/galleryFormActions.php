<?php 
/**
 * PHP Gallery Form Actions
 *
 * PHP Gallery form actions contains all the actions that can be performed by the admin
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Admin / PHP Gallery
 * @author     Balu John Thomas <balujohnthomas@gmail.com>
 * @license    GPL
 * @version    1.0.0
 **/
 
include "../includes/checkLoggedIn.php";
include "../../includes/connect.php";
include "../includes/functions.php";
$uploadsDir = "../../UPLOADS";

$formParam = $_REQUEST["form_param"];
switch($formParam){
    case "create_album":
        $albumName = $_POST["album_name"];
        if(isset($albumName) && $albumName !== ""){
            $qry = "INSERT INTO tbl_gallery(album_name) VALUES('$albumName')";
            if(mysql_query($qry)){
                mkdir("../../UPLOADS/".$albumName,"0777");
                mkdir("../../UPLOADS/".$albumName."/thumbs","0777"); //thumbnails
                $msg = "Album created successfully";
                header("Location: ../index.php?s=true&t=CrALB");
            }
            else{
                header("Location: ../index.php?s=false&t=CrALB");
            }
        }
    break;
    
    case "upload_photo":
        $albumID = $_POST["album_id"];
        $albumName = $_POST["album_name"];
        $imgTmp = $_FILES["imgFile"]["tmp_name"];
        $imgName = $_FILES["imgFile"]["name"];
        
        if(move_uploaded_file($imgTmp, $uploadsDir."/".$albumName."/".$imgName)){
            makeThumbnails($uploadsDir."/".$albumName , $imgName);
            makeThumbnails($uploadsDir."/".$albumName , $imgName, "", 1024, 768); //Big image
            
            $qry = "INSERT INTO tbl_photos (AID, file_name) VALUES(".$albumID.", '".$imgName."')";
            mysql_query($qry);
            echo 'success';
        }
    break;
    
    case "setCover":
        $imgID = $_REQUEST["imgID"];
        $albID = $_REQUEST["albID"];
        $albName = $_REQUEST["albName"];
        
        $qry = "UPDATE tbl_gallery SET CID=".$imgID." WHERE AID=".$albID;
        $qryImg = "UPDATE tbl_photos SET cover_status=1 WHERE PID=".$imgID;
        if(mysql_query($qry)){
            mysql_query("UPDATE tbl_photos SET cover_status=0");
            mysql_query($qryImg);
            header("Location: ../index.php?s=true&t=setCvrALB&act=edit&albID=".$albID."&albName=".$albName);
        }
        else{
            header("Location: ../index.php?s=false&t=setCvrALB&act=edit&albID=".$albID."&albName=".$albName);
        }
    break;
    
    case "delPic":
        $imgID = $_REQUEST["imgID"];
        $albID = $_REQUEST["albID"];
        $albName = $_REQUEST["albName"];
        
        $qry = "DELETE FROM tbl_photos WHERE PID=".$imgID;
        if(mysql_query($qry)){
            header("Location: ../index.php?s=true&t=delImgALB&act=edit&albID=".$albID."&albName=".$albName);
        }
        else{
            header("Location: ../index.php?s=false&t=delImgALB&act=edit&albID=".$albID."&albName=".$albName);
        }
    break;
    
    case "delAlbum":
        $albID = $_REQUEST["albID"];
        $albName = $_REQUEST["albName"];
        
        deleteDir($uploadsDir."/".$albName);
        
        $resAlb = mysql_query("DELETE FROM tbl_gallery WHERE AID=".$albID);
        $resImg = mysql_query("DELETE FROM tbl_photos WHERE AID=".$albID);
        if($resAlb && $resImg){
            header("Location: ../index.php?s=true&t=delALB");
        }
        else{
            header("Location: ../index.php?s=false&t=delALB");
        }
    break;
}
?>