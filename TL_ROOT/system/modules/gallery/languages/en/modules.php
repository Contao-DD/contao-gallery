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
$GLOBALS['TL_LANG']['MOD']['gallery'] = array('Galleries', 'This module manages pictures in galleries.');

/**
 * Front end modules
 */
$GLOBALS['TL_LANG']['FMD']['gallery'] = 'Galleries';
$GLOBALS['TL_LANG']['FMD']['gallerylist'] = array('Gallery list', 'adds a list of gallery items from a collection.');
$GLOBALS['TL_LANG']['FMD']['gallerylistpage'] = array('Gallery list by page', 'adds a list of gallery items from a collection linked to a page.');
$GLOBALS['TL_LANG']['FMD']['galleryviewer']  = array('Gallery viewer', 'shows the details and images in any gallery item.');
$GLOBALS['TL_LANG']['FMD']['gallerysingle']  = array('Gallery single', 'shows the details and images in a single gallery item.');
$GLOBALS['TL_LANG']['FMD']['gallerydfgallery'] = array('Gallery dfGallery', 'shows the images in a gallery item using flash-based dfGallery.');

?>