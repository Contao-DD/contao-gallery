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
$GLOBALS['TL_LANG']['tl_gallery_archive']['title'] = array('Title', 'Please enter the title of the gallery collection.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['description'] = array('Description', 'Please enter a short description for the gallery collection.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['jumpTo']      = array('Jump to page', 'Please select the page to which visitors will be redirected when clicking on a gallery link.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['sortmode']    = array('Sort mode', 'Sets the default sorting mode for the gallery collection.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['pgFilter']    = array('Page filter', 'Associate this gallery collection with a page to use as filter in the gallery list.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['artgroups']   = array('Artist groups', 'Here you can filter the artist selection groups.');

$GLOBALS['TL_LANG']['tl_gallery_archive']['allowComments']  = array('Enable comments', 'Allow your visitors to comment gallery items.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['notify']         = array('Notify', 'Please choose who to notify when comments are added.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['template']       = array('Comments layout', 'Please choose a comment layout. Comment template files start with <em>com_</em>.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['sortOrder']      = array('Sort order', 'By default, comments are sorted ascending, starting with the oldest one.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['perPage']        = array('Comments per page', 'Number of comments per page. Set to 0 to disable pagination.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['moderate']       = array('Moderate comments', 'Approve comments before they are published on the website.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['bbcode']         = array('Allow BBCode', 'Allow visitors to format their comments with BBCode.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['requireLogin']   = array('Require login to comment', 'Allow only authenticated users to create comments.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['disableCaptcha'] = array('Disable security question', 'Use this option only if you have limited comments to authenticated users.');

$GLOBALS['TL_LANG']['tl_gallery_archive']['protected']      = array('Protect archive', 'Show gallery items to certain member groups only.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['groups']         = array('Allowed member groups', 'These groups will be able to see the gallery items in this collection.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['makeFeed']       = array('Generate feed', 'Generate an RSS or Atom feed from the gallery collection.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['format']         = array('Feed format', 'Please choose a feed format.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['language']       = array('Feed language', 'Please enter the page language according to the ISO-639 standard (e.g. <em>en</em> or <em>en-us</em>).');
$GLOBALS['TL_LANG']['tl_gallery_archive']['source']         = array('Export settings', 'Here you can choose what will be exported.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['maxItems']       = array('Maximum number of items', 'Here you can limit the number of feed items. Set to 0 to export all.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['feedBase']       = array('Base URL', 'Please enter the base URL with protocol (e.g. <em>http://</em>).');
$GLOBALS['TL_LANG']['tl_gallery_archive']['alias']          = array('Feed alias', 'Here you can enter a unique filename (without extension). The XML feed file will be auto-generated in the root directory of your installation, e.g. as <em>name.xml</em>.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['feeddescription']= array('Feed description', 'Please enter a short description of the gallery feed.');
$GLOBALS['TL_LANG']['tl_gallery_archive']['tstamp']         = array('Revision date', 'Date and time of the latest revision');



/**
 * Reference
 */
//$GLOBALS['TL_LANG']['tl_gallery_archive']['ascending']  = 'ascending';
//$GLOBALS['TL_LANG']['tl_gallery_archive']['descending'] = 'descending';
$GLOBALS['TL_LANG']['tl_gallery_archive']['name_asc']  = 'File name (ascending)';
$GLOBALS['TL_LANG']['tl_gallery_archive']['name_desc'] = 'File name (descending)';
$GLOBALS['TL_LANG']['tl_gallery_archive']['date_asc']  = 'Date (ascending)';
$GLOBALS['TL_LANG']['tl_gallery_archive']['date_desc'] = 'Date (descending)';
$GLOBALS['TL_LANG']['tl_gallery_archive']['meta']      = 'Meta file (meta.txt)';
$GLOBALS['TL_LANG']['tl_gallery_archive']['random']    = 'Random order';

// Nofify
$GLOBALS['TL_LANG']['tl_gallery_archive']['notify_admin']  = 'System administrator';
$GLOBALS['TL_LANG']['tl_gallery_archive']['notify_author'] = 'Author of the gallery item';
$GLOBALS['TL_LANG']['tl_gallery_archive']['notify_both']   = 'Author and system administrator';

// Sort mode
$GLOBALS['TL_LANG']['tl_gallery_archive']['sorting']  = 'Manual sorting';
$GLOBALS['TL_LANG']['tl_gallery_archive']['title_asc']   = 'Title (alphabetical)';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_gallery_archive']['title_legend']   = 'Title, description and redirect page';
$GLOBALS['TL_LANG']['tl_gallery_archive']['filter_legend']  = 'Filter settings';
$GLOBALS['TL_LANG']['tl_gallery_archive']['groups_legend']  = 'Artist Groups';
$GLOBALS['TL_LANG']['tl_gallery_archive']['image_legend']   = 'Image default settings';
$GLOBALS['TL_LANG']['tl_gallery_archive']['comments_legend']= 'Comments';
$GLOBALS['TL_LANG']['tl_gallery_archive']['protected_legend'] = 'Access protection';
$GLOBALS['TL_LANG']['tl_gallery_archive']['feed_legend']    = 'RSS/Atom feed';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_gallery_archive']['new']    = array('New gallery collection', 'Create a new gallery collection');
$GLOBALS['TL_LANG']['tl_gallery_archive']['edit']   = array('Edit gallery collection', 'Edit gallery collection ID %s');
$GLOBALS['TL_LANG']['tl_gallery_archive']['copy']   = array('Copy gallery collection', 'Copy gallery collection ID %s');
$GLOBALS['TL_LANG']['tl_gallery_archive']['delete'] = array('Delete gallery collection', 'Delete gallery collection ID %s');
$GLOBALS['TL_LANG']['tl_gallery_archive']['show']   = array('Gallery collection details', 'Show details of galllery collection ID %s');

?>