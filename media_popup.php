<script type="text/javascript">


/****************
NOTES
----------
This a script that allows you to open the wordpress media mediaUploader
to select images and insert them in custom meta BOXES
*****************/


  jQuery(document).ready(function(jQuery){

  var mediaUploader;

  jQuery('#img_select').on('click', function(e) {

    var locat = this;

    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();

      jQuery("#image_url").val(attachment.url);

    });
    // Open the uploader dialog
    mediaUploader.open();
  });


  //alert("Heasrctyvxubin");


});



</script>