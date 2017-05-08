//Use this file to inject custom javascript behaviour into the foogallery edit page
//For an example usage, check out wp-content/foogallery/extensions/default-templates/js/admin-gallery-default.js

(function (FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION, $, undefined) {

	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION.doSomething = function() {
		//do something when the gallery template is changed to foo-justified-album
	};

	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION.adminReady = function () {
		$('body').on('foogallery-gallery-template-changed-foo-justified-album', function() {
			FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION.doSomething();
		});
	};

}(window.FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION = window.FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION || {}, jQuery));

jQuery(function () {
	FOO_JUSTIFIED_ALBUM_TEMPLATE_FOOGALLERY_EXTENSION.adminReady();
});