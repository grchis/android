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
//
$pret =& JRequest::getVar( 'credite', '', 'post', 'string' );

//echo 'abonament > '.$pret->abonament.' pret > '.$pret->pret.' moneda > '.$pret->m_scurt;
//obtinem profilul
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->LoadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=proforma'); 

?>
<h3><?php echo JText::_('SAUTO_METODA_DE_PLATA').': '.JText::_('SAUTO_METODA_PLATA_OP');?></h3>
<div><?php echo JText::_('SAUTO_PLATA_OP_DETALII2'); ?></div>

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
			<?php echo JText::_('SAUTO_PRET_TRANZ'); ?>
		</td>
		<td valign="top" class="sa_table_cell">
			<input type="text" name="d_pret" value="<?php echo $pret; ?>" disabled />
			<input type="hidden" name="pret" value="<?php echo $pret; ?>" />
			<?php echo ' '.JText::_('SAUTO_LEI'); ?>
			<input type="hidden" name="moneda" value="1" />
			<input type="hidden" name="metoda_plata" value="op" />
			<input type="hidden" name="tip_plata" value="puncte" />
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
		<td valign="top" class="sa_table_cell"></td>
		<td valign="top" class="sa_table_cell">
			<input type="submit" value="<?php echo JText::_('SA_GENERARE_PROFORMA'); ?>" />
		</td>
	</tr>
</table>
</form>
