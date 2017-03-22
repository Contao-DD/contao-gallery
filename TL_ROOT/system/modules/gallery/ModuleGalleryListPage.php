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
 * Class ModuleGalleryListPage
 *
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Controller
 */
class ModuleGalleryListPage extends ModuleGallery
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_gallerylistpage';

	/**
	 * Archives
	 * @var string
	 */
	protected $arrArchives = array();


	public function generate()
	{
		global $objPage;

		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### GALLERY LIST PAGE-LINKED ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;

			return $objTemplate->parse();
		}

		$objArchive = $this->Database->prepare("SELECT * FROM tl_gallery_archive WHERE pgFilter=?")
																->execute($objPage->id);
																
		// setup default sorting if set 
		if ($this->gallery_sort == 'default' && $objArchive->numRows && strlen($objArchive->sortmode))
		{
			$this->gallery_sort = $objArchive->sortmode;
		}
		else
		{
			$this->gallery_sort = $this->gallery_sort ? $this->gallery_sort : 'date';
		}
		
		// setup page filter
		$arrArchives = array();
		$objArchive->reset();
		while ($objArchive->next())
		{
			$arrArchives[] = $objArchive->id;
		}
		$this->gallery_archives = $this->sortOutProtected($arrArchives);

		// Return if there are no collections
		if (!is_array($this->gallery_archives) || count($this->gallery_archives) < 1)
		{
			return '';
		}

		$this->arrArchives = $objArchive->fetchAllAssoc();

		// prepare conditions filter
		$this->gallery_conditions = deserialize($this->gallery_conditions, true);

		// prepare field filters
		$this->gallery_filters = deserialize($this->gallery_filters, true);

		// for getting filter options
		$this->loadLanguageFile('tl_gallery');
		$this->loadDataContainer('tl_gallery');

		return parent::generate();
	}


	/**
	 * Return if there are no files
	 * @return string
	 */
	protected function compile()
	{

		global $objPage;

		$time = time();
		$skipFirst = intval($this->skipFirst);
		$offset = 0;
		$limit = null;


		// setup filter conditions
		$strCondition = '';
		$arrConditions = array();
		if (is_array($this->gallery_conditions))
		{
			foreach ($this->gallery_conditions as $condition)
			{
				list($k, $v) = explode('::', $condition);
				$arrConditions[$k][] = $v;
			}
		}

		// setup filter options for list
		$arrFilter = array();
		foreach ($GLOBALS['TL_DCA']['tl_gallery']['fields'] as $k=>$v)
		{
			if (in_array($k, $this->gallery_filters) && $v['eval']['feFilter'])
			{
				$options = array();
				// launch the options_callback
				if (is_array($v['options_callback']))
				{
					$callback = $v['options_callback'];
					$this->import($callback[0]);
					$options = $this->$callback[0]->$callback[1]($this);
					$ref = false;
				}
				else
				{
					$options = $v['options'];
					$ref = true;
				}
				if (is_array($options) && count($options)) 
				{
					$arrFilter[$k]['label'] = $v['label'][0];
					$arrFilter[$k]['options']['all'] = array(
						'label' => $GLOBALS['TL_LANG']['MSC']['filterAll'],
						'href'	=> strlen($this->Input->get($k)) ? $this->addToUrl("&$k=&page=") : '',
						'class'	=> !strlen($this->Input->get($k)) ? 'active' : ''
					);
					foreach ($options as $kk=>$vv)
					{
						if (is_array($arrConditions[$k]) && in_array($vv, $arrConditions[$k]))
								continue;
						$key = $ref ? $vv : $kk;

						$arrFilter[$k]['options'][$key] = array(
							'label' => $ref ? $v['reference'][$vv] : $vv,
							'href' => $this->Input->get($k) != $key ? $this->addToUrl("&$k=$key&page="): ''
						);

						if ($this->Input->get($k) == $key)
						{
							$arrFilter[$k]['class'] = 'active';
							$arrFilter[$k]['options'][$key]['class'] = 'active';
							$arrConditions[$k][] = $key;
						}
					}
				}
			}
		}

		foreach ($arrConditions as $k=>$v)
		{
			if (is_array($v) && count($v))
			{
				array_unique($v);
				$num = is_numeric($v[0]);
				$strCondition .= (strlen($strCondition) ? " AND " : "") . $k . " IN (" . (!$num ? "'" : "") . implode((!$num ? "'" : ""). ','.(!$num ? "'" : ""), $v) . (!$num ? "'" : "") . ")";
			}
		}

		// Maximum number of items
		if ($this->gallery_numberOfItems > 0)
		{
			$limit = $this->gallery_numberOfItems;
		}

		switch ($this->gallery_sort)
		{
			case 'date':
			case 'date_desc':
				$strSort = 'date desc, title';
				break;

			case 'date_asc':
				$strSort = 'date, title';
				break;
				
			case 'random':
				$strSort = 'RAND()';
				break;
			
			case 'title':
			case 'sorting':
			default:
				$strSort = $this->gallery_sort;

		}

		// Split pages
		if ($this->perPage > 0)
		{
			
			// Get total number of items
			$objTotalStmt = $this->Database->prepare("SELECT id AS count FROM tl_gallery WHERE pid IN (" . implode(',', array_map('intval', $this->gallery_archives)) . ")" . ($this->gallery_featured ? " AND featured=1" : "") . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . (strlen($strCondition) ? " AND " . $strCondition : "") . " ORDER BY " . $strSort);

			if (!is_null($limit))
			{
				$objTotalStmt->limit($limit);
			}

			$objTotal = $objTotalStmt->execute(1);
			$total = $objTotal->numRows;

			// Get the current page
			$page = $this->Input->get('page') ? $this->Input->get('page') : 1;

			if ($page > ($total/$this->perPage))
			{
				$page = ceil($total/$this->perPage);
			}

			// Set limit and offset
			$limit = ((is_null($limit) || $this->perPage < $limit) ? $this->perPage : $limit);
			$offset = ((($page > 1) ? $page : 1) - 1) * $this->perPage;

			// Add pagination menu
			$objPagination = new Pagination($total, $this->perPage);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		$objGalleryStmt = $this->Database->prepare("SELECT *, author AS authorId, artist AS artistId, (SELECT sortBy FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS parentSortBy, (SELECT title FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS archive, (SELECT jumpTo FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE tl_user.id=tl_gallery.author) AS author, (SELECT CONCAT(firstname, ' ', lastname) FROM tl_member WHERE tl_member.id=tl_gallery.artist) AS artist FROM tl_gallery WHERE pid IN (" . implode(',', array_map('intval', $this->gallery_archives)) . ")" . ($this->gallery_featured ? " AND featured=1" : "") . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . (strlen($strCondition) ? " AND " . $strCondition : "") . " ORDER BY ".$strSort);

		// Limit result
		if ($limit)
		{
			$objGalleryStmt->limit($limit, $offset);
		}

		$objGalleries = $objGalleryStmt->execute();

		$this->Template->searchable = $this->searchable;
		$this->Template->arrFilter = $arrFilter;
		$this->Template->galleries = $this->parseGalleries($objGalleries);
		$this->Template->archives = $this->gallery_archives;
		$this->Template->arrArchives = $this->arrArchives;

		// Overwrite the page description
		if ($this->arrArchives[0]['description'] != '')
		{
			$objPage->description = $this->prepareMetaDescription($this->arrArchives[0]['description']);
		}

	}
}

?>