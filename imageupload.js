jQuery(document).ready(function($) {
	$('#upload_image_button').click(function() {
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	window.send_to_editor = function(html) {
		var imgurl = $('img', html).attr('src');
		$('#term_meta_color_img').val(imgurl);
		tb_remove();
	};
});