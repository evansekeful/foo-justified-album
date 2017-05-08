<?php
/**
 * FooGallery Foo Justified Album Extension
 *
 * Justified view for albums.
 *
 * @package   Foo_Justified_Album_Template_FooGallery_Extension
 * @author    Elizabeth Evans
 * @license   GPL-2.0+
 * @link      http://solnimbus.com
 * @copyright 2014  Elizabeth Evans
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - Foo Justified Album
 * Description: Justified view for albums.
 * Version:     1.0.0
 * Author:      Elizabeth Evans
 * Author URI:  http://solnimbus.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'Foo_Justified_Album_Template_FooGallery_Extension' ) ) {

	define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_FILE', __FILE__ );
	define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL', plugin_dir_url( __FILE__ ));
	define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION', '1.0.0');
	define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_PATH', plugin_dir_path( __FILE__ ));
	define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_SLUG', 'foogallery-foo-justified-album');
	//define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL', 'http://fooplugins.com');
	//define('FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME', 'Foo Justified Album');

	require_once( 'foogallery-foo-justified-album-init.php' );

	class Foo_Justified_Album_Template_FooGallery_Extension {
		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_album_templates', array( $this, 'add_template' ) );
			add_filter( 'foogallery_album_templates_files', array( $this, 'register_myself' ) );
			add_filter( 'foogallery_located_template-foo-justified-album', array( $this, 'enqueue_dependencies' ) );
			add_filter( 'foogallery_template_js_ver-foo-justified-album', array( $this, 'override_version' ) );
			add_filter( 'foogallery_template_css_ver-foo-justified-album', array( $this, 'override_version' ) );

			//used for auto updates and licensing in premium extensions. Delete if not applicable
			//init licensing and update checking
			//require_once( FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_PATH . 'includes/EDD_SL_FooGallery.php' );

			//new EDD_SL_FooGallery_v1_1(
			//	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_FILE,
			//	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_SLUG,
			//	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION,
			//	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL,
			//	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME,
			//	'Foo Justified Album');
		}

		/**
		 * Register myself so that all associated JS and CSS files can be found and automatically included
		 * @param $extensions
		 *
		 * @return array
		 */
		function register_myself( $extensions ) {
			$extensions[] = __FILE__;
			return $extensions;
		}

		/**
		 * Override the asset version number when enqueueing extension assets
		 */
		function override_version( $version ) {
			return FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION;
		}

		/**
		 * Enqueue any script or stylesheet file dependencies that your gallery template relies on
		 */
		function enqueue_dependencies() {
			$js = FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/jquery.album-foo-justified-album.js';
			wp_enqueue_script( 'album-foo-justified-album', $js, array('jquery'), FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );

			$css = FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/album-foo-justified-album.css';
			foogallery_enqueue_style( 'album-foo-justified-album', $css, array(), FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );
		}

		/**
		 * Add our album template to the list of templates available for every album
		 * @param $album_templates
		 *
		 * @return array
		 */
		function add_template( $album_templates ) {

			$album_templates[] = array(
				'slug'        => 'foo-justified-album',
				'name'        => __( 'Foo Justified Album', 'foogallery-foo-justified-album'),
				'preview_css' => FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/foo-justified-album.css',
				'admin_js'	  => FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/admin-foo-justified-album.js',
				'fields'	  => array(
							array(
									'id'	  => 'help',
									'title'	  => __( 'Tip', 'foogallery' ),
									'type'	  => 'html',
									'help'	  => true,
									'desc'	  => __( 'The Justified Album template uses the popular <a href="http://miromannino.com/projects/justified-gallery/" target="_blank">Justified Gallery jQuery Plugin</a> under the hood. You can specify thumbnail captions by setting the alt text for your attachments.', 'foogallery' ),
							),
							array(
									'id'      => 'thumb_height',
									'title'   => __( 'Thumb Height', 'foogallery' ),
									'desc'    => __( 'Choose the height of your thumbnails. Thumbnails will be generated on the fly and cached once generated.', 'foogallery' ),
									'type'    => 'number',
									'class'   => 'small-text',
									'default' => 250,
									'step'    => '10',
									'min'     => '0',
							),
							array(
									'id'      => 'row_height',
									'title'   => __( 'Row Height', 'foogallery' ),
									'desc'    => __( 'The preferred height of your gallery rows. This can be different from the thumbnail height.', 'foogallery' ),
									'type'    => 'number',
									'class'   => 'small-text',
									'default' => 150,
									'step'    => '10',
									'min'     => '0',
							),
							array(
									'id'      => 'max_row_height',
									'title'   => __( 'Max Row Height', 'foogallery' ),
									'desc'    => __( 'A number (e.g 200) which specifies the maximum row height in pixels. A negative value for no limits. Alternatively, use a percentage (e.g. 200% which means that the row height cannot exceed 2 * rowHeight)', 'foogallery' ),
									'type'    => 'text',
									'class'   => 'small-text',
									'default' => '200%'
							),
							array(
									'id'      => 'margins',
									'title'   => __( 'Margins', 'foogallery' ),
									'desc'    => __( 'The spacing between your thumbnails.', 'foogallery' ),
									'type'    => 'number',
									'class'   => 'small-text',
									'default' => 1,
									'step'    => '1',
									'min'     => '0',
							),
							array(
									'id'      => 'captions',
									'title'   => __( 'Show Captions', 'foogallery' ),
									'desc'    => __( 'Show a caption when hovering over your thumbnails. (Set captions by adding either a title or alt text to an attachment)', 'foogallery' ),
									'type'    => 'checkbox',
									'default' => 'on',
							),
							array(
									'id'      => 'caption_source',
									'title'   => __( 'Caption Source', 'foogallery' ),
									'desc'    => __( 'Pull captions from either the attachment Title, Caption or Alt Text.', 'foogallery' ),
									'type'    => 'radio',
									'default' => 'title',
									'spacer'  => '<span class="spacer"></span>',
									'choices' => array(
											'title'  => __( 'Attachment Title', 'foogallery' ),
											'caption'   => __( 'Attachment Caption', 'foogallery' ),
											'alt'   => __( 'Attachment Alt Text', 'foogallery' )
									)
							),
							array(
									'id'      => 'thumbnail_link',
									'title'   => __( 'Thumbnail Link', 'foogallery' ),
									'default' => 'image' ,
									'type'    => 'thumb_link',
									'spacer'  => '<span class="spacer"></span>',
									'desc'	  => __( 'You can choose to link each thumbnail to the full size image, or to the image\'s attachment page, or you can choose to not link to anything.', 'foogallery' ),
							),
							array(
									'id'      => 'lightbox',
									'title'   => __( 'Lightbox', 'foogallery' ),
									'desc'    => __( 'Choose which lightbox you want to display images with. The lightbox will only work if you set the thumbnail link to "Full Size Image".', 'foogallery' ),
									'type'    => 'lightbox',
							),
					//available field types available : html, checkbox, select, radio, textarea, text, checkboxlist, icon
					//an example of a icon field used in the default gallery template
					//array(
					//	'id'      => 'border-style',
					//	'title'   => __('Border Style', 'foogallery-foo-justified-album'),
					//	'desc'    => __('The border style for each thumbnail in the gallery.', 'foogallery-foo-justified-album'),
					//	'type'    => 'icon',
					//	'default' => 'border-style-square-white',
					//	'choices' => array(
					//		'border-style-square-white' => array('label' => 'Square white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-white.png'),
					//		'border-style-circle-white' => array('label' => 'Circular white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-white.png'),
					//		'border-style-square-black' => array('label' => 'Square Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-black.png'),
					//		'border-style-circle-black' => array('label' => 'Circular Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-black.png'),
					//		'border-style-inset' => array('label' => 'Square Inset', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-inset.png'),
					//		'border-style-rounded' => array('label' => 'Plain Rounded', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-plain-rounded.png'),
					//		'' => array('label' => 'Plain', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-none.png'),
					//	)
					//),
				)
			);

			return $album_templates;
		}
	}
}
