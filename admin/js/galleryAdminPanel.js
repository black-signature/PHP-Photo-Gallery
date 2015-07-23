var AdminPanel = (function(){
    var eventListeners = function(){
        $("#create_gallery").bind("click", function(){
            $(".msg-area").hide();
            
            $("#photo_uploader").addClass("hide");
            $("#gallery_chooser").val("null");
            if($("#create_album_form").hasClass("hide")){
                $("#create_album_form").removeClass("hide");
            }
            else{
                $("#create_album_form").addClass("hide");
            }
        });
        
        $("#gallery_chooser").bind("change", function(){
            if($(this).val() !== "null" ){
                showUploader($(this).val(), $("#gallery_chooser option:selected").data("album-name"));
            }
            else{
                $("#photo_uploader").addClass("hide");
            }
        });
        
        $("#upload_pics").bind("click", function(){
            var allImg = $("#photo")[0].files, imgCount = allImg.length, albumID = $("#album_id").val(), albumName = $("#album_name").val(), totalFilesUploaded = 0;
            
            var uploadSuccess = function(res){
                if(res == "success"){
                    $("#currentImg").html(totalFilesUploaded);
                    
                    if(totalFilesUploaded < imgCount){
                        var fd = new FormData();
                        fd.append( 'imgFile', allImg[totalFilesUploaded] );
                        fd.append( 'album_id', albumID );
                        fd.append( 'album_name', albumName );
                        fd.append( 'form_param', "upload_photo" );
                        
                        request("API/galleryFormActions.php", uploadSuccess, uploadError, fd);
                        totalFilesUploaded++;
                    }
                    else{
                        $("#uploadProgress").addClass("hide");
                        $("#photo_uploader form")[0].reset();
                    }
                }
            };
            
            var uploadError = function(res){
                console.log(res);
            };
            
            if(imgCount > 0){
                var fd = new FormData();
                fd.append( 'imgFile', allImg[totalFilesUploaded] );
                fd.append( 'album_id', albumID );
                fd.append( 'album_name', albumName );
                fd.append( 'form_param', "upload_photo" );
                
                $("#uploadProgress").removeClass("hide");
                $("#currentImg").html("1");
                $("#totalImg").html(imgCount);
                
                request("API/galleryFormActions.php", uploadSuccess, uploadError, fd);
                totalFilesUploaded++;
            }
        });
        
        $(".delete-album").bind("click", function(){
            if(!confirm("Are you sure, you want to delete the entire album along with its pictures?")){
                return false;
            }
        });
    };
    
    var showUploader = function(albumID, albumName){
        $(".msg-area").hide();
        $("#create_album_form").addClass("hide");
        $("#photo_uploader").removeClass("hide");
        $("#photo_uploader form")[0].reset()
        
        $("#album_id").val(albumID);
        $("#album_name").val(albumName);
        //$("#album_name_head").html(albumName);
    };
    
    var request = function(url, successCallBack, errorCallBack, cData){
        $.ajax({
            url         : url,
            data        : cData,
            type        : "POST",
            processData : false,
            contentType : false,
            success     : successCallBack,
            error       : errorCallBack
        });
    };
    
    return {
        init : function(){
            eventListeners();
        }
    };
    
})();

$(document).ready(function(){
    AdminPanel.init();
});