jQuery(document).ready(function() {
	jQuery("#t4b_new_post").css("display","none");
	jQuery("#t4b_edit_post").css("display","none");
	jQuery("#new_table").click(function() {
		jQuery("#t4b_new_post").slideDown("slow");
		jQuery("#new_table").hide();
		jQuery("#edit_table").hide();
		jQuery('#sidebar').hide();
		jQuery("#add_new_table h2").text("Add Featured Posts");
		jQuery(".table_list").css("display","none");
	});
	jQuery("#edit_table").click(function() {
		jQuery("#t4b_edit_post").slideDown("slow");
		jQuery("#new_table").hide();
		jQuery("#edit_table").hide();
		jQuery('#sidebar').hide();
		jQuery("#add_new_table h2").text("Edit Featured Posts");
		jQuery(".table_list").css("display","none");
	});
	jQuery('#t4b-loading-image').bind('ajaxStart', function(){
		jQuery(this).css("display","inline-block");
	}).bind('ajaxComplete', function(){
		jQuery(this).css("display","none");
	});

	var featureName = jQuery('#feature_additem');
	jQuery('#addpost').live('click', function() {
		jQuery('<tr class="featurebody"><td><input type="text" name="postID[]" value="" placeholder="Enter post ID" required /></td><td><span id="remFeatute"></span></td></tr>').appendTo(featureName);
		jQuery('#remDisable').attr('id', 'remFeatute');
		return false;
	});
	jQuery('#remFeatute').live('click', function() {
		var num = jQuery('#feature_additem tr.featurebody').length;
		if (num - 1 === 1)
			jQuery('#remFeatute').attr('id', 'remDisable');
		jQuery(this).parents('tr.featurebody').remove();
		return false;
	});

	var featureeditName = jQuery('#feature_edititem');
	jQuery('#editpost').live('click', function() {
		jQuery('<tr class="featurebody"><td><input type="text" name="postID[]" value="" placeholder="Enter post ID" size="10" required /></td><td>&nbsp;</td><td><span id="remFeatute"></span></td></tr>').appendTo(featureeditName);
		return false;
	});
	jQuery(function() {
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				jQuery(this).width(jQuery(this).width());
			});
			return ui;
		};
		jQuery('#feature_edititem tbody').sortable({
			helper: fixHelper
		}).disableSelection();
	});
	jQuery('.feat_bg').wpColorPicker();
	jQuery('.img_bg').wpColorPicker();
	jQuery('.title_color').wpColorPicker();
	jQuery('.title_visited').wpColorPicker();
	jQuery('.text_color').wpColorPicker();
	jQuery('.link_color').wpColorPicker();
	jQuery('.link_hover').wpColorPicker();
	jQuery('.pinfo_color').wpColorPicker();
	jQuery('.pintxt_color').wpColorPicker();
});