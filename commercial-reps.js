jQuery(document).ready(function($) {
    $("#upload-representative-photo").click(function(event) {
        event.preventDefault();
        if(wp.media.frames.photo_frame) {
            wp.media.frames.photo_frame.open();
            return;
        }
        
        wp.media.frames.photo_frame = wp.media({
            title: 'Upload Representative Photo',
            button: {
                text: 'Set Photo',
            },
            multiple: false
        });

        wp.media.frames.photo_frame.on('select', function() {
            var attachment = wp.media.frames.photo_frame.state().get('selection').first().toJSON();
            $("#representative-photo").val(attachment.id);
            $("#representative-thumbnail").attr('src', attachment.url);
        });


        wp.media.frames.photo_frame.open();
    });
});
