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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_gallery']['title']				= array('Title', 'Please enter the title of the gallery.');
$GLOBALS['TL_LANG']['tl_gallery']['alias']				= array('Gallery alias', 'The gallery alias is a unique reference to the gallery which can be called instead of the gallery ID.');
$GLOBALS['TL_LANG']['tl_gallery']['date']					= array('Date', 'Please enter the date of the gallery.');
$GLOBALS['TL_LANG']['tl_gallery']['author'] 			= array('Author', 'Here you can change the author of the gallery item.');
$GLOBALS['TL_LANG']['tl_gallery']['location']			= array('Location', 'Please enter the name of the location.');
$GLOBALS['TL_LANG']['tl_gallery']['artist']				= array('Artist or Photographer member', 'Please select the artist or photographer (members).');

$GLOBALS['TL_LANG']['tl_gallery']['artsize']			= array('Artwork size', 'Enter the size as width, height and unit.');
$GLOBALS['TL_LANG']['tl_gallery']['medium']				= array('Medium', 'Enter the medium as paint or print.');
$GLOBALS['TL_LANG']['tl_gallery']['substrate']		= array('Substrate', 'Enter the substrate onto which the art is painted or photo is printed.');

$GLOBALS['TL_LANG']['tl_gallery']['description']	= array('Description', 'Please enter a short description for the gallery.');
$GLOBALS['TL_LANG']['tl_gallery']['singleSRC']    = array('Poster Image', 'Please select the poster image to be used in the gallery list view.');
$GLOBALS['TL_LANG']['tl_gallery']['multiSRC']  	  = array('Gallery image files', 'Please select one or more images and/or folders (images in a folder will be included automatically).');
$GLOBALS['TL_LANG']['tl_gallery']['setImages']  	= array('Override default image settings', 'Enables you to override the gallery collection\'s image settings.');
$GLOBALS['TL_LANG']['tl_gallery']['posterSize']    	    = array('Poster image width and height', 'Please enter either the image width, the image height or both measures to resize the image. If you leave both fields blank, the original image size will be displayed.');
$GLOBALS['TL_LANG']['tl_gallery']['posterFullsize']			= array('Poster fullsize view', 'If you choose this option, the image can be viewed fullsize by clicking it.');
$GLOBALS['TL_LANG']['tl_gallery']['size']    	    = array('Gallery Image width and height', 'Please enter either the image width, the image height or both measures to resize the image. If you leave both fields blank, the original image size will be displayed.');
$GLOBALS['TL_LANG']['tl_gallery']['imagemargin']	= array('Gallery Image margin', 'Please enter the top, right, bottom and left margin and the unit. Image margin is the space inbetween an image and its neighbour elements.');
$GLOBALS['TL_LANG']['tl_gallery']['perRow']    	  = array('Thumbnails per row', 'Please enter the number of thumbnails per row.');
$GLOBALS['TL_LANG']['tl_gallery']['perPage']   	  = array('Items per page', 'The number of items per page. Set to 0 to disable pagination.');
$GLOBALS['TL_LANG']['tl_gallery']['sortBy']   	   = array('Order by', 'Please select a sort order.');
$GLOBALS['TL_LANG']['tl_gallery']['fullsize']			= array('Fullsize view', 'If you choose this option, the image can be viewed fullsize by clicking it.');

$GLOBALS['TL_LANG']['tl_gallery']['cssClass']     = array('CSS class', 'Here you can enter one or more classes.');
$GLOBALS['TL_LANG']['tl_gallery']['status']     	= array('Status', 'Select the status of the gallery item.');
$GLOBALS['TL_LANG']['tl_gallery']['noComments']   = array('Disable comments', 'Do not allow comments for this particular gallery item.');
$GLOBALS['TL_LANG']['tl_gallery']['featured']     = array('Feature item', 'Show the gallery item in a featured gallery list.');
$GLOBALS['TL_LANG']['tl_gallery']['published']    = array('Publish item', 'Make the gallery item publicly visible on the website.');
$GLOBALS['TL_LANG']['tl_gallery']['start']        = array('Show from', 'Do not show the gallery item on the website before this day.');
$GLOBALS['TL_LANG']['tl_gallery']['stop']         = array('Show until', 'Do not show the gallery item on the website after this day.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_gallery']['name_asc']  = 'File name (ascending)';
$GLOBALS['TL_LANG']['tl_gallery']['name_desc'] = 'File name (descending)';
$GLOBALS['TL_LANG']['tl_gallery']['date_asc']  = 'Date (oldest first)';
$GLOBALS['TL_LANG']['tl_gallery']['date_desc'] = 'Date (recent first)';
$GLOBALS['TL_LANG']['tl_gallery']['meta']      = 'Meta file (meta.txt)';
$GLOBALS['TL_LANG']['tl_gallery']['random']    = 'Random order';

// Medium
$GLOBALS['TL_LANG']['tl_gallery']['oil']		= 'Oil';
$GLOBALS['TL_LANG']['tl_gallery']['acr']		= 'Acrylic';
$GLOBALS['TL_LANG']['tl_gallery']['ola']		= 'Oil and acrylic';
$GLOBALS['TL_LANG']['tl_gallery']['mpt']		= 'Monoprint';
$GLOBALS['TL_LANG']['tl_gallery']['cpt']		= 'Colour print';

// Substrate
$GLOBALS['TL_LANG']['tl_gallery']['cvs']		= 'Canvas';
$GLOBALS['TL_LANG']['tl_gallery']['ppr']		= 'Paper';
$GLOBALS['TL_LANG']['tl_gallery']['pho']		= 'Photo';
$GLOBALS['TL_LANG']['tl_gallery']['vnl']		= 'Vinyl';
$GLOBALS['TL_LANG']['tl_gallery']['brd']		= 'Board';
$GLOBALS['TL_LANG']['tl_gallery']['fab']		= 'Fabriano';

//Status
$GLOBALS['TL_LANG']['tl_gallery']['avail']	= 'Available';
$GLOBALS['TL_LANG']['tl_gallery']['sold']		= 'Sold';
$GLOBALS['TL_LANG']['tl_gallery']['resv']		= 'Reserved';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_gallery']['title_legend']		= 'Title and other descriptive information';
$GLOBALS['TL_LANG']['tl_gallery']['poster_legend']	= 'Poster image';
$GLOBALS['TL_LANG']['tl_gallery']['gallery_legend']	= 'Gallery images';
$GLOBALS['TL_LANG']['tl_gallery']['groups_legend']	= 'Artist groups';
$GLOBALS['TL_LANG']['tl_gallery']['expert_legend']	= 'Expert settings';
$GLOBALS['TL_LANG']['tl_gallery']['publish_legend']	= 'Publish settings';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_gallery']['new']   			= array('New gallery', 'Create a new gallery');
$GLOBALS['TL_LANG']['tl_gallery']['edit']  			= array('Edit gallery', 'Edit gallery ID %s');
$GLOBALS['TL_LANG']['tl_gallery']['copy']   		= array('Copy gallery', 'Copy gallery ID %s');
$GLOBALS['TL_LANG']['tl_gallery']['delete'] 		= array('Delete gallery', 'Delete gallery ID %s');
$GLOBALS['TL_LANG']['tl_gallery']['show']   		= array('Gallery details', 'Show details of gallery ID %s');
$GLOBALS['TL_LANG']['tl_gallery']['toggle']     = array('Publish/unpublish gallery', 'Publish/unpublish gallery ID %s');
$GLOBALS['TL_LANG']['tl_gallery']['editheader'] = array('Edit collection settings', 'Edit the gallery collection settings');


?>