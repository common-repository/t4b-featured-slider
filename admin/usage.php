<div class="wrap">
	<div id="t4b-slider-container" class="postbox-container" style="width:75%;">
		<h2>T4B Featured Slider 1.5.1</h2>
		<div class="t4busage-maincontent">
			<hr>
			<div id="poststuff">
				<div class="postbox">
					<h3>About the plugin</h3>
					<div class="inside">
						<p>"T4B Featured Slider" is a simple and easy WordPress plugin to show featured posts on your blog using a smooth jQuery slider. You can use this plugin as an alternate of WordPress <strong>Sticky</strong> posts.<br /><br />To get started click on <strong>Add Post</strong> button under <b>Featured</b> section. Add featured posts as many as you want to show in your blog by entering the post ID. You can easily findout the post id from the right sidebar. Just enter the URL of the post and click on <strong>Get ID</strong> button. Later you can edit, delete and reorder featured posts at any time.<br /><br />Now, copy the below code and paste it in your blog posts/pages, where you want to show featured slider. In the end, enable the featured slider located at the top under <strong>Settings</strong> section. There you can also easily configure the slider by changing the settings without editing the stylesheet.</p>
					</div>
				</div>
			</div><!-- End poststuff -->
			<div id="poststuff">
				<div class="postbox">
					<h3>Code Usage Instruction</h3>
					<div class="inside">
						<p><b>Put the below code snippet in your blog posts/pages, where you want to show featured slider:</b><br/><br />
							<code><span style="color: #0000BB">   &#60;&#63;php if&#40;get_option&#40;&#39;t4b_option&#39;&#41;&#61;&#61;Enabled) &#123; if&#40;function_exists&#40;show_Featured_Post_Slider&#40;&#41;&#41;&#41; &#123; show_Featured_Post_Slider&#40;&#41;&#59; &#125; &#125; &#63;&#62;</span></code></p>
						<p><b>To prevent duplicate posts from displaying while using featured slider, take the help from the below code snippet to get an idea before quering. It will help you to get all the posts that have been queried, except the ones we have already outputted in the featured slider:</b><br/><br />
							<code><span style="color: #0000BB">
								&#60;&#63;php<br />
								&#36;stickies &#61; t4bFeaturedPost&#40;&#41;&#59;<br />
								&#36;temp &#61; &#36;wp_query&#59;<br />
								&#36;wp_query &#61; null&#59;<br />
								if&#40;get_option&#40;&#39;t4b_option&#39;&#41; &#61;&#61; Enabled&#41; &#123;<br />
									&#36;wp_query &#61; new WP_Query&#40;array&#40; &#39;post__not_in&#39; &#61;&#62; &#36;stickies &#41;&#41;&#59;<br />
								&#125; else &#123;<br />
									&#36;wp_query &#61; new WP_Query&#40;&#41;&#59;<br />
								&#125;<br />
								&#63;&#62;
							</span></code>
						</p>
						<p><b>Then put the rest of the codes.</b></p>
					</div>
				</div>
			</div><!-- End poststuff -->
			<div id="poststuff">
				<div class="postbox">
					<h3>Important Note</h3>
					<div class="inside">
						<ol>
							<li>Before Deactivating the plugin please disabled the "Show Featured Slider" option, which is located at the top of setiings page.</li>
							<li>After Deleting the plugin remove also the above CODE from your blog post/page.</li>
							<li>This is very important, otherwise there will be an error message on your blog.</li>
						</ol>
					</div>
				</div>
			</div><!-- End poststuff -->
			<hr>
			<div class="borderTop">
				<div class="last">
					<p class="prepend-top append-1">This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.<br /><br />This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.<br /><br />You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.</p>
				</div>
			</div><!-- end borderTop -->

		</div><!-- End t4busage-maincontent -->
	</div><!-- End postbox-container -->
	<?php t4b_sidebar(); ?>
</div>