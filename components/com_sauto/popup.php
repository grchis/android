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
//echo '>>>> '.$type;

$document = JFactory::getDocument ();
$ajaxlink = 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$document->addScript($ajaxlink);
require("popup.js");
$document->addScriptDeclaration ($jspopup);
$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
$db = JFactory::getDbo();
if ($type == 'c') {	
	//client fara alerte
	$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'c'";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$link = JRoute::_('index.php?option=com_sauto&view=setalert&task=client');
	?>
	<div id="boxes">
	<div style="top:150px; left: 551.5px; display: none;" id="dialog" class="window">
	<div style=" float:left; font-weight:bold; font-size:16px; padding-left:5px;"><?php echo JText::_('SAUTO_SETEAZA_ALERTELE'); ?></div>
	<div align="right" style="font-weight:bold; margin:5px 3px 0 0;"><a href="javascript:void()" class="close"><img src="<?php echo $img_path; ?>close.png" width="16" style="border:none; cursor:pointer;" /></a></div>
	
	<div align="center" style="margin:5px 0 5px 0;">
	<form method="post" action="<?php echo $link; ?>">
		
		<table width="80%" class="sa_table_class">
			<tr class="sa_table_row"><td class="sa_table_cell" align="center">
				<h3><?php echo JText::_('SAUTO_H3_ALERTE_CLIENTI'); ?></h3>
			</td></tr>
		<?php
		foreach ($list as $l) {
			echo '<tr class="sa_table_row"><td class="sa_table_cell" align="left"><input type="checkbox" name="alerta_'.$l->id.'" value="s-'.$l->id.'" /> '.$l->nume_alerta.'</td></tr>';
		}
		?>
		<tr class="sa_table_row">
		<td class="sa_table_cell" align="center"><input type="submit" value="<?php echo JText::_('SAUTO_SETEAZA_ALERTE_NOI'); ?>" /></td>
		</tr>
		</table>
	</form>
	</div>
	
	</div>
	
	<!-- Mask to cover the whole screen -->
	<div style="width: 2000px; height: 2000px; display: none; opacity: 0.7;" id="mask"></div>
	</div>
	<?php
} elseif ($type == 'd') {
	//dealer fara alerte
	$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'd'";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$link = JRoute::_('index.php?option=com_sauto&view=setalert&task=dealer');
	?>
	<div id="boxes_d">
	<div style="top:150px; left: 551.5px; display: none;" id="dialog" class="window">
	<div style=" float:left; font-weight:bold; font-size:16px; padding-left:5px;"><?php echo JText::_('SAUTO_SETEAZA_ALERTELE'); ?></div>
	<div align="right" style="font-weight:bold; margin:5px 3px 0 0;"><a href="javascript:void()" class="close"><img src="<?php echo $img_path; ?>close.png" width="16" style="border:none; cursor:pointer;" /></a></div>
	
	<div align="center" style="margin:5px 0 5px 0;">
	<form method="post" action="<?php echo $link; ?>">
		
		<table width="80%" class="sa_table_class">
		<tr class="sa_table_row">
		<td class="sa_table_cell" align="center">
		<h3><?php echo JText::_('SAUTO_H3_ALERTE_CLIENTI'); ?></h3>
		</td>
		</tr>
		<?php
		foreach ($list as $l) {
			if ($l->multiple == 0) { $sg = 's'; } else { $sg = 'm'; }
			echo '<tr class="sa_table_row"><td class="sa_table_cell" align="left"><input type="checkbox" name="alerta_'.$l->id.'" value="'.$sg.'-'.$l->id.'" /> '.$l->nume_alerta.'</td></tr>';
		}
		$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
		$db->setQuery($query);
		$acts = $db->loadObjectList();
		echo '<tr class="sa_table_row"><td class="sa_table_cell" align="center"><h3>'.JText::_('SAUTO_SETATI_CATEGORII_ACTIVITATE').'</h3></td></tr>';
		foreach ($acts as $a) {
			echo '<tr class="sa_table_row"><td class="sa_table_cell" align="left"><input type="checkbox" name="act_'.$a->id.'" value="1" /> '.$a->tip.'</td></tr>';
		}
		?>
		
		<tr class="sa_table_row">
		<td class="sa_table_cell" align="center"><input type="submit" value="<?php echo JText::_('SAUTO_SETEAZA_ALERTE_NOI'); ?>" /></td>
		</tr>
		</table>
	</form>
	</div>
	
	</div>
<?php
}
