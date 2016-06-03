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
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->LoadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=proforma'); 
require("menu_filter_d.php");
?>

<h4><strong><?php echo JText::_('SAUTO_METODA_DE_PLATA').': '.JText::_('SAUTO_METODA_PLATA_OP');?></strong></h4>
<div><?php echo JText::_('SAUTO_PLATA_OP_DETALII2'); ?></div>

<br /><br />
<h4><?php echo JText::_('SAUTO_INSERT_FINANCIAR_DATES'); ?></h4>
<form method="post" action="<?php echo $link_form; ?>" enctype="multipart/form-data">
	<fieldset style="margin-bottom: 15px;">
				<p> <?php echo JText::_('SAUTO_COMPANIE'); ?> </p>
				<input type="text" name="d_companie" value="<?php echo $profil->companie; ?>" disabled />
				<p><?php echo JText::_('SAUTO_FORM_EMAIL'); ?></p>
				<input type="text" name="email" value="<?php echo $user->email; ?>" disabled />
				<p><?php echo JText::_('SAUTO_REPREZENTANT'); ?></p>
				<input type="text" name="d_reprezentant" value="<?php echo $profil->reprezentant; ?>" disabled />
				<p><?php echo JText::_('SAUTO_PRET_TRANZ'); ?></p>
				<input type="text" name="d_pret" value="<?php echo $pret; ?>" disabled />
				<input type="hidden" name="pret" value="<?php echo $pret; ?>" />
				<p><?php echo ' '.JText::_('SAUTO_LEI'); ?></p>
				<input type="hidden" name="moneda" value="1" />
				<input type="hidden" name="metoda_plata" value="op" />
				<input type="hidden" name="tip_plata" value="puncte" />
				<?php 
				$link_prf = JRoute::_('index.php?option=com_sauto&view=edit_profile');
				echo '<p>'.JText::_('SAUTO_WRONG_PROFILE_DATES').' <a href="'.$link_prf.'">'.JText::_('SAUTO_GO_TO_PROFILE').'</a></p>'; ?>
		</fieldset>
		<input id="submit" type="submit" value="<?php echo JText::_('SA_GENERARE_PROFORMA'); ?>" />
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
