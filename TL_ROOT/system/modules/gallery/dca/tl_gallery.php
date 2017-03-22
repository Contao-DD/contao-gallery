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
 * Table tl_gallery 
 */
$GLOBALS['TL_DCA']['tl_gallery'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_gallery_archive',
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_gallery', 'checkPermission'),
			array('tl_gallery', 'setSortmode'),
			array('tl_gallery', 'generateFeed'),
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('date DESC'),
			'flag'                    => 8,
			'headerFields'            => array('title', 'sortmode', 'jumpTo', 'tstamp', 'allowComments'), // ptable
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_gallery', 'listGallery')
		),
		'label' => array
		(
			'fields'                  => array('title', 'date'),
			'format'                  => '%s (%s)'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['copy'],
				'href'                => 'act=paste&mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['cut'],
				'href'                => 'act=paste&mode=cut',
				'icon'                => 'cut.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_gallery', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_gallery']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                   => '{title_legend},title,alias,author,location,status,date,artist,artsize,medium,substrate,description;{poster_legend},singleSRC,posterSize,posterFullsize;{gallery_legend:hide},multiSRC,size,imagemargin,perRow,perPage,sortBy,fullsize;{expert_legend:hide},cssClass,noComments,featured;{publish_legend:hide},published,start,stop'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'long')
		),		
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_gallery', 'generateAlias')
			)
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['author'],
			'default'                 => $this->User->id,
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'findInSet'=>true, 'tl_class'=>'w50')
		),
		'location' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['location'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array( 'maxlength'=>255, 'tl_class'=>'long')
		),		
		'artist' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['artist'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback' 				=> array('tl_gallery', 'getArtists'),
			'eval'                    => array('includeBlankOption'=>true, 'findInSet'=>true, 'feFilter'=>true, 'tl_class'=>'w50')
		),		
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['status'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'filter'                  => true,
			'options'                 => array('avail','sold','resv'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_gallery'],
			'eval'                    => array('includeBlankOption'=>true, 'feFilter'=>true, 'tl_class'=>'w50')
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['date'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'flag'               			=> 8,
			'eval'                    => array('maxlength'=>10, 'rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'artsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['artsize'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('cm','mm','in','px'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_gallery', 'limitImageWidth')
			)
		),
		'medium' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['medium'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'filter'                  => true,
			'options'                 => array('oil', 'acr', 'ola', 'mpt', 'cpt'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_gallery'],
			'eval'                    => array('maxlength'=>255, 'includeBlankOption'=>true, 'feFilter'=>true, 'tl_class'=>'w50')
		),		
		'substrate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['substrate'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'select',
			'filter'                  => true,
			'options'                 => array('cvs','ppr','pho','vnl','brd','fab'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_gallery'],
			'eval'                    => array('maxlength'=>255, 'includeBlankOption'=>true, 'feFilter'=>true, 'tl_class'=>'w50')
		),		
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions' => 'jpg,jpeg,gif,png,tif,tiff', 'mandatory'=>true, 'tl_class'=>'clr')
		),
		'posterSize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['posterSize'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'search'                  => true,
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_gallery', 'limitImageWidth')
			)
		),
		'posterFullsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['posterFullsize'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'multiSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['multiSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'checkbox', 'files'=>true, 'extensions' => 'jpg,jpeg,gif,png,tif,tiff', 'tl_class'=>'clr')
		),		
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'search'                  => true,
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_gallery', 'limitImageWidth')
			)
		),
		'imagemargin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['imagemargin'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'perRow' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['perRow'],
			'default'                 => 4,
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
			'eval'                    => array('tl_class'=>'w50')
		),
		'perPage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['perPage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
		),
		'sortBy' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['sortBy'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('name_asc', 'name_desc', 'date_asc', 'date_desc', 'meta', 'random'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_gallery'],
			'eval'                    => array('tl_class'=>'w50')
		),

		'fullsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['fullsize'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'cssClass' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['cssClass'],
			'exclude'                 => true,
			'inputType'               => 'text',
		),
		'noComments' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['noComments'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'featured' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['featured'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_gallery']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		)

		
	)
);


/**
 * Class tl_gallery
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Gallery 
 */
class tl_gallery extends Backend
{

	/**
	 * Cache the Artists list
	 */

	public $arrArtists = null;

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Check permissions to edit table tl_gallery
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			$key = array_search('allowComments', $GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['headerFields']);
			unset($GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['headerFields'][$key]);
		}

		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->galleries) || count($this->User->galleries) < 1)
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->galleries;
		}

		$id = strlen($this->Input->get('id')) ? $this->Input->get('id') : CURRENT_ID;

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen($this->Input->get('pid')) || !in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to create gallery items in gallery collection ID "'.$this->Input->get('pid').'"', 'tl_gallery checkPermission', TL_ERROR);
					$this->redirect('typolight/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				// manual sorting mode 1, has PID=ID of child
				// date sorting mode 2, has PID=PID of parent
				$pid = ($this->Input->get('mode') == '2') ? $this->Input->get('pid') : CURRENT_ID;

				if (!in_array($pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' gallery item ID "'.$id.'" to gallery collection ID "'.$pid.'"', 'tl_gallery checkPermission', TL_ERROR);
					$this->redirect('typolight/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
				$objArchive = $this->Database->prepare("SELECT pid FROM tl_gallery WHERE id=?")
											 ->limit(1)
											 ->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid gallery item ID "'.$id.'"', 'tl_gallery checkPermission', TL_ERROR);
					$this->redirect('typolight/main.php?act=error');
				}

				if (!in_array($objArchive->pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' gallery item ID "'.$id.'" of gallery collection ID "'.$objArchive->pid.'"', 'tl_gallery checkPermission', TL_ERROR);
					$this->redirect('typolight/main.php?act=error');
				}
				break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access gallery collection ID "'.$id.'"', 'tl_gallery checkPermission', 5);
					$this->redirect('typolight/main.php?act=error');
				}

				$objArchive = $this->Database->prepare("SELECT id FROM tl_gallery WHERE pid=?")
											 ->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid gallery collection ID "'.$id.'"', 'tl_gallery checkPermission', 5);
					$this->redirect('typolight/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Invalid command "'.$this->Input->get('act').'"', 'tl_gallery checkPermission', 5);
					$this->redirect('typolight/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access gallery collection ID "'.$id.'"', 'tl_gallery checkPermission', 5);
					$this->redirect('typolight/main.php?act=error');
				}
				break;
		}
	}

	/**
	 * Set sortmode from collection
	 * @param object
	 */
	public function setSortmode(DataContainer $dc)
	{
		$pid = $this->activeRecord->id ? $this->activeRecord->pid : CURRENT_ID;

		$objArchive = $this->Database->prepare("SELECT sortmode FROM tl_gallery_archive WHERE id=?")
				->execute($pid);

		if ($objArchive->numRows)
		{
			switch ($objArchive->sortmode)
			{
				case 'sorting':
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['fields'] = array('sorting');
					unset($GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['flag']);
					break;

				case 'date_asc':
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['fields'] = array('date', 'title');
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['flag'] = 8;
					break;

				case 'title':
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['fields'] = array('title');
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['flag'] = 11;
					break;

				case 'date_desc':
				default:
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['fields'] = array('date DESC', 'title');
					$GLOBALS['TL_DCA']['tl_gallery']['list']['sorting']['flag'] = 8;
			
			}
		
		}

	}


	/**
	 * Autogenerate a gallery alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{

		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_gallery WHERE alias=?")
								   ->execute($varValue);

		// Check whether the gallery alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;

	}



	/**
	 * Construct member list using firstname, lastname or company (if empty)
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function getArtists($id=null)
	{
		$id = CURRENT_ID;

		$objMemberGroups = $this->Database->prepare("SELECT artgroups FROM tl_gallery_archive WHERE id=?")
				->execute($id);

		if ($objMemberGroups->numRows && $objMemberGroups->artgroups)
		{
			$arrMemberGroups = deserialize($objMemberGroups->artgroups);
		}
		else
		{
			return array();
		}


		// get members and add them to the list
		$objMembers = $this->Database->prepare("SELECT * FROM tl_member")
				->execute();
		
		$arrMembers = array();
		while ($objMembers->next())
		{
			$groups = deserialize($objMembers->groups, true);
			foreach ($groups as $group)
			{
				if (in_array($group, $arrMemberGroups))
				{
					$arrMembers[$objMembers->id] = $objMembers->firstname . ' ' . $objMembers->lastname;
				}
			}
		}

		return $arrMembers;
	}



	/**
	 * Calculate the maximum image width and adjust the current width if necessary
	 * @param mixed
	 * @param object
	 * @return mixed
	 */
	public function limitImageWidth($varValue, DataContainer $dc)
	{
		if (!strlen($GLOBALS['TL_CONFIG']['maxImageWidth']) || $GLOBALS['TL_CONFIG']['maxImageWidth'] < 1)
		{
			return $varValue;
		}

		$arrValue = deserialize($varValue);
		$intMaxWidth = intval($GLOBALS['TL_CONFIG']['maxImageWidth']);

		$objGallery = $this->Database->prepare("SELECT perRow, imagemargin FROM tl_gallery WHERE id=?")
								  ->limit(1)
								  ->execute($dc->id);

		// Calculate image width if it is an image gallery
		if ($objGallery->numRows)
		{
			$arrMargin = deserialize($objGallery->imagemargin);
			if ($arrMargin['unit'] == 'px')
			{
				$intMaxWidth = $intMaxWidth - ($objGallery->perRow * ($arrMargin['left'] + $arrMargin['right']));
			}
			$intMaxWidth = floor($intMaxWidth / $objGallery->perRow);
		}

		// Adjust width if image is too wide
		if ($intMaxWidth > 0 && $arrValue[0] > $intMaxWidth)
		{
			$arrValue[0] = $intMaxWidth;
		}
		
		return serialize($arrValue);
	}

	/**
	 * Render the BE gallery
	 */
	public function getGalleryModule($intId)
	{
		$this->import('BEGallery');
		$this->BEGallery->galleryId = $intId;

		return $this->BEGallery->generate(); 
	}


	/**
	 * List record
	 * @param array
	 * @return string
	 */
	public function listGallery($arrRow)
	{
		$time = time();
		$key = ($arrRow['published'] && ($arrRow['start'] == '' || $arrRow['start'] < $time) && ($arrRow['stop'] == '' || $arrRow['stop'] > $time)) ? 'published' : 'unpublished';
		$date = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['date']);
		$image = $this->getImage($arrRow['singleSRC'], 100, 100, 'box');

		if (($imgSize = @getimagesize(TL_ROOT . '/' . $image)) !== false)
		{
			$size = ' ' . $imgSize[3];
		}

		$arrArtsize = deserialize($arrRow['artsize']);
		$artsize = (strlen($arrArtsize[0]) && strlen($arrArtsize[1]) && strlen($arrArtsize[2])) ? sprintf($GLOBALS['TL_LANG']['MSC']['artsize'], $arrArtsize[0], $arrArtsize[1], $arrArtsize[2]) : '';

		if (!is_array($this->arrArtists) || count($this->arrArtists) < 1)
		{
			// setup cache from options_callback, saves from DB calls
			$this->arrArtists = $this->getArtists(); 
		}
		$artist = $this->arrArtists[$arrRow['artist']];

		$featured = $arrRow['featured'] ? '<div class="icon">'.$this->generateImage('all.gif', $GLOBALS['TL_LANG']['tl_gallery']['featured'][0]).'</div>' : '';

		return '
<div class="cte_type ' . $key . '"><strong>' . $arrRow['title'] . '</strong> - ' . $date . '</div>
<div class="limit_height h64 block">
	<div class="singleSRC"><img src="' . $image .'" '. $size . ' /></div>
	<div class="info">
		<div class="artist">'.$artist.'</div>
		<div class="artsize">' . $artsize . '</div>
		<div class="status">'.$GLOBALS['TL_LANG']['tl_gallery'][$arrRow['status']].'</div>
		'.$featured.'
	</div>
	<div class="location"><em>'.$arrRow['location'].'</em></div>
'	. $arrRow['description'] 
	. $this->getGalleryModule($arrRow['id']) . '
</div>' . "\n";
	}



	/**
	 * Update the RSS-feed
	 */
	public function generateFeed()
	{
		$this->import('Gallery');
		$this->Gallery->generateFeed(CURRENT_ID);
	}



	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_gallery::published', 'alexf'))
		{
			return '';
		}

		$href .= '&tid='.$row['id'].'&state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}		

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_gallery::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish gallery item ID "'.$intId.'"', 'tl_gallery toggleVisibility', TL_ERROR);
			$this->redirect('typolight/main.php?act=error');
		}

		$this->createInitialVersion('tl_gallery', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_gallery']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_gallery']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_gallery SET published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_gallery', $intId);

		// Update the RSS feed (for some reason it does not work without sleep(1))
		sleep(1);
		$this->generateFeed();
	}

}


?>