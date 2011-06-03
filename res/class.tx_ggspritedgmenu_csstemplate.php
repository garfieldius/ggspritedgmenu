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
 * Generates a CSS style by loading a template and applying
 * content to markers
 *
 * @package TYPO3
 * @subpackage ggspritedgemenu
 * @since 06.12.2009
 * @author Georg Grossberger <georg@grossberger.at>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 */
class tx_ggspritedgmenu_csstemplate {

	protected $template = '';
	protected $marker = array();

	private static $_templateCache = array();

	const TEMPLATE_BASE   = 'base';
	const TEMPLATE_NORMAL = 'normal';
	const TEMPLATE_HOVER  = 'hover';

	/**
	 * Set the template for the style
	 *
	 * @param String $template
	 * @return tx_ggspritedgemenu_csstemplate
	 */
	public function setTemplate($template) {
		$this->template = $template;
		return $this;
	}

	/**
	 * Add a marker - content pair for rendering
	 *
	 * @param String $marker
	 * @param String $content
	 * @return tx_ggspritedgemenu_csstemplate
	 */
	public function setMarker($marker, $content) {
		$this->marker[ (string) $marker ] = trim((string) $content);
		return $this;
	}

	/**
	 * Fetches the template and returns it;
	 *
	 * @return String
	 */
	protected function getTemplateData() {

		if (!array_key_exists($this->template, self::$_templateCache)) {
			$content = file_get_contents(t3lib_extMgm::extPath('ggspritedgmenu', 'res/csstemplates/' . $this->template . '.txt'));
			$content = t3lib_div::trimExplode(chr(10), $content, TRUE);
			$content = implode('', $content);
			self::$_templateCache[ $this->template ] = $content;
		}
		return self::$_templateCache[ $this->template ];
	}

	/**
	 * Create the style, based on given data
	 *
	 * @return String
	 */
	public function render() {

		$template = $this->getTemplateData();

		foreach ($this->marker as $marker => $content) {
			$template = str_ireplace('#' . $marker . '#', $content, $template);
		}

		return $template;
	}
}
?>