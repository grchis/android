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
#gkMainbody table tbody{
		width:100%!important;
}
#gkMainbody table:before {
    content: "";
	width:100%;
	
  }
  input[type="text"]{
	  width:100%;
  }
  #submit{
	  font-size: 100%;
	  width:80%;
	  margin-left:10%;
	  margin-right:10%;
  }
</style>
<?php
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
require('menu_filter_d.php');
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
<fieldset>
		<p><?php echo JText::_('SA_COMPLETARE_DATE_FACTURARE'); ?></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_NUME'); ?></p>
    	<input type="text" name="billing_last_name" id="idLastName"  value="<?php echo $names[0]; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_PRENUME'); ?></p>
		<input type="text" name="billing_first_name" id="idFirstName"  value="<?php echo $names[1]; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_CODFISCAL'); ?></p>
		<p><input type="text" name="billing_fiscal_number" id="idFiscalNumber"  value="<?php echo $profil->cod_fiscal; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_CI'); ?></p>
		<p><input type="text" name="billing_identity_number" id="idIdentityNumber"  /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_TARA'); ?></p>
		<p><input type="text" name="billing_country"  value="<?php echo JText::_('SAUTO_FORM_MP_TARA_NAME'); ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_JUD_SEC'); ?></p>
		<p><input type="text" name="billing_county"  value="<?php echo $profil->judet; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_CITY'); ?></p>
		<p><input type="text" name="billing_city"  value="<?php echo $profil->localitate; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_CP'); ?></p>
		<p><input type="text" name="billing_zip_code"  value="<?php echo $profil->cod_postal; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_ADRESA'); ?></p>
		<p><textarea style="width: 100%; height: 5%; resize:none"  aria-hidden="true" type="text" name="billing_address" disabled><?php echo $profil->sediu; ?></textarea>
		<p><?php echo JText::_('SAUTO_FORM_MP_EMAIL'); ?></p>
		<p><input type="text" name="billing_email"  value="<?php echo $profil->email; ?>" disabled />
		<p><?php echo JText::_('SAUTO_FORM_MP_TELEFON'); ?></p>
		<p><input type="text" name="billing_mobile_phone"  value="<?php echo $profil->telefon; ?>" disabled /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_BANCA'); ?></p>
		<p><input type="text" name="billing_bank"  /></p>
		<p><?php echo JText::_('SAUTO_FORM_MP_IBAN'); ?></p>
		<p><input type="text" name="billing_iban"  /></p>
	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	<input type="hidden" name="item" value="<?php echo 'credite-cc-'.$uid.'-'.$pret; ?>" />
	<input type="hidden" name="valoare" value="<?php echo $pret; ?>" />
	<input type="hidden" name="moneda" value="RON" />
	</fieldset>
	<input id="submit" type="submit" value="<?php echo JText::_('SAUTO_PLATESTE_CU_CC'); ?>">
	</form>
<script type="text/javascript">
	document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
	
</script>
