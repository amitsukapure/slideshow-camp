<?php 
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

		<h2><?php echo __('Settings','slideshow-camp') ?></h2>
		<div class="slideshow-listing">
			<?php if(empty($slideshows)) : ?>
				<?php echo __('No slideshow found', 'slideshow-camp'); ?>
			<?php else : ?>
				<table>
				<?php 
					$count = 0;
					foreach ($slideshows as $key => $slideshow) {
						?>
							<tr>
								<td><?php echo $count+1; ?></td>
								<td><?php echo $slideshow['title'] ?></td>
								<td>
									<a href="<?php echo admin_url('admin.php?page=sildeshow-camp&edit-slideshow='.$key) ?>" data-key="<?php echo $key ?>"><?php echo __('Edit', 'slideshow-camp'); ?> </a> | 
									<a href="javascript:void(0)" data-key="<?php echo $key ?>"><?php echo __('Delete', 'slideshow-camp'); ?></a>
								</td>
							</tr>
						<?php
						$count++;
					}
				?>
				</table>
			<?php endif; ?>
			<div class="button-wrapper">
				<a href="<?php echo admin_url('admin.php?page=sildeshow-camp&new-slideshow=true'); ?>" id="slideshow-camp-button" class="button-primary"><?php echo __('Add new slideshow','slideshow-camp'); ?></a>
			</div> <!-- button-wrapper -->
		</div> <!-- slideshow-listing -->

	<?php elseif($edit_slideshow != false) : ?>	

		<?php $slideshow = $slideshows[$edit_slideshow]; ?>

		<h2><?php echo __('Edit new slideshow','slideshow-camp') ?></h2>
		<div class="edit-slideshow">
			<form method="post">
				<div class="form-field">
					<label for="title"><?php echo __('Title', 'slideshow-camp'); ?></label>
					<input type="text" name="slideshow[title]" value="<?php echo $slideshow['title'] ?>" />
				</div>
				<div class="form-field">
					<label for="slug"><?php echo __('Slug', 'slideshow-camp'); ?></label>
					<input type="text" name="slideshow[slug]" value="<?php echo $slideshow['slug'] ?>" />
				</div>
				<div class="form-field">
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
								</div>
							<?php } ?>
						<?php endif; ?>
					</div>
					<input type="button" id="add-slideshow-images" class="button" value="<?php echo __('Add Image', 'slideshow-camp') ?>" />
				</div>
				<div class="form-field">
					<input type="submit" name="submit-slideshow" value="<?php echo __('Update slideshow', 'slideshow-camp'); ?>" class="button-primary">
				</div>
			</form>
		</div>

	<?php else : ?>

		<h2><?php echo __('Add new slideshow','slideshow-camp') ?></h2>
		<div class="new-slideshow">
			<form method="post">
				<div class="form-field">
					<label for="title"><?php echo __('Title', 'slideshow-camp'); ?></label>
					<input type="text" name="slideshow[title]" />
				</div>
				<div class="form-field">
					<label for="slug"><?php echo __('Slug', 'slideshow-camp'); ?></label>
					<input type="text" name="slideshow[slug]" />
				</div>
				<div class="form-field">
					<input type="hidden" id="slideshow-images" name="slideshow[images]" />
					<div class="slideshow-images">

					</div>
					<input type="button" id="add-slideshow-images" class="button" value="<?php echo __('Add Images', 'slideshow-camp') ?>" />
				</div>
				<div class="form-field">
					<input type="submit" name="submit-slideshow" value="<?php echo __('Create new slideshow', 'slideshow-camp'); ?>" class="button-primary">
				</div>
			</form>
		</div> <!-- new-slideshow -->

	<?php endif; ?>

	</div> <!-- inner -->
</div> <!-- wrapper -->