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
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/pay_op_abn_mobile.php');
}else{
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
//
$tip_abonament =& JRequest::getVar( 'tip_abonament', '', 'post', 'string' );
//obtinem pretul abonamentului
$query = "SELECT `ab`.`abonament`, `ab`.`pret`, `m`.`m_scurt`, `m`.`id` FROM #__sa_abonament AS `ab` JOIN #__sa_moneda AS `m` ON `ab`.`id` = '".$tip_abonament."' AND `ab`.`moneda` = `m`.`id`";
$db->setQuery($query);
$pret = $db->loadObject();
//echo 'abonament > '.$pret->abonament.' pret > '.$pret->pret.' moneda > '.$pret->m_scurt;
//obtinem profilul
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->LoadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=proforma'); 

///////////
//obtin curs euro
$time = time();
$actualDate = date('Y-m-d', $time);
$query = "SELECT `curs_euro` FROM #__sa_curs_valutar WHERE `data` LIKE '".$actualDate."%'";
$db->setQuery($query);
$curs_euro = $db->loadResult();
//echo '>>>>  '.$curs_euro;
///////////
?>
<h3><?php echo JText::_('SAUTO_METODA_DE_PLATA').': '.JText::_('SAUTO_METODA_PLATA_OP');?></h3>
<div><?php echo JText::_('SAUTO_PLATA_OP_DETALII'); ?></div>

<br /><br />
<h4><?php echo JText::_('SAUTO_INSERT_FINANCIAR_DATES'); ?></h4>
<form method="post" action="<?php echo $link_form; ?>" enctype="multipart/form-data">
<table width="100%" class="sa_table_class">
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_COMPANIE'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="d_companie" value="<?php echo $profil->companie; ?>" disabled />
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="email" value="<?php echo $user->email; ?>" disabled />
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_REPREZENTANT'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="d_reprezentant" value="<?php echo $profil->reprezentant; ?>" disabled />
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_ABONAMENT_DORIT'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="d_abonament" value="<?php echo $pret->abonament; ?>" disabled />
			<input type="hidden" name="abonament" value="<?php echo $tip_abonament; ?>" />
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_PRET_TRANZ'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="d_pret" value="<?php echo $pret->pret; ?>" disabled />
			<input type="hidden" name="pret" value="<?php echo $pret->pret; ?>" />
			<?php echo ' '.$pret->m_scurt; ?>
			<input type="hidden" name="moneda" value="<?php echo $pret->id; ?>" />
			<input type="hidden" name="metoda_plata" value="op" />
			<input type="hidden" name="tip_plata" value="abonament" />
		</td>
	</tr>
	
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell" colspan="2">
			<?php 
			$link_prf = JRoute::_('index.php?option=com_sauto&view=edit_profile');
			echo JText::_('SAUTO_WRONG_PROFILE_DATES').' <a href="'.$link_prf.'">'.JText::_('SAUTO_GO_TO_PROFILE').'</a>'; ?>
		</td>
	</tr>
	
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell" colspan="2">
			<?php echo JText::_('SAUTO_NOTIFICARE_PLATA').'<br />'; 
			echo JText::_('SAUTO_CURS_EURO').': '.$curs_euro.' '.JText::_('SAUTO_LEI').'. ';
			echo ' '.JText::_('SAUTO_TOTAL_PLATA').': <span style="color:red;">'.($curs_euro * $pret->pret).' '.JText::_('SAUTO_LEI').'</span>.';
			?>
			<input type="hidden" name="curs_euro" value="<?php echo $curs_euro; ?>" />
		</td>
	</tr>
	
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"></td>
		<td valign="top" class="sa_table_cell">
			<input type="submit" value="<?php echo JText::_('SA_GENERARE_PROFORMA'); ?>" />
		</td>
	</tr>
</table>
</form>
<?php } ?>