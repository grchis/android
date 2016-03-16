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
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$user =& JFactory::getUser();
$uid = $user->id;
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
Jhtml::_('behavior.modal');

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

//poza user
$query = "SELECT `poza`, `fullname` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$prf = $db->loadObject();
$width = 'style="width:800px;"';
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	
		<table width="100%" class="sa_table_class">
			<tr class="sa_table_row">
				<td colspan="2" class="sa_table_cell"><h1><?php echo $rezult->titlu_anunt; ?></h1></td>
			</tr>
			<tr class="sa_table_row">
				<td valign="top" width="50%" class="sa_table_cell">
				
<?php
//echo $rezult->tip_anunt.'<br />';
$data_adaugarii = explode(" ", $rezult->data_adaugarii);
echo JText::_('SAUTO_DATA').': '.$data_adaugarii[0].'<br />';
//obtin categorie
$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$rezult->tip_anunt."'";
$db->setQuery($query);
$categorie = $db->loadResult();
$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$rezult->tip_anunt);
echo JText::_('SAUTO_CATEGORY').': <a href="'.$link_categ.'">'.$categorie.'</a><br />';
if ($rezult->tip_anunt == 1) {
	//1
	require("display_request_1.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 2) {
	//2
	require("display_request_2.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 3) {
	//3
	require("display_request_3.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 4) {
	//4
	require("display_request_4.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 5) {
	//5
} elseif ($rezult->tip_anunt == 6) {
	//6
	require("display_request_6.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 7) {
	//7
} elseif ($rezult->tip_anunt == 8) {
	//8
	require("display_request_8.php");
	view_detail($rezult);
} elseif ($rezult->tip_anunt == 9) {
	//9
	require("display_request_9.php");
	view_detail($rezult);
} 
?>
				</td>
				<td valign="top" class="sa_table_cell">
<?php
require("display_proprietar.php");
view_proprietar($rezult->proprietar);
?>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td valign="bottom" class="sa_table_cell"><?php echo JText::_('SAUTO_MESAJ_CERERE'); ?></td>
				<td valign="top" class="sa_table_cell">
<?php
$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total != 0) {
	//avem poze
	require("display_pictures.php");
	view_pictures($anunt_id, $rezult->proprietar);
	//echo 'avem poze > '.$total;
}
?>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td colspan="2" class="sa_table_cell">
<?php echo $rezult->anunt; ?>
				</td>
			</tr>	
			<tr class="sa_table_row">
				<td colspan="2" class="sa_table_cell">
					<div style="margin-top:20px;">
					<table width="100%" class="sa_table_class">
<?php 
//preluam ofertele facute
$img_path = JURI::base()."components/com_sauto/assets/images/";
$img_path2 = JURI::base()."components/com_sauto/assets/users/";
//$query = "SELECT `p`.`companie`, `p`.`poza`, `p`.`telefon`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$firma."' AND `p`.`localitate` = `l`.`id`";
$query = "SELECT  `c`.`id`, `c`.`companie` as `comp`,`c`.`data_adaugarii`, `c`.`mesaj`, `c`.`ordonare`, `c`.`raspuns`, `p`.`companie`, `p`.`poza` FROM #__sa_comentarii as `c` JOIN #__sa_profiles as `p` ON `c`.`companie` = `p`.`uid` AND `c`.`anunt_id` = '".$anunt_id."' AND `c`.`proprietar` = '".$uid."' AND `c`.`published` = '1' ORDER BY `c`.`companie` ASC, `c`.`ordonare` ASC";
$db->setQuery($query);
$rasp = $db->loadObjectList();
//echo $query;
//print_r($rasp);
$link_u_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$uid);
foreach ($rasp as $r) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->comp);
	//echo '>>>> id firma = '.$r->companie.' >>>> '.$r->ordonare.' ->>> '.$r->raspuns.'<br />';
	if ($r->raspuns == 1) {
		//companie, aliniat la stanga
?>
						<tr class="sa_table_row '<?php echo $style; ?>.'">
							<td colspan="3" align="left" class="sa_table_cell">
								<div class="sa_client_comment"><?php echo JText::_('SAUTO_COMENTARIU_DEALER'); ?>: </div>
							</td>
						</tr>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td rowspan="2" class="sa_table_cell" width="90">
		<?php
		if ($r->poza != '') {
			//avatar custom
			echo '<img src="'.$img_path2.$r->comp.'/'.$r->poza.'" width="70" border="0" />';
		} else { 
			//avatar standard
			echo '<img src="'.$img_path.'icon_profile.png" border="0" />';
		}
		?>
							</td>
							<td colspan="2" class="sa_table_cell">
								<div style="display:inline;">
									<div style="float:left;" class="sa_link_profile">
										<a class="sa_public_profile" href="<?php echo $link_profile; ?>"><?php echo $r->companie; ?></a>
									</div>
									<div style="float:right;">
		<?php
		$data_add = explode(" ", $r->data_adaugarii);
		echo $data_add[0];
		?>
									</div>
								</div>
								<div style="clear:both;"></div>
							</td>
						</tr>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td colspan="2" class="sa_table_cell"><?php echo $r->mesaj; ?></td>
						</tr>
		<?php
		$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
		$db->setQuery($query);
		$totals = $db->loadResult();
		if ($totals != 0) {
			?>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td colspan="3" class="sa_table_cell">
			<?php
			$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
			$db->setQuery($query);
			$poze2 = $db->loadObjectList();
			?>
								<div style="display:inline">
			<?php
			foreach ($poze2 as $p2) {
				?>
									<div style="float:left;padding:5px;">
										<a class="modal" rel="{handler: 'iframe', size: {x: 750, y: 600}}" href="<?php echo $img_path2.$uid.'/'.$p2->poza; ?>">
											<img src="<?php echo $img_path2.$uid.'/'.$p2->poza; ?>" width="70" border="0" />
										</a>
									</div>
				<?php
			}
			?>
								</div>
								<div style="clear:both;"></div>
							</td>
						</tr>
			<?php
		}
						
	} else {
		//client, aliniat la dreapta
		?>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td colspan="3" align="right" class="sa_table_cell">
								<div class="sa_client_comment"><?php echo JText::_('SAUTO_COMENTARIU_CLIENT'); ?></div>
							</td>
						</tr>
						<tr class="sa_table_row '<?php $style; ?>">
							<td colspan="2" class="sa_table_cell">
								<div style="display:inline;">
									<div style="float:left;">
		<?php
		$data_add = explode(" ", $r->data_adaugarii);
		echo $data_add[0];	
		?>
									</div>
									<div style="float:right;" class="sa_link_profile">';
										<a class="sa_public_profile" href="<?php $link_u_profile; ?>"><?php echo $prf->fullname; ?></a>
									</div>
								</div>
								<div style="clear:both;"></div>
							</td>
							<td rowspan="2" class="sa_table_cell" width="90" align="right">
		<?php
		if ($prf->poza != '') {
			//avatar custom
			echo '<img src="'.$img_path2.$uid.'/'.$prf->poza.'" width="70" border="0" />';
		} else {
			//avatar standard
			echo '<img src="'.$img_path.'icon_profile.png" border="0" />';
		}
		?>
							</td>
						</tr>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td colspan="2" class="sa_table_cell"><?php echo $r->mesaj; ?></td>
						</tr>
		<?php
		$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
		$db->setQuery($query);
		$totals = $db->loadResult();
		if ($totals != 0) {
			?>
						<tr class="sa_table_row '<?php echo $style; ?>">
							<td colspan="3" class="sa_table_cell">
			<?php
			$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
			$db->setQuery($query);
			$poze = $db->loadObjectList();
			?>
								<div style="display:inline">
			<?php
			foreach ($poze as $p) {
				?>
									<div style="float:left;padding:5px;">
										<a class="modal" rel="{handler: 'iframe', size: {x: 750, y: 600}}" href="<?php echo $img_path2.$uid.'/'.$p->poza; ?>">
											<img src="<?php echo $img_path2.$uid.'/'.$p->poza; ?>" width="70" border="0" />
										</a>
									</div>
				<?php
			}
			?>
								</div>
								<div style="clear:both;"></div>
							</td>
						</tr>
			<?php
		}
	
	}
					
}
			?>
					</table>
				</td>
			</tr>
		</table>
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
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
