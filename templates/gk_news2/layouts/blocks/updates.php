<?php

// No direct access.
defined('_JEXEC') or die;

// Used helper function
if(!function_exists('gk_get_last_update')) {
	function gk_get_last_update($table, $column, $state) {
		$db = JFactory::getDBO();
		$date_query = 'SELECT '.$column.' FROM #__'.$table.' WHERE '.$state.' = 1 ORDER BY '.$column.' DESC LIMIT 1;';	
		$db->setQuery($date_query);
		if($dates = $db->loadAssocList()) {
			foreach($dates as $date) {
				return strtotime($date[$column]);
			}
		}
	}
}

// Basic variables
$final_date = 0;
$new_date = 0;

// get joomla created dates
$final_date = gk_get_last_update('content', 'created', 'state');
// check if any modify date isn't later
$new_date = gk_get_last_update('content', 'modified', 'state');
if($new_date > $final_date) $final_date = $new_date; 
// the same for K2 if exist
if(file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php')) {
	$new_date = gk_get_last_update('k2_items', 'created', 'published');
	if($new_date > $final_date) $final_date = $new_date; 
	// return the final results
	$new_date = gk_get_last_update('k2_items', 'modified', 'published');
	if($new_date > $final_date) $final_date = $new_date; 
}

echo JText::_('TPL_GK_LANG_UPDATE_DATE') . ' ' . date(JText::_('TPL_GK_LANG_UPDATE_DATE_FORMAT'), $final_date);

// EOF