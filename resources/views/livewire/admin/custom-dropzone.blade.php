<div wire:ignore>
<div class="form-body">
    <div class="form-group">
        <div id="dpz-multiple-files" class="dropzone dropzone-area">
        </div>
    </div>
</div>

@csrf

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
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },

        url: "{{ route('save_img.custom') }}", // Set the url
        success: function(file, response) {
            $('form').append('<input type="hidden"   name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
            Livewire.dispatch('add_doc' , [response.name] )
        },
        sending: function(file, xhr, data) {
        // Append your data to the AJAX request
            data.append('file_name','{{$folder}}'); // Replace 'key' and 'value' with your actual key-value pair
        },
        removedfile: function(file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            Livewire.dispatch('del_doc' , [name] )
        },
        // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
        init: function() {
            @if (isset($event) && $event->document)
                var files =
                    {!! json_encode($event->document) !!}
                for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                }
            @endif
        }
    }

</script>

</div>
