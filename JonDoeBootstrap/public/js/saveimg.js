var idProduct;

$(".picture").click(function () {
    idProduct=$(this).attr("id").split("_")[1];
    $("#image").attr("src", $(this).attr("src"));
    $("#pictureModal").foundation("open");
    defineCropper();
  
    return false;
  });
  
  
  $("#save").click(function () {
    var size = { width: 350, height: 350 };
    var result = $image.cropper("getCroppedCanvas", size, size);
  
    $.ajax({
        type: "POST",
        url:  "/products/savepicture",
        data: "id=" + idProduct + "&picture=" + result.toDataURL(),
        success: function(backServer){
          if(backServer==="OK"){
            $("#p_"+idProduct).attr("src",result.toDataURL());
            $("#photoModal").foundation("close");
          }else{
            alert(backServer);
          }
        }
      });
  
    return false;
  });
  
 
  var $image;
  
  function defineCropper() {
    var URL = window.URL || window.webkitURL;
    $image = $("#image");
    var options = { aspectRatio: 1 / 1 };
  
    
    $image.on({}).cropper(options);
  
    var uploadedImageURL;
  
   
    var $inputImage = $("#inputImage");
  
    if (URL) {
      $inputImage.change(function () {
        var files = this.files;
        var file;
  
        if (!$image.data("cropper")) {
          return;
        }
  
        if (files && files.length) {
          file = files[0];
  
          if (/^image\/\w+$/.test(file.type)) {

            if (uploadedImageURL) {
              URL.revokeObjectURL(uploadedImageURL);

            }
  
            uploadedImageURL = URL.createObjectURL(file);
            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
            $inputImage.val('');
          } else {
            window.alert("Wrong format");
          }
        }
      });
    } else {
      $inputImage.prop("disabled", true).parent().addClass("disabled");
    }
  }