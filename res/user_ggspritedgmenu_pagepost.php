<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Georg Grossberger (georg@grossberger.at)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Page post hook for creating the sprite file. We do this here
 * so we only need to create the image once, no matter how
 * many GMENU objects are on the page
 *
 * @package TYPO3
 * @subpackage ggspritedgmenu
 * @since 06.12.2009
 * @author Georg Grossberger <georg@grossberger.at>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 */
class user_ggspritedgmenu_pagepost {

	/**
	 *
	 * @var boolean
	 */
	protected static $alreadyDone = FALSE;

	/**
	 *
	 * @var tx_ggspritedgmenu_collector
	 */
	private static $_collectorInstance = null;

	/**
	 * Compose a single image of the gmenu images
	 *
	 * @param Array $params
	 * @param Array $obj
	 * @return user_ggspritedgmenu_pagepost
	 */
	public function makeSprite(&$params, &$obj) {

		if (self::$alreadyDone || $this->getCollector()->isEmpty()) { // If there is nothing to do, make it short
			return $this;
		}

		$collector  = $this->getCollector()->getCollection();
		$width 		= 0;
		$height 	= 0;
		$config		= array();
		$c			= 1;
			
		// Compile a IMG_RESOURCE setup, which will merge images
		foreach ($collector as $id => $menupoint) {

			$normal   = $menupoint['normal'];
			$rollover = $menupoint['rollover'];

			if (!($normal instanceof tx_ggspritedgmenu_image)) {
				continue;
			}

			$key = (string) ($c * 10);
			$config[$key] = 'IMAGE';
			$config[$key . '.'] = array(
				'file'	 => $normal->getImage(),
				'offset' => '0,' . $height
			);

			$c++;
			$height += $normal->getHeight();
			$width	=  max($width, $normal->getWidth());

			if ($rollover instanceof tx_ggspritedgmenu_image) {
				$key = (string) ($c * 10);
				$config[$key] = 'IMAGE';
				$config[$key . '.'] = array(
					'file'	 => $rollover->getImage(),
					'offset' => '0,' . $height
				);

				$c++;
				$height += $rollover->getHeight();
				$width	=  max($width, $rollover->getWidth());
			}
		}

		// Now create it
		$sprite = $GLOBALS['TSFE']->cObj->IMG_RESOURCE(array(
			'file' => 'GIFBUILDER',
			'file.' => array(
				'XY'					=> $width . ',' . $height,
				'format'				=> 'png',
				'transparentBackground' => true
			) + $config
		));

		// Move to desired location
		rename($sprite, 'typo3temp/GB/' . $this->getCollector()->getSpriteImage());

		// Make sure we do not do this twice (should never occur anyway)
		self::$alreadyDone = TRUE;
		return $this;
	}

	/**
	 * Get the image collection
	 *
	 * @return tx_ggspritedmenu_collector
	 */
	protected function getCollector() {
		if (is_null(self::$_collectorInstance)) {
			self::$_collectorInstance = t3lib_div::makeInstance('tx_ggspritedgmenu_collector');
		}
		return self::$_collectorInstance;
	}

}
?>