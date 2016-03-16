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



$query = "SELECT `r`.`anunt_id`, `r`.`firma`, `r`.`mesaj`, `r`.`pret_oferit`, `r`.`moneda`, `a`.`titlu_anunt`, `p`.`companie`, `p`.`poza`, `m`.`m_scurt` FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi AS `a` JOIN #__sa_profiles AS `p` JOIN #__sa_moneda AS `m` ON  `r`.`anunt_id` = `a`.`id` AND `r`.`firma` = `p`.`uid` AND `r`.`moneda` = `m`.`id` AND `r`.`proprietar` = '".$uid."' AND `r`.`status_raspuns` = '0' ORDER BY `r`.`id` DESC LIMIT 0, 5 ";
$db->setQuery($query);
$list = $db->loadObjectList();
$i=1;
?>
<h3><?php echo JText::_('SA_ULTIMELE_OFERTE_PRIMITE'); ?></h3>

<?php
if (empty($list)) {
	echo JText::_('SAUTO_NU_SUNT_OFERTE_PRIMITE');
} else {
	echo '<div class="sa_viz_main">';
	foreach ($list as $l) {
		if ($class == ' sa-row1 ') { 
			$class = ' sa-row0 '; 
		} else { 
			$class = ' sa-row1 '; 
		}
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->firma);
		?>
		<div class="sa_list_nr sa_tables_cell sa_tables_align_left <?php echo $class; ?>">
			<?php echo $i; ?>
		</div>
		<div class="sa_list_anunt sa_tables_cell sa_tables_align_left <?php echo $class; ?>">
			<?php
			echo '<div class="sa_request_title">';
				echo '<a href="'.$link_anunt.'" class="sa_link_request">';
					echo $l->titlu_anunt;
				echo '</a>';
			echo '</div>';
			?>
		</div>
		<div class="sa_list_user sa_tables_cell sa_tables_align_left <?php echo $class; ?>">
			<?php
			echo '<div class="sa_request_title">';
				echo '<a href="'.$link_profile.'" class="sa_link_request">';
					echo $l->companie;
				echo '</a>';
			echo '</div>';
			?>
		</div>
		<div class="sa_list_price sa_tables_cell sa_tables_align_right <?php echo $class; ?>">
			<?php
			echo $l->pret_oferit.' '.$l->m_scurt;
			?>
		</div>
		<?php 
	$i++;
	}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}
?>



