<?php 
session_start();
/**
 * PHP Gallery login check 
 *
 * PHP Gallery login check for admin, which is common for the whole application.
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
 
if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
    die('<h1>Direct access is not permitted</h1>');
}

if( !isset($_SESSION["signed_in"]) || $_SESSION["signed_in"] != true){
    header("Location: login.php");
}
?>