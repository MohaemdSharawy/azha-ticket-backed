
       
    
        <div class="form-body">
            <div class="form-group">
                <div id="dpz-multiple-files" class="dropzone dropzone-area">
                </div>
            </div>
        </div>

    <?php echo csrf_field(); ?>

<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,
       maxFilesize: 10, // MB
       clickable: true,
       addRemoveLinks: true,
       acceptedFiles: 'image/*, .pdf, .docx',
       dictFallbackMessage: " There Is Problem in YOur Browser",
       dictInvalidFileType: " This Type Not Supported",
       dictCancelUpload: "Cancel uploading ",
       dictCancelUploadConfirmation: "Are You sure You Want Upload This Files ",
       dictRemoveFile: "Delete File",
       dictMaxFilesExceeded: "You Upload Maximume Allowed Files ",
       headers: {
           'X-CSRF-TOKEN':
               "<?php echo e(csrf_token()); ?>"
       }
       ,
       url: "<?php echo e(route('save_img')); ?>", // Set the url
       success:
           function (file, response) {
               $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
               uploadedDocumentMap[file.name] = response.name
           }
       ,
       removedfile: function (file) {
           file.previewElement.remove()
           var name = ''
           if (typeof file.file_name !== 'undefined') {
               name = file.file_name
           } else {
               name = uploadedDocumentMap[file.name]
           }
           $('form').find('input[name="document[]"][value="' + name + '"]').remove()
       }
       ,
       // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
       init: function () {
               <?php if(isset($event) && $event->document): ?>
           var files =
           <?php echo json_encode($event->document); ?>

               for (var i in files) {
               var file = files[i]
               this.options.addedfile.call(this, file)
               file.previewElement.classList.add('dz-complete')
               $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
           }
           <?php endif; ?>
       }
   }
</script>
<?php /**PATH /home/sunrise/public_html/tickets/resources/views/layouts/dropzone.blade.php ENDPATH**/ ?>