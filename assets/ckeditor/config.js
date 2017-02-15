/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.removePlugins = 'save';
	config.height = '1000px';
	config.allowedContent = true;
	config.extraAllowedContent = 'div(*)';
	config.fullPage = true;
	config.extraAllowedContent = 'span;ul;li;table;td;tr;width;p;style;*[id];*(*);*{*}';
};
