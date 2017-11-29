jQuery(document).ready(function ($) {
    let mediaUploader;
    $('#upload-button').on('click', function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Choose a Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });
        mediaUploader.open();

        mediaUploader.on('select', function () {
            let attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#profile-picture').val(attachment.url);
            $('.profile-picture img').attr('src', attachment.url);
        });


    });

    $('#remove-picture').on('click', function (e) {
        e.preventDefault();
        let answer = confirm('Are you sure you want to remove your Profile Picture?');

        if (answer) {
            $('#profile-picture').val('');
            $('.sunset-general-form').submit();
        }
    });
});