<?php

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.typolight.org>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once('initialize.php');


/**
 * Class CronJob
 *
 * Cron job controller.
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.typolight.org>
 * @package    Controller
 */
class ConvertComments extends Backend
{

	/**
	 * Initialize object (do not remove)
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Run the controller
	 */
	public function run()
	{

		$blnOld = $this->Database->tableExists('tl_gallery_comments');
		$objNew = $this->Database->execute("SELECT * FROM tl_comments WHERE source='tl_gallery'");

		if ($blnOld && $objNew->numRows == 0)
		{
			// Gallery comments
			$objComment = $this->Database->execute("SELECT * FROM tl_gallery_comments");
	
			if ($objComment->numRows)
			{
				while ($objComment->next())
				{
					$arrSet = $objComment->row();
		
					$arrSet['source'] = 'tl_gallery';
					$arrSet['parent'] = $arrSet['pid'];
					unset($arrSet['id']);
					unset($arrSet['pid']);
		
					$this->Database->prepare("INSERT INTO tl_comments %s")->set($arrSet)->execute();
				}
	
				$this->log('Gallery comments migrated to "tl_comments"', 'runonce.php', TL_GENERAL);
			}
		}
		else
		{
			$this->log('Gallery comments not migrated as existing entries were found in "tl_comments"', 'runonce.php', TL_GENERAL);
		}
	}

}


/**
 * Instantiate controller
 */
$objConvertComments = new ConvertComments();
$objConvertComments->run();

?>