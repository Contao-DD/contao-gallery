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
 * Class ModuleGallery 
 *
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Controller
 */
abstract class ModuleGallery extends Module
{

	/**
	 * URL cache array
	 * @var array
	 */
	private static $arrUrlCache = array();


	/**
	 * Sort out protected archives
	 * @param array
	 * @return array
	 */
	protected function sortOutProtected($arrArchives)
	{
		if (BE_USER_LOGGED_IN || !is_array($arrArchives) || count($arrArchives) < 1)
		{
			return $arrArchives;
		}

		$this->import('FrontendUser', 'User');
		$objArchive = $this->Database->execute("SELECT id, protected, groups FROM tl_gallery_archive WHERE id IN(" . implode(',', array_map('intval', $arrArchives)) . ")");
		$arrArchives = array();

		while ($objArchive->next())
		{
			if ($objArchive->protected)
			{
				if (!FE_USER_LOGGED_IN)
				{
					continue;
				}

				$groups = deserialize($objArchive->groups);

				if (!is_array($groups) || count($groups) < 1 || count(array_intersect($groups, $this->User->groups)) < 1)
				{
					continue;
				}
			}

			$arrArchives[] = $objArchive->id;
		}

		return $arrArchives;
	}




	/**
	 * Template
	 * @var string
	 */
	/**
	 * Parse one or more items and return them as array
	 * @param object
	 * @param boolean
	 * @return array
	 */
	protected function parseGalleries(Database_Result $objGalleries)
	{
		if ($objGalleries->numRows < 1)
		{
			return array();
		}

		$this->import('String');

		$arrGalleries = array();
		$limit = $objGalleries->numRows;
		$count = 0;

		$objGalleries->reset();
		while ($objGalleries->next())
		{

			// Setup template
			$strTemplate = $this->gallery_template ? $this->gallery_template : 'gal_default';
			$objTemplate = (TL_MODE == 'BE') 
												? new BackendTemplate($this->rssMode ? 'be_galleryrss' : 'be_galleryimages')
												: new FrontendTemplate($strTemplate);

			$objTemplate->setData($objGalleries->row());

			$objTemplate->count = ++$count;
			$objTemplate->class = (strlen($objGalleries->cssClass) ? ' ' . $objGalleries->cssClass : '') . (($count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even');

      // Add Metadata
      $arrMetafields = $this->getMetaFields($objGalleries);
      $objTemplate->hasMetaFields = count($arrMetafields) ? true : false;
 			$objTemplate->metaFields = $arrMetafields;
 			$objTemplate->date = $arrMetafields['date']; // override default date display
			$objTemplate->timestamp = $objGalleries->date;

			// Add links
			if ($this instanceof ModuleGalleryList || $this instanceof ModuleGalleryListPage) 
			{
				$objTemplate->linkTitle = $this->generateLink($objGalleries->title, $objGalleries, $blnAddArchive);
				$objTemplate->more = $this->generateLink($GLOBALS['TL_LANG']['MSC']['more'], $objGalleries, $blnAddArchive);
				$objTemplate->link = $this->generateGalleryUrl($objGalleries, $blnAddArchive);
				$objTemplate->archive = $objGalleries->archive;
			}

			
			// Add poster image
			$chksize = deserialize($this->gallery_posterSize);
			if ($chksize[0] > 0 || $chksize[1] > 0)
			{
					$size = $this->gallery_posterSize;
					$fullsize = $this->gallery_posterFullsize;
			}
			else
			{
				$size = $objGalleries->posterSize;
				$fullsize = $objGalleries->posterFullsize;
			}

			$objTemplate->addImage = true;

			if (is_file(TL_ROOT . '/' . $objGalleries->singleSRC))
			{
				if ($size)
				{
					$objGalleries->size = $size;
					$objGalleries->alt = $objGalleries->title;
					if (!$fullsize && ($this instanceof ModuleGalleryList || $this instanceof ModuleGalleryListPage))
					{ 
						$objGalleries->imageUrl = $this->generateGalleryUrl($objGalleries, $blnAddArchive);
					}
					$objGalleries->fullsize = $fullsize;

				}

				$this->addImageToTemplate($objTemplate, $objGalleries->row());
			}

			// Add gallery
			$body = array();
			if (TL_MODE == 'BE' || (TL_MODE == 'FE' && $this->gallery_showPreview))
			{

				$images = array();
				$auxName = array();
				$auxDate = array();
	
				$objGalleries->multiSRC = deserialize($objGalleries->multiSRC, true);
				// required for parseMetaFile function (in FrontEnd)
				$this->multiSRC = $objGalleries->multiSRC;
		
				// Get all images
				foreach ($objGalleries->multiSRC as $file)
				{
					if (!is_dir(TL_ROOT . '/' . $file) && !file_exists(TL_ROOT . '/' . $file) || array_key_exists($file, $images))
					{
						continue;
					}

					// Single files
					if (is_file(TL_ROOT . '/' . $file))
					{

						$objFile = new File($file);
						$this->parseMetaFile(dirname($file), true);
						$arrMeta = $this->arrMeta[$objFile->basename];
		
						if ($arrMeta[0] == '')
						{
							$arrMeta[0] = str_replace('_', ' ', preg_replace('/^[0-9]+_/', '', $objFile->filename));
						}
		
						if ($objFile->isGdImage)
						{
							$images[$file] = array
							(
								'name' => $objFile->basename,
								'singleSRC' => $file,
								'alt' => $arrMeta[0],
								'imageUrl' => $arrMeta[1],
								'caption' => $arrMeta[2]
							);
		
							$auxDate[] = $objFile->mtime;
						}
		
						continue;

					}


					$subfiles = scan(TL_ROOT . '/' . $file);
					$this->arrAux = array();
					$this->parseMetaFile($file);

					// Folders
					foreach ($subfiles as $subfile)
					{
						if (is_dir(TL_ROOT . '/' . $file . '/' . $subfile))
						{
							continue;
						}
		
						$objFile = new File($file . '/' . $subfile);
		
						if ($objFile->isGdImage)
						{
							$arrMeta = $this->arrMeta[$subfile];
		
							if ($arrMeta[0] == '')
							{
								$arrMeta[0] = str_replace('_', ' ', preg_replace('/^[0-9]+_/', '', $objFile->filename));
							}
		
							$images[$file . '/' . $subfile] = array
							(
								'name' => $objFile->basename,
								'singleSRC' => $file . '/' . $subfile,
								'alt' => $arrMeta[0],
								'imageUrl' => $arrMeta[1],
								'caption' => $arrMeta[2]
							);
		
							$auxDate[] = $objFile->mtime;
						}
					}
				}
		
				// Get sorting mode, module override or gallery
				$sortBy = $this->gallery_sortBy ? $this->gallery_sortBy : $objGalleries->sortBy;

				// Sort array
				switch ($sortBy)
				{
					default:
					case 'name_asc':
						uksort($images, 'basename_natcasecmp');
						break;
		
					case 'name_desc':
						uksort($images, 'basename_natcasercmp');
						break;
		
					case 'date_asc':
						array_multisort($images, SORT_NUMERIC, $auxDate, SORT_ASC);
						break;
		
					case 'date_desc':
						array_multisort($images, SORT_NUMERIC, $auxDate, SORT_DESC);
						break;
		
					case 'meta':
						$arrImages = array();
						foreach ($this->arrAux as $k)
						{
							if (strlen($k))
							{
								$arrImages[] = $images[$k];
							}
						}
						$images = $arrImages;
						break;
		
					case 'random':
						shuffle($images);
						break;
				}
		
				$images = array_values($images);
				$total = count($images);
				$limit = $total;
				$offset = 0;
	
				// Get gallery size, module override or gallery
				$chksize = deserialize($this->gallery_size);
				$fullsize = 0;
				if ($chksize[0] > 0 || $chksize[1] > 0)
				{
					$size = $this->gallery_size;
					$fullsize = $this->gallery_fullsize;
					$limit = $this->gallery_numberOfImages ? $this->gallery_numberOfImages : $limit;
				}
				else
				{
					$size = deserialize($objGalleries->size);
					$fullsize = $objGalleries->fullsize;
				}

				$perRow = $this->gallery_perRow ? $this->gallery_perRow : $objGalleries->perRow;
				$perPage = $this->gallery_perPage ? $this->gallery_perPage  : $objGalleries->perPage;

				// Get gallery margin, module override or gallery
				if (strlen($this->gallery_imagemargin))
				{
					$chkmargin = deserialize($this->gallery_imagemargin);

					if ($chkmargin['top'] > 0 || $chkmargin['right'] > 0 || $chkmargin['bottom'] > 0 || $chkmargin['left'] > 0)
					{
						$imagemargin = $this->gallery_imagemargin;
					}
				}
				else
				{
					$imagemargin = $objGalleries->imagemargin;
				}

				// Pagination
				$strPage = 'pagegal_'.$objGalleries->id;
				if ($perPage > 0 && !$blnShowPreview)
				{
					$page = $this->Input->get($strPage) ? $this->Input->get($strPage) : 1;
					$offset = ($page - 1) * $perPage;
					$limit = min($perPage + $offset, $total);
		
					$objPagination = new PaginationCustom($total, $perPage, $strPage);
					$objTemplate->pagination = $objPagination->generate("\n  ");
				}
		
				$rowcount = 0;
				$colwidth = floor(100/$perRow);
				$intMaxWidth = (TL_MODE == 'BE') ? floor((320 / $perRow)) : floor(($GLOBALS['TL_CONFIG']['maxImageWidth'] / $perRow));
				$strLightboxId = 'lightbox[lb' . $objGalleries->id . ']';
				$body = array();
					
				// Rows
				for ($i=$offset; $i<$limit; $i=($i+$perRow))
				{
					$class_tr = '';
		
					if ($rowcount == 0)
					{
						$class_tr = ' row_first';
					}
		
					if (($i + $perRow) >= count($images))
					{
						$class_tr = ' row_last';
					}
		
					$class_eo = (($rowcount % 2) == 0) ? ' even' : ' odd';
		
					// Columns
					for ($j=0; $j<$perRow; $j++)
					{
						$class_td = '';
		
						if ($j == 0)
						{
							$class_td = ' col_first';
						}
		
						if ($j == ($perRow - 1))
						{
							$class_td = ' col_last';
						}
		
						$objCell = new stdClass();
						$key = 'row_' . $rowcount . $class_tr . $class_eo;
		
						// Empty cell
						if (!is_array($images[($i+$j)]) || ($j+$i) >= $limit)
						{
							$objCell->class = 'col_'.$j . $class_td;
							$body[$key][$j] = $objCell;
		
							continue;
						}

						// Add size and margin
						$images[($i+$j)]['size'] = $size;
						$images[($i+$j)]['imagemargin'] = $imagemargin;
						$images[($i+$j)]['fullsize'] = $fullsize;
		
						$this->addImageToTemplate($objCell, $images[($i+$j)], $intMaxWidth, $strLightboxId);
		
						// Add column width and class
						$objCell->colWidth = $colwidth . '%';
						$objCell->class = 'col_'.$j . $class_td;
		
						$body[$key][$j] = $objCell;
					}
		
					++$rowcount;
					
					// BE mode only shows first line of images
					if (TL_MODE == 'BE')
						break;
				}

			} // gallery processing
			
			// add gallery
			$objTemplate->body = $body;	

			// add total metadata
			$objTemplate->total = $arrMetafields['qty'] ? $total : '';
			$objTemplate->qty = $arrMetafields['qty'] ? sprintf($GLOBALS['TL_LANG']['MSC']['imageQty'], $total) : '';

			$arrGalleries[] = $objTemplate->parse();
		}


		return $arrGalleries;
	}

	
  /**
   * Return the meta fields of a gallery as array
   * @param object
   * @return array
   */
  protected function getMetaFields(Database_Result $objGallery)
  {
    $meta = deserialize($this->gallery_metaFields);

    if (!is_array($meta))
    {
      return array();
    }

		$this->loadLanguageFile('tl_gallery');

    $return = array();
    foreach ($meta as $field)
    {
      switch ($field)
      {
        case 'qty':
					$return['qty'] = 1;
          break;

        case 'date':
					$return['date'] = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objGallery->date);
          break;

				case 'author':
					$return['author'] = strlen($objGallery->author) ? $GLOBALS['TL_LANG']['MSC']['by'] . ' ' . $objGallery->author : '';
					break;

        case 'location':
          $return['location'] = $objGallery->location;
          break;

        case 'status':
          $return['status'] = $GLOBALS['TL_LANG']['tl_gallery'][$objGallery->status];
          break;

        case 'artist':
          $return['artistBy'] = strlen($objGallery->artist) ? sprintf($GLOBALS['TL_LANG']['MSC']['byGallery'], $objGallery->artist) : '';
          $return['artist'] = strlen($objGallery->artist) ? $objGallery->artist : '';
          break;

        case 'artsize':
        	$artsize = deserialize($objGallery->artsize);
          $return['artsize'] = (strlen($artsize[0]) && strlen($artsize[1])) ? sprintf($GLOBALS['TL_LANG']['MSC']['artsize'], $artsize[0], $artsize[1], $artsize[2]) : '';
          break;

        case 'medium':
          $return['medium'] = $GLOBALS['TL_LANG']['tl_gallery'][$objGallery->medium];
          break;

        case 'substrate':
          $return['substrate'] = $GLOBALS['TL_LANG']['tl_gallery'][$objGallery->substrate];
          break;

				case 'comments':
					$objComments = $this->Database->prepare("SELECT COUNT(*) AS total FROM tl_comments WHERE source='tl_gallery' AND parent=?" . (!BE_USER_LOGGED_IN ? " AND published=1" : ""))
												  ->execute($objGallery->id);

					if ($objComments->numRows)
					{
						$return['ccount'] = $objComments->total;
						$return['comments'] = sprintf($GLOBALS['TL_LANG']['MSC']['commentCount'], $objComments->total);
					}
					break;

      }
    }

    return $return;
  }


	private function generateGalleryUrl(Database_Result $objGallery, $blnAddArchive=false)
	{

		// Get internal page
		$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
							 	  ->limit(1)
								  ->execute($objGallery->parentJumpTo);

		if ($objPage->numRows < 1)
		{
			return ampersand($this->Environment->request, ENCODE_AMPERSANDS);
		}

		// Link to galleryviewer
		return ampersand($this->generateFrontendUrl($objPage->fetchAssoc(), '/items/' . ((strlen($objGallery->alias) && !$GLOBALS['TL_CONFIG']['disableAlias']) ? $objGallery->alias : $objGallery->id)));

	}


	/**
	 * Generate a link and return it as string
	 * @param string
	 * @param object
	 * @param boolean
	 * @return string
	 */
	private function generateLink($strLink, Database_Result $objGallery, $blnAddArchive=false)
	{
		return sprintf('<a href="%s" title="%s">%s</a>',
						$this->generateGalleryUrl($objGallery, $blnAddArchive),
						$GLOBALS['TL_LANG']['MSC']['viewGallery'],
						$strLink);
	}

}

?>