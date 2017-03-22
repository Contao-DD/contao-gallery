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
 * Class ModuleGallerySingle 
 *
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Controller
 */
class ModuleGallerySingle extends ModuleGallery
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_gallerysingle';


	/**
	 * Return if there are no files
	 * @return string
	 */

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### GALLERY SINGLE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Return if there are no files
	 * @return string
	 */
	protected function compile()
	{

		$this->Template->galleries = '';

		$time = time();

		// Get gallery item
		$objGallery = $this->Database->prepare("SELECT *, author AS authorId, artist AS artistId, (SELECT title FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS archive, (SELECT jumpTo FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE tl_user.id=tl_gallery.author) AS author, (SELECT CONCAT(firstname, ' ', lastname) FROM tl_member WHERE tl_member.id=tl_gallery.artist) AS artist FROM tl_gallery WHERE (id=? OR alias=?)" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : ""))
									 ->limit(1)
									 ->execute((is_numeric($this->gallery) ? $this->gallery : 0), $this->gallery, $time, $time);

		if ($objGallery->numRows < 1)
		{
			$this->Template->galleries = '';
			return;
		}

		$this->gallery_archives = $this->sortOutProtected(array($objGallery->pid));

		// Return if there are no archives
		if (!is_array($this->gallery_archives) || count($this->gallery_archives) < 1)
		{
			return;
		}

		$arrGalleries = $this->parseGalleries($objGallery);

		$this->Template->galleries = $arrGalleries[0];

	}
	

}

?>