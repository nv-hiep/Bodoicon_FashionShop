/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.filebrowserBrowseUrl      = base_url + 'assets/js/kcfinder/browse.php?opener=ckeditor&type=files';
        config.filebrowserImageBrowseUrl = base_url + 'assets/js/kcfinder/browse.php?opener=ckeditor&type=images';
        config.filebrowserFlashBrowseUrl = base_url + 'assets/js/kcfinder/browse.php?opener=ckeditor&type=flash';
        config.filebrowserUploadUrl      = base_url + 'assets/js/kcfinder/upload.php?opener=ckeditor&type=files';
        config.filebrowserImageUploadUrl = base_url + 'assets/js/kcfinder/upload.php?opener=ckeditor&type=images';
        config.filebrowserFlashUploadUrl = base_url + 'assets/js/kcfinder/upload.php?opener=ckeditor&type=flash';
    };