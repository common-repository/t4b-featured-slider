<?php
/*
Plugin Name: T4B Featured Slider
Plugin URI: http://wordpress.org/plugins/t4b-featured-slider/
Version: 1.5.1
Description: "T4B Featured Slider" allows you to show featured posts on your blog using a smooth jQuery slider.
Author: moviehour
Author URI: https://profiles.wordpress.org/moviehour/
Text Domain: t4b
*/

define('T4B_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
if(is_admin()) { include ( T4B_PLUGIN_PATH . 't4b_admin.php' ); }
function t4b_admin_enqueue_scripts() {
	wp_register_script('t4b-admin-js', WP_PLUGIN_URL .'/t4b-featured-slider/js/t4b-admin.js', array('jquery'), '1.5.1');
	wp_enqueue_script('t4b-admin-js');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('wp-color-picker');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('t4b-admin-css', WP_PLUGIN_URL .'/t4b-featured-slider/css/t4b-admin.css?v=1.5.1');
}
add_action('admin_init', 't4b_admin_enqueue_scripts');
function t4b_enqueue_scripts() {
	if(get_option('t4b_option')== 'Enabled') {
		wp_enqueue_script('jquery');
		wp_register_script('t4b-front-js', WP_PLUGIN_URL .'/t4b-featured-slider/js/t4b-front.js', array('jquery'), '1.5.1');
		wp_enqueue_script('t4b-front-js');
	}
}
add_action('wp_enqueue_scripts', 't4b_enqueue_scripts');
add_action( 'init', 'featured_post_install', 1 );
add_action( 'switch_blog', 'featured_post_install' );
function featured_post_install() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	global $charset_collate;
    $wpdb->t4b_id_lists = "{$wpdb->prefix}t4b_id_lists";
	$sql_create_table = "CREATE TABLE {$wpdb->t4b_id_lists} (
	          id INT NOT NULL AUTO_INCREMENT,
    	      post_id VARCHAR(200) NOT NULL default '0',
        	  post_title varchar(200) NOT NULL,
	          activity_date datetime NOT NULL default '0000-00-00 00:00:00',
    	      PRIMARY KEY  (id)
	     ) $charset_collate; ";
	dbDelta( $sql_create_table );
}
function t4b_process_featured_post() {
	global $wpdb;
	featured_post_install();
	$table_name = $wpdb->prefix."t4b_id_lists";
	$postid = $_POST['postID'];
	if($postid) {
		if ($_POST['list_id'] == 'Add Post') {
			foreach($postid as $key => $pid) {
				$postdata = get_post($pid, ARRAY_A);
				$post_title = $postdata['post_title'];
				$post_type = $postdata['post_type'];
				if($post_type == 'post') {
					$sql_to_insert = "insert into $table_name(post_id,post_title,activity_date) values('$pid','$post_title',NOW());";
					$wpdb->query($sql_to_insert);
				}
			}
		} elseif ($_POST['edit_list_id'] == 'Update') {
			$sql_to_delete = "DELETE FROM $table_name";
			$wpdb->query($sql_to_delete);
			foreach($postid as $key => $pid) {
				$postdata = get_post($pid, ARRAY_A);
				$post_title = $postdata['post_title'];
				$post_type = $postdata['post_type'];
				if($post_type == 'post') {
					$sql_to_insert = "insert into $table_name(post_id,post_title,activity_date) values('$pid','$post_title',NOW());";
					$wpdb->query($sql_to_insert);
				}
			}
		}
	} else {
		$sql_to_delete = "DELETE FROM $table_name";
		$wpdb->query($sql_to_delete);
	}
}
function get_featured_post_lists() {
	global $wpdb;
	$table_name = $wpdb->prefix."t4b_id_lists"; 
	$sql_to_all = "SELECT * FROM $table_name ORDER BY id ASC";
	$result = $wpdb->get_results($sql_to_all);
	if($result === NULL) { $result = 0; }
	return $result;
}
/* GET THUMBNAIL URL */
function get_featured_image_url(){
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'large');
	$image_url = $image_url[0];
	echo $image_url;
}	
function wpe_excerptlength_feapost($length) {
	$t4b_slider_limit = get_option('limit');
	if(empty($t4b_slider_limit)){$t4b_slider_limit = 350;}
	return $t4b_slider_limit;
}
function wpe_excerptmore_feapost($more) {
	global $post;
	$t4b_slider_rmore = get_option('read_more');
	if(empty($t4b_slider_rmore)){$t4b_slider_rmore = "[...]";}
	return '&nbsp;&nbsp;<a href="'. get_permalink($post->ID) . '">' . $t4b_slider_rmore . '</a>';
}
function t4b_wpe_excerpt($length_feapost='', $more_feapost='') {
    global $post;
    if(function_exists($length_feapost)){add_filter('excerpt_length', $length_feapost);}
    if(function_exists($more_feapost)){add_filter('excerpt_more', $more_feapost);}
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}
function t4bFeaturedPost() {
	$fpID = array();
	$all_lists = get_featured_post_lists();
	foreach($all_lists as $flists) {$fpID[] = $flists->post_id;}
	return $fpID;
}
function show_Featured_Post_Slider() { ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#pslider').bxSlider({
			mode: 'fade',
			controls:false,
			auto:true,
			pager: true
		});
	});
</script>
<?php $t4b_slider_path =  WP_PLUGIN_URL . "/t4b-featured-slider"; ?>
<style>#pslider{width:<?php $t4b_slider_width = get_option('feat_width'); if(!empty($t4b_slider_width)) {echo $t4b_slider_width;} else {echo "640";}?>px;height:<?php $t4b_slider_height = get_option('feat_height'); if(!empty($t4b_slider_height)) {echo $t4b_slider_height;} else {echo "300";}?>px;overflow:hidden;}#pcover{width:<?php $t4b_slider_width = get_option('feat_width'); if(!empty($t4b_slider_width)) {echo $t4b_slider_width;} else {echo "640";}?>px;height:<?php $t4b_slider_height = get_option('feat_height'); if(!empty($t4b_slider_height)) {echo $t4b_slider_height;} else {echo "300";}?>px;margin:<?php $t4b_slider_slider_top = get_option('slider_top'); if(!empty($t4b_slider_slider_top)) {echo $t4b_slider_slider_top;} else {echo "10";}?>px 0 <?php $t4b_slider_slider_bot = get_option('slider_bot'); if(!empty($t4b_slider_slider_bot)) {echo $t4b_slider_slider_bot;} else {echo "20";}?>px 5px ;position: relative; background:<?php $t4b_slider_bg = get_option('feat_bg'); if(!empty($t4b_slider_bg)) {echo $t4b_slider_bg;} else {echo "#364D55";}?> url(<?php echo $t4b_slider_path; ?>/images/featured.png) 55px 0 no-repeat;}.mytext{position:relative;margin:20px 0px 0px 0px;width:<?php $t4b_slider_width = get_option('feat_width'); if(!empty($t4b_slider_width)) {echo $t4b_slider_width - 10;} else {echo "630";}?>px;height:<?php $t4b_slider_height = get_option('feat_height'); if(!empty($t4b_slider_height)) {echo $t4b_slider_height - 40;} else {echo "260";}?>px;display:inline;float:left;}.slimg{float:left;margin:<?php $t4b_slider_image_top = get_option('image_top'); if(!empty($t4b_slider_image_top)) {echo $t4b_slider_image_top;} else {echo "25";}?>px 20px 10px 20px;width: <?php $t4b_slider_img_width = get_option('img_width'); if(!empty($t4b_slider_img_width)) {echo $t4b_slider_img_width;} else {echo "180";}?>px;height: <?php $t4b_slider_img_height = get_option('img_height'); if(!empty($t4b_slider_img_height)) {echo $t4b_slider_img_height;} else {echo "180";}?>px;padding:5px;background:<?php $t4b_slider_img_bg = get_option('img_bg'); if(!empty($t4b_slider_img_bg)) {echo $t4b_slider_img_bg;} else {echo "#4C666C";}?>;}.mytext-right{width:<?php $t4b_slider_cont_width = get_option('cont_width'); if(!empty($t4b_slider_cont_width)) {echo $t4b_slider_cont_width;} else {echo "395";}?>px;float:right;}.mytext-right h2{padding:10px 0 0;color:<?php $t4b_slider_title_color = get_option('title_color'); if(!empty($t4b_slider_title_color)) {echo $t4b_slider_title_color;} else {echo "#FAFAFA";}?>;font-size: 18px ;font-weight:bold;text-decoration:none;line-height: 25px}.mytext-right h2 a:link,.mytext-right h2 a:visited{color:<?php $t4b_slider_title_visited = get_option('title_visited'); if(!empty($t4b_slider_title_visited)) {echo $t4b_slider_title_visited;} else {echo "#F4F4F2";}?>;text-decoration:none;}.mytext-right a {color:<?php $t4b_slider_link_color = get_option('link_color'); if(!empty($t4b_slider_link_color)) {echo $t4b_slider_link_color;} else {echo "#5E98BA";}?>;text-decoration:none;outline:none;}.mytext-right a:hover {color:<?php $t4b_slider_link_hover = get_option('link_hover'); if(!empty($t4b_slider_link_hover)) {echo $t4b_slider_link_hover;} else {echo "#F4F4F2";}?>;text-decoration:none;}.mytext-right p{padding:10px 5px 0px 0px;color:<?php $t4b_slider_text_color = get_option('text_color'); if(!empty($t4b_slider_text_color)) {echo $t4b_slider_text_color;} else {echo "#aaa";}?>;font-size: 14px;line-height:20px;}.mytext-right span{padding:5px;background:<?php $t4b_slider_pinfo_color = get_option('pinfo_color'); if(!empty($t4b_slider_pinfo_color)) {echo $t4b_slider_pinfo_color;} else {echo "#4C666C";}?>;color:<?php $t4b_slider_pintxt_color = get_option('pintxt_color'); if(!empty($t4b_slider_pintxt_color)) {echo $t4b_slider_pintxt_color;} else {echo "#FAFAFA";}?>;font-size: 12px}.bx-wrapper{width:<?php $t4b_slider_width = get_option('feat_width'); if(!empty($t4b_slider_width)) {echo $t4b_slider_width;} else {echo "640";}?>px!important;}.bx-window{height:<?php $t4b_slider_height = get_option('feat_height'); if(!empty($t4b_slider_height)) {echo $t4b_slider_height;} else {echo "300";}?>px!important;width:<?php $t4b_slider_width = get_option('feat_width'); if(!empty($t4b_slider_width)) {echo $t4b_slider_width;} else {echo "640";}?>px!important;}.bx-pager{position:absolute;padding:5px 10px 5px 5px;bottom:10px;right:10px;z-index:1000;}a.pager-link{width:12px;height:12px;display:block;text-indent:-9000px;background:url(<?php echo $t4b_slider_path; ?>/images/cog.png);float:right;margin-left:5px;}a.pager-active{width:12px;height:12px;display:block;text-indent:-9000px;background:url(<?php echo $t4b_slider_path; ?>/images/coga.png);float:right;margin-left:5px;}</style><?php
	$t4b_slider_sort = get_option('sort'); if(empty($t4b_slider_sort)){$t4b_slider_sort = "post_date";}
	$t4b_slider_order = get_option('order'); if(empty($t4b_slider_order)){$t4b_slider_order = "DESC";}

	$stickies = t4bFeaturedPost();
	rsort( $stickies );
	$args = array( 'post__in' => $stickies, 'ignore_sticky_posts' => 1, 'orderby' => $t4b_slider_sort, 'order' => $t4b_slider_order);
	$featured = new WP_Query( $args );
		
	if ($featured->have_posts()): ?>
		<div id="pcover">
		<div id="pslider">
		<?php while( $featured->have_posts() ) : $featured->the_post(); ?>
			<div class="mytext">
				<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink() ?>"><img class="slimg" src="<?php get_featured_image_url(); ?>" alt="" /></a>
				<?php } else { ?>
					<a href="<?php the_permalink() ?>">
						<img class="slimg" src="<?php bloginfo('template_directory'); ?>/images/dummy.png" alt="" />
					</a>
				<?php } ?>
				<div class="mytext-right">
                   	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                   	<span>By&nbsp;&nbsp;&nbsp;<?php the_author_posts_link(); ?>&nbsp;&nbsp;&nbsp;On&nbsp;&nbsp;&nbsp;<?php the_time('M j, Y'); ?>&nbsp;&nbsp;&nbsp;<?php comments_popup_link('0 Comment', '1 Comment', '% Comments'); ?></span>
					<?php t4b_wpe_excerpt('wpe_excerptlength_feapost', 'wpe_excerptmore_feapost'); ?>
				</div>
			</div>   	
	    <?php endwhile; wp_reset_query(); ?>
		</div>
		</div><?php
	endif;
}
?>