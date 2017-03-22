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
 * @license    LGPL 
 * @filesource
 */


/**
 * Class BEGallery 
 *
 * @copyright  Thyon Design 2010 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Controller
 */
class BEGallery extends ModuleGallery
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_gallery';

	/**
	 * Return if there are no files
	 * @return string
	 */

	public function __construct()
	{
		$this->import('Database');
		$this->import('Input');

		$this->galleryId = 0;
		$this->rssMode = false;
	}
	

	public function generate() 
	{
		$this->Template = new BackendTemplate($this->strTemplate);
		return parent::generate();
	}

	public function compile()
	{
		$this->Template->galleries = '';
		
		$objGalleries = $this->Database->prepare("SELECT * FROM tl_gallery WHERE id=?")
										->limit(1)
										->execute($this->galleryId);

		if ($objGalleries->numRows < 1)
		{
			$this->Template->galleries = '';
		}

		$arrGalleries = $this->parseGalleries($objGalleries);
		$this->Template->galleries = $arrGalleries[0];

	}
}

?>