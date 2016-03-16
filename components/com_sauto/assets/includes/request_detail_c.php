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
require_once('/mobile/request_detail_c_mobile.php');
}else{
$id = JRequest::getVar( 'id', '', 'get', 'string' );
$db = JFactory::getDbo();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
$document = JFactory::getDocument();
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);


$ajaxlink = 'http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js';
//$document->addScript($ajaxlink);
$ajaxlink2 = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js';
$document->addScript($ajaxlink2);
$path_js = JPATH_COMPONENT.DS.'assets'.DS.'script'.DS.'popup.js';
require($path_js);
$document->addScriptDeclaration ($jspopup3);

$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$tip = 'client';
$multiple_id = 1;
require("function_load_img.php");
require("function_report.php");
require("function_form_comment.php");
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
			require("display_request_5.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 6) {
			//6
			require("display_request_6.php");
			view_detail($rezult, $tip);
		} elseif ($rezult->tip_anunt == 7) {
			//7
			require("display_request_7.php");
			view_detail($rezult, $tip);
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
			
			view_proprietar($rezult->proprietar, $tip, $id, '');
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="bottom" class="sa_table_cell"><?php echo JText::_('SAUTO_MESAJ_CERERE'); ?></td>
		<td valign="top" class="sa_table_cell">
		<?php
		$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$id."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total != 0) {
			//avem poze
			require("display_pictures.php");
			view_pictures($id, $rezult->proprietar);
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
			<div style="display:inline;">
			<?php
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$id."'";
			$db->setQuery($query);
			$oferte = $db->loadResult();
			if ($oferte == 0) {
				$link_edit = JRoute::_('index.php?option=com_sauto&view=edit_request');
				echo '<form action="'.$link_edit.'" method="post" name="edit_form_'.$id.'" id="edit_form_'.$id.'">';
				echo '<input type="hidden" name="anunt_id" value="'.$id.'" />';
				echo '</form>';
				echo '<div style="float:left;">';
				echo '<div class="sa_table_cell sa_phone sa_min_width sa_cursor sa_hover" onClick="document.forms[\'edit_form_'.$id.'\'].submit();">';
				echo '<span class="sa_oferte_span">';
					echo JText::_('SAUTO_EDIT_REQUEST');
				echo '</span>';
				echo '</div>';
				echo '</div>';
				echo '<div style="float:left;margin-left:10px;">';
				echo '<div style="position:relative;float:right;">';
				echo '<div class="sa_table_cell sa_phone sa_min_width sa_hover">';
				echo '<span class="sa_oferte_span">';
				$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=delete&id='.$id);
					echo '<a href="'.$link_delete_anunt.'" class="sa_delete_box">';
					echo JText::_('SAUTO_DELETE_REQUEST');
					echo '</a>';
				echo '</span>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			 } ?>
			<div style="float:right;">
			<?php 
			report_now($rezult->raportat, $id, $uid);
			?>
			</div>
			</div><div style="clear:both;"></div>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="2" class="sa_table_cell">
			<hr class="sauto_hr"/>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="2" class="sa_table_cell">
			<div style="margin-top:20px;">
			<table width="100%" class="sa_table_class">
				<?php 
				//preluam ofertele facute
				
				$img_path2 = JURI::base()."components/com_sauto/assets/users/";
	
$query = "SELECT `r`.`firma`, `r`.`id`, `r`.`mesaj`, `r`.`status_raspuns`, `r`.`data_adaugarii`, `r`.`pret_oferit`, `p`.`companie`, `p`.`calificative`, 
		`p`.`poza`, `p`.`telefon`, `l`.`localitate`, `m`.`m_scurt`, `ab`.`abonament`, `u`.`block`, `p`.`reprezentant`, `p`.`f_principal` 
		FROM #__sa_raspunsuri as `r` 
		JOIN #__sa_profiles as `p` 
		JOIN #__sa_localitati as `l` 
		JOIN #__sa_moneda as `m` 
		JOIN #__sa_abonament as `ab` 
		JOIN #__users AS `u` 
		ON `r`.`anunt_id` = '".$id."' AND `r`.`firma` = `p`.`uid` AND `p`.`localitate` = `l`.`id` AND `r`.`moneda` = `m`.`id` 
		AND `p`.`abonament` = `ab`.`id` AND `p`.`uid` = `u`.`id`";
				$db->setQuery($query);
				$rasps = $db->loadObjectList();
				$z = 1;
				foreach ($rasps as $r) {
					if ($r->block == 0) {
					if ($style == ' sa-row1 ') { 
						$style = ' sa-row0 '; 
					} else { 
						$style = ' sa-row1 '; 
					}
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->firma);
					echo '<tr class="sa_table_row '.$style.'">';
						echo '<td valign="top" width="90" class="sa_table_cell">';
							if ($r->poza == '') {
								//fara avatar
								echo '<img src="'.$img_path.'fi_avatar.png" width="100" border="0" />';
							} else {
								//cu avatar
								echo '<img src="'.$img_path2.$r->firma.'/'.$r->poza.'" width="100" border="0" />';
							}
						echo '</td>';
						echo '<td valign="top" class="sa_table_cell">';
							echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$r->companie.'</a></div>';
							if ($r->f_principal == 0) {
								echo '<div>'.JText::sprintf('SAUTO_FILIALA_REPREZENTATA DE', $r->reprezentant).'</div>';
							}
								echo JText::_('SAUTO_CITY_TITLE').': '.$r->localitate.' ';
								echo '| '.JText::_('SAUTO_CALIFICATIV_TITLE').': '.$r->calificative.'%';
						echo '</td>';
						echo '<td valign="top" colspan="2" class="sa_table_cell" align="center"><div class="sa_tip_abon">'.JText::_('SAUTO_TIP_VANZATOR').': '.$r->abonament.'</div></td>';
					echo '</tr>';
					echo '<tr class="sa_table_row '.$style.'">';
						echo '<td colspan="4" valign="top" class="sa_table_cell">';
							echo '<div class="sa_mesaj_oferta">'.JText::_('SAUTO_MESAJ_OFERTA_TITLE').':</div>';	
						echo '</td>';
						echo '<tr class="sa_table_row '.$style.'">';
							echo '<td colspan="2" valign="top" class="sa_table_cell">';
							echo '<div>'.$r->mesaj.'</div>';	
							echo '<div style="display:inline;">';
								if ($rezult->proprietar == $uid) {
									echo '<div style="float:left;">'.JText::_('SAUTO_PRET_TITLE').': '.$r->pret_oferit.' '.$r->m_scurt.'</div>';
								} else {
									echo '<div style="float:left;">'.JText::_('SAUTO_PRET_TITLE').': '.JTEXT::_('SA_VIZIBIL_DOAR_PROPRIETARULUI').'</div>';
								}
								$data = explode(" ", $r->data_adaugarii);
								echo '<div style="float:right;">'.JText::_('SAUTO_DATA_TITLE').': '.$data[0].'</div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
						echo '</td>';
						echo '<td valign="top" class="sa_table_cell">';
						//////////
							$display_add_coment = 0;
							if ($rezult->proprietar == $uid) {
								if ($rezult->is_winner == 0) {
									$display_add_coment = 1;
								} else {
									if ($r->status_raspuns == 1) {
										$display_add_coment = 1;	
									}
								}
							}
							
							
						/////////
						if ($rezult->proprietar == $uid) {
							echo '<div>';
							//verific nr de comentarii
							$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$id."' AND `companie` = '".$r->firma."' AND `proprietar` = '".$rezult->proprietar."'";
							$db->setQuery($query);
							$total_comms = $db->loadResult();
							if ($total_comms != 0) {
							$link_comments = JRoute::_('index.php?option=com_sauto&view=comment_list');
							echo '<form action="'.$link_comments.'" method="post" name="sa_list_comm_'.$r->id.'" id="sa_list_comm_'.$r->id.'">';
								echo '<input type="hidden" name="anunt_id" value="'.$id.'" />';
								echo '<input type="hidden" name="proprietar" value="'.$rezult->proprietar.'" />';
								echo '<input type="hidden" name="firma" value="'.$r->firma.'" />';
							echo '</form>';
							echo '<div onClick="document.forms[\'sa_list_comm_'.$r->id.'\'].submit();" class="sa_add_comment sa_submit_form sa_hover">';
							echo JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')';
							echo '</div>';
							} else {
								if ($display_add_coment == 1) {
								echo '<div>';						
								echo '<a onClick="toggle_visibility(\'add_comment_'.$z.'\');" class="sauto_ajax_link">';
									echo '<div class="sa_phone sa_add_comment sa_hover">';
									echo JText::_('SAUTO_ADD_COMMENT_BUTTON');	
									echo '</div>';
								echo '</a>';
								echo '</div><br />';
							}
							}
							echo '</div>';
						}
							echo '<div class="sa_phone sa_phone_oferte sa_hover">';
							echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
							echo '<span class="sa_phone_span">';
							echo $r->telefon;
							echo '</span>';
							echo '</div>';
						echo '</td>';
						echo '<td valign="top" class="sa_table_cell">';
						if ($rezult->proprietar == $uid) {
							if ($rezult->is_winner == 1) {
								if ($r->status_raspuns == 1) {
									$status_oferta = JText::_('SAUTO_OFERTA_CASTIGATOARE');
								} else {
									$status_oferta = JText::_('SAUTO_OFERTA_NECASTIGATOARE');
								} 
							} else {
echo '<div><button id="popup_window" data-popup-target="#winner-popup_'.$r->id.'" class="sa_hover">'.JText::_('SAUTO_SELECT_OFERTA_BUTTON').'</button></div>';
								echo '<br /><br /><img src="'.$img_path.'icon_bifa_inactiva.png" border="1" class="sauto_bifa_inactiva" />'; 
								?>	
								</div>
								<div id="winner-popup_<?php echo $r->id; ?>" class="popup">
									<div class="popup-body"><span class="popup-exit"></span>
										<div class="popup-content">
											<h2 class="popup-title">Apasa Esc pentru anulare</h2>
											<?php
											$link_form_winner = JRoute::_('index.php?option=com_sauto&view=set_winner');
											echo '<form action="'.$link_form_winner.'" method="post" name="select-'.$r->id.'" id="select-'.$r->id.'" >';
											echo '<input type="hidden" name="rasp_id" value="'.$r->id.'" />';
											echo '<input type="hidden" name="anunt_id" value="'.$id.'" />';
											echo 'Sigur doresti sa setezi aceasta oferta ca si castigatoare?';
											if ($r->status_raspuns == 0) {
												echo '<div class="sa_submit_div" onClick="document.forms[\'select-'.$r->id.'\'].submit();">';	
												echo '<input type="submit" value="Alege oferta castigatoare" /></div>';
											}
											echo '</form>';
								?>
										</div>
									</div>
								</div>
								<div class="popup-overlay"></div>
								<?php 
							}
						
							if ($r->status_raspuns == 1) {
								echo '<div class="sa_oferta_castig">';
								echo '<div>'.$status_oferta.'</div>';
								echo '<img src="'.$img_path.'icon_bifa_activa.png" border="0" />';
								//verific daca am acordat calificativ deja
								$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$id."'";
								$db->setQuery($query);
								$t_cals = $db->loadResult();
								if ($t_cals == 0) {
									//acord calificativ
									echo '<div>';
									echo '<a onClick="toggle_visibility(\'calificativ\');" class="sauto_ajax_link">';
									echo JText::_('SAUTO_OFERA_CALIFICATIV');
									echo '</a>';
									echo '</div>';
								} else {
									echo '<div>';
									echo JText::_('SAUTO_CALIFICATIV_ACORDAT');
									echo '</div>';
								}
								echo '</div>';
							} 
						} else {
							//echo '<div class="sa_oferta_castig">';
							//echo '<div><button id="popup_window" data-popup-target="#winner-popup_'.$r->id.'" class="sa_hover">'.JText::_('SAUTO_SELECT_OFERTA_BUTTON').'</button></div>';
								echo '<img src="'.$img_path.'icon_bifa_inactiva.png" border="1" class="sauto_bifa_inactiva" />'; 
							//echo '</div>';
						}						
						echo '</td>';
					echo '</tr>';
					echo '<tr class="sa_table_row '.$style.'"><td colspan="4" class="sa_table_cell">';
						if ($r->status_raspuns == 1) {
							if ($t_cals == 0) {
									echo '<div id="calificativ" style="display:none;">';
									require("calificativ.php");
									$redirect = 'detail';
									calificativ($uid, $r->firma, $id, $r->id, 'customer', $redirect);
									echo '</div>';
								}
						}
					
						echo '<div id="add_comment_'.$z.'" style="display:none;">';
						
						$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment');
						?>

<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm_<?php echo $r->id; ?>" id="submit_comm_<?php echo $r->id; ?>">
<?php
form_comment($r->id, $multiple_id, $id, $rezult->proprietar, $r->firma);
?>
	
	<?php loadImg($r->id, $multiple_id); ?>					
	</form>
		
	<div onClick="document.forms['submit_comm_<?php echo $r->id; ?>'].submit();" class="sa_add_comment sa_submit_form">
	<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>
						<?php
						echo '</div>';
					echo '</td></tr>';
					$z = $z+1;
					} else {
						if ($blocked == 0) { $blocked = 1; } else { $blocked = $blocked+1; }
					}
				}
				?>
			</table>
			</div>
			<?php
			if ($blocked != 0) {
				echo '<div class="sa_warnings">'.JText::sprintf('SAUTO_OFERTE_IN_ASTEPTARE', $blocked).'</div>';
			}
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="2" align="right" class="sa_table_cell">
		<button onclick="window.history.go(-1)"><?php echo JText::_('SAUTO_BACK_BUTTON'); ?></button>
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
		?>
			</div>
		</td>
	</tr>
</table>

<?php
}
?>
