/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'MyToolbar' ; 
	config.toolbar_MyToolbar = 
	[ 
		[ 'NewPage' , 'Preview', 'Source'], 
		[ 'Cut' , 'Copy' , 'Paste' , 'PasteText' , 'PasteFromWord' ,'Scayt' ], 
		[ 'Undo' , 'Redo' , '-' , 'Find' , 'Replace' , '-' , 'SelectAll' , 'RemoveFormat' ], 
		[ 'Image' , 'Flash' , 'Table' , 'HorizontalRule' , 'Smiley' , 'SpecialChar' , 'PageBreak'], 
		[ 'Bold' , 'Italic' , 'Strike' ], 
		[ 'Link' , 'Unlink' , 'Anchor' ], 
		'/' , 
		[ 'Styles' , 'Format' ], 
		[ 'NumberedList' , 'BulletedList' , '-' , 'Outdent' , 'Indent' , 'Blockquote' ], 
		[ 'TextColor', 'BGColor'],
	];
	config.toolbar_basic = 
	[ 
		[ 'NewPage' , 'Preview', 'Source'], 
		[ 'Cut' , 'Copy' , 'Paste' , 'PasteText' , 'PasteFromWord' ,'Scayt' ], 
		[ 'Image' , 'Flash' , 'Table' , 'Smiley' , 'SpecialChar'], 
		[ 'Bold' , 'Italic' , 'Strike' ], 
		[ 'NumberedList' , 'BulletedList' , '-' , 'Outdent' , 'Indent' , 'Blockquote' ], 
		[ 'Link' , 'Unlink' , 'Anchor' ], 
		[ 'TextColor', 'BGColor'],
	];
};
