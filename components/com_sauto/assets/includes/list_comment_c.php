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
$limit = '5';
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;

$query = "SELECT `c`.`id`, `c`.`readed_c`, `c`.`anunt_id`, `c`.`companie` AS `comp`, `c`.`data_adaugarii`, `c`.`mesaj`, `p`.`poza`, `p`.`companie`, `p`.`calificative`, `a`.`titlu_anunt` FROM #__sa_comentarii AS `c` JOIN #__sa_profiles AS `p` JOIN #__sa_anunturi AS `a` ON `c`.`companie` = `p`.`uid` AND `c`.`anunt_id` = `a`.`id` AND `c`.`proprietar` = '".$uid."' AND `c`.`raspuns` = '1' ORDER BY `c`.`id` DESC LIMIT 0, ".$limit."";
$db->setQuery($query);
$list = $db->loadObjectList();

$image_path = JURI::base()."components/com_sauto/assets/";
?>
<h3><?php echo JText::_('SA_ULTIMELE_COMENTARII_PRIMITE'); ?></h3>

<?php
if (empty($list)) {
	echo JText::_('SAUTO_NU_SUNT_COMENTARII_PRIMITE');
} else {
	echo '<div class="sa_viz_main">';
	foreach ($list as $l) {
		if ($class == ' sa-row1 ') { 
			$class = ' sa-row0 '; 
		} else { 
			$class = ' sa-row1 '; 
		}
		
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->comp);
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);
		$link_comment = JRoute::_('index.php?option=com_sauto&view=single_comment&id='.$l->id);
?>
<div class="sa_list_img sa_tables_cell_high sa_tables_align_left <?php echo $class; ?>">
			<?php
			if ($l->poza != '') {
				$poza = $image_path.'users/'.$l->comp."/".$l->poza;
			} else {
				$poza = $image_path.'/images/fi_avatar.png';
			}
			echo '<img src="'.$poza.'" width="100" />';
			?>
		</div>
		<div class="sa_list_content sa_tables_cell_high sa_tables_align_left <?php echo $class; ?>">
			<?php
			echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$l->companie.'</a></div>';
			echo '<hr />';
			echo '<div>';
				if ($l->readed_d == 0) { echo '<img src="'.$image_path.'images/icon_nou.png" /> '; }
				echo '<a class="sa_public_profile" href="'.$link_anunt.'">'.$l->titlu_anunt.'</a></div>';
			echo '<div>'.substr(strip_tags($l->mesaj), 0, 20).' ...<a href="'.$link_comment.'" class="sa_comments">'.JText::_('SAUTO_TOT_COMENTARIUL').'</a></div>';
			?>
		</div>
		<div class="sa_list_data sa_tables_cell_high sa_tables_align_right <?php echo $class; ?>">
			<?php
			$data_add = explode(" ", $l->data_adaugarii);
			echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
			echo '<div>'.JText::_('SAUTO_PROFILE_FEEDBACKS').' '.$l->calificative.'%</div>';
			?>
		</div>
	<?php 
	}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}
?>

<?php

if (!empty($list)) {

	$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `raspuns` = '1' AND `readed_c` = '0'";
	$db->setQuery($query);
	$total = $db->loadResult();
	if ($total != 0) {
		echo '<div style="display:inline;">';
	
			echo '<div style="float:right;">';
				$link_read = JRoute::_('index.php?option=com_sauto&view=mark_read');
				echo '<a href="'.$link_read.'" class="sa_comments_read">'.JText::_('SA_MARECHEAZA_CITIT').'</a>';
			echo '</div>';
		
		echo '</div>';

		echo '<div style="clear:both;"></div>';
	}
}
?>
