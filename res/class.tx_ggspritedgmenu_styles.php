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
 * Generates the styles for the menu
 *
 * @package TYPO3
 * @subpackage ggspritedmenu
 * @since 06.12.2009
 * @author Georg Grossberger <georg@grossberger.at>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 */
class tx_ggspritedgmenu_styles implements t3lib_Singleton {

	/**
	 * Generate the styles and insert them into the header
	 *
	 * @param tx_ggspritedgmenu_collector $collector
	 * @return tx_ggspritedmenu_styles
	 */
	public function generate(tx_ggspritedgmenu_collector $collector) {

		$content  = '';
		$template = $this->getTemplate();
		$offset	  = 0;

		foreach ($collector->getCollection() as $id => $menupoint) {

			$normal   = $menupoint['normal'];
			$rollover = $menupoint['rollover'];

			if (!$normal instanceof tx_ggspritedgmenu_image) {
				continue;
			}


			$content .= $template
						->setTemplate( tx_ggspritedgmenu_csstemplate::TEMPLATE_NORMAL )
						->setMarker('width', $normal->getWidth())
						->setMarker('height', $normal->getHeight())
						->setMarker('id', $id)
						->setMarker('offset', $offset)
						->render();

			$offset += $normal->getHeight();

			if ($rollover instanceof tx_ggspritedgmenu_image) {
				$content .= $template
						->setTemplate( tx_ggspritedgmenu_csstemplate::TEMPLATE_HOVER )
						->setMarker('width', $rollover->getWidth())
						->setMarker('height', $rollover->getHeight())
						->setMarker('offset', $offset)
						->render();
				$offset += $rollover->getHeight();
			}
		}

		$image = md5(serialize($collector->getCollection())) . '.png';
		$collector->setSpriteImage($image);

		$spriteImage = 'GB/' . $image;

		if (!$GLOBALS['TSFE']->config['config']['inlineStyle2TempFile']) {
			$spriteImage  = 'typo3temp/' . $spriteImage;
		}

		$content = $template->setTemplate( tx_ggspritedgmenu_csstemplate::TEMPLATE_BASE )->setMarker('sprite', $spriteImage)->render()
					. $content;

		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_ggspritedgmenu_pi1.']['_CSS_DEFAULT_STYLE'] = $content;
		return $this;
	}

	/**
	 * Get an instance of tx_ggspritedgemenu_csstemplate
	 * for generating the styles
	 *
	 * @return tx_ggspritedgemenu_csstemplate
	 */
	protected function getTemplate() {
		return t3lib_div::makeInstance('tx_ggspritedgmenu_csstemplate');
	}
}
?>