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

$user =& JFactory::getUser();
$uid = $user->id;


$document = JFactory::getDocument();
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);

$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$proprietar =& JRequest::getVar( 'proprietar', '', 'post', 'string' );
$firma =& JRequest::getVar( 'firma', '', 'post', 'string' );
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
Jhtml::_('behavior.modal');

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$img_path = JURI::base()."components/com_sauto/assets/images/";
$tip = 'client';
$multiple_id = 0;
$r_id = '';
require("function_load_img.php");
require("function_report.php");
require("function_form_comment.php");
$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment'); 

$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$rezult->tip_anunt);	
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
		echo JText::_('SAUTO_CATEGORY').': <a href="'.$link_categ.'">'.$categorie.'</a><br />';
		if ($rezult->tip_anunt == 1) {
			//1
			require("display_request_1.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 2) {
			//2
			require("display_request_2.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 3) {
			//3
			require("display_request_3.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 4) {
			//4
			require("display_request_4.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 5) {
			//5
		} elseif ($rezult->tip_anunt == 6) {
			//6
			require("display_request_6.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 7) {
			//7
		} elseif ($rezult->tip_anunt == 8) {
			//8
			require("display_request_8.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 9) {
			//9
			require("display_request_9.php");
			view_detail($rezult, $tip);
		} 
		?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php
			require("display_proprietar.php");
			view_proprietar($rezult->proprietar, $tip);
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
		<td colspan="2" class="sa_table_cell" align="right">
			<?php 
			report_now($rezult->raportat, $anunt_id, $uid);
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="2" class="sa_table_cell">
		<div style="margin-top:20px;">
			<table width="100%" class="sa_table_class">
				<?php 
				//preluam ofertele facute
				$img_path2 = JURI::base()."components/com_sauto/assets/users/";
	
$query = "SELECT `p`.`companie`, `p`.`calificative`, `p`.`poza`, `p`.`telefon`, `l`.`localitate`, `a`.`abonament` 
		FROM #__sa_profiles as `p` 
		JOIN #__sa_localitati as `l` 
		JOIN #__sa_abonament as `a` 
		ON `p`.`uid` = '".$firma."' AND `p`.`localitate` = `l`.`id` AND `p`.`abonament` = `a`.`id`";
				$db->setQuery($query);
				$rasp = $db->loadObject();
				//print_r($rasp);
				$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$firma);
				?>
				<tr class="sa_table_row">
					<td valign="top" width="110" class="sa_table_cell">
					<?php
					if ($rasp->poza == '') {
								//fara avatar
								echo '<img src="'.$img_path.'fi_avatar.png" width="100" border="0" />';
							} else {
								//cu avatar
								echo '<img src="'.$img_path2.$firma.'/'.$rasp->poza.'" width="100" border="0" />';
							}
					?>
					</td>
					<td valign="top" class="sa_table_cell">
					<?php
					echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$rasp->companie.'</a></div>';
					echo '<div>'.JText::_('SAUTO_CITY_TITLE').': '.$rasp->localitate.'</div>';
								
					//obtin oferta
					$query = "SELECT `r`.`mesaj`, `r`.`data_adaugarii`, `r`.`pret_oferit`, `r`.`moneda`, `m`.`m_scurt`  
						FROM #__sa_raspunsuri AS `r` JOIN #__sa_moneda AS `m` 
						ON `r`.`anunt_id` = '".$anunt_id."' AND `r`.`proprietar` = '".$rezult->proprietar."' 
						AND `r`.`firma` = '".$firma."' AND `r`.`moneda` = `m`.`id`";
					$db->setQuery($query);
					//echo $query;
					$oferta = $db->loadObject();
						echo '<div>'.$oferta->mesaj.'</div>';
						
					?>
					</td>
					<td valign="top" align="center">
						<div class="sa_tip_abon">
							<?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$rasp->abonament; ?>
						</div>
						<?php
						echo '<div>'.JText::_('SAUTO_CALIFICATIV_TITLE').' '.$rasp->calificative.'%</div>';
						echo '<div>'.JText::_('SAUTO_PRET_OFERTA').' '.$oferta->pret_oferit.' '.$oferta->m_scurt.'</div>';
						?>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td colspan="3" class="sa_table_cell">
						<div class="sa_demarcare"><hr class="sauto_hr" /></div>
						<table width="100%" class="sa_table_class">
					<?php
$query = "SELECT `c`.`id`, `c`.`raspuns`, `c`.`data_adaugarii`, `c`.`mesaj`, `p`.`fullname`, `p`.`poza`, `p`.`companie` 
FROM #__sa_comentarii as `c` JOIN #__sa_profiles as `p` ON `c`.`anunt_id` = '".$anunt_id."' AND `c`.`proprietar` = `p`.`uid` 
AND `c`.`proprietar` = '".$proprietar."' AND `c`.`companie` = '".$firma."' ORDER BY `c`.`ordonare` ASC";
					$db->setQuery($query);
					$lists = $db->loadObjectList();
					
					//obtin datele companiei
					$query = "SELECT `p`.`companie`, `p`.`poza` FROM #__sa_profiles as `p` WHERE `uid` = '".$firma."'";
					$db->setQuery($query);
					$company = $db->loadObject();
					foreach ($lists as $l) {
						if ($style == ' sa-row1 ') { 
							$style = ' sa-row0 '; 
						} else { 
							$style = ' sa-row1 '; 
						}
						if ($l->raspuns == 0) {
							//proprietar
							echo '<tr class="sa_table_row '.$style.'"><td colspan="4" align="right" class="sa_table_cell"><div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_CLIENT').': </div></td></tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td align="right" colspan="3" class="sa_table_cell">';
							echo '<div style="display:inline;">';
							echo '<div style="float:left;">'.$l->data_adaugarii.'</div>';
							echo '<div class="sa_link_profile" style="float:right;"><a class="sa_public_profile" href="'.$link_profile.'">'.$l->fullname.'</a></div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
							echo '</td>';
							echo '<td rowspan="2" width="1">';
							/*if ($l->poza == '') {
								//fara avatar
								echo '<img src="'.$img_path.'fi_avatar.png" width="100" border="0" />';
							} else {
								//cu avatar
								echo '<img src="'.$img_path2.$proprietar.'/'.$l->poza.'" width="100" border="0" />';
							}*/
							echo '</td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'"><td colspan="3" class="sa_table_cell">'.$l->mesaj.'</td></tr>';
							echo '<tr class="sa_table_row '.$style.'"><td colspan="4" class="sa_table_cell">';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$l->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$l->id."'";
								$db->setQuery($query);
								$poze = $db->loadObjectList();
								echo '<div class="sa_pics">';
								echo '<div style="display:inline">';
								foreach ($poze as $p) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$p->owner.'/'.$p->poza.'">';
									echo '<img src="'.$img_path2.$p->owner.'/'.$p->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								echo '</div>';
								echo '<div style="clear:both;"></div>';
							}
							echo '</td></tr>';
						} else {
							//companie
							echo '<tr class="sa_table_row '.$style.'"><td colspan="4" align="left" class="sa_table_cell"><div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_DEALER').': </div></td></tr>';
							echo '<tr class="sa_table_row '.$style.'">';
							echo '<td rowspan="2" width="1" class="sa_table_cell">';
							/*if ($company->poza == '') {
								//fara avatar
								echo '<img src="'.$img_path.'fi_avatar.png" border="0" width="100" />';
							} else {
								//cu avatar
								echo '<img src="'.$img_path2.$firma.'/'.$company->poza.'" width="100" border="0" />';
							}*/
							echo '</td>';
							echo '<td align="left" colspan="3" class="sa_table_cell">';
							echo '<div style="display:inline;">';
							echo '<div class="sa_link_profile" style="float:left;"><a class="sa_public_profile" href="'.$link_profile.'">'.$company->companie.'</a></div>';
							echo '<div style="float:right;">'.$l->data_adaugarii.'</div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
							echo '</td>';
							echo '</tr>';
							echo '<tr class="sa_table_row '.$style.'"><td colspan="3" class="sa_table_cell">'.$l->mesaj.'</td></tr>';
							echo '<tr class="sa_table_row '.$style.'"><td colspan="4" class="sa_table_cell">';
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$l->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$l->id."'";
								$db->setQuery($query);
								$poze = $db->loadObjectList();
								echo '<div class="sa_pics">';
								echo '<div style="display:inline">';
								foreach ($poze as $p) {
									
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$p->owner.'/'.$p->poza.'">';
									echo '<img src="'.$img_path2.$p->owner.'/'.$p->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
									
								}
								echo '</div>';
								echo '</div>';
								echo '<div style="clear:both;"></div>';
							}
							echo '</td></tr>';
						}
					}
					?>
					<tr class="sa_table_row">
							<td colspan="4" class="sa_table_cell">
						<hr class="sauto_hr" />
						</td>
						</tr>	
					<?php
					if ($rezult->is_winner == 0) { 
					?>
						<tr class="sa_table_row">
							<td colspan="4" class="sa_table_cell">
								<div class="sa_comment_reply"><?php echo JText::_('SAUTO_COMMENT_REPLY'); ?></div></td>
						</tr>
						<tr class="sa_table_row">
							<td colspan="4" class="sa_table_cell">
	
							<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm" id="submit_comm">
							<?php
							form_comment($r_id, $multiple_id, $anunt_id, $proprietar, $firma);
							echo loadImg($r_id, $multiple_id); ?>					
	</form>
		
	<div onClick="document.forms['submit_comm'].submit();" class="sa_add_comment sa_submit_form sa_hover">
	<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>
							</td>
						</tr>
						<?php } else {
								if ($rezult->uid_winner == $firma) {
								?>
								<tr class="sa_table_row">
							<td colspan="4" class="sa_table_cell"><div class="sa_comment_reply"><?php echo JText::_('SAUTO_COMMENT_REPLY'); ?></div></td>
						</tr>
						<tr class="sa_table_row">
							<td colspan="4" class="sa_table_cell">

<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm" id="submit_comm">
<?php
form_comment($r_id, $multiple_id, $anunt_id, $proprietar, $firma);
echo loadImg($r_id, $multiple_id); 
?>					
	</form>
		
	<div onClick="document.forms['submit_comm'].submit();" class="sa_add_comment sa_submit_form sa_hover">
	<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>

							</td>
						</tr>
								<?php
								}
							} ?>
						<tr class="sa_table_row">
							<td colspan="2" class="sa_table_cell">
							<button onclick="window.history.go(-1)"><?php echo JText::_('SAUTO_BACK_ANUNT_BUTTON'); ?></button>
							</td>
							<td colspan="2" class="sa_table_cell" align="right">
								<?php
								//verificam daca sunt comentarii necitite
								$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `raspuns` = '1' AND `readed_c` = '0'";
								$db->setQuery($query);
								$unreaded = $db->loadResult();
								if ($unreaded != 0) {
									echo '<div style="float:right;">';
									$link_read = JRoute::_('index.php?option=com_sauto&view=mark_read&id='.$anunt_id);
									echo '<a href="'.$link_read.'" class="sa_comments_read">'.JText::_('SA_MARECHEAZA_CITIT').'</a>';
									echo '</div>';
								}
								?>
							</td>
						</tr>
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
