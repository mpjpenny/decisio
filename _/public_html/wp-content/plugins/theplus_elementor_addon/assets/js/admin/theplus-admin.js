(function ($) {
	"use strict";
	$(document).ready(function() {
		//ajax get acf field on post id
		if($("#tp_preview_post_input").length){
			$("#tp_preview_post_input").focusout(function(){			
			var tp_render_mode = $('[name="tp_render_mode_type"]').val();
            if(tp_render_mode != 'acf_repeater'){
                return;
            }
            var post_id = $("#tp_preview_post").val();
            jQuery.ajax({
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'plus_acf_repeater_field',
                    post_id: post_id,
					security: theplus_nonce,
                },
                success: function (res) {
				
                    jQuery("#tp_acf_field_name").find('option').remove().end();
                    if(res.data.length){
                        jQuery.each(res.data, function(i, d) {
                            jQuery("#tp_acf_field_name").append(jQuery("<option/>", {
                                value: d.meta_id,
                                text: d.text
                            }));
                        });
                    }
                }
            });
			});
		}
	});
})(window.jQuery);