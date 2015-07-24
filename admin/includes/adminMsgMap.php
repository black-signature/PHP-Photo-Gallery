<?php 
/**
 * PHP Gallery Admin Error/Success Msgs
 *
 * PHP Gallery admin actions error / success messages can be configured from this page.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Messages
 * @author     Balu John Thomas <balujohnthomas@gmail.com>
 * @license    GPL
 * @version    1.0.0
 **/
 
if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
    die('<h1>Direct access is not permitted</h1>');
}

$msgMap["CrALB"]["true"] = "Album Created Successfully";
$msgMap["CrALB"]["false"] = "Error while creating the album";
$msgMap["setCvrALB"]["true"] = "Image successfully set as cover";
$msgMap["setCvrALB"]["false"] = "Error while setting as cover. Please try later";
$msgMap["delImgALB"]["true"] = "Image deleted successfully";
$msgMap["delImgALB"]["false"] = "Error while deleting the image. Please try later";
$msgMap["delALB"]["true"] = "Album deleted successfully";
$msgMap["delALB"]["false"] = "Error while deleting the album. Please try later";

//Installer messages
$msgMap["instSuccess"]["true"] = "Installation successful. Please create an admin user";
$msgMap["instDBTblFailed"]["false"] = "Oops. An error occurred while creating tables. Please check your DB connection";

$msgMap["inDBNE"]["false"] = "Database doesn't exist";
$msgMap["inDBConF"]["false"] = "Invalid database access credentials";
$msgMap["instComplete"]["true"] = "Installation complete. Please click on finish to continue";
$msgMap["credBlank"]["false"] = "One ore more required fields seems to empty";
$msgMap["passMismatch"]["false"] = "Password and confirm password doesn't match";
$msgMap["adminExists"]["false"] = "Username already exists.";
?>