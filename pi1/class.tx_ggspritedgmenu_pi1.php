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
 * Based upon the GTMenu class by Stefan Beylen and Torsten Schrade this class
 * extends the functionality by creating a sprite with all images of all GMENU
 * objects on the page. The generated styles are put into the _CSS_DEFAULT_STYLES
 * key of the page setup so typo3 puts it in the same place like CSS styled content
 * is.
 *
 * See the great GTMenu script at http://wiki.typo3.org/index.php/GTMENU
 *
 * @package TYPO3
 * @subpackage ggspritedgmenu
 * @since 6.12.2009
 * @author Georg Grossberger <georg@grossberger.at>
 * @author Stefan Beylen for http://we-make.net <intsys@swissinfo.org>
 * @author Torsten Schrade <t.schrade@connecta.ag>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 */
class tx_ggspritedgmenu_pi1 {

	/**
	 * Generates a GMENU with the same output
	 * like a TMENU, but some additional CSS
	 * classes to apply a generated image sprite
	 * Called by TypoScript using the IProcFunc
	 * property of the GMENU object
	 *
	 * @param $I Array
	 * @param $I Array
	 * @return Array
	 */
	public function create($I, $conf){

		// Unset unnecessary date from the setup
		unset(
			$I['linkHREF']['onMouseover'],
			$I['linkHREF']['onMouseout'],
			$GLOBALS['TSFE']->additionalJavaScript,
			$GLOBALS['TSFE']->JSImgCode
		);

		$collector = $this->getCollector();

		// Count through the items
		$uniqueString = $collector->getNextId();
		// Set needed infos for the TCE
		$I['linkHREF']['class']	= 'gt-menu gt-' . $uniqueString;
		$I['parts']['image']	= htmlspecialchars($I['title'], ENT_QUOTES, $GLOBALS['TSFE']->metaCharset, false);
		$conf['parentObj']->I 	= $I;
		$conf['parentObj']->setATagParts();

		$I = $conf['parentObj']->I;
		$I['parts']['ATag_begin'] = $I['A1'] . '<span>';
		$I['parts']['ATag_end']   = '</span>' . $I['A2'];

		preg_match('/[^>]*src=\"(.*?)\"[^>]*/', $I['IMG'], $match['src']);

		// Save the image for image generation
		$image = $match['src'][1];
		$rollover = null;

		if(!empty($conf['parentObj']->result['RO'][ $I['key'] ]['output_file'])) {
			$rollover = $conf['parentObj']->result['RO'][ $I['key'] ]['output_file'];
		}

		// Add to stylesheet
		t3lib_div::makeInstance('tx_ggspritedgmenu_styles')->generate(
			$collector->addImage($image, $rollover)
		);

		return $I;
	}

	/**
	 * Get the image collection
	 *
	 * @return tx_ggspritedmenu_collector
	 */
	protected function getCollector() {
		return t3lib_div::makeInstance('tx_ggspritedgmenu_collector');
	}
}
?>