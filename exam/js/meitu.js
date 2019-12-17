$(function () {
    var old_avatar  = "http://open.web.meitu.com/sources/images/1.jpg";
    var avatar      = $('.my_head img').attr('value');
    var avatar_url = "http://studyit.club/itclub/images/"+avatar;
    if(!avatar_url){
        avatar_url = old_avatar;
    }
    xiuxiu.embedSWF("altContent",5,"100%","100%");
    xiuxiu.setUploadURL("http://studyit.club/itclub/imageUploadForm.php");
    xiuxiu.setUploadType(2);
    xiuxiu.setUploadDataFieldName("Filedata");
    xiuxiu.onInit = function ()
    {
        xiuxiu.loadPhoto(avatar_url);
    };
    xiuxiu.onUploadResponse = function (data)
    {
        layer.msg('上传成功',{time:2000});
        window.location.reload();
    }
});

