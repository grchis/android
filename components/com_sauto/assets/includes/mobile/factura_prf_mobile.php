<style type="text/css">
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}

#gkMainbody table tbody{
		width:100%!important;
}
#gkMainbody table thead{
		width:100%!important;
}
  #gkMainbody table tr{
	  width:100%;
  }
#gkMainbody table:before {
    content: "";
	width:100%;
	
  }
 #gkMainbody table  th {
	border-top: 1px solid #222;
    border-bottom: 1px solid #e5e5e5;
    color: #222; 
    font-weight: 600;
    padding: 10px;
    text-align: left;
  }

</style>
<?php
defined('_JEXEC') || die('=;)');
$document =& JFactory::getDocument();
$document->addStyleSheet( 'components/com_sauto/assets/media.css', 'text/css', 'print' );
$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'includes'.DS;
require($path."print.php");
$document->addScriptDeclaration ($js_code);
$link = JRoute::_('index.php?option=com_sauto&view=facturi');
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//obtin date factura
$query = "SELECT * FROM #__sa_facturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$date_f = $db->loadObject();
$serii = explode(" - ", $date_f->factura);
$data = explode(" ", $date_f->data_tr);
//reprezentant firma
$query = "SELECT `reprezentant` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$repr = $db->loadResult();
$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
//selectez ce se prelucreaza, creditele sau valoarea in lei
if ($date_f->tip_plata == 'credit') {
	$credite = $date_f->credite;
} else {
	$credite = ($date_f->pret*$date_f->curs_euro);
}
//obtin pret fara tva
$fara_tva_tot = $credite/(1.24);
$fara_tva_tot_r = round($fara_tva_tot, 2);
$fara_tva_u = $fara_tva_tot/$credite;
$fara_tva_u_r = round($fara_tva_u, 2);
$tva_tot = $credite - $fara_tva_tot;
$tva_u = $tva_tot / $credite;
$tva_u_r = round($tva_u, 2);
$total_u = $credite * $fara_tva_u;
$total_u_r = round($total_u, 2);
$total_tva = $credite * $tva_u;
$total_tva_r = round($total_tva, 2);
$totalul = $total_u + $total_tva;
require('menu_filter_d.php');
?>
<div style="float:right;margin-bottom:10px;">
<input type=button onclick="printDiv('printnow')" value="<?php echo JText::_('SAUTO_FACT_TIPARESTE_PROFORMA'); ?>" />
</div>

<br /><br />
<div class="print" id="printnow">
<table width="100%" class="sa_table_class" cellpadding="0"  cellspacing="0" border="0">
	<tr>
		<td colspan="3" align="right">
<?php 
echo JText::_('SA_FACT_SERIA').' <strong>'.$date_f->serie_prf.'</strong>';
?>
		</td>
	</tr>
	<tr>
		<td valign="top" width="35%"><?php require("furnizor_mobile.php"); furnizor(); ?></td>
		<td valign="top" align="center">
			<br /><br />
			<div class="sa_fact_title"><?php echo JText::_('SAUTO_FACTURA_PROFORMA'); ?></div>
			<img src="<?php echo $img_path; ?>logo_site.png" width="150" border="0" />
			<div>
			<?php $link_site = JUri::base(); ?>
			<a href="<?php echo $link_site; ?>" class="sa_fact_site"><?php echo JText::_('SAUTO_FACTURA_SITE'); ?></a>
			</div>
		</td>
		<td valign="top" width="35%"><?php client($uid); ?></td>
	</tr>
	<tr>
		<td colspan="3" align="center"><?php echo JText::_('SAUTO_FACTURA_PROFORMA').' '.$date_f->serie_prf.' '.JText::_('SA_FACT_DIN_DATA').' '.$data[0]; ?></td>
	</tr>	
	<tr>
		<td colspan="3">
		<table width="100%">
			<tr>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_NR_CRT'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_DENUMIRE'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_UM'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_CANTITATE'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_PRET_UNITAR'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_VAL_F_TVA'); ?></td>
				<td class="sa_factura_header"><?php echo JText::_('SAUTO_FACT_VAL_TVA'); ?></td>
			</tr>
			<tr>
				<td>1</td>
				<td>
					<?php 
					if ($date_f->tip_plata == 'credit') {
						echo JText::_('SAUTO_FACT_CUMPARARE_CREDITE');
					} else {
						echo JText::_('SAUTO_FACT_ABONAMENT');	
					}
					?>
				</td>
				<td>buc.</td>
				<td>
					<?php
					if ($date_f->tip_plata == 'credit') { 
						echo $credite; 
					} else {
						echo '1';
					} ?>
				</td>
				<td>
					<?php
					if ($date_f->tip_plata == 'credit') { 
						echo '1'; 
					} else {
						echo $credite;
					} ?>
				</td>
				<td><?php echo round(($fara_tva_u*$credite), 2); ?></td>
				<td><?php echo round(($tva_u*$credite), 2); ?></td>
			</tr>
			<tr>
				<td colspan="5"><?php echo JText::_('SAUTO_FACT_TOTAL'); ?></td>
				<td><?php echo $fara_tva_tot_r; ?></td>
				<td><?php echo $total_tva_r; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<div style="margin-top:300px;">
			<table width="100%">
				<tr>
					<td valign="top" width="20%">
						<?php echo JText::_('SAUTO_FACT_SEMNATURA_STAMPILA'); ?>
					</td>
					<td valign="top" width="40%">
						<?php echo JText::_('SAUTO_FACT_DATE_EXPEDITIE'); ?><br />
						<?php echo JText::_('SAUTO_FACT_DELEGAT').' '.$repr; ?><br />
						<?php echo JText::_('SAUTO_FACT_BI_CI'); ?> .....<br />
						<?php echo JText::_('SAUTO_FACT_AUTO'); ?> .....<br />
						<?php echo JText::_('SAUTO_FACT_SEMNATURI'); ?>......<br />
					</td>
					<td valign="top">
						<?php echo JText::_('SAUTO_FACT_TOTAL_DIN'); ?><br />
						<br /><br />
						<?php echo JText::_('SAUTO_FACT_SDEMNATURA_PRIMIRE'); ?><br />
						.................
					</td>
					<td valign="top">
					<?php echo $total_u_r; ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $total_tva_r; ?>
					<br />
					<br />
					<?php echo JText::_('SAUTO_FACT_TOTAL_PLATA'); ?>
					<br /><br />
					<?php echo $credite; ?>
					</td>
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>
</div>
<div style="float:right;margin-top:10px;">
<a href="<?php echo $link; ?>"><?php echo JText::_('SAUTO_FACT_INAPOI_LA_FACTURI'); ?></a>
</div>
<script type="text/javascript">
	document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
	
</script>