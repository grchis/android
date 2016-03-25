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
require_once('/mobile/alerts_d_mobile.php');
}else{
$document = JFactory::getDocument ();
$app =& JFactory::getApplication();
$app->setUserState('url_alert', 'alerte');


require("toggle_js.php");
$document->addScriptDeclaration ($js_code);

JHTML::_('behavior.tooltip');

$user =& JFactory::getUser();
$uid = $user->id;

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->alerts_article."'";
$db->setQuery($query);
$alerts_article = $db->loadResult();

$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->alert_det_article."'";
$db->setQuery($query);
$alert_det_article = $db->loadResult();
$width = 'style="width:800px;"';

$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$prf = $db->loadObject();
//print_r($prf);
//echo '>>>> '.$prf->categorii_activitate;
$alerta = $prf->alerte;

$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'd'";
$db->setQuery($query);
$alerts = $db->loadObjectList();
$link_form = JRoute::_('index.php?option=com_sauto&view=set_alert');
$sep = ',';
$exploded = explode(',', $alerta);
?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
			<h3>
				<?php echo JText::_('SAUTO_SELECT_ALERTS'); ?>
			</h3>
			<table width="100%" class="sa_table_class">
				<tr class="sa_table_row">
					<td class="sa_table_cell" colspan="2">
		<?php
		$cats = explode(",", $prf->categorii_activitate);
		$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
		$db->setQuery($query);
		$tip = $db->loadObjectList();

		?>
						<table class="sa_table_class" width="100%">
							<tr class="sa_table_row">
								<td class="sa_factura_header"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></td>
								<td class="sa_factura_header"><?php echo JText::_('SAUTO_DEALER_DOMENIU_ACT'); ?></td>

								<td class="sa_factura_header"><?php echo JText::_('SAUTO_EDIT_REQUEST'); ?></td>
							</tr>
	<?php
		foreach ($tip as $t) {
			$link_alerts_edit = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_edit&id='.$t->id);
			$link_alerts_enable = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_enable&id='.$t->id);
			$valoare = $t->id.'-1';
							echo '<tr class="sa_table_row">';
								echo '<td class="sa_table_cell">';
					if (in_array($valoare, $cats)) {
						echo '<img src="'.$img_path.'check_yes.png" width="22" />';
					} else {
						echo '<img src="'.$img_path.'check_no.png" width="22" />';
					}
								echo '</td>';
								echo '<td class="sa_table_cell">'.$t->tip.'</td>';
								echo '<td class="sa_table_cell">';
					if (in_array($valoare, $cats)) {
						echo '<a href="'.$link_alerts_edit.'">'.JText::_('SA_ALERTS_EDIT').'</a>';
					} else {
						echo '<a href="'.$link_alerts_enable.'">'.JText::_('SA_ALERTS_ENABLE').'</a>';
					}
								echo '</td>';
							echo '</tr>';
		}
	?>

							<tr class="sa_table_row">
								<td colspan="3">
									<?php $link_frm = JRoute::_('index.php?option=com_sauto&view=process&task=z_alert'); ?>
									<form action="<?php echo $link_frm; ?>" method="post">
			<?php
			//verificam daca sunt alerte setate
			$query = "SELECT `alert_id` FROM #__sa_zalerte WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$alerta = $db->loadResult();
			if ($alerta == '') { $alerta  = '4'; }
			?>
									<table class="sa_table_class" width="100%">
										<tr class="sa_table_row">
											<td class="sa_table_cell" valign="top">
					<?php
					$q = 27;
					//$i = 1;


					//preluam valorile
					$query = "SELECT * FROM #__sa_zil_alert WHERE `published` = '1'";
					$db->setQuery($query);
					$list = $db->loadObjectList();
	$i=0;
	echo '<table class="sa_table_class">';
	foreach($list as $l) {
		if (!$i%2) echo '<tr class="sa_table_row">';
			echo '<td class="sa_table_cell">';
				echo '<input type="radio" name="alerta" value="'.$l->id.'" ';
					if ($l->id == $alerta) { echo ' checked '; }
				echo ' /> ';
					echo $l->nume;
			echo '</td>';
		if ($i%2) echo '</tr>';
      $i++;
	}
	echo '</table>';

					?>
											</td>
											<td class="sa_table_cell" valign="top" align="right">
<?php  if ($prf->categorii_activitate != '') { ?>
												<input type="submit" value="<?php echo JText::_('SAUTO_SETEAZA_ALERTA'); ?>" />
<?php } ?>
											</td>
										</tr>
									</table>

									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>

	<?php
$i=0;
	foreach ($alerts as $a) {
		if ($style == ' sa-row1 ') {
			$style = ' sa-row0 ';
			} else {
			$style = ' sa-row1 ';
			}

			$expl = explode('_', $exploded[$i]);
			//print_r($exploded);
			//echo '<br />';
			if ($a->multiple == 0) {
		echo '<tr class="sa_table_row '.$style.'">';
		echo '<td class="sa_table_cell">';
			//.$a->nume_alerta.
			echo JHtml::tooltip($a->descriere, $a->nume_alerta, '', $a->nume_alerta);
		echo '</td>';
		echo '<td class="sa_table_cell" align="right" width="100">';
			echo '<form action="'.$link_form.'" method="post" name="set_alert_'.$a->id.'" id="set_alert_'.$a->id.'">';
			//
			if ($a->multiple == 1) {
				//echo 'old 1-1';
				echo '<input type="hidden" name="old_value" value="m-'.$a->id.'_'.$expl[1].'" />';
			} else {
				//echo 'old 1-2';
				echo '<input type="hidden" name="old_value" value="s-'.$a->id.'_'.$expl[1].'" />';
			}
			if ($expl[1] == 0) { $new_v = 1; } else { $new_v = 0; }
			if ($a->multiple == 1) {
				//echo 'new 2-1';
				echo '<input type="hidden" name="new_value" value="m-'.$a->id.'_'.$new_v.'[]" />';
			} else {
				//echo 'new 2-2';
				echo '<input type="hidden" name="new_value" value="s-'.$a->id.'_'.$new_v.'" />';
			}
			echo '</form>';
			echo '<div style="display:inline;">';
				echo '<div style="float:left;" class="sa_alert_box ';
					// sa_alert_selected
					if ($expl[1] == 1) { echo 'sa_alert_selected'; } else { echo 'sa_cursor'; }
				echo '"';
					if ($expl[1] == 0) { echo ' onClick="document.forms[\'set_alert_'.$a->id.'\'].submit();" '; }
				echo '>'.JText::_('SAUTO_ALERT_YES').'</div>';
				echo '<div style="float:left;" class="sa_alert_box ';
					//sa_cursor
					if ($expl[1] == 0) { echo 'sa_alert_selected'; } else { echo 'sa_cursor'; }
				echo '"';
					if ($expl[1] == 1) { echo ' onClick="document.forms[\'set_alert_'.$a->id.'\'].submit();" '; }
				echo '>'.JText::_('SAUTO_ALERT_NO').'</div>';
			echo '</div>';
			echo '<div style="clear:both;"></div>';
		echo '</td>';
	echo '</tr>';
		} else {

		}
	$i++;
	}

?>
</table>

			<div>
				<?php
				echo $alert_det_article;
				?>
			</div>

<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
		?>
		<div class="sauto_main_right">
		<?php echo $alerts_article; ?>
	</div>
			</div>
		</td>
	</tr>
</table>
<?php }?>

