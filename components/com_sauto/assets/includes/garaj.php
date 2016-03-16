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

$db = JFactory::getDbo();

$user =& JFactory::getUser();
$uid = $user->id;

$query = "SELECT `garaj` FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$total_garaj = $db->loadResult();

$query = "SELECT count(*) FROM #__sa_garaj WHERE `owner` = '".$uid."'";
$db->setQuery($query);
$garaj = $db->loadResult();

?>


<?php
//listare masini

$img_path = JURI::base()."components/com_sauto/assets/images/";
$width = 'style="width:800px;"';
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>

<div class="sa_mail_exist">
<?php echo JText::_('SAUTO_GARAJ_NOTIFICARE'); ?>
</div>
<div style="display:inline;">
<div style="float:left;"><?php echo JText::_('SAUTO_TOTAL_MASINI_GARAJ').': '.$garaj.' '.JText::_('SAUTO_GARAJ_DIN_MAXIM').' '.$total_garaj; ?></div>
<?php
$add = JRoute::_('index.php?option=com_sauto&view=garaj&task=add');

?>

</div>
<div style="clear:both;"></div>
<br />
<hr />
<br />
<?php
echo '<table width="100%" class="sa_table_class">';
if ($garaj == 0) {
	//nici o masina in garaj
	for ($i=1;$i<6;$i++) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell">';
				echo '<img src="'.$img_path.'gray-car.png" />';
			echo '</td>';
			echo '<td colspan="2" class="sa_table_cell" align="center">';
				echo '<form action="'.$add.'" method="post">';
					echo '<input type="submit" value="'.JText::_('SAUTO_ADAUGA_IN_GARAJ').'" />';
				echo '</form>';
			echo '</td>';
		echo '</tr>';
		if ($i == 3) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						$categ = '';
						echo showAds($pozitionare, $categ);
					echo '</td>';
				echo '</tr>';	
		}
		$i++;
	//echo 'show car....<br />';
	}
} else {
	//cel putin o masina in garaj
	JHTML::_('behavior.tooltip');
	
	$query = "SELECT `g`.*, `mc`.`marca_auto`, `md`.`model_auto`, `c`.`carburant`, `cr`.`caroserie`  FROM #__sa_garaj AS `g` JOIN #__sa_marca_auto AS `mc` JOIN #__sa_model_auto AS `md` JOIN #__sa_carburant AS `c` JOIN #__sa_caroserie AS `cr` ON `g`.`owner` = '".$uid."' AND `g`.`marca` = `mc`.`id` AND `g`.`model` = `md`.`id` AND `g`.`carburant` = `c`.`id` AND `g`.`caroserie` = `cr`.`id` ORDER BY `g`.`id` DESC";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$i =1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}
		
		if ($l->transmisie == 1) {
			$trans = JText::_('SAUTO_TRANSMISIE_MANUALA');
		} elseif ($l->transmisie == 2) {
			$trans = JText::_('SAUTO_TRANSMISIE_AUTOMATA');
		} else {
			$trans = JText::_('SAUTO_TRANSMISIE_NECOMPLECTATA');
		}
		
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell">';
				echo '<img src="'.$img_path.'blue-car.png" />';

			echo '</td>';
			echo '<td align="center" class="sa_table_cell">';
				$info_auto = JText::_('SAUTO_INFO_AUTO');
				$detail_auto = JText::_('SAUTO_ANUL_FABR').' '.$l->an_fabricatie.'<br />
					'.JText::_('SAUTO_TIP_TRANSMISIE').' '.$trans.'<br />'.$l->cilindree.' cm<sup>3</sup> :: '.$l->carburant.'<br />
					'.$l->caroserie;
				echo JHtml::tooltip($detail_auto, $info_auto, '', $l->marca_auto.'  '.$l->model_auto);
				echo '<br />'.$l->serie_caroserie;

					
				echo '</td>';
				echo '<td align="center" class="sa_table_cell" width="100">';
					$link_edit = JRoute::_('index.php?option=com_sauto&view=garaj&task=edit&id='.$l->id);
					$link_delete = JRoute::_('index.php?option=com_sauto&view=garaj&task=delete&id='.$l->id);
					echo '<a href="'.$link_edit.'"><img src="'.$img_path.'edit_garaj.png" /></a>';
					echo '  ';
					echo '<a href="'.$link_delete.'"><img src="'.$img_path.'delete_garaj.png" /></a>';
				echo '</td>';
			echo '</tr>';
			echo '<tr class="sa_table_row '.$style.'">';
				echo '<td valign="top" class="sa_table_cell" colspan="3">';
					if ($l->exp_itp == '0000-00-00') { $exp_itp = JText::_('SA_NECOMPLETAT'); } else { $exp_itp = $l->exp_itp; }
					echo JText::_('SAUTO_D_EXPIRARE_ITP').': '.$exp_itp;
					if ($l->exp_rca == '0000-00-00') { $exp_rca = JText::_('SA_NECOMPLETAT'); } else { $exp_rca = $l->exp_rca; }
					echo '<span class="sa_asigurari">'.JText::_('SAUTO_D_EXPIRARE_RCA').': '.$exp_rca.'</span>';
					if ($l->exp_rvg == '0000-00-00') { $exp_rvg = JText::_('SA_NECOMPLETAT'); } else { $exp_rvg = $l->exp_rvg; }
					echo '<span class="sa_asigurari">'.JText::_('SAUTO_D_EXPIRARE_RVG').': '.$exp_rvg.'</span>';
				echo '</td>';
			echo '</tr>';
		if ($i == 3) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						$categ = '';
						echo showAds($pozitionare, $categ);
					echo '</td>';
				echo '</tr>';	
		}	
	$i++;
	}
	
	$garaj = $garaj+1;
	for ($i=$garaj;$i<6;$i++) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell">';
				echo '<img src="'.$img_path.'gray-car.png" />';
			echo '</td>';
			echo '<td colspan="2" class="sa_table_cell" align="center">';
				echo '<form action="'.$add.'" method="post">';
					echo '<input type="submit" value="'.JText::_('SAUTO_ADAUGA_IN_GARAJ').'" />';
				echo '</form>';
			echo '</td>';
		echo '</tr>';
		if ($i == 3) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						$categ = '';
						echo showAds($pozitionare, $categ);
					echo '</td>';
				echo '</tr>';	
		}	
	}
}

echo '</table>';

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
			</div>
		</td>
	</tr>
</table>
