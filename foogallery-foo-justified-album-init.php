<?php
//This init class is used to add the extension to the extensions list while you are developing them.
//When the extension is added to the supported list of extensions, this file is no longer needed.

if ( !class_exists( 'Foo_Justified_Album_Template_FooGallery_Extension_Init' ) ) {
	class Foo_Justified_Album_Template_FooGallery_Extension_Init {

		function __construct() {
			add_filter( 'foogallery_available_extensions', array( $this, 'add_to_extensions_list' ) );
		}

		function add_to_extensions_list( $extensions ) {
			$extensions[] = array(
				'slug'=> 'foo-justified-album',
				'class'=> 'Foo_Justified_Album_Template_FooGallery_Extension',
				'title'=> __('Foo Justified Album', 'foogallery-foo-justified-album'),
				'file'=> 'foogallery-foo-justified-album-extension.php',
				'description'=> __('Justified view for albums.', 'foogallery-foo-justified-album'),
				'author'=> ' Elizabeth Evans',
				'author_url'=> 'http://solnimbus.com',
				'thumbnail'=> FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION_URL . '/assets/extension_bg.png',
				'tags'=> array( __('template', 'foogallery') ),	//use foogallery translations
				'categories'=> array( __('Build Your Own', 'foogallery') ), //use foogallery translations
				'source'=> 'generated'
			);

			return $extensions;
		}
	}

	new Foo_Justified_Album_Template_FooGallery_Extension_Init();
}