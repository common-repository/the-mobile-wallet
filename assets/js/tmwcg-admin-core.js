jQuery(document).ready(function($) {
    // Media Uploader
    $('#upload_logo_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#logo').val(image_url);
				$('#logo_preview').attr('src', image_url);
            });
    });

	$('#upload_style_file_button').click(function(e) {
        e.preventDefault();
        var image_style_file = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e) {
                var uploaded_image_style_file = image_style_file.state().get('selection').first();
                var image_url_style_file = uploaded_image_style_file.toJSON().url;
                $('#style_file').val(image_url_style_file);
				$('#style_file_preview').attr('src', image_url_style_file);
            });
    });

	$('.remove-image-button').click(function() {
        var targetInput = $(this).data('target');
        var previewImage = $(this).data('preview');
        
        // Clear input value
        $(targetInput).val('');
        
        // Reset preview image source
        $(previewImage).attr('src', tmwcg.tmwcg_plugin_url+'assets/img/placeholder.png');
		$(this).remove();
    });

    // Color Picker
    $('.color-field').wpColorPicker();


	function toggleBackgroundColorRow() {
        var cardStyle = $('#card_style').val();
        if (cardStyle === 'banner') {
            $('#background_color_row').show();
        } else {
            $('#background_color_row').hide();
        }
    }

    // Initial toggle based on the selected value
    toggleBackgroundColorRow();

    // Change event handler for the card style dropdown
    $('#card_style').change(function() {
        toggleBackgroundColorRow();
    });

});