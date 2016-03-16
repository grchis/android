<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

function view_pictures($id, $uid) {
	Jhtml::_('behavior.modal');
	$img_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS.$uid.DS;
	$db = JFactory::getDbo();
	$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$id."' ORDER BY `id` ASC";
	$db->setQuery($query);
	$pics = $db->loadObjectList();
	echo '<div style="display:inline;">';
		foreach ($pics as $p) {
			echo '<div style="float:left;padding:5px;">';
				echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path.$p->poza.'"><img src="'.$img_path.$p->poza.'" alt="'.$p->alt.'" width="50" border="0" /></a>';
			echo '</div>';
		}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}

?>
