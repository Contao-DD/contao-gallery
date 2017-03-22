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
 * @copyright  Thyon Design 2010
 * @author     John Brand <john.brand@thyon.com>
 * @package    Gallery
 * @license    LGPL
 * @filesource
 */


/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['gallerylist']    = '{title_legend},name,headline,type;{config_legend},gallery_archives,gallery_numberOfItems,gallery_featured,perPage,skipFirst,gallery_sort;{filter_legend:hide},gallery_filters,gallery_conditions;{template_legend:hide},gallery_metaFields,gallery_template,gallery_posterSize,gallery_posterFullsize,gallery_showPreview;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['gallerylistpage']    = '{title_legend},name,headline,type;{config_legend},gallery_numberOfItems,gallery_featured,perPage,skipFirst,gallery_sort;{filter_legend:hide},gallery_filters,gallery_conditions;{template_legend:hide},gallery_metaFields,gallery_template,gallery_posterSize,gallery_posterFullsize,gallery_showPreview;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['galleryviewer']  = '{title_legend},name,headline,type;{config_legend},gallery_archives;{template_legend:hide},gallery_metaFields,gallery_template,gallery_posterSize,gallery_posterFullsize,gallery_showPreview;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['gallerysingle'] = '{title_legend},name,headline,type;{config_legend},gallery;{template_legend:hide},gallery_metaFields,gallery_template,gallery_posterSize,gallery_posterFullsize,gallery_showPreview;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Add the comments template drop-down menu
 */
if (in_array('comments', Config::getInstance()->getActiveModules()))
{
	$GLOBALS['TL_DCA']['tl_module']['palettes']['galleryviewer'] = str_replace('{protected_legend:hide}', '{comment_legend:hide},com_template;{protected_legend:hide}', $GLOBALS['TL_DCA']['tl_module']['palettes']['galleryviewer']);
}


$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'gallery_showPreview';
// Insert new Subpalettes after position 1
array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'], 1, array
	(
		'gallery_showPreview'	=> 'gallery_size,gallery_imagemargin,gallery_perRow,gallery_perPage,gallery_sortBy,gallery_fullsize,gallery_numberOfImages'
	)
);


/**
 * Modify fields of tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['fullsize']['eval']['tl_class'] = 'w50 m12';


/**
 * Add fields to tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_gallery', 'getGalleries'),
//	'foreignKey'              => 'tl_gallery.title',
	'reference'								=> &$GLOBALS['TL_LANG']['tl_module']['galleries'],
	'eval'                    => array('mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['galleries'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['galleries'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'foreignKey'              => 'tl_gallery_archive.title',
	'eval'                    => array('mandatory'=>true)
);


$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_archives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_archives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_gallery_archive.title',
	'eval'                    => array('multiple'=>true, 'mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_sort'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_sort'],
	'default'                 => 'date_desc',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('date_desc','date_asc','title','sorting','random'),
	'reference'								=> &$GLOBALS['TL_LANG']['tl_module']['gallery_sortval'],
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_filters'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_filters'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'				=> array('tl_module_gallery','getFilterFields'),
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_conditions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_conditions'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'				=> array('tl_module_gallery','getFilterOptions'),
	'eval'                    => array('multiple'=>true, 'size'=>36)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_numberOfItems'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_numberOfItems'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_featured'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_featured'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_metaFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_metaFields'],
	'default'                 => array('location', 'date', 'description'),
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('qty','comments','author','location','status','date','artist','artsize','medium','substrate'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['gallery_metaval'],
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_template'],
	'default'                 => 'gal_delault',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_gallery', 'getGalleryTemplates'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_posterSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_posterSize'],
	'inputType'               => 'imageSize',
	'options'                 => array('crop', 'proportional', 'box'),
	'search'                  => true,
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_posterFullsize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_posterFullsize'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12')
);


$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_showPreview'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_showPreview'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_imagemargin'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_imagemargin'],
	'exclude'                 => true,
	'inputType'               => 'trbl',
	'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_size'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_size'],
	'inputType'               => 'imageSize',
	'options'                 => array('crop', 'proportional', 'box'),
	'search'                  => true,
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_perRow'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_perRow'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
);


$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_perPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_perPage'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_sortBy'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_sortBy'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('name_asc', 'name_desc', 'date_asc', 'date_desc', 'meta', 'random'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['gallery_sortval'],
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_fullsize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_fullsize'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gallery_numberOfImages'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gallery_numberOfImages'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);


/**
 * Class tl_module_gallery
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    Gallery 
 */
 
class tl_module_gallery extends Backend
{

	/**
	 * Remove default sorting mode to edit table tl_gallery_archive
	 */
	public function removeSortOption($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->type == 'gallerylistpage')
		{
			array_unshift($GLOBALS['TL_DCA']['tl_module']['fields']['gallery_sort']['options'], 'default');
		}
	}




	/**
	 * Return all galleries as array
	 * @return array
	 */
	public function getGalleries()
	{

		$objGalleries = $this->Database->prepare("SELECT pid, id, title, (SELECT title FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS archive FROM tl_gallery")
									 ->execute();
			
		$groups = array();

		while ($objGalleries->next())		
		{
			$groups['archive_'.$objGalleries->pid][] = $objGalleries->id;
			$GLOBALS['TL_LANG']['tl_module']['galleries']['archive_'.$objGalleries->pid] = $objGalleries->archive;
			$GLOBALS['TL_LANG']['tl_module']['galleries'][$objGalleries->id] = $objGalleries->title;
		}

		return $groups;
	}




	/**
	 * Return all filter fields
	 * @return array
	 */
	public function getFilterFields()
	{
		$this->loadLanguageFile('tl_gallery');
		$this->loadDataContainer('tl_gallery');

		$arrReturn = array();
		foreach ($GLOBALS['TL_DCA']['tl_gallery']['fields'] as $k=>$v)
		{
			if ($v['eval']['feFilter'])
			{
				$arrReturn[$k] = $v['label'][0] ? $v['label'][0] : $k;
			}
		}

		return $arrReturn;
	}
	
	
	/**
	 * Return all filter fields and options as matrix checkbox
	 * @return array
	 */
	public function getFilterOptions()
	{
		$this->loadLanguageFile('tl_gallery');
		$this->loadDataContainer('tl_gallery');

		// get all ids
		$objArchive = $this->Database->prepare("SELECT id FROM tl_gallery_archive")
									 ->execute();
			
		$id = false;
		while ($objArchive->next())
		{
			$id[] = $objArchive->id;
		}

		$arrReturn = array();
		foreach ($GLOBALS['TL_DCA']['tl_gallery']['fields'] as $k=>$v)
		{
			if ($v['eval']['feFilter'])
			{
				$options = array();
				// launch the options_callback
				if (is_array($id) && is_array($v['options_callback']))
				{
					$callback = $v['options_callback'];
					$this->import($callback[0]);
					$options = $this->$callback[0]->$callback[1]($id);
					$ref = false;
				}
				else
				{
					$options = $v['options'];
					$ref = true;
				}
				foreach ($options as $kk=>$vv)
				{
					$arrReturn[$k][specialchars($k.'::'. ($ref ? $vv : $kk))] = $ref ? $v['reference'][$vv] : $vv;
				}
			}
		}

		return $arrReturn;
	}


	/**
	 * Return all gallery templates as array
	 * @param object
	 * @return array
	 */
	public function getGalleryTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('gal_', $dc->activeRecord->pid);
	}

}

?>