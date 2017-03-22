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
 * Class ModuleGalleryViewer
 *
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Controller
 */
class ModuleGalleryViewer extends ModuleGallery
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_galleryviewer';


	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### GALLERY VIEWER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;

			return $objTemplate->parse();
		}

		// Return if no gallery item has been specified
		if (!$this->Input->get('items'))
		{
			return '';
		}

		$this->gallery_archives = $this->sortOutProtected(deserialize($this->gallery_archives));

		// Return if there are no archives
		if (!is_array($this->gallery_archives) || count($this->gallery_archives) < 1)
		{
			return '';
		}

		return parent::generate();
	}


	/**
	 * Return if there are no files
	 * @return string
	 */
	protected function compile()
	{
		global $objPage;

		$this->Template->galleries = '';
		$this->Template->referer = 'javascript:history.go(-1)';
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];

		$time = time();

		// Get gallery item
		$objGallery = $this->Database->prepare("SELECT *, author AS authorId, artist AS artistId, (SELECT title FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS archive, (SELECT jumpTo FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE tl_user.id=tl_gallery.author) AS author, (SELECT CONCAT(firstname, ' ', lastname) FROM tl_member WHERE tl_member.id=tl_gallery.artist) AS artist FROM tl_gallery WHERE pid IN (" . implode(',', array_map('intval', $this->gallery_archives)) . ")" . ($this->gallery_featured ? " AND featured=1" : "") . " AND (id=? OR alias=?)" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : ""))
									 ->limit(1)
									 ->execute((is_numeric($this->Input->get('items')) ? $this->Input->get('items') : 0), $this->Input->get('items'), $time, $time);

		if ($objGallery->numRows < 1)
		{

			$this->Template->galleries = '<p class="error">' . sprintf($GLOBALS['TL_LANG']['MSC']['invalidPage'], $this->Input->get('items')) . '</p>';

			// Do not index the page
			$objPage->noSearch = 1;
			$objPage->cache = 0;

			// Send 404 header
			header('HTTP/1.0 404 Not Found');
			return;
		}
		
		$arrGalleries = $this->parseGalleries($objGallery);
		$this->Template->galleries = $arrGalleries[0];

		// Overwrite page title
		if (strlen($objGallery->title))
		{
			$objPage->pageTitle = $objGallery->title;
		}	

		// Overwrite the page description
		if ($objGallery->description != '')
		{
			$objPage->description = $this->prepareMetaDescription($objGallery->description);
		}

		// HOOK: comments extension required
		if ($objGallery->noComments || !in_array('comments', $this->Config->getActiveModules()))
		{
			$this->Template->allowComments = false;
			return;
		}

		// Check whether comments are allowed
		$objArchive = $this->Database->prepare("SELECT * FROM tl_gallery_archive WHERE id=?")
									 ->limit(1)
									 ->execute($objGallery->pid);

		if ($objArchive->numRows < 1 || !$objArchive->allowComments)
		{
			$this->Template->allowComments = false;
			return;
		}

		$this->Template->allowComments = true;

		$this->import('Comments');
		$arrNotifies = array();

		// Notify system administrator
		if ($objArchive->notify != 'notify_author')
		{
			$arrNotifies[] = $GLOBALS['TL_ADMIN_EMAIL'];
		}

		// Notify author
		if ($objArchive->notify != 'notify_admin')
		{
			$objAuthor = $this->Database->prepare("SELECT email FROM tl_user WHERE id=?")
										->limit(1)
										->execute($objGallery->authorId);

			if ($objAuthor->numRows)
			{
				$arrNotifies[] = $objAuthor->email;
			}
		}

		$objConfig = new stdClass();

		$objConfig->perPage = $objArchive->perPage;
		$objConfig->order = $objArchive->sortOrder;
		$objConfig->template = $objArchive->template;
		$objConfig->requireLogin = $objArchive->requireLogin;
		$objConfig->disableCaptcha = $objArchive->disableCaptcha;
		$objConfig->bbcode = $objArchive->bbcode;
		$objConfig->moderate = $objArchive->moderate;

		$this->Comments->addCommentsToTemplate($this->Template, $objConfig, 'tl_gallery', $objGallery->id, $arrNotifies);

	}
	
	
		
}

?>