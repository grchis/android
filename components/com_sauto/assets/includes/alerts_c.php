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
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>

	<h3>
		<?php echo JText::_('SAUTO_SELECT_ALERTS'); ?>
	</h3>
<br />
<table width="100%" class="sa_table_class">
	<?php

	$query = "SELECT `alerte` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$alerta = $db->loadResult();


	$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'c'";
	$db->setQuery($query);
	$alerts = $db->loadObjectList();
	$link_form = JRoute::_('index.php?option=com_sauto&view=set_alert');


			//echo '<hr />'.$alerta.'<hr />';
			//obtin valoarea curenta a alertei
			$sep = ',';
			//echo '>>>> '.$sep.'<br />';
			$exploded = explode(',', $alerta);
			//echo print_r($exploded).'<br />';



		$i=0;
	foreach ($alerts as $a) {
		if ($style == ' sa-row1 ') {
			$style = ' sa-row0 ';
			} else {
			$style = ' sa-row1 ';
			}

			$expl = explode('_', $exploded[$i]);
			//print_r($expl);
			//echo '<br />';
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td class="sa_table_cell">';
				//start creare tabel

					echo JHtml::tooltip($a->descriere, $a->nume_alerta, '', $a->nume_alerta);
echo '</td>';
		echo '<td class="sa_table_cell" align="right" width="100">';
							echo '<form action="'.$link_form.'" method="post" name="set_alert_'.$a->id.'" id="set_alert_'.$a->id.'">';
							//
							echo '<input type="hidden" name="old_value" value="s-'.$a->id.'_'.$expl[1].'" />';
								if ($expl[1] == 0) { $new_v = 1; } else { $new_v = 0; }
							echo '<input type="hidden" name="new_value" value="s-'.$a->id.'_'.$new_v.'" />';
							echo '</form>';
							echo '<div style="display:inline;">';
							echo '<div style="float:left;" class="sa_alert_box sa_hover ';
							// sa_alert_selected
								if ($expl[1] == 1) { echo 'sa_alert_selected'; } else { echo 'sa_cursor'; }
							echo '"';
								if ($expl[1] == 0) { echo ' onClick="document.forms[\'set_alert_'.$a->id.'\'].submit();" '; }
							echo '>'.JText::_('SAUTO_ALERT_YES').'</div>';
							echo '<div style="float:left;" class="sa_alert_box sa_hover ';
							//sa_cursor
								if ($expl[1] == 0) { echo 'sa_alert_selected'; } else { echo 'sa_cursor'; }
							echo '"';
								if ($expl[1] == 1) { echo ' onClick="document.forms[\'set_alert_'.$a->id.'\'].submit();" '; }
							echo '>'.JText::_('SAUTO_ALERT_NO').'</div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
						echo '</td>';
					echo '</tr>';

				?>

				<?php
			echo '</td>';
		echo '</tr>';
	$i++;
	}
	?>
	<tr>
				<td colspan="2">
					<?php
					$pozitionare = 'c';
					$categ = '';
					echo showAds($pozitionare, $categ);
					?>
				</td>
			</tr>
</table>

			<div>
				<?php
				echo $alert_det_article;
				?>
			</div>



<?php
//echo JHtml::tooltip('Tooltip Text', 'Tooltip Title', '', 'text la care apare tooltip');
?>
</td>
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
