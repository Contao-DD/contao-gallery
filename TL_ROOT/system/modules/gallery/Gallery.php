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
 * Class Gallery 
 *
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Gallery
 */
class Gallery extends Frontend
{


	/**
	 * Update a particular RSS feed
	 * @param integer
	 */
	public function generateFeed($intId)
	{
		$objArchive = $this->Database->prepare("SELECT * FROM tl_gallery_archive WHERE id=? AND makeFeed=?")
									 ->limit(1)
									 ->execute($intId, 1);

		if ($objArchive->numRows < 1)
		{
			return;
		}

		$objArchive->feedName = strlen($objArchive->alias) ? $objArchive->alias : 'news' . $objArchive->id;

		// Delete XML file
		if ($this->Input->get('act') == 'delete')
		{
			$this->import('Files');
			$this->Files->delete($objArchive->feedName . '.xml');
		}

		// Update XML file
		else
		{
			$this->generateFiles($objArchive->row());
			$this->log('Generated news feed "' . $objArchive->feedName . '.xml"', 'News generateFeed()', TL_CRON);
		}
	}


	/**
	 * Delete old files and generate all feeds
	 */
	public function generateFeeds()
	{
		$this->removeOldFeeds();
		$objArchive = $this->Database->execute("SELECT * FROM tl_gallery_archive WHERE makeFeed=1");

		while ($objArchive->next())
		{
			$objArchive->feedName = strlen($objArchive->alias) ? $objArchive->alias : 'gallery' . $objArchive->id;

			$this->generateFiles($objArchive->row());
			$this->log('Generated news feed "' . $objArchive->feedName . '.xml"', 'News generateFeeds()', TL_CRON);
		}
	}


	/**
	 * Generate an XML files and save them to the root directory
	 * @param array
	 */
	protected function generateFiles($arrArchive)
	{
		$time = time();
		$strType = ($arrArchive['format'] == 'atom') ? 'generateAtom' : 'generateRss';
		$strLink = strlen($arrArchive['feedBase']) ? $arrArchive['feedBase'] : $this->Environment->base;
		$strFile = $arrArchive['feedName'];

		$objFeed = new Feed($strFile);

		$objFeed->link = $strLink;
		$objFeed->title = $arrArchive['title'];
		$objFeed->description = $arrArchive['feeddescription'];
		$objFeed->language = $arrArchive['language'];
		$objFeed->published = $arrArchive['tstamp'];

		// Get items
		$objArticleStmt = $this->Database->prepare("SELECT *, (SELECT name FROM tl_user WHERE tl_user.id=tl_gallery.author) AS authorName FROM tl_gallery WHERE pid=? AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1 ORDER BY date DESC");

		if ($arrArchive['maxItems'] > 0)
		{
			$objArticleStmt->limit($arrArchive['maxItems']);
		}

		$objArticle = $objArticleStmt->execute($arrArchive['id']);

		// Get default URL
		$objParent = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
									->limit(1)
									->execute($arrArchive['jumpTo']);

		$strUrl = $this->generateFrontendUrl($objParent->fetchAssoc(), '/items/%s');

		// Parse items
		while ($objArticle->next())
		{
			$objItem = new FeedItem();

			$objItem->title = $objArticle->title;
			$objItem->link = $strLink . $this->getLink($objArticle, $strUrl);
			$objItem->published = $objArticle->date;
			$objItem->author = $objArticle->authorName;

			// Add the gallery
			$this->import('BEGallery');
			$this->BEGallery->galleryId = $objArticle->id;
			$this->BEGallery->rssMode = true;
			$gallery = $this->BEGallery->generate();
			
			$strDescription = $objArticle->description . $gallery;

			// Prepare the description
			$strDescription = $this->replaceInsertTags($strDescription);
			$objItem->description = $this->convertRelativeUrls($strDescription, $strLink);

			$objFeed->addItem($objItem);
		}

		// Create file
		$objRss = new File($strFile . '.xml');
		$objRss->write($this->replaceInsertTags($objFeed->$strType()));
		$objRss->close();
	}


	/**
	 * Add gallery newsfeed to the page
	 * @param array
	 * @param integer
	 * @return array
	 */
	public function addFeedsToLayout($objPage, $objLayout, $fe)
	{
		$galleryfeeds = deserialize($objLayout->galleryfeeds);

		// Add galleryfeeds
		if (is_array($galleryfeeds) && count($galleryfeeds) > 0)
		{
			$objFeeds = $this->Database->execute("SELECT * FROM tl_gallery_archive WHERE id IN(" . implode(',', array_map('intval', $galleryfeeds)) . ")");

			while($objFeeds->next())
			{
				$base = strlen($objFeeds->feedBase) ? $objFeeds->feedBase : $fe->Environment->base;
				$GLOBALS['TL_HEAD'][] = '<link rel="alternate" href="' . $base . $objFeeds->alias . '.xml" type="application/' . $objFeeds->format . '+xml" title="' . $objFeeds->title . '" />' . "\n";
			}
		}
	}

	/**
	 * Add gallery feed names to the protection array
	 * @return array
	 */
	public function removeOldFeeds($blnReturn=false)
	{

		$objArchives = $this->Database->prepare("SELECT id, alias FROM tl_gallery_archive WHERE makeFeed=1")
									  ->limit(1)
									  ->execute();

		if ($objArchives->numRows < 1)
		{
			return array();
		}
	
		$return = array();
		while ($objArchives->next())
		{
			$return[] = strlen($objArchives->alias) ? $objArchives->alias : 'gallery' . $objArchives->id;
		}

		$this->log('Protected gallery feeds ' . implode(', ', $return) . ' from deletion"', 'Gallery removeOldFeeds()', TL_CRON);

		return $return;
	}




	/**
	 * Add gallery items to the indexer
	 * @param array
	 * @param integer
	 * @return array
	 */
	public function getSearchablePages($arrPages, $intRoot=0)
	{

		$arrRoot = array();

		if ($intRoot > 0)
		{
			$arrRoot = $this->getChildRecords($intRoot, 'tl_page', true);
		}

		$time = time();
		$arrProcessed = array();

		// Get all gallery collections
		$objArchive = $this->Database->execute("SELECT id, jumpTo FROM tl_gallery_archive WHERE protected!=1");

		// Walk through each archive
		while ($objArchive->next())
		{

			if (is_array($arrRoot) && count($arrRoot) > 0 && !in_array($objArchive->jumpTo, $arrRoot))
			{
				continue;
			}

			if (!isset($arrProcessed[$objArchive->jumpTo]))
			{
				$arrProcessed[$objArchive->jumpTo] = false;

				// Get target page
				$objParent = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=? AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1 AND noSearch!=1")
											->limit(1)
											->execute($objArchive->jumpTo);

				// Determin domain
				if ($objParent->numRows)
				{
					$domain = $this->Environment->base;
					$objParent = $this->getPageDetails($objParent->id);

					if (strlen($objParent->domain))
					{
						$domain = ($this->Environment->ssl ? 'https://' : 'http://') . $objParent->domain . TL_PATH . '/';
					}

					$arrProcessed[$objArchive->jumpTo] = $domain . $this->generateFrontendUrl($objParent->row(), '/items/%s');
				}
			}

			// Skip items without target page
			if ($arrProcessed[$objArchive->jumpTo] === false)
			{
				continue;
			}

			$strUrl = $arrProcessed[$objArchive->jumpTo];

			// Get items
			$objGallery = $this->Database->prepare("SELECT * FROM tl_gallery WHERE pid=? AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1 ORDER BY date DESC")
										 ->execute($objArchive->id);

			// Add items to the indexer
			while ($objGallery->next())
			{
				$arrPages[] = $this->getLink($objGallery, $strUrl);
			}
		}

		return $arrPages;
	}


	/**
	 * Return the link of a gallery item
	 * @param object
	 * @param string
	 * @return string
	 */
	private function getLink(Database_Result $objGallery, $strUrl)
	{
		// return generated url
		return sprintf($strUrl, (strlen($objGallery->alias) && !$GLOBALS['TL_CONFIG']['disableAlias']) ? $objGallery->alias : $objGallery->id);
	}


	/**
	 * Add gallery title and url in comments lister
	 * @param array
	 * @return string
	 */
	public function listComments($arrRow)
	{
		if ($arrRow['source'] != 'tl_gallery')
		{
			return '';
		}
			
		$objParent = $this->Database->prepare("SELECT id, title FROM tl_gallery WHERE id=?")
									->execute($arrRow['parent']);

		if ($objParent->numRows)
		{
			return ' (<a href="typolight/main.php?do=gallery&table=tl_gallery&act=edit&id=' . $objParent->id . '">' . $objParent->title . '</a>)';
		}

	}


	/**
	 * Check whether the user is allowed to edit a comment 
	 * @param integer
	 * @param string
	 * @return boolean
	 */
	public function isAllowedToEditComment($intParent, $strSource)
	{
		if ($strSource != 'tl_gallery')
		{
			return false;
		}

		$this->import('BackendUser', 'User');

		// Check the access to the gallery module
		if ($this->User->hasAccess('gallery', 'modules'))
		{
			$objArchive = $this->Database->prepare("SELECT pid FROM tl_gallery WHERE id=?")
										 ->limit(1)
										 ->execute($intParent);

			// Check the access to the gallery archive
			if ($objArchive->numRows > 0 && $this->User->hasAccess($objArchive->pid, 'galleries'))
			{
				return true;
			}
		}
		
		return false;

	}


	/**
	 * Replace Gallery inserttags
	 * @param string
	 * @return string
	 */
	public function replaceGalleryInsertTags($strTag)
	{
		$elements = explode('::', $strTag);

		if (strtolower($elements[0]) == 'insert_gallery' && intval($elements[1]) && intval($elements[2]))
		{
			$intId = $elements[1];
			$modId = $elements[2];

			// Generate module
			$objModule = $this->Database->prepare("SELECT * FROM tl_module WHERE id=?")
										->limit(1)
										->execute($modId);

			if ($objModule->numRows)
			{
				$objModule = new ModuleGallerySingle($objModule);
				$objModule->gallery = $intId;
				$strBuffer = $objModule->generate();
	
				return $strBuffer;
			}
		}

		return false; //not for me
	}


}

?>