<?php 
$conn = mysql_connect("localhost","root","");
if(!$conn){
    die("<h1>Could not establish a database connection</h1>");
}
else{
    mysql_select_db("db_gallery");
}
?>