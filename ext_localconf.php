<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// hook is called before Caching / pages on their way in the cache.
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][$_EXTKEY] = '&user_ggspritedgmenu_pagepost->makeSprite';

?>