<style type="text/css">
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}

#gkMainbody table:before {
    content: "";
	width:100%;
	
  }
  #gkMainbody table {
	 padding: 30px 0 20px 0;
    width: 540px!important;
    display: block!important;
	width:100%;
    overflow: scroll;
    max-width: 100%;
</style>
<?php
defined('_JEXEC') || die('=;)');
$document = JFactory::getDocument();
require("toggle_js_mobile.php");
$document->addScriptDeclaration ($js_code);

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' ";
$db->setQuery($query);
//$db->execute();
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 0) {
require("fara_anunturi.php");
} else {
$link = JRoute::_('index.php?option=com_sauto&view=facturi');
$query = "SELECT `f`.*, `t`.`new_upload` FROM #__sa_facturi AS `f` JOIN #__sa_tranzactii AS `t` ON `f`.`uid` = '".$uid."' AND `f`.`id` = `t`.`tranz_id` ORDER BY `f`.`id` DESC";
$db->setQuery($query);
$list = $db->loadObjectList();
require('menu_filter_d.php');
$i=1;
?>
<table width="100%!important">
	<tr>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FACT_NR_CRT'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FACT_FACTURA'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FACT_TIP_PLATA'); ?></td>
		<td valign="top" class="sa_table_cell">
			<?php echo JText::_('SAUTO_CREDITE_TRANZ').' /<br />'.JText::_('SAUTO_VALOARE_FACT'); ?>
		</td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FACT_DESCARCA'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_FACT_ORIGINALA'); ?></td>
		<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_TIP_SERVICIU'); ?></td>
	</tr>
	<?php
	$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=load_file'); 
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}	
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell">'.$i.'</td>';
			$data = explode(" ", $l->data_tr);
			//data tranzactie
			echo '<td valign="top" class="sa_table_cell">'.$data[0].'</td>';
			//serie factura/proforma
			echo '<td valign="top" class="sa_table_cell">';
				if ($l->prf == 1) {
					//proforma
					echo $l->serie_prf;
				} else {
					//factura
					echo $l->factura;
				}
				//.$l->factura.
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell" valign="top" class="sa_table_cell">';
				$tip_plata = explode(" - ", $l->factura);
				if ($tip_plata[0] == 'op') {
					echo JText::_('SA_TIP_PLATA_OP');
				} elseif ($tip_plata[0] == 'pp') {
					echo JText::_('SA_TIP_PLATA_PP');
				} elseif ($tip_plata[0] == 'cc') {
					echo JText::_('SA_TIP_PLATA_CC');
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell"vv>';
				if ($l->tip_plata == 'credit') {
					echo $l->credite;
				} else {
					echo $l->pret.' ';
						if ($tip_plata[0] == 'pp') {
							echo JText::_('SA_MONEDA_EURO');
						} else {
							echo JText::_('SA_MONEDA_LEI');
						}
				}
			echo '</td>';
			echo  '<td valign="top" class="sa_table_cell">';
				if ($l->status_tr == 1) { 
					echo '<div class="sa_fact_green">'.JText::_('SA_FACT_STATUS_PLATIT').'</div>';
				} else {
					echo '<div class="sa_fact_red">'.JText::_('SA_FACT_STATUS_NEPLATIT').'</div>';
					
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell"v>';
				if ($l->status_tr == 1) {
					$link_factura = JRoute::_('index.php?option=com_sauto&view=factura&type=fact&id='.$l->id);
					echo '<a href="'.$link_factura.'">'.JText::_('SA_FACT_LINK_FACTURA').'</a>';
				} else {
					$link_factura = 'index.php?option=com_sauto&view=factura&type=prf&id='.$l->id;
					echo '<a href="'.$link_factura.'">'.JText::_('SA_FACT_LINK_PROFORMA').'</a>';
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
				if ($l->status_tr == 1) {
					if ($l->original == 2) {
						echo '<div class="sa_fact_tr">'.JText::_('SAUTO_ORIGINAL_TRIMIS').'</div>';
					} elseif ($l->original == 1) {
						echo '<div class="sa_fact_sol">'.JText::_('SAUTO_ORIGINAL_SOLICITAT').'</div>';
					} else  { 
						$link_original = JRoute::_('index.php?option=com_sauto&view=facturi&task=original');
						echo '<form action="'.$link_original.'" method="post">';
						echo '<input type="checkbox" name="original" value="1" onChange="this.form.submit()" /> '.JText::_('SAUTO_SOLICIT');
						echo '<input type="hidden" name="id" value="'.$l->id.'" />';
						echo '<input type="hidden" name="return" value="lista" />';
						echo '</form>';
					}
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
				/*if ($l->status_tr == 0) {
					$link_aprob = JRoute::_('index.php?option=com_sauto&view=aprobplata&id='.$l->id);
					echo '<a href="'.$link_aprob.'">aproba plata</a>';
				}*/
				echo $l->tip_plata;
			echo '</td>';
		echo '</tr>';
		if ($l->status_tr == 0) { 
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell" colspan="9">';
			if ($l->new_upload == 0) {
				echo '<form method="post" action="'.$link_form.'" enctype="multipart/form-data">';
				echo '<input type="hidden" name="id_factura" value="'.$l->id.'" />'; 
				
				echo JText::_('SAUTO_FISIER_PLATA').' ';
				echo '<input type="file" name="image" value="" /> ';
				echo ' <input type="submit" value="'.JText::_('SAUTO_EFECTUARE_PLATA').'" style="float:right;"/></form>';
			} else {
				echo JText::_('SA_FISIER_INCARCAT'); 	
			} 
			echo '</td>';
		echo '</tr>';
		}
		$i++;
	}
	?>
</table>
<?php	
}
?>
<script type="text/javascript">
	document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
	
</script>