(function( $ ) {
    'use strict';

    $(document).on('click', '.delete-slideshow-image', function(){
        $(this).parent().remove();
        $('#slideshow-images').trigger('change');
    });

    $('#slideshow-title').on('keyup', function(){
        var title = $(this).val();
        var slug = title.trim().replace(/[^a-z0-9]+/gi, '-').toLowerCase();
        $('#slideshow-slug').val(slug);
    });

    $('#slideshow-images').on('change', function(){
        var img_array = [];
        $('.slideshow-images').find('.image-wrapper').each(function(i, image){
            var id = $(this).attr('data-id');
            img_array.push(id);
        });
        var images = img_array.join(',');
        $('#slideshow-images').val(images);
    });

    $( ".slideshow-images" ).sortable({
        containment: "parent",
        update: function(event, ui) {
            $('#slideshow-images').trigger('change');
        }
    });

    function renderMediaUploader() {
        'use strict';
     
        var file_frame, image_data;
     
        /**
         * If an instance of file_frame already exists, then we can open it
         * rather than creating a new instance.
         */
        if ( undefined !== file_frame ) {
     
            file_frame.open();
            return;
     
        }
     
        /**
         * If we're this far, then an instance does not exist, so we need to
         * create our own.
         *
         * Here, use the wp.media library to define the settings of the Media
         * Uploader. We're opting to use the 'post' frame which is a template
         * defined in WordPress core and are initializing the file frame
         * with the 'insert' state.
         *
         * We're also not allowing the user to select more than one image.
         */
        file_frame = wp.media.frames.file_frame = wp.media({
            frame:    'post',
            state:    'insert',
            multiple: false
        });
     
        /**
         * Setup an event handler for what to do when an image has been
         * selected.
         *
         * Since we're using the 'view' state when initializing
         * the file_frame, we need to make sure that the handler is attached
         * to the insert event.
         */
        file_frame.on( 'insert', function() {
     
            var json = file_frame.state().get( 'selection' ).first().toJSON();

            var html = '<div class="image-wrapper" data-id="'+json.id+'"> \
                <img src="'+json.url+'" alt="image"/>\
                <span class="dashicons dashicons-no-alt delete-slideshow-image"></span>\
            </div>';

            var images = $('#slideshow-images').val();
            var images_array = images.split(',');
            images_array.push(json.id);

            var images_array = images_array.filter(function(v){return v!==''});

            if(images_array.length > 1) {
                var images = images_array.join(',');
            } else {
                images = json.id;
            }
            $('#slideshow-images').val(images);

            $('.slideshow-images').append(html);

            $('#add-slideshow-images').val('Insert more image');

        });
     
        // Now display the actual file_frame
        file_frame.open();
     
    }
 

    $( '#add-slideshow-images' ).on( 'click', function( evt ) {

        // Stop the anchor's default behavior
        evt.preventDefault();

        // Display the media uploader
        renderMediaUploader();

    });
 
})( jQuery );