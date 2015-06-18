;(function(global,$){

    $(document).ready(function() {
        $('.direct-upload').each( function() {

            var $form = $(this);

            $(this).fileupload({
                url: $form.attr('action'),
                type: 'POST',
                autoUpload: true,
                dataType: 'xml',
                add: function (event, data) {

                    // Use XHR, fallback to iframe
                    options = $(this).fileupload('option');
                    use_xhr = !options.forceIframeTransport &&
                                ((!options.multipart && $.support.xhrFileUpload) ||
                                $.support.xhrFormDataFileUpload);

                    if (!use_xhr) {
                        using_iframe_transport = true;
                    }

                    // Submit
                    data.submit();
                },
                send: function(e, data) {
                    $('.progress').fadeIn();

                },
                progressall: function(e, data){
                    $('.js-message').html("<span class='in-progress'>Upload in progress...</span>");
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.progress .bar').css(
                        'width', progress + '%'
                    );
                    $('.js-message').append(progress+'% Complete');
                },
                fail: function(e, data) {
                    window.onbeforeunload = null;
                    $('.js-message').html("File upload error!");
                    $('.progress .bar').css(
                        'background-color','red'
                    );
                },
                success: function(data) {
                    var fieldId = $form.attr('data-field-id'),
                        // Root->PostResponse->Location
                        fileLocation = $(data).find('Location').text();

                    $('#' + fieldId).val(fileLocation);
                },
                done: function (event, data) {
                    $('.progress').fadeOut(300, function() {
                        $('.bar').css('width', 0);
                    });
                    $('.in-progress').html("");
                    $('.js-message').html("The following files were uploaded successfully:");
                    var fileNames = data.originalFiles;
                    for (var i=0; i<fileNames.length; i++){
                        $('.js-message').append("<li>"+ fileNames[i].name + "</li>");
                    }
                }
            });
        });
    });

})(window,jQuery);

