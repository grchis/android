<style type="text/css">
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
	#gkMainbody table:before {
    content: "";
  }

</style>
<?php
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
//

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

$tip_abonament =& JRequest::getVar( 'tip_abonament', '', 'post', 'string' );
//obtinem pretul abonamentului
$query = "SELECT `ab`.`abonament`, `ab`.`pret`, `m`.`m_scurt`, `m`.`id` FROM #__sa_abonament AS `ab` JOIN #__sa_moneda AS `m` ON `ab`.`id` = '".$tip_abonament."' AND `ab`.`moneda` = `m`.`id`";
$db->setQuery($query);
$pret = $db->loadObject();
//obtin curs valutar
$time = time();
$data = date('Y-m-d', $time);
$query = "SELECT `curs_euro` FROM #__sa_curs_valutar WHERE `data` LIKE '".$data."%'";
$db->setQuery($query);
$curs_v = $db->loadResult();
$pret_nou = $pret->pret * $curs_v;
?>

<div>
<?php echo JText::_('SA_PLATA_CC_ABONAMENT_DESC'); ?>
</div>
<br />
<div>
<?php
echo JText::sprintf('SA_PLATA_CC_ABONAMENT_DESC2', $pret->abonament, $pret->pret, $pret_nou, $curs_v); 
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
	<input type="hidden" name="item" value="<?php echo 'abonament-cc-'.$uid.'-'.$pret_nou.'-'.$pret->pret; ?>" />
	<input type="hidden" name="valoare" value="<?php echo $pret_nou; ?>" />
	<input type="hidden" name="moneda" value="RON" />
	<input type="submit" value="<?php echo JText::_('SAUTO_PLATESTE_CU_CC'); ?>">
	</form>
<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')

		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#sa_reclame_top')) {
			jQuery('#sa_reclame_top').remove();
		}
		if (jQuery('#sa_viz_side_bar')) {
			jQuery('#sa_viz_side_bar').remove();
		}
		if (jQuery('#additional_content')) {
			jQuery('#additional_content').remove();
		}

		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

		jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);
	
</script>
