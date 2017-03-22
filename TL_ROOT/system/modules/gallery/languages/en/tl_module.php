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
 * @copyright  Leo Feyer 2005
 * @author     Leo Feyer <leo@typolight.org>
 * @package    News
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['gallery']      = array('Gallery', 'Please select a gallery to display.');
$GLOBALS['TL_LANG']['tl_module']['gallery_archives']      = array('Gallery archives', 'Please select one or more gallery archives.');
$GLOBALS['TL_LANG']['tl_module']['gallery_metaFields']    = array('Meta-data fields', 'Please choose which galley meta-date fields are displayed.');
$GLOBALS['TL_LANG']['tl_module']['gallery_dateFormat']    = array('Date format', 'Please enter a date format as used by the PHP <em>date()</em> function.');

$GLOBALS['TL_LANG']['tl_module']['gallery_sort']  = array('Sort order', 'Choose which field is used to sort the gallery list.');
$GLOBALS['TL_LANG']['tl_module']['gallery_enableFilter']   	  = array('Enable filter support', 'Enable the gallery list to respond to url filter parameters.');
$GLOBALS['TL_LANG']['tl_module']['gallery_filters']   	  = array('Add field filters', 'Add the following filter fields to the gallery list.');
$GLOBALS['TL_LANG']['tl_module']['gallery_conditions'] = array('Filter by conditions', 'Select which field conditions to filter on.');

$GLOBALS['TL_LANG']['tl_module']['gallery_numberOfItems']  = array('Total number of gallery items', 'Here you can limit the total number of gallery items. Set to 0 to show all.');
$GLOBALS['TL_LANG']['tl_module']['gallery_featured']  = array('Featured items only', 'Show only featured gallery items in the list');

$GLOBALS['TL_LANG']['tl_module']['gallery_posterSize']        = array('Poster Image width and height', 'Here you can set the image dimensions and the resize mode (optional).');
$GLOBALS['TL_LANG']['tl_module']['gallery_posterFullsize']			= array('Poster Fullsize view', 'If you choose this option, the image can be viewed fullsize by clicking it.');
$GLOBALS['TL_LANG']['tl_module']['gallery_showPreview']  = array('Show gallery images', 'Add the gallery images. Optionally modify the default image settings.');
$GLOBALS['TL_LANG']['tl_module']['gallery_size']        = array('Gallery Image width and height', 'Here you can set the image dimensions and the resize mode (optional).');
$GLOBALS['TL_LANG']['tl_module']['gallery_imagemargin'] = array('Image margin', 'Please enter the top, right, bottom and left margin and the unit. Image margin is the space inbetween an image and its neighbour elements.');
$GLOBALS['TL_LANG']['tl_module']['gallery_perRow']    	  = array('Thumbnails per row', 'Please enter the number of thumbnails per row.');
$GLOBALS['TL_LANG']['tl_module']['gallery_perPage']   	  = array('Items per page', 'The number of items per page. Set to 0 to disable pagination.');
$GLOBALS['TL_LANG']['tl_module']['gallery_sortBy']   	   = array('Order by', 'Please select a sort order.');
$GLOBALS['TL_LANG']['tl_module']['gallery_fullsize']			= array('Fullsize view', 'If you choose this option, the image can be viewed fullsize by clicking it.');
$GLOBALS['TL_LANG']['tl_module']['gallery_numberOfImages']   	  = array('Total number of images', 'Here you can limit the total number of gallery items. Set to 0 to show all.');

$GLOBALS['TL_LANG']['tl_module']['gallery_template']      = array('Gallery template', 'Here you can select the gallery template.');

$GLOBALS['TL_LANG']['tl_module']['dfTitle'] = array('Gallery title', 'Please enter a title for the gallery.');
$GLOBALS['TL_LANG']['tl_module']['dfSize'] = array('Width and height', 'Please enter the width and height of the Flash movie.');
$GLOBALS['TL_LANG']['tl_module']['dfInterval'] = array('Slide interval', 'Please enter the slide interval in seconds.');
$GLOBALS['TL_LANG']['tl_module']['dfTemplate'] = array('XML template', 'Please choose an XML template to initialize the gallery.');
$GLOBALS['TL_LANG']['tl_module']['dfPause'] = array('Pause at start', 'Do not start the slideshow by default.');


/**
 * Reference
 */

// shared sorting values
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['default'] 		= 'Default (gallery collection setting)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['date_desc']	= 'Date (recent first)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['date_asc'] 	= 'Date (oldest first)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['title'] 			= 'Title (alphabetical)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['sorting'] 		= 'Manual sorting';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['random'] 		= 'Random order';

// Add ones for gallery sorting too
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['name_asc'] 	= 'File name (ascending)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['name_desc'] 	= 'File name (descending)';
$GLOBALS['TL_LANG']['tl_module']['gallery_sortval']['meta'] 			= 'Meta file (meta.txt)';

// Meta Values
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['author']    		= 'Author';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['location']    	= 'Location';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['status']				= 'Status';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['date']					= 'Date';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['artist']				= 'Artist or photographer';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['artsize']    	= 'Artwork size';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['medium']	    	= 'Medium';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['substrate']	  = 'Substrate';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['comments']    	= 'Comments';
$GLOBALS['TL_LANG']['tl_module']['gallery_metaval']['qty']    			= 'Image quantity';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['dfconfig_legend'] = 'dfGallery settings';
$GLOBALS['TL_LANG']['tl_module']['filter_legend'] = 'Filter settings';



?>