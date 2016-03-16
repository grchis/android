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

$document =& JFactory::getDocument();
$document->addStyleSheet( 'components/com_sauto/assets/media.css', 'text/css', 'print' );

$js_code = 'function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}';
$document->addScriptDeclaration ($js_code);

$link = JRoute::_('index.php?option=com_sauto&task=financiar&action=facturi');
$db = JFactory::getDbo();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
echo '<h3>Afisare factura</h3>';
//obtin date factura
$query = "SELECT * FROM #__sa_facturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$date_f = $db->loadObject();
$serii = explode(" - ", $date_f->factura);
$data = explode(" ", $date_f->data_tr);
//reprezentant firma
$query = "SELECT `reprezentant` FROM #__sa_profiles WHERE `uid` = '".$date_f->uid."'";
$db->setQuery($query);
$repr = $db->loadResult();

//obtin cursul euro
$query = "SELECT `curs_euro` FROM #__sa_curs_valutar WHERE `data` LIKE '".$data[0]."%'";
$db->setQuery($query);
$curs_v = $db->loadResult();

//selectez ce se prelucreaza, creditele sau valoarea in lei
if ($date_f->tip_plata == 'credit') {
	$credite = $date_f->credite;
} else {
	$credite = ($date_f->pret*$curs_v);
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
$img_path = JUri::root().'components/com_sauto/assets/images/';
//echo '>>> '.$img_path;
?>
<div style="float:right;margin-bottom:10px;">
<input type=button onclick="printDiv('printnow')" value="Tipareste factura" />
</div>
<br /><br /><br />
<div class="print" id="printnow">
<table width="100%" class="sa_table_class" cellpadding="0"  cellspacing="0">
	<tr>
		<td colspan="3" align="right">
<?php 
echo 'Seria <strong>'.$serii[1].'</strong> nr. <strong>'.$serii[2].'</strong>';
?>
		</td>
	</tr>
	<tr>
		<td valign="top" width="35%">
			<?php 
			$path = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'includes'.DS.'furnizor.php';
			require($path); furnizor(); ?></td>
		<td valign="top" align="center" width="35%">
		<br /><br />
			<div class="sa_fact_title">Factura<br /><?php echo $serii[1].' '.$serii[2].' / '.$data[0]; ?></div>
			<img src="<?php echo $img_path; ?>logo_site.png" width="150" border="0" />
			<div>
			<?php $link_site = JUri::root(); ?>
			<a href="<?php echo $link_site; ?>" class="sa_fact_site">www.siteauto.ro</a>
			</div>
		</td>
		<td valign="top" align="right"><?php client($date_f->uid); ?></td>
	</tr>
	<tr>
		<td colspan="3" align="center"><?php echo 'Fact. nr. '.$serii[2].' din data '.$data[0]; ?></td>
	</tr>	
	<tr>
		<td colspan="3">
		<table width="100%">
			<tr>
				<td class="sa_factura_header">Nr. Crt.</td>
				<td class="sa_factura_header">Denumire</td>
				<td class="sa_factura_header">U.M.</td>
				<td class="sa_factura_header">Cantitate</td>
				<td class="sa_factura_header">Pret unitar</td>
				<td class="sa_factura_header">Val. f. TVA</td>
				<td class="sa_factura_header">Val. TVA</td>
			</tr>
			<tr>
				<td>1</td>
				<td>
					<?php 
					if ($date_f->tip_plata == 'credit') {
						echo 'Credite';
					} else {
						echo 'Abonament';	
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
				<td colspan="5">Total</td>
				<td><?php echo $fara_tva_tot_r; ?></td>
				<td><?php echo $total_tva_r; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<div style="margin-top:800px;">
			<table width="100%">
				<tr>
					<td valign="top" width="20%">
						Semnatura si stampila furnizorului
					</td>
					<td valign="top" width="40%">
						Date expeditie:<br />
						<?php echo 'Delegat: '.$repr; ?><br />
						BI/CI: .....<br />
						Auto: .....<br />
						Semnaturi......<br />
					</td>
					<td valign="top">
						Total din<br />care accize<br />
						<br /><br />
						Semnatura primire<br />
						.................
					</td>
					<td valign="top">
					<?php echo $total_u_r; ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $total_tva_r; ?>
					<br />
					<br />
					Total de plata
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
<a href="<?php echo $link; ?>">Inapoi la lista de facturi</a>
</div>

