<?php
function t4b_sidebar() {
	featured_post_install();
	$msg = '** Enter URL of a post to get ID **';
	$t4b_records = '';
	if(isset($_POST['get_id']) && $_POST['get_id'] == 'Get ID') {
		$url = $_POST['post_link'];
		$postid = url_to_postid( $url );
		$title = get_the_title(url_to_postid($url));
		$postdata = get_post($postid, ARRAY_A);
		$authorID = $postdata['post_author'];
		$user_info = get_userdata($authorID);
		$author_name = $user_info->user_login;
		if($postid) {
			$msg = '<b>Post URL:</b> <a href="'.$url.'" target="_blank">'.$url.'</a><br />
					<b>Post ID:</b> '.$postid.'<br />
					<b>Post Title:</b> '.$title.'<br />
					<b>Post Author:</b> '.$author_name.'<br />';
		} else {	$msg = '<font color="red">Invalid URL!</font>'; }
	}
	if(isset( $_POST['remove_op']) && $_POST['remove_op'] == 'Remove' ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 't4b_id_lists';
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);
		$t4b_table_options = array( 't4b_option', 'sort', 'order', 'feat_width', 'feat_height', 'cont_width', 'img_width', 'img_height', 'feat_bg', 'img_bg', 'title_color', 'title_visited', 'text_color', 'link_color', 'link_hover', 'pinfo_color', 'pintxt_color', 'slider_top', 'slider_bot', 'slider_left', 'image_top', 'read_more', 'limit' );
		foreach($t4b_table_options as $options) {
			delete_option($options);
		}
		$t4b_records = 'You have successfully deleted all the records of the plugin from your WP database.';
	} ?>
	<div class="postbox-container" style="width:25%">
		<div id="t4bsidebar">
			<div id="t4busage-features" class="t4busage-sidebar">
			<form method="post" id="remove_op" enctype="multipart/form-data">
				<input type="hidden" name="get_post_id" value="urltoid" />
				<div class="inside">
					<p style="font-size:16px;text-align:justify">We will not update this plugin anymore! We have released another slider plugin named as <a href="https://wordpress.org/plugins/elegant-responsive-content-slider/" target="_blank"><strong>Elegant Responsive Content Slider</strong></a> with lot more functionalities. The plugin is fully <strong>Responsive</strong> and beside the box view, you can display the slider in <strong>Full Screen</strong> mode too. We will request to all to delete this plugin and install our new slider plugin. Please, click on Remove button to delete all the options of this plugin before deleting:</p>
					<table class="form-table">
						<tr valign="top">
							<td><input type="submit" name="remove_op" class="button-primary" value="Remove"></td>
						</tr>
						<tr valign="top"><td colspan="3"><?php echo $t4b_records; ?></td></tr>
					</table>
				</div>
			</form>
			</div>
			<div id="t4busage-features" class="t4busage-sidebar">
			<form method="post" id="get_ID" enctype="multipart/form-data">
				<input type="hidden" name="get_post_id" value="urltoid" />
				<h3>Get the ID</h3>
				<div class="inside">
					<p>To get the ID of a post simply enter the URL of the post and click on Get ID button:</p>
					<table class="form-table">
						<tr valign="top">
							<td>URL:</td>
							<td><input type="text" name="post_link" value="" size="10" /></td>
							<td><input type="submit" name="get_id" class="button-primary" value="Get ID"></td>
						</tr>
						<tr valign="top"><td colspan="3"><?php echo $msg; ?></td></tr>
					</table>
				</div>
			</form>
			</div>
			<div id="t4busage-info" class="t4busage-sidebar">
				<h3>Plugin Info</h3>
				<ul class="t4busage-list">
					<li>Version: 1.5.1</li>
					<li>Scripts: PHP + JS + CSS</li>
					<li>Requires: Wordpress 3.5+</li>
					<li>First release: 29 August 2013</li>
					<li>Developed by: <a href="https://www.realwebcare.com" target="_blank">Realwebcare</a></li>
					<li>Facebook page: <a href="http://facebook.com/realwebcare" target="_blank">realwebcare</a></li>
					<li>Published under: <a href="http://www.gnu.org/licenses/gpl.txt" target="_blank">GNU General Public License</a></li>
				</ul>
			</div>
		</div>
	</div>
<?php } ?>