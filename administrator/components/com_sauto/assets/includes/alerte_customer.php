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

$db = JFactory::getDbo();

$uid =& JRequest::getVar( 'uid', '', 'get', 'string' );

JHTML::_('behavior.tooltip');
?>
<table width="100%" class="sa_table_class">
	<?php
	
	$query = "SELECT `alerte` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$alerta = $db->loadResult();


	$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'c'";
	$db->setQuery($query);
	$alerts = $db->loadObjectList();
	$link_form = 'index.php?option=com_sauto&task=alerte&action=set_alert&type=customer&uid='.$uid;
	

			//obtin valoarea curenta a alertei
			$sep = ',';
			$exploded = explode(',', $alerta);
	
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

</table>
