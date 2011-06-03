<?php

########################################################################
# Extension Manager/Repository config file for ext "ggspritedgmenu".
#
# Auto generated 01-06-2011 16:17
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Sprited GMENU',
	'description' => 'An extended GTMenu script that can be used more easily and creates a single sprite with all GMENU images of a page.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '0.1.2',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Georg Grossberger',
	'author_email' => 'georg@grossberger.at',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.3.0-4.6.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:13:{s:16:"ext_autoload.php";s:4:"48ce";s:12:"ext_icon.gif";s:4:"3ac5";s:17:"ext_localconf.php";s:4:"5368";s:14:"doc/manual.sxw";s:4:"182d";s:35:"pi1/class.tx_ggspritedgmenu_pi1.php";s:4:"d343";s:41:"res/class.tx_ggspritedgmenu_collector.php";s:4:"95d0";s:43:"res/class.tx_ggspritedgmenu_csstemplate.php";s:4:"cdf7";s:37:"res/class.tx_ggspritedgmenu_image.php";s:4:"ef8a";s:38:"res/class.tx_ggspritedgmenu_styles.php";s:4:"9f20";s:36:"res/user_ggspritedgmenu_pagepost.php";s:4:"b4bc";s:25:"res/csstemplates/base.txt";s:4:"3679";s:26:"res/csstemplates/hover.txt";s:4:"df90";s:27:"res/csstemplates/normal.txt";s:4:"13e6";}',
	'suggests' => array(
	),
);

?>