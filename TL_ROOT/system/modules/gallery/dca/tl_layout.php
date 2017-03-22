<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 * 
 * The Catalog extension allows the creation of multiple catalogs of custom items,
 * each with its own unique set of selectable field types, with field extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the 
 * data in each catalog.
 * 
 * PHP version 5
 * @copyright	Thyon Design 2010 <http://www.thyon.com/>
 * @author		John Brand
 * @package		Gallery
 * @license		LGPL 
 * @filesource
 */


/**
 * Table tl_layout 
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['galleryfeeds'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['galleryfeeds'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'options_callback'        => array('tl_layout_gallery', 'getGalleryfeeds'),
			'eval'                    => array('multiple'=>true)
		);

$GLOBALS['TL_DCA']['tl_layout']['palettes']['default']=str_replace('calendarfeeds', 'calendarfeeds,galleryfeeds' , $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_layout']['palettes']['1cl']=str_replace('calendarfeeds', 'calendarfeeds,galleryfeeds' , $GLOBALS['TL_DCA']['tl_layout']['palettes']['1cl']);
$GLOBALS['TL_DCA']['tl_layout']['palettes']['2cll']=str_replace('calendarfeeds', 'calendarfeeds,galleryfeeds' , $GLOBALS['TL_DCA']['tl_layout']['palettes']['2cll']);
$GLOBALS['TL_DCA']['tl_layout']['palettes']['2clr']=str_replace('calendarfeeds', 'calendarfeeds,galleryfeeds' , $GLOBALS['TL_DCA']['tl_layout']['palettes']['2clr']);
$GLOBALS['TL_DCA']['tl_layout']['palettes']['3cl']=str_replace('calendarfeeds', 'calendarfeeds,galleryfeeds' , $GLOBALS['TL_DCA']['tl_layout']['palettes']['3cl']);



/**
 * Class to add XML feeds
 */

class tl_layout_gallery extends Backend
{
	/**
	 * Return all catalogs with XML feeds
	 * @return array
	 */
	 public function getGalleryfeeds() 
	 {

		$objFeed = $this->Database->execute("SELECT id, title FROM tl_gallery_archive WHERE makeFeed=1");

		if ($objFeed->numRows < 1)
		{
			return array();
		}

		$return = array();
		while ($objFeed->next())
		{
			$return[$objFeed->id] = $objFeed->title;
		}

		return $return;  
	}
}

?>