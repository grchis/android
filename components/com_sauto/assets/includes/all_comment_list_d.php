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
$query = "SELECT `poza`, `companie` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$prf = $db->loadObject();
$width = 'style="width:800px;"';
?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<table width="100%" class="sa_table_class" id="m_table">
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
			<h2><?php echo JText::_('SAUTO_COMMENTS_LIST'); ?></h2>
			<table width="100%" class="sa_table_class">
				<?php 
				//preluam ofertele facute
				$img_path = JURI::base()."components/com_sauto/assets/images/";
				$img_path2 = JURI::base()."components/com_sauto/assets/users/";
	
				//$query = "SELECT `p`.`companie`, `p`.`poza`, `p`.`telefon`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$firma."' AND `p`.`localitate` = `l`.`id`";
				$query = "SELECT  `c`.`id`, `c`.`proprietar`, `c`.`companie` as `comp`,`c`.`data_adaugarii`, `c`.`mesaj`, `c`.`ordonare`, `c`.`raspuns`, `p`.`fullname`, `p`.`poza` FROM #__sa_comentarii as `c` JOIN #__sa_profiles as `p` ON `c`.`proprietar` = `p`.`uid` AND `c`.`anunt_id` = '".$anunt_id."' AND `c`.`companie` = '".$uid."' AND `c`.`published` = '1' ORDER BY `c`.`companie` ASC, `c`.`ordonare` ASC";
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
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="3" align="left" class="sa_table_cell"><div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_DEALER').': </div></td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td rowspan="2" class="sa_table_cell" width="90">';
								if ($r->poza != '') {
									//avatar custom
									echo '<img src="'.$img_path2.$uid.'/'.$prf->poza.'" width="70" border="0" />';
								} else { 
									//avatar standard
									echo '<img src="'.$img_path.'icon_profile.png" border="0" />';
								}
							echo '</td>';
							echo '<td colspan="2" class="sa_table_cell">';
								echo '<div style="display:inline;">';
									echo '<div style="float:left;" class="sa_link_profile">';
										echo '<a class="sa_public_profile" href="'.$link_profile.'">'.$prf->companie.'</a>';
									echo '</div>';
									echo '<div style="float:right;">';
									$data_add = explode(" ", $r->data_adaugarii);
									echo $data_add[0];
									echo '</div>';
								echo '</div><div style="clear:both;"></div>';
							echo '</td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="2" class="sa_table_cell">'.$r->mesaj.'</td>';
							echo '</tr>';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								echo '<tr class="sa_table_row '.$style.'">';
								echo '<td colspan="3" class="sa_table_cell">';
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze2 = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze2 as $p2) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p2->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p2->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								echo '<div style="clear:both;"></div>';
								echo '</td>';
								echo '</tr>';
							}
						} else {
							//client, aliniat la dreapta
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="3" align="right" class="sa_table_cell"><div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_CLIENT').'</div></td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="2" class="sa_table_cell">';
								echo '<div style="display:inline;">';
									echo '<div style="float:left;">';
									$data_add = explode(" ", $r->data_adaugarii);
									echo $data_add[0];	
									echo '</div>';
									echo '<div style="float:right;" class="sa_link_profile">';
									echo '<a class="sa_public_profile" href="'.$link_u_profile.'">'.$r->fullname.'</a>';
									echo '</div>';
								echo '</div><div style="clear:both;"></div>';
							echo '</td>';
							echo '<td rowspan="2" class="sa_table_cell" width="90" align="right">';
								if ($prf->poza != '') {
									//avatar custom
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$r->poza.'" width="70" border="0" />';
								} else {
									//avatar standard
									echo '<img src="'.$img_path.'icon_profile.png" border="0" />';
								}
							echo '</td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="2" class="sa_table_cell">'.$r->mesaj.'</td>';
							echo '</tr>';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								echo '<tr class="sa_table_row '.$style.'">';
								echo '<td colspan="3" class="sa_table_cell">';
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze as $p) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								echo '<div style="clear:both;"></div>';
								echo '</td>';
								echo '</tr>';
							}
						}
					
				}
			?>
						</table>
					</td>
				</tr>
			</table>
		</div>	
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
<!---------------------------MOBILEEEEEE------------------------------->
<div id="m_visitors" style="background-color:#F9F9F9">
	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
	</div>
	<div id="hidden-values">
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
			$content=file_get_contents('display_request_1');
			echo $content;	
			view_detail($rezult, $tip);	 
			} elseif ($rezult->tip_anunt == 2) {
			//2
			$content=file_get_contents('display_request_2');
			echo $content;	
			view_detail($rezult, $tip);	 
		} elseif ($rezult->tip_anunt == 3) {
			//3
			$content=file_get_contents('display_request_3');
			echo $content;	
			view_detail($rezult, $tip);	 
		} elseif ($rezult->tip_anunt == 4) {
			//4
			$content=file_get_contents('display_request_4');
			echo $content;	
			view_detail($rezult, $tip);	 
		} elseif ($rezult->tip_anunt == 5) {
			//5
		} elseif ($rezult->tip_anunt == 6) {
			//6
			$content=file_get_contents('display_request_6');
			echo $content;	
			view_detail($rezult, $tip);	 
		} elseif ($rezult->tip_anunt == 7) {
			//7
		} elseif ($rezult->tip_anunt == 8) {
			//8
			$content=file_get_contents('display_request_8');
			echo $content;	
			view_detail($rezult, $tip);	 
		} elseif ($rezult->tip_anunt == 9) {
			//9
			$content=file_get_contents('display_request_9');
			echo $content;	
			view_detail($rezult, $tip);	 
		} 
		?>
		
	</div>
	<?php
		if ($tip == 1){
			echo "<h1>Detalii Companie</h1>";
		} else {
			echo "<h1>Detalii Client</h1>";
		}
		$content=file_get_contents('display_proprietar');
		echo $content;	
		getMobileDetails($rezult->proprietar, $tip, $id, '');	 
	?>
	<div id="main-container">
		<h1>Detalii Cerere</h1>
	</div>
	<br/>
	<br/>
	<div id="container">
	<h1>OFERTE</h1>
	<?php 
	//preluam ofertele facute
	$img_path = JURI::base()."components/com_sauto/assets/images/";
	$img_path2 = JURI::base()."components/com_sauto/assets/users/";
	$query = "SELECT  `c`.`id`, `c`.`proprietar`, `c`.`companie` as `comp`,`c`.`data_adaugarii`, `c`.`mesaj`, `c`.`ordonare`, `c`.`raspuns`, `p`.`fullname`, `p`.`poza` FROM #__sa_comentarii as `c` JOIN #__sa_profiles as `p` ON `c`.`proprietar` = `p`.`uid` AND `c`.`anunt_id` = '".$anunt_id."' AND `c`.`companie` = '".$uid."' AND `c`.`published` = '1' ORDER BY `c`.`companie` ASC, `c`.`ordonare` ASC";
	$db->setQuery($query);
	$rasp = $db->loadObjectList();
	$link_u_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$uid);
	foreach ($rasp as $r) {
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->comp);
		if ($r->raspuns == 1) {
					//companie, aliniat la stanga
					echo '<div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_DEALER').': </div>';
					if ($r->poza != '') {
					//avatar custom
					echo '<img src="'.$img_path2.$uid.'/'.$prf->poza.'" width="18%" height="100px" style="vertical-align: top;" />';
					} else { 
					//avatar standard
					echo '<img src="'.$img_path.'icon_profile.png" width="18%" height="100px" style="vertical-align: top;" />';
							}
					echo '<div style="display:inline;">';
									echo '<div style="float:left;" class="sa_link_profile">';
										echo '<a class="sa_public_profile" href="'.$link_profile.'">'.$prf->companie.'</a>';
									echo '</div>';
									echo '<div style="float:right;">';
									$data_add = explode(" ", $r->data_adaugarii);
									echo $data_add[0];
									echo '</div>';
								echo '</div><div style="clear:both;"></div>';
							echo '<p>'.$r->mesaj.'</p>';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
							$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze2 = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze2 as $p2) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p2->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p2->poza.'" width="18%" height="100px" style="vertical-align: top;"/>';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								
							}
						} else {
							//client, aliniat la dreapta
							echo '<div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_CLIENT').'</div>';
							echo '<div style="display:inline;">';
									echo '<div style="float:left;">';
									$data_add = explode(" ", $r->data_adaugarii);
									echo $data_add[0];	
									echo '</div>';
									echo '<div style="float:right;" class="sa_link_profile">';
									echo '<a class="sa_public_profile" href="'.$link_u_profile.'">'.$r->fullname.'</a>';
									echo '</div>';
								echo '</div><div style="clear:both;"></div>';
							if ($prf->poza != '') {
									//avatar custom
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$r->poza.'" width="70" border="0" />';
								} else {
									//avatar standard
									echo '<img src="'.$img_path.'icon_profile.png" width="18%" height="100px" style="vertical-align: top;" />';
								}
							echo '<p>'.$r->mesaj.'</p>';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze as $p) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p->poza.'" width="18%" height="100px" style="vertical-align: top;" />';
									echo '</a>';
									echo '</div>';
								}
								
							}
						}
					
				}
			?>
</div>
<script type="text/javascript">

	var isMobile = navigator.userAgent.contains('Mobile');
	
	if (!isMobile)
	{
	document.getElementById('m_visitors').remove();
	}else{
		var element = document.getElementById('hidden-values');
		var textValues = element.innerHTML.split('<br>');
		var appendElement = '';
		for(var i = 0;i < textValues.length - 1; i++){
			var splitValues = textValues[i].split(':');
			var appendElement = '<p><span class="some-class">' + splitValues[0] + ': </span>' + splitValues[1] + '</p>';
			document.getElementById('main-container').innerHTML += appendElement;
		}
		document.getElementById('hidden-values').remove();
		document.getElementsByClassName('sa_reclama_right')[0].remove();
		document.getElementById('m_table').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementsByTagName('center')[0].remove();
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
	}

</script>