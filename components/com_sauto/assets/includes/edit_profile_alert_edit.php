<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/edit_profile_alert_edit_mobile.php');
}else{
$db = JFactory::getDbo();

$user =& JFactory::getUser();
$uid = $user->id;

$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//obtin numele domeniului de activitate
$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadResult();

$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
$db->setQuery($query);
$judet = $db->loadObjectList();
			
//obtinem marci auto
$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
$db->setQuery($query);
$marci = $db->loadObjectList();

//obtin setarile curente
$query = "SELECT * FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '".$id."'";
$db->setQuery($query);
$curent = $db->loadObject();

//print_r($curent);
 
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_save');	
?>
<form method="post" action="<?php echo $link; ?>">
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell">
			<strong><?php echo $tip; ?></strong>
		</td>
		<td class="sa_table_cell">
			<input type="checkbox" name="delete" value="1" style="margin-left:25px;" /> 
			<?php echo JText::_('SAUTO_ELIMINA_DOM_ACT'); ?>
		</td>
		<td class="sa_table_cell">
			<input type="hidden" name="alert_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="alert_type" value="delete" />
			<input type="submit" value="<?php echo JText::_('SAUTO_CONFIRM_DELETE_DOM_ACT'); ?>" />
		</td>
	</tr>
</table>
</form>
<br /><br /><hr /><br /><br />
<form method="post" action="<?php echo $link; ?>">
<table class="sa_table_class" width="100%">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top"><strong><?php echo $tip; ?></strong></td>
		<td class="sa_table_cell" valign="top">
		<?php if (($id == '2') OR ($id == '5')) { } else { ?>
		<div style="float:left;width:250px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_m_all_<?php echo $id; ?>" value="1" 
				<?php if ($curent->lista_marci == 'all') { echo 'checked'; } ?>
			/><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></div>
			<?php 
				$c_marci = explode(",", $curent->lista_marci);
				foreach ($marci as $m) {
					$m_id = $m->id;
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" ';
							if (in_array($m_id, $c_marci)) { echo 'checked'; }
						echo '/> ';
					echo ' '.$m->marca_auto.'</div>';
				} ?>
		</div>
	</div>
		<?php } ?>
		</td>
		<td class="sa_table_cell" valign="top">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_j_all_<?php echo $id; ?>" value="1" 
				<?php if ($curent->lista_judete == 'all') { echo 'checked'; } ?>
			/><?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?></div>
			<?php 
				$c_judete = explode(",", $curent->lista_judete);
				foreach ($judet as $j) {
					$j_id = $j->id;
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_j_'.$id.'_'.$j->id.'" value="1" ';
							if (in_array($j_id, $c_judete)) { echo 'checked'; }
						echo '/> ';
					echo ' '.$j->judet.'</div>';
				} ?>
		</div>
		</td>
		<td class="sa_table_cell" valign="top">
		<?php
		if ($id == 1) {
			$query = "SELECT `nou`, `sh` FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '1'";
			$db->setQuery($query);
			$type = $db->loadObject();
			?>
			<div><strong><?php echo JText::_('SAUTO_ALEGE_TIP_PIESA'); ?></strong></div>
			<div>
				<input type="checkbox" name="nou" value="1" <?php if ($type->nou == '1') { echo ' checked '; } ?>/> 
				<?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?>
			</div>
			<div>
				<input type="checkbox" name="sh" value="1" <?php if ($type->sh == '1') { echo ' checked '; } ?>/> 
				<?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?>
			</div>
			<?php
		}
		?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td class="sa_table_cell" colspan="3" align="center">
			<input type="hidden" name="alert_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="alert_type" value="edit" />
			<input type="submit" value="<?php echo JText::_('SAUTO_ALERT_BUTTON_EDIT'); ?>" />
		</td>
	</tr>
</table>
</form>
<?php  } ?>