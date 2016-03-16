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
$rezult_pagina = '10';
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;


$query = "SELECT `c`.`anunt_id`, `c`.`poster_id`, `c`.`mesaj`, `c`.`tip`, `a`.`titlu_anunt`, `p`.`fullname`, `p`.`calificative` FROM #__sa_calificativ AS `c` JOIN #__sa_anunturi AS `a` JOIN #__sa_profiles AS `p` ON  `c`.`anunt_id` = `a`.`id` AND `c`.`poster_id` = `p`.`uid` AND `c`.`dest_id` = '".$uid."' ORDER BY `c`.`id` DESC LIMIT 0, 5 ";
$db->setQuery($query);
$list = $db->loadObjectList();
$i=1;
?>
<h3><?php echo JText::_('SAUTO_LAST_FEEDBACK_RECEIVED'); ?></h3>
<?php
if (empty($list)) {
	echo JText::_('SAUTO_NU_SUNT_CALIFICATIVE_PRIMITE');
} else {
	echo '<div class="sa_viz_main">';
	foreach ($list as $l) {
		if ($class == ' sa-row1 ') { 
			$class = ' sa-row0 '; 
		} else { 
			$class = ' sa-row1 '; 
		}
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->poster_id);
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);
		?>
		<div class="sa_list_nr sa_tables_cell_medium sa_tables_align_left <?php echo $class; ?>">
			<?php echo $i; ?>
		</div>
		<div class="sa_list_anunt sa_tables_cell_medium sa_tables_align_left <?php echo $class; ?>">
			<?php
			echo '<div class="sa_request_title">';
				echo '<a href="'.$link_anunt.'" class="sa_link_request">';
					echo $l->titlu_anunt;
				echo '</a>';
			echo '</div>';
			echo $l->mesaj;
			?>
		</div>
		<div class="sa_list_user sa_tables_cell_medium sa_tables_align_left <?php echo $class; ?>">
			<?php
			echo '<div class="sa_request_title">';
				echo '<a href="'.$link_profile.'" class="sa_link_request">';
					echo $l->fullname;
				echo '</a>';
			echo '</div>';
			echo JText::_('SAUTO_FEEDBACKS').' '.$l->calificative.'%';
			?>
		</div>
		<div class="sa_list_price sa_tables_cell_medium sa_tables_align_right <?php echo $class; ?>">
			<?php
			if ($l->tip == 'p') {
				//pozitiv
				$icon = 'feedback_pozitiv.png';
			} elseif ($l->tip == 'x') {
				//negativ
				$icon = 'feedback_negativ.png';
			} elseif ($l->tip == 'n') {
				//neutru
				$icon = 'feedback_neutru.png';
			}
			echo '<img src="'.$img_path.$icon.'" />';
			?>
		</div>
		<?php
	$i++;
	}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}
?>
