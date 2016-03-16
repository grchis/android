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
	JHtml::_('behavior.framework', true);
	Jhtml::_('behavior.modal');
	$img_path = JURI::base()."components/com_sauto/assets/users/".$uid."/";
	$db = JFactory::getDbo();
	$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$id."' ORDER BY `id` ASC";
	$db->setQuery($query);
	$pics = $db->loadObjectList();
		$height = 0;
		foreach ($pics as $p) {
			$size = getimagesize($img_path.$p->poza);
			//print_r($size);
			$n_height = (50 * $size[1]) / $size[0];
			if ($n_height > $height) { $height = $n_height; }
			//echo $n_height.'<hr />';
		}
		$height = round($height);
	echo '<div style="display:inline;">';
		foreach ($pics as $p) {
			echo '<div class="sa_view_pic" style="height:'.$height.'px;">';
				echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path.$p->poza.'"><img src="'.$img_path.$p->poza.'" alt="'.$p->alt.'" width="50" border="0" /></a>';
			echo '</div>';
		}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}

?>
