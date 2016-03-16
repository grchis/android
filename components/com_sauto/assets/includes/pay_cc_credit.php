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
$query = "SELECT `p`.*, `j`.`judet`, `l`.`localitate`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__sa_judete AS `j` JOIN #__sa_localitati AS `l` JOIN #__users AS `u` ON `p`.`uid` = '".$uid."' AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id` AND `p`.`uid` = `u`.`id`";
$db->setQuery($query);
$profil = $db->LoadObject();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$cfg = $db->LoadObject();


$baza = JUri::base();
$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=card_redirect');
$names = explode(" ", $profil->reprezentant);
//print_r($names);
?>

<div>
<?php echo JText::_('SA_PLATA_CC_CREDITE_DESC'); ?>
</div>
<br />
<div>
<?php 
echo JText::sprintf('SA_PLATA_CC_CREDITE_DESC2', $pret); 
?>
</div>
<br />
<div>
<?php
echo JText::sprintf('SA_PLATA_CC_CREDITE_DESC3', $pret); 
?>
</div>
<br /><br />

<form action="<?php echo $link_form; ?>" method="post" name="frmPaymentRedirect">
<!-- 	If you want the values in the payment page to be prefilled, you need to request them from the customer and POST them to the payment gateway. If not, the customer will have to fill them in the secure page on mobilpay.ro -->
<table width="100%" class="sa_table_class">
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell" colspan="2"><h3><?php echo JText::_('SA_COMPLETARE_DATE_FACTURARE'); ?></h3></td>
	</tr>
<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_NUME'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_last_name" id="idLastName" style="width: 200px;" value="<?php echo $names[0]; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_PRENUME'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_first_name" id="idFirstName" style="width: 200px;" value="<?php echo $names[1]; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_CODFISCAL'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_fiscal_number" id="idFiscalNumber" style="width: 200px;" value="<?php echo $profil->cod_fiscal; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_CI'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_identity_number" id="idIdentityNumber" style="width: 200px;" /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_TARA'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_country" style="width: 200px;" value="<?php echo JText::_('SAUTO_FORM_MP_TARA_NAME'); ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_JUD_SEC'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_county" style="width: 200px;" value="<?php echo $profil->judet; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_CITY'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_city" style="width: 200px;" value="<?php echo $profil->localitate; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_CP'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_zip_code" style="width: 200px;" value="<?php echo $profil->cod_postal; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_ADRESA'); ?></td>
		<td valign="top" class="sa_table_cell"><textarea type="text" name="billing_address" style="width: 200px; height: 150px;" disabled><?php echo $profil->sediu; ?></textarea></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_EMAIL'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_email" style="width: 200px;" value="<?php echo $profil->email; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_TELEFON'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_mobile_phone" style="width: 200px;" value="<?php echo $profil->telefon; ?>" disabled /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_BANCA'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_bank" style="width: 200px;" /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MP_IBAN'); ?></td>
		<td valign="top" class="sa_table_cell"><input type="text" name="billing_iban" style="width: 200px;" /></td>
	</tr>
</table>

	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	<input type="hidden" name="item" value="<?php echo 'credite-cc-'.$uid.'-'.$pret; ?>" />
	<input type="hidden" name="valoare" value="<?php echo $pret; ?>" />
	<input type="hidden" name="moneda" value="RON" />
	<input type="submit" value="<?php echo JText::_('SAUTO_PLATESTE_CU_CC'); ?>">
	</form>
