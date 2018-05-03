/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.allowedContent = true;
	config.filebrowserBrowseUrl = '/public/ckfinder/ckfinder.html?id=1',
    config.filebrowserUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    config.filebrowserImageUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    config.filebrowserFlashUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	config.filebrowserWindowFeatures = 'resizable=yes,scrollbars=no',
	config.toolbar = '2WEB';
	config.toolbar_2WEB =
	[
	 	['Source','Paste','PasteText','PasteFromWord'],
		['OrderedList','UnorderedList'],
		['Bold','Italic','Underline'],
		['Link','Unlink','Anchor'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','NumberedList','BulletedList'],
		'/',
		['Image','Styles','Format','Font'],
		/*['TextColor','BGColor'],*/['Maximize','-','About']	// No comma for the last row.		
		
	];
	
	config.toolbar = '2WEB2';	
	config.toolbar_2WEB2 =
	[
	 	['Source','Paste','PasteText','PasteFromWord'],
		['OrderedList','UnorderedList','RemoveFormat'],
		['Source','-','Bold','Italic','-','JustifyLeft','JustifyCenter','JustifyRight','-','OrderedList','UnorderedList','NumberedList','BulletedList'],
		['Table','Link','Unlink','Image','-','Format',/*'TextColor','BGColor',*/'-','Maximize','-','About']
		
	];
	
};
