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

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;

$img_path = JURI::base()."components/com_sauto/assets/images/";

//obtin filiale
$query = "SELECT `cod_fiscal` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$cf = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_profiles WHERE `cod_fiscal` = '".$cf."' AND `f_principal` = '0'";
$db->setQuery($query);
$filiale = $db->loadResult();
if ($filiale == 0) {
	?>
	<br /><br /><br />
	<table width="80%" class="sa_table_class">
		<tr class="sa_table_row">
			<td valign="top" class="sa_table_cell" width="40">
				<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
			</td>
			<td valign="top" class="sa_table_cell">
				<?php echo JText::_('SA_MISSING_FILIALE'); ?>
			</td>
		</tr>
	</table>
	
	<?php /*<div class="sa_missing_request_1">
		<div class="sa_missing_request">
			<div class="sa_missing_request_left">
				<?php //$link_add = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
				<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
			</div>
			<div class="sa_missing_request_right">
			<?php echo JText::_('SA_MISSING_FILIALE'); ?>
			</div>
		</div>
	</div>
	<br /><br /><br /><br /><br />
	<div style="clear:both;"></div> */ ?>
	<?php
} else {
$query = "SELECT `p`.`uid`, `p`.`telefon`, `j`.`judet`, `l`.`localitate`, `p`.`cod_postal`, `p`.`poza`, `p`.`companie`, 
	`p`.`reprezentant`, `p`.`sediu`, `u`.`email`, `u`.`registerDate`, `u`.`block`  
	FROM #__sa_profiles AS `p` 
	JOIN #__users AS `u`
	JOIN #__sa_judete AS `j`
	JOIN #__sa_localitati AS `l` 
	ON `p`.`cod_fiscal` = '".$cf."' 
	AND `p`.`f_principal` = '0' 
	AND `p`.`uid` = `u`.`id` 
	AND `p`.`judet` = `j`.`id`
	AND `p`.`localitate` = `l`.`id`";
$db->setQuery($query);
$filials = $db->loadobjectList();
//print_r($filials);
?>
<h2><?php echo JText::_('SAUTO_LISTA_FILIALE'); ?></h2>
<table width="100%" class="sa_table_class">
	<thead>
		<th class="sa_table_head"><?php echo JText::_('SAUTO_REPREZENTANT').'<br />'.JText::_('SAUTO_FORM_MP_EMAIL'); ?></th>
		<th class="sa_table_head"><?php echo JText::_('SAUTO_PROFILE_JUDET').'<br />'.JText::_('Localitate'); ?></th>
		<th class="sa_table_head"><?php echo JText::_('SAUTO_PROFILE_TELEFON').'<br />'.JText::_('SAUTO_REGISTER_DATE'); ?></th>
		<th class="sa_table_head" colspan="3"><?php echo JText::_('SAUTO_ACTION'); ?></th>
	</thead>
<?php
	foreach ($filials as $f) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	?>
	<tr class="sa_table_row <?php echo $style; ?>">
		<td valign="top" class="sa_table_cell">
			<?php 
			echo '<div>'.$f->reprezentant.'</div>';
			echo '<div>'.$f->email.'</div>';
			?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php
			echo '<div>'.$f->judet.'</div>';
			echo '<div>'.$f->localitate.'</div>';
			?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php
			echo '<div>'.$f->telefon.'</div>';
			echo '<div>'.$f->registerDate.'</div>';
			?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php
			$link_edit = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=edit_filiala&id='.$f->uid);
			$link_delete = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=delete_filiala&id='.$f->uid);
			$link_aprove = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=aprove_filiala&id='.$f->uid);
				if ($f->block == 1) {
					echo '<a href="'.$link_aprove.'" class="sauto_filiale"><img src="'.$img_path.'check_yes.png" /></a>';
				}
			?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php echo '<a href="'.$link_edit.'" class="sauto_filiale"><img src="'.$img_path.'edit_garaj.png" /></a>'; ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php echo '<a href="'.$link_delete.'" class="sauto_filiale"><img src="'.$img_path.'delete_garaj.png" /></a>'; ?>
		</td>
	</tr>
	<?php
	}
?>
</table>
<?php
}
