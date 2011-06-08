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
 * Collects all images of a HMENU on a page so a single sprite
 * can be created by a single call after the page generation
 * when all images are available
 *
 * @package TYPO3
 * @subpackage ggspritedgmenu
 * @since 06.12.2009
 * @author Georg Grossberger <georg@grossberger.at>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 */
class tx_ggspritedgmenu_collector implements t3lib_Singleton, Iterator, Countable {

	protected $images  = array();

	protected static $counter = 0;

	protected $spriteImage = null;
	
	protected $cursor = 0;

	/**
	 * Add an image to the sprite array
	 *
	 * @param String $normal
	 * @param String $rollover
	 * @return tx_ggspritedmenu_collector
	 */
	public function addImage($normal, $rollover = null) {

		if (!is_file($normal)) {
			t3lib_div::sysLog(
				'The given filename is not an available file, please make sure the image generation works',
				'ggspritedmenu',
				t3lib_div::SYSLOG_SEVERITY_ERROR
			);
		}

		$normal = t3lib_div::makeInstance('tx_ggspritedgmenu_image')->setImage($normal);
		if (!is_null($rollover)) {
			$rollover = t3lib_div::makeInstance('tx_ggspritedgmenu_image')->setImage($rollover);
		}
		$this->images[ self::$counter ] = array(
			'normal'	=> $normal,
			'rollover'	=> $rollover
		);
		return $this;
	}

	/**
	 * Get ID of the next image
	 *
	 * @return Integer
	 */
	public function getNextId() {
		self::$counter++;
		return self::$counter;
	}

	/**
	 * Set the image file name for the sprite
	 *
	 * @param String $imageFile
	 * @return tx_ggspritedgmenu_collector
	 */
	public function setSpriteImage($imageFile) {
		$this->spriteImage = $imageFile;
		return $this;
	}

	/**
	 * Get the image file name for the sprite
	 *
	 * @return String
	 */
	public function getSpriteImage() {
		if (is_null($this->spriteImage)) {
			$this->spriteImage = 'typo3temp/GB/' . md5(serialize($this->images)) . '.png';
		}
		return $this->spriteImage;
	}

	/**
	 * Tells if there are items available or not
	 *
	 * @return Boolean True if no items collected, true if there are
	 */
	public function isEmpty() {
		return $this->count() < 1;
	}

	/**
     * The following code is a minimal implementation of the Iterator
     * interface, so we can traverse the images using the foreach construct.
     * This section is a slightly modified piece of code, available at
	 * http://www.php.net/manual/en/language.oop5.iterations.php
	 */


    public function rewind() {
        $this->cursor = 0;
    }

    public function current() {
        $this->images[ $this->cursor ];
    }

    public function key() {
        return $this->cursor;
    }

    public function next() {
        $this->cursor++;
    }

    public function valid() {
       return $this->cursor >= $this->count();
    }

    /**
     * Implements the Contable interface
     */

    public function count() {
    	return count($this->images);
    }
}
?>