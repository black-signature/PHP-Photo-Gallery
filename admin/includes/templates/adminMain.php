<?php 
/**
 * PHP Gallery Admin Main : Template
 *
 * PHP Gallery admin header template which holds the main template fragment.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Template
 * @author     Balu John Thomas <balujohnthomas@gmail.com>
 * @license    GPL
 * @version    1.0.0
 **/
 
if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
    die('<h1>Direct access is not permitted</h1>');
}

$qry = "SELECT * FROM tbl_gallery ORDER BY AID DESC";
$res = mysql_query($qry);
?>

<?php 
if(!isset($_GET["act"]) && !$_GET["act"] == "edit"){
?>
<div class="container" id="main_container">
    <div class="text-right"><a href="logout.php">Logout</a></div>
    <div class="row gallery-actions">
        <div class="col-md-2"><button id="create_gallery" type="submit" class="btn btn-success">Create New Album</button></div>
        <?php 
        if(mysql_num_rows($res) > 0){
        ?>
        <div class="col-md-4">
            Upload Photos into 
            <select id="gallery_chooser" class="gallery-chooser">
                <option value="null">-- Select Album --</option>
                <?php 
                while($arrOpt = mysql_fetch_array($res)){
                ?>
                    <option data-album-name="<?php echo $arrOpt["album_name"]; ?>" value="<?php echo $arrOpt["AID"]; ?>"><?php echo $arrOpt["album_name"]; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <?php
        }
        ?>
    </div>
    
    <?php 
    if( isset($_GET["s"]) ){
        if($_GET["s"] == "true"){
            ?>
                <p class="bg-success msg-area"><?php echo $msgMap[ $_GET["t"] ][ $_GET["s"] ]; ?></p>
            <?php
        }
        else{
            ?>
                <p class="bg-danger msg-area"><?php echo $msgMap[ $_GET["t"] ][ $_GET["s"] ]; ?></p>
            <?php
        }
    }
    ?>
    
    <div class="row create-album-form hide" id="create_album_form">
        <div class="col-md-12">
            <form class="form-inline" action="API/galleryFormActions.php" method="POST">
              <div class="form-group">
                <input type="text" class="form-control" name="album_name" id="album_name" placeholder="Enter album name" />
                <input type="hidden" name="form_param" value="create_album" />
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
    
    <div class="row upload-photo-form hide" id="photo_uploader">
        <div class="col-md-12">
            <form class="form-inline" enctype="multipart/form-data" onsubmit="return false;">
              <div class="form-group">
                <input type="file" class="form-control" name="photo[]" id="photo" multiple />
                <input type="hidden" name="form_param" value="upload_photos" />
                <input type="hidden" id="album_id" name="album_id" value="" />
                <input type="hidden" id="album_name" name="album_name" value="" />
              </div>
              <button id="upload_pics" type="submit" class="btn btn-primary">Upload</button>
              
              <div id="uploadProgress" class="upload-progress hide">Uploading <span id="currentImg"></span> of <span id="totalImg"></span></div>
            </form>
        </div>
    </div>
    <?php 
    $res = mysql_query($qry);
    if(mysql_num_rows($res) > 0){
    ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Album Name</th>
          <th>Date Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
            $count = 0;
            while($arr = mysql_fetch_array($res)){
            $count++;
            ?>
                <tr>
                  <th scope="row"><?php echo $count; ?></th>
                  <td><?php echo $arr["album_name"]; ?></td>
                  <td><?php echo $arr["creation_date"]; ?></td>
                  <td>
                      <a class="edit-album" href="index.php?act=edit&albID=<?php echo $arr["AID"]; ?>&albName=<?php echo $arr["album_name"]; ?>">Edit</a> | 
                      <a class="delete-album" href="API/galleryFormActions.php?form_param=delAlbum&act=del&albID=<?php echo $arr["AID"]; ?>&albName=<?php echo $arr["album_name"]; ?>">Delete</a>
                  </td>
                </tr>
            <?php
            }
        ?>
      </tbody>
    </table>
    <?php
    }
    else{
    ?>
        <div>No albums created!</div>
    <?php
    }
    ?>
</div>
<?php 
}
else if(isset($_GET["act"]) && $_GET["act"] == "edit"){
    $albID = $_GET["albID"];
    $albName = $_GET["albName"];
    $qry = "SELECT * FROM tbl_photos WHERE AID=".$albID;
    $res = mysql_query($qry);
    if(mysql_num_rows($res) > 0){
    ?>
        <div id="album_view_container" class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 id="album_name_title_1"><?php echo $albName; ?></h3>
                </div>
                <div class="col-md-10 text-right">
                    <a href="index.php">Back to Home</a>
                </div>
            </div>
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Thumbnail</th>
                  <th>Uploaded Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $count = 0;
                while($arr = mysql_fetch_array($res)){
                $count++;
                ?>
                <tr>
                  <th scope="row">
                    <?php echo $count; ?>
                  </th>
                  <td><img src="../UPLOADS/<?php echo $albName."/".$arr["file_name"] ?>" width="50" /></td>
                  <td><?php echo $arr["upload_date"]; ?></td>
                  <td>
                    <?php 
                    if($arr["cover_status"] != 1){
                        ?>
                        <a href="API/galleryFormActions.php?form_param=setCover&imgID=<?php echo $arr["PID"]; ?>&albID=<?php echo $arr["AID"]; ?>&albName=<?php echo $albName;?>">Set as Cover</a> |
                        <a href="API/galleryFormActions.php?form_param=delPic&imgID=<?php echo $arr["PID"]; ?>&albID=<?php echo $arr["AID"]; ?>&albName=<?php echo $albName;?>">Delete</a>
                        <?php
                    }
                    else{
                        echo "(<em>Cover Image</em>)";
                    }
                    ?>
                  </td>
                </tr>
                <?php 
                }
                ?>
              </tbody>
            </table>
        </div>
    <?php
    }
    else{
        ?>
        <div class="container">
            <div> No photos found! <a href="index.php">Back to Home</a></div>
        </div>
        <?php
    }
}
?>