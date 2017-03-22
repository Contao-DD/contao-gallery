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
 * Extend default palette
 */

// insert member field description 
$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('{groups_legend}', '{detail_legend:hide},description;{groups_legend}', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);

	// Fields
$GLOBALS['TL_DCA']['tl_member']['fields']['description'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_member']['description'],
		'exclude'                 => true,
		'search'                  => true,
		'inputType'               => 'textarea',
		'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true, 'feViewable'=>true),
	);
		

?>