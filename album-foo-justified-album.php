<?php
/**
 * FooGallery Foo Justified Album gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */
global $current_foogallery_album;
global $current_foogallery_album_arguments;
$gallery = foogallery_album_get_current_gallery();

$height = foogallery_album_template_setting( 'thumb_height', '250' );
$row_height = foogallery_album_template_setting( 'row_height', '150' );
$max_row_height = foogallery_album_template_setting( 'max_row_height', '200%' );

$displayed = [];
$display_counter = 0;

if ( strpos( $max_row_height, '%' ) !== false ) {
	$max_row_height = '"' . $max_row_height . '"';
}

$margins = foogallery_album_template_setting( 'margins', '1' );
$captions = foogallery_album_template_setting( 'captions', '' ) == 'on';
$gutter_width = foogallery_album_template_setting( 'gutter_width', '10' );
$args = array(
	'link' => foogallery_album_template_setting( 'thumbnail_link', 'image' )
);
$lightbox = foogallery_album_template_setting( 'lightbox', 'unknown' );
$caption_source = foogallery_album_template_setting( 'caption_source', 'title' );
?>

<div style="display:none;" data-justified-options='{ "rowHeight": <?php echo $row_height; ?>, "maxRowHeight": <?php echo $max_row_height; ?>, "margins": <?php echo $margins; ?>, "captions": <?php echo $captions ? 'true' : 'false'; ?> }' id="foogallery-album-<?php echo $current_foogallery_album->ID; ?>" class="foogallery-container foogallery-justified foogallery-justified-loading foogallery-lightbox-<?php echo $lightbox; ?>" >
	<?php foreach ( $current_foogallery_album->galleries() as $gallery ) {
		// Check for album galleries
		if (!empty($gallery->attachment_ids)) {

			// Check for featured image/cover image
			$attachment = $gallery->featured_attachment();
			if ( false === $attachment ) continue;

			// Save cover image into variable
			$img_src = $attachment->html_img_src( $args );
			$displayed[$display_counter] = $attachment->ID;
			$display_counter ++;

			// Save link in variable
			if ( 'page' === $link ) {
					//get the URL to the attachment page
					$url = get_attachment_link( $attachment->ID );
				} else if ( 'custom' === $link ) {
					$url = $args['custom_link'];
				} else {
					$url = $attachment->url;
				}
				//fallback for images that might not have a custom url
				if ( empty( $url ) ) {
					$url = $this->url;
				}
				$img_link ='#';
				//only add if the link is NOT set to 'none'
				if ( $link !== 'none' ){
					$img_link = $url;
				}


			// Build gallery title
			$title = empty( $gallery->name ) ?
				sprintf( __( '%s #%s', 'foogallery' ), foogallery_plugin_name(), $gallery->ID ) :
				$gallery->name;

			// Build gallery alternative text
			if ( 'title' == $caption_source ) {
				$gallery->alt = $gallery->title;
			} else if ( 'caption' == $caption_source ) {
				$gallery->alt = $gallery->caption;
			} ?>

			<a href="<?php echo esc_url( $img_link); ?>" rel="<?php echo $lightbox; ?>_<?php echo $gallery->ID ?>" class="<?php echo $lightbox;?>">
				<img alt="<?php echo $title; ?>" src="<?php echo $img_src; ?>" height="<?php echo $height; ?>px" />
			</a>

		<?php } ?>
	<?php } ?>
</div>
<!-- Load the rest of gallery images on to page -->
<div style="display: none;"class="foogallery-lightbox-<?php echo $lightbox; ?>">
	<?php foreach ( $current_foogallery_album->galleries() as $gallery ) {
		foreach ( $gallery->attachments() as $attachment ) {
			$id = $attachment->ID;
			if ( !in_array($id, $displayed) ) {
				$img_html = $attachment->html_img_src( $args );
	?>

	<a href="<?php echo esc_url( $img_html); ?>" rel="<?php echo $lightbox; ?>_<?php echo $gallery->ID ?>" class="<?php echo $lightbox;?>">
		<img src="<?php echo $img_html; ?>" />
	</a>

	<?php }
		}
	} ?>
</div>
