(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
 $("#buttonUpload").on('click', function(event) {
        event.preventDefault();
        $(this).prop("disabled",true);
        if ($("#fileText").val() === "Upload workbook excel file" || $("#fileText").val() === "") {
          Swal.fire({
          title:'Error',
          text:'Please select a excel file to upload',
          icon:'error',
          confirmButtonText:'Try again'
          });   
          $(this).prop("disabled",false);
        }
        else{
          var formData= new FormData(document.getElementById("uploadForm"));
         Swal.fire({
            title: 'In progress...',
            html: 'Please, wait while the workbook is uploading, it could take a couple of minutes ',
            timerProgressBar: true,
            onBeforeOpen: () => {
            Swal.showLoading()
            }
          });
          $.ajax({
            url: '../controller/upload-data.php',
            type: 'POST',
            dataType: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false
          })
          .done(function(data) {
                    $("#buttonUpload").prop("disabled",false);
                    Swal.fire({
                    title:'Success',
                    text:'Your workbook has been uploaded',
                    icon:'success',
                    confirmButtonText:'Done'
                   }); 
          })
          .fail(function() {
            Swal.fire({
              title:'Error',
              text:'Has been failed the upload of the workbook, try it later',
              icon:'error',
              confirmButtonText:'Try again'
             });   
          })
        }
    }); 
  });
})(jQuery);