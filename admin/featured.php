<?php
	$all_lists = get_featured_post_lists();
	$flists = '';
?>
<div class="wrap">
	<div id="t4b-slider-container" class="postbox-container" style="width:75%;">
	<h2>T4B Featured Post <?php if(count($all_lists) > 0) { ?><a href="#" id="edit_table" class="add-new-h2">Edit Post</a><?php } else { ?><a href="#" id="new_table" class="add-new-h2">Add Post</a><?php } ?><span id="t4b-loading-image"></span></h2>
	<form method="post" id="t4b_new_post" enctype="multipart/form-data" action="">
		<input type="hidden" name="new_featured_table" value="newfeature" />
		<div id="tablefeaturediv">
			<div id="sliderfeaturediv">
				<div class="sliderfeaturewrap">
					<h3>Add Featured Post</h3>
					<table id="feature_additem" cellspacing="0">
						<tr class="featureheader">
							<th>Post ID</th>
							<th>Actions</th>
						</tr>
						<tr class="featurebody">
							<td><input type="text" name="postID[]" value="" placeholder="Enter post ID" required /></td>
							<td><span id="remDisable"></span></td>
						</tr>
					</table>
					<input type="button" id="addpost" class="button-primary" value="Add New" />
				</div>
			</div>
			<input type="submit" id="t4b_add_new" name="list_id" class="button-primary" value="<?php _e('Add Post'); ?>" />
		</div>
	</form>
	<form method="post" id="t4b_edit_post" enctype="multipart/form-data" action="">
		<input type="hidden" name="edit_featured_table" value="editfeature" />
		<div id="tablefeaturediv">
			<div id="sliderfeaturediv">
				<div class="editsliderfeaturewrap">
					<h3>Edit/Add Featured Post</h3>
					<table id="feature_edititem" cellspacing="0">
						<tr class="featureheader">
							<th>Post ID</th>
							<th>Post Name</th>
							<th>Actions</th>
						</tr>
						<?php foreach($all_lists as $item => $lists) { ?>
						<tr class="featurebody">
							<td width="2%"><input type="text" name="postID[<?php echo $item; ?>]" value="<?php echo $lists->post_id; ?>" placeholder="Enter post ID" size="10" required /></td>
							<td width="90%"><?php echo $lists->post_title; ?></td>
							<td><span id="remFeatute"></span></td>
						</tr>
						<?php } ?>
					</table>
					<input type="button" id="editpost" class="button-primary" value="Add New" />
				</div>
			</div>
			<input type="submit" id="t4b_edit_post" name="edit_list_id" class="button-primary" value="<?php _e('Update'); ?>" />
		</div>
		<p class="feature_notice">*** You can reorder featured posts by dragging with the mouse ***</p>
	</form>
	<?php if(count($all_lists) > 0) { ?>
		<div class="table_list">
			<form id='wrcpt_edit_form' method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="wrcpt_edit_process" value="editprocess" />
				<table id="t4b_list" class="form-table">
					<thead>
						<tr>
							<th>SN</th>
							<th>Post ID</th>
							<th>Post Title</th>
							<th>Activity Date</th>
						</tr>
					</thead>
					<tbody id="t4b<?php echo $flists; ?>">
					<?php
					foreach($all_lists as $key => $flists) {
					$tableSN = $key+1;
					?>
						<tr <?php if($tableSN % 2 == 0) { echo 'class="alt"'; } ?>>
							<td width="2%"><?php echo $tableSN; ?></td>
							<td width="10%"><?php echo $flists->post_id; ?></td>
							<td><?php echo '<a href="'.get_permalink( $flists->post_id ).'" target="_blank">'.$flists->post_title.'</a>'; ?></td>
							<td width="20%"><?php echo $flists->activity_date; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</form>
		</div>
		<?php } else { ?>
				<div class="table_list">
					<p class="get_started">You didn't add any Featured Post yet! Click on <strong>Add Post</strong> button to get started. If you feel trouble to understand what to do, then navigate to <strong>T4B Slider >> Usage</strong> and follow the guidelines described there.</p>
				</div>
		<?php } ?>
	</div>
	<?php t4b_sidebar(); ?>
</div>