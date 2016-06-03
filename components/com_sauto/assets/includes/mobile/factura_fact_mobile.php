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

//obtin cursul euro
$query = "SELECT `curs_euro` FROM #__sa_curs_valutar WHERE `data` LIKE '".$data[0]."%'";
$db->setQuery($query);
$curs_v = $db->loadResult();
//echo $query.'<br />>>> '.$curs_v;
//selectez ce se prelucreaza, creditele sau valoarea in lei
if ($date_f->tip_plata == 'credit') {
	$credite = $date_f->credite;
} else {
	if ($date_f->moneda == 3) { 
	$credite = ($date_f->pret*$curs_v);
	} else {
	$credite = $date_f->pret;
	}
}
//obtin pret fara tva
//echo 'credite > '.$credite.'<br />';
$fara_tva_tot = $credite/(1.24);
//echo 'brut > '.$fara_tva_tot.'<br />';
$fara_tva_tot_r = round($fara_tva_tot, 2);
//echo 'p. f. tva tot > '.$fara_tva_tot_r.'<br />';
$fara_tva_u = $fara_tva_tot/$credite;
//echo 'brut > '.$fara_tva_u.'<br />';
$fara_tva_u_r = round($fara_tva_u, 2);
//echo 'pret f tva unit > '.$fara_tva_u_r.'<br />';
$tva_tot = $credite - $fara_tva_tot;
//echo 'tva brut total > '.$tva_tot.'<br />';
$tva_u = $tva_tot / $credite;
//echo 'tva unit brut> '.$tva_u.'<br />';
$tva_u_r = round($tva_u, 2);
//echo 'tva u > '.$tva_u_r.'<br />';
$total_u = $credite * $fara_tva_u;
//echo 'total fara tva brut > '.$total_u.'<br />';
$total_u_r = round($total_u, 2);
//echo 'total fara tva > '.$total_u_r.'<br />';
$total_tva = $credite * $tva_u;
//echo 'tva brut > '.$total_tva.'<br />';
$total_tva_r = round($total_tva, 2);
//echo 'tva > '.$total_tva_r.'<br />';
$totalul = $total_u + $total_tva;
//echo 'totalul > '.$totalul;
?>
<div style="float:right;margin-bottom:10px;">
<input type=button onclick="printDiv('printnow')" value="<?php echo JText::_('SAUTO_FACT_TIPARESTE_FACTURA'); ?>" />
</div>
<br /><br />
<div class="print" id="printnow">
<table width="100%" class="sa_table_class" cellpadding="0"  cellspacing="0">
	<tr>
		<td colspan="3" align="right">
<?php 
echo JText::_('SA_FACT_SERIA').' <strong>'.$serii[1].'</strong> '.JText::_('SA_FACT_NR').' <strong>'.$serii[2].'</strong>';
?>
		</td>
	</tr>
	<tr>
		<td valign="top" width="35%"><?php require("furnizor.php"); furnizor(); ?></td>
		<td valign="top" align="center">
		<br /><br />
			<div class="sa_fact_title"><?php echo JText::_('SA_FACT_LINK_FACTURA').'<br />'.$serii[1].' '.$serii[2].' / '.$data[0]; ?></div>
			<img src="<?php echo $img_path; ?>logo_site.png" width="150" border="0" />
			<div>
			<?php $link_site = JUri::base(); ?>
			<a href="<?php echo $link_site; ?>" class="sa_fact_site"><?php echo JText::_('SAUTO_FACTURA_SITE'); ?></a>
			</div>
		</td>
		<td valign="top" width="35%"><?php client($uid); ?></td>
	</tr>
	<tr>
		<td colspan="3" align="center"><?php echo JText::_('SA_FACT_FACT_NR').' '.$serii[2].' '.JText::_('SA_FACT_DIN_DATA').' '.$data[0]; ?></td>
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
					//denumire factura
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
					//cantitate
					if ($date_f->tip_plata == 'credit') { 
						echo $credite; 
					} else {
						echo '1';
					} ?>
				</td>
				<td>
					<?php
					//pret
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
			<div class="print2">
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
