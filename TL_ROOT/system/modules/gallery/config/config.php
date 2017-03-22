<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Gallery 
 * @license    GPL 
 * @filesource
 */


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['gallery'] = array
(
		'tables'       => array('tl_gallery_archive', 'tl_gallery'),
		'icon'         => 'system/modules/gallery/html/gallery.gif',
		'stylesheet'   => 'system/modules/gallery/html/style.css',
);


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['gallery'] = array
	(
		'gallerylist'				=> 'ModuleGalleryList',
		'gallerylistpage'		=> 'ModuleGalleryListPage',
		'galleryviewer'			=> 'ModuleGalleryViewer',
		'gallerysingle'			=> 'ModuleGallerySingle',
  	'gallerydfgallery'	=> 'ModuleGalleryDfGallery'
	);

/**
 * Permissions override 
 */
$GLOBALS['TL_PERMISSIONS'][] = 'galleries';
$GLOBALS['TL_PERMISSIONS'][] = 'galleryp';


/**
 * Register hook to list gallery comments titles 
 */
$GLOBALS['TL_HOOKS']['listComments'][] = array('Gallery', 'listComments');

/**
 * Register hook to allow editing of gallery comments items 
 */
$GLOBALS['TL_HOOKS']['isAllowedToEditComment'][] = array('Gallery', 'isAllowedToEditComment');


/**
 * Register hook to add gallery items to the indexer
 */
$GLOBALS['TL_HOOKS']['getSearchablePages'][] = array('Gallery', 'getSearchablePages');


/**
 * Register hook to add rss feeds to the layout
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Gallery', 'addFeedsToLayout');


/**
 * Preserve feeds hook
 */
$GLOBALS['TL_HOOKS']['removeOldFeeds'][] = array('Gallery', 'removeOldFeeds');
 

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily'][] = array('Gallery', 'generateFeeds');


/**
 * Gallery replaceInsertTags hook
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Gallery', 'replaceGalleryInsertTags');
 
?>