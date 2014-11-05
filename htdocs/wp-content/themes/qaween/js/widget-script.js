jQuery(document).ready( function($){
	function media_upload( button_class) {
	    var _custom_media = true,
	    _orig_send_attachment = wp.media.editor.send.attachment;
	    $('body').on('click',button_class, function(e) {
	        var button_id ='#'+$(this).attr('id');
	        var self = $(button_id);
	        var send_attachment_bkp = wp.media.editor.send.attachment;
	        var button = $(button_id);
	        var id = button.attr('id').replace('_button_upload', '');
	        _custom_media = true;
	        wp.media.editor.send.attachment = function(props, attachment){
	            if ( _custom_media  ) {
	               $('#'+id).val(attachment.url);
	               $('#'+id+'_preview').attr('src',attachment.url).show();   
	               $('#'+id+'_button_remove').css('display','inline-block');   
	            } else {
	                return _orig_send_attachment.apply( button_id, [props, attachment] );
	            }
	        }
	        wp.media.editor.open(button);
	        return false;
	    });
	}
	media_upload( '.widget_media_upload');

	function media_remove( button_class) {
	    $('body').on('click',button_class, function(e) {
	        var button_id ='#'+$(this).attr('id');
	        var button = $(button_id);
	        var id = button.attr('id').replace('_button_remove', '');
		    $(this).hide();  
		    $('#'+id+'_preview').attr('src','').hide();   
		    $('#'+id).val('');
	        return false;
	    });

	}
	media_remove( '.widget_media_remove');
});