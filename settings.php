<?php 
	$is_update = false;
	if(isset($_GET['delete-slideshow']) && $_GET['delete-slideshow'] != '') {
		$key = $_GET['delete-slideshow'];
		$slideshows = (get_option('slideshowCamp')) ? get_option('slideshowCamp') : array() ;
		if(!empty($slideshows)) {
			if(isset($slideshows[$key])) {
				unset($slideshows[$key]);
			}
		}
		$is_update = update_option('slideshowCamp',$slideshows);
		if($is_update) {
			?>
				<script type="text/javascript">
					window.location = "<?php echo admin_url('admin.php?page=sildeshow-camp'); ?>";
				</script>
			<?php
		}
	}
	if(isset($_POST['submit-slideshow']) && $_POST['submit-slideshow'] != '') {
		$slideshows = (get_option('slideshowCamp')) ? get_option('slideshowCamp') : array() ;
		$keys = array();
		if(!empty($slideshows)) {
			$keys = array_keys($slideshows);
		}
		$slug = $_POST['slideshow']['slug'];
		if(isset($_GET['edit-slideshow'])) {
			$slideshows[$slug] = $_POST['slideshow'];
		} else {
			if(!in_array($slug, $keys)) {
				$slideshows[$slug] = $_POST['slideshow'];
			}
		}

		$is_update = update_option('slideshowCamp',$slideshows);
		?>
			<div class="<?php echo ($is_update) ? 'succes updated' : 'error'; ?>">
				<p>
				<?php echo ($is_update) ? __('New slideshow added', 'slideshow-camp') : __('Could not able to update', 'slideshow-camp'); ?>
				</p>
			</div>
		<?php
	}
?>
<?php $is_new_slideshow = (isset($_GET['new-slideshow']) && $_GET['new-slideshow'] == true) ? true : false; ?>
<?php $edit_slideshow = (isset($_GET['edit-slideshow']) && $_GET['edit-slideshow'] != '') ? $_GET['edit-slideshow'] : false; ?>
<div class="wrapper">
	<div class="inner">

	<?php $slideshows = get_option('slideshowCamp'); ?>

	<?php if(!$is_new_slideshow && $edit_slideshow === false) : ?>

		<h2><?php echo __('Sildeshow Camp','slideshow-camp') ?></h2>
		<div class="slideshow-listing">
			<?php if(empty($slideshows)) : ?>
				<?php echo __('No slideshow found', 'slideshow-camp'); ?>
			<?php else : ?>
				<table class="wp-list-table widefat fixed striped pages">
				<thead>
					<tr>
						<td><?php echo __('Sr. No.', 'slideshow-camp'); ?></td>
						<td><?php echo __('Title', 'slideshow-camp'); ?></td>
						<td><?php echo __('Shortcode', 'slideshow-camp'); ?></td>
						<td><?php echo __('Actions', 'slideshow-camp'); ?></td>
					</tr>
				</thead>
				<?php 
					$count = 0;
					foreach ($slideshows as $key => $slideshow) {
						?>
							<tr>
								<td><?php echo $count+1; ?></td>
								<td><?php echo $slideshow['title'] ?></td>
								<td>[slideshowCamp slug="<?php echo $slideshow['slug'] ?>"]</td>
								<td>
									<a href="<?php echo admin_url('admin.php?page=sildeshow-camp&edit-slideshow='.$key) ?>" data-key="<?php echo $key ?>"><?php echo __('Edit', 'slideshow-camp'); ?> </a> | 
									<a href="<?php echo admin_url('admin.php?page=sildeshow-camp&delete-slideshow='.$key) ?>" data-key="<?php echo $key ?>"><?php echo __('Delete', 'slideshow-camp'); ?></a>
								</td>
							</tr>
						<?php
						$count++;
					}
				?>
				</table>
			<?php endif; ?>
			<br/>
			<div class="button-wrapper">
				<a href="<?php echo admin_url('admin.php?page=sildeshow-camp&new-slideshow=true'); ?>" id="slideshow-camp-button" class="button-primary"><?php echo __('Add new slideshow','slideshow-camp'); ?></a>
			</div> <!-- button-wrapper -->
		</div> <!-- slideshow-listing -->

	<?php elseif($edit_slideshow != false) : ?>	

		<?php $slideshow = $slideshows[$edit_slideshow]; ?>

		<h2><?php echo __('Edit slideshow','slideshow-camp') ?></h2>
		<div class="edit-slideshow">
			<form method="post">
			<table class="form-table">
				<tr class="form-field">
					<td width="180px">
						<label for="title"><?php echo __('Title', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="text" id="slideshow-title" name="slideshow[title]" value="<?php echo $slideshow['title'] ?>" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="slug"><?php echo __('Slug', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="text" name="slideshow[slug]" id="slideshow-slug" value="<?php echo $slideshow['slug'] ?>" />
					</td>
				</tr>
				<tr class="form-field">
					<td><label><?php echo __('Images', 'slideshow-camp'); ?></label><br/><span class="help"><?php echo __('Insert images one by one'); ?></span></td>
					<td>
						<input type="hidden" value="<?php echo $slideshow['images']; ?>" id="slideshow-images" name="slideshow[images]" />
						<div class="slideshow-images">
							<?php 
								$slideshow_images_array = array();
								if ($slideshow['images'] != '') {
									$slideshow_images_array = explode(',', $slideshow['images']);
								} 
							?>
							<?php if(!empty($slideshow_images_array)) : ?>
								<?php foreach ($slideshow_images_array as $key => $img) { ?>
									<?php if($img == '') { continue; } ?>
									<div class="image-wrapper" data-id="<?php echo $img; ?>">
										<img src="<?php echo wp_get_attachment_url($img); ?>" alt="images" />
										<span class="dashicons dashicons-no-alt delete-slideshow-image"></span>
									</div>
								<?php } ?>
							<?php endif; ?>
						</div>
						<input type="button" id="add-slideshow-images" class="button" value="<?php echo __('Insert Image', 'slideshow-camp') ?>" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="mode"><?php echo __('Animation of slide', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<select name="slideshow[mode]">
							<option value="horizontal"><?php echo __('Horizontal', 'slideshow-camp'); ?></option>
							<option value="vertical"><?php echo __('Vertical', 'slideshow-camp'); ?></option>
							<option value="fade"><?php echo __('Fade', 'slideshow-camp'); ?></option>
						</select>
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="speed"><?php echo __('Transition Speed', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="text" value="<?php echo $slideshow['speed'] ?>" name="slideshow[speed]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="infiniteLoop"><?php echo __('Infinite Loop', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" <?php echo ($slideshow['infiniteLoop'] == 'on') ? 'checked' : ''; ?> name="slideshow[infiniteLoop]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="adaptiveHeight"><?php echo __('Adaptive Height', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" <?php echo ($slideshow['adaptiveHeight'] == 'on') ? 'checked' : ''; ?> name="slideshow[adaptiveHeight]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>	
						<label for="auto"><?php echo __('Auto Start', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" <?php echo ($slideshow['auto'] == 'on') ? 'checked' : ''; ?> name="slideshow[auto]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="controls"><?php echo __('Enable Controls?', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" <?php echo ($slideshow['controls'] == 'on') ? 'checked' : ''; ?> name="slideshow[controls]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="pager"><?php echo __('Enable Pager?', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" <?php echo ($slideshow['pager'] == 'on') ? 'checked' : ''; ?> name="slideshow[pager]" />
					</td>
				</tr>
				<tr class="form-field">
					<td colspan="2">
						<input type="submit" name="submit-slideshow" value="<?php echo __('Update slideshow', 'slideshow-camp'); ?>" class="button-primary"> &nbsp; <a href="<?php echo admin_url('admin.php?page=sildeshow-camp'); ?>" class="button-default button"><?php echo __('Back to Slideshows'); ?></a>
					</td>
				</tr>
			</table>
			</form>
		</div>

	<?php else : ?>

		<h2><?php echo __('Add new slideshow','slideshow-camp') ?></h2>
		
		<div class="new-slideshow box">
			<form method="post">
			<table class="form-table">
				<tr class="form-field">
					<td width="180px">
						<label for="title"><?php echo __('Title', 'slideshow-camp'); ?></label>
					</td>
					<td> 
						<input type="text" id="slideshow-title" name="slideshow[title]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="slug"><?php echo __('Slug', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="text" id="slideshow-slug" name="slideshow[slug]" />
					</td>
				</tr>
				<tr class="form-field">
					<td><label><?php echo __('Images', 'slideshow-camp'); ?></label></td>
					<td>
						<input type="hidden" id="slideshow-images" name="slideshow[images]" />
						<div class="slideshow-images"></div>
						<input type="button" id="add-slideshow-images" class="button" value="<?php echo __('Insert Image', 'slideshow-camp') ?>" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="mode"><?php echo __('Animation of slide', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<select name="slideshow[mode]">
							<option value="horizontal"><?php echo __('Horizontal', 'slideshow-camp'); ?></option>
							<option value="vertical"><?php echo __('Vertical', 'slideshow-camp'); ?></option>
							<option value="fade"><?php echo __('Fade', 'slideshow-camp'); ?></option>
						</select>
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="speed"><?php echo __('Transition Speed', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="text" name="slideshow[speed]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="infiniteLoop"><?php echo __('Infinite Loop', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" checked name="slideshow[infiniteLoop]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="adaptiveHeight"><?php echo __('Adaptive Height', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" name="slideshow[adaptiveHeight]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="auto"><?php echo __('Auto Start', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" checked name="slideshow[auto]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="controls"><?php echo __('Enable Controls?', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" checked name="slideshow[controls]" />
					</td>
				</tr>
				<tr class="form-field">
					<td>
						<label for="pager"><?php echo __('Enable Pager?', 'slideshow-camp'); ?></label>
					</td>
					<td>
						<input type="checkbox" checked name="slideshow[pager]" />
					</td>
				</tr>
				<tr class="form-field">
					<td colspan="2">
						<input type="submit" name="submit-slideshow" value="<?php echo __('Create new slideshow', 'slideshow-camp'); ?>" class="button-primary"> &nbsp; <a href="<?php echo admin_url('admin.php?page=sildeshow-camp'); ?>" class="button-default button"><?php echo __('Back to Slideshows'); ?></a>
					</td>
				</tr>
			</table>
			</form>
		</div> <!-- new-slideshow -->

	<?php endif; ?>

	</div> <!-- inner -->
</div> <!-- wrapper -->