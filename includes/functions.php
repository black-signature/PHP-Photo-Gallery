<?php
include "connect.php"; 
function getCoverImg($CID){
    $qry = "SELECT file_name FROM tbl_photos WHERE PID = ".$CID;
    $res = mysql_query($qry);
    $arr = mysql_fetch_array($res);
    
    return $arr["file_name"];
}
?>