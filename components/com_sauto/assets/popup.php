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
$path_js = JPATH_COMPONENT.DS.'assets'.DS.'script'.DS.'popup.js';
require($path_js);
$document->addScriptDeclaration ($jspopup);
$document->addScriptDeclaration ($jspopup2);
$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
$db = JFactory::getDbo();
if ($type == 'd') {
	//dealer fara categorii activitate
	//$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'd'";
	//$db->setQuery($query);
	//$list = $db->loadObjectList();
	
	$link = JRoute::_('index.php?option=com_sauto&view=setalert&task=dealertemp');
	//obtinem judetele
	$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
	$db->setQuery($query);
	$judet = $db->loadObjectList();
			
	//obtinem marci auto
	$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
	$db->setQuery($query);
	$marci = $db->loadObjectList();
					
	?>
	<div id="boxes_d">
	<div style="top:150px; left: 551.5px; display: none;" id="dialog" class="window">
	<div style=" float:left; font-weight:bold; font-size:16px; padding-left:5px;"><?php echo JText::_('SAUTO_SETARI_DOMENIU_ACT'); ?></div>
	<div align="right" style="font-weight:bold; margin:5px 3px 0 0;"><a href="javascript:void()" class="close"><img src="<?php echo $img_path; ?>close.png" width="16" style="border:none; cursor:pointer;" /></a></div>
	
	<div align="center" style="margin:5px 0 5px 0;">
	
	
		<table width="95%" class="sa_table_class">
		<?php
$url =& JURI::getInstance(  );
//echo 'URI is ' . $url->toString();
		$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
		$db->setQuery($query);
		$acts = $db->loadObjectList();
		echo '<tr class="sa_table_row"><td class="sa_table_cell" align="center" colspan="2"><h3>'.JText::_('SAUTO_SETATI_CATEGORII_ACTIVITATE').'</h3></td></tr>';
		foreach ($acts as $a) {
			//obtin alert_temp
			$query = "SELECT `alert_id` FROM #__sa_alert_temp WHERE `uid` = '".$uid."' AND `alert_id` = '".$a->id."'";
			$db->setQuery($query);
			$setat = $db->loadResult();
			//echo '>>>>> '.$setat.'<br />';
			echo '<tr class="sa_table_row">';
				if ($setat == $a->id) {
					echo '<td class="sa_table_cell" align="left" valign="top" width="200">';
					echo '<div style="display:inline;"><div id="img'.$a->id.'" style="float:left;">';
					 
					echo '</div>';
					echo ' <div>'.$a->tip.'</div><div style="clear:both;"></div></td>';
					echo '<td class="sa_table_cell" align="left" valign="top">';
						echo JText::_('SAUTO_ALERTA_SETATA_DEJA');
					echo '</td>';
				} else {
					echo '<form method="post" action="'.$link.'">';
				echo '<td class="sa_table_cell" align="left" valign="top" width="200">';
					echo '<div style="display:inline;"><div id="img'.$a->id.'" style="float:left;">';
						echo '<input type="checkbox" name="act_'.$a->id.'" value="1" id="sel'.$a->id.'" 	onclick="showMe(\'div'.$a->id .'\', \'act_'.$a->id.'\')" />';
					echo '</div>';
				echo ' <div>'.$a->tip.'</div><div style="clear:both;"></div></td>';
				echo '<td class="sa_table_cell" align="left" valign="top">';
					echo '<div id="div'.$a->id.'" style="display:none">';
						?>
<div style="display:inline;">
	<?php if ( ($a->id == '2') OR ($a->id == '5')) { 

	} else {  ?>
	<div style="float:left;width:250px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_m_all_<?php echo $a->id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></div>
			<?php foreach ($marci as $m) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_m_'.$a->id.'_'.$m->id.'" value="1" /> ';
					echo ' '.$m->marca_auto.'</div>';
				} ?>
		</div>
	</div>
	<?php } ?>
	<div style="float:left;width:250px;margin-left:20px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_j_all_<?php echo $a->id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?></div>
			<?php foreach ($judet as $j) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_j_'.$a->id.'_'.$j->id.'" value="1" /> ';
					echo ' '.$j->judet.'</div>';
				} ?>
		</div>
	</div>
</div>
<div style="clear:both;"></div>	
<div style="margin-top:10px;">
	<input type="hidden" name="url" value="<?php echo $url->toString(); ?>" />
	<input type="hidden" name="alert_id" value="<?php echo $a->id; ?>" />
	<input type="submit" value="<?php echo JText::_('SA_SETEAZA_ALERTA_2'); ?>" /></div>					<?php
					//echo '>>> '.$a->id;
					echo '</div>';
					
					echo '</form>';
				}
				echo '</td>';
			echo '</tr>';
		}
		?>
		
		<tr class="sa_table_row">
		<td class="sa_table_cell" align="center" colspan="2">
			<?php
			$link2 = JRoute::_('index.php?option=com_sauto&view=setalert&task=dealer');
			echo '<form method="post" action="'.$link2.'">';
			?>
			<input type="submit" value="<?php echo JText::_('SAUTO_SETEAZA_ALERTE_NOI'); ?>" />
			</form>
			</td>
			
		</tr>
		</table>
		<?php /*<div id="img1">div 1</div>
		<div id="img2">div 2</div>
		<div id="div1">rezult div 1</div>
		<div id="div2">rezult div 2</div>
		<div id="div3">rezult div 3</div>
		<div id="div4">rezult div 4</div>
		*/ ?>
		<script>
$("#img1").on('click', function() {
   $(this).hide();
   $("#div1").show();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});

$("#img2").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").show();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img3").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").show();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img4").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").show();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img5").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").show();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img6").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").show();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img7").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").show();
   $("#div8").hide();
   $("#div9").hide();
});
$("#img8").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").show();
   $("#div9").hide();
});
$("#img9").on('click', function() {
   $(this).hide();
   $("#div1").hide();
   $("#div2").hide();
   $("#div3").hide();
   $("#div4").hide();
   $("#div5").hide();
   $("#div6").hide();
   $("#div7").hide();
   $("#div8").hide();
   $("#div9").show();
});
</script>
	</div>
	
	</div>
<?php
}
