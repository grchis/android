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
require_once('/mobile/request_detail_d_mobile.php');
}else{
$document = JFactory::getDocument();
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);

$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$db = JFactory::getDbo();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
//print_r($rezult);
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$tip = 'dealer';
$multiple_id = 1;
require("function_load_img.php");
require("function_form_comment.php");
require("function_report.php");

//verific tipul de abonament
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$abonament = $db->loadResult();
//$abonament  = 3;
$width = 'style="width:100%!important;"';
?>
<table class="sa_table_class" id="m_table">>
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
			view_proprietar($rezult->proprietar, $tip, $id, $uid);
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
		<td class="sa_table_cell">
			<?php
			//verificam daca oferta este finalizata
			if ($rezult->uid_winner == 0 ) {
				//verificam starea contului proprietarului
				$query = "SELECT `deleted` FROM #__sa_profiles WHERE `uid` = '".$rezult->proprietar."'";
				$db->setQuery($query);
				$deleted = $db->loadResult();
				if ($deleted == 0) {
				//verificam daca aceasta firma a ofertat deja
				$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$id."' AND `firma` = '".$uid."'";
				$db->setQuery($query);
				$check = $db->loadResult();
				if ($check != 0) {
					//
					?>
					<div class="sa_table_cell sa_phone sa_min_width_offer sa_hover">
						<span class="sa_oferte_span">
							<?php echo JText::_('SAUTO_DEALER_MAKED_OFFER'); ?>
						</span>
					</div>
					<?php
				} else {
					?>
					<div onClick="toggle_visibility('add_price');" class="sa_table_cell sa_phone sa_min_width_offer sa_cursor sa_hover">
						<span class="sa_oferte_span">
							<?php echo JText::_('SAUTO_DEALER_MAKE_OFFER'); ?>
						</span>
					</div>				
				<?php 
				}
			}
			} ?>
		</td>
		<td class="sa_table_cell" align="right">
			<?php 
			report_now($rezult->raportat, $id, $uid);
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="2" align="center" class="sa_table_cell">
			<?php
			$link_add_price = JRoute::_('index.php?option=com_sauto&view=make_offer'); 
			?>
			<div id="add_price" style="display:none;">
				<?php
				//obtin credite curente
				$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
				$db->setQuery($query);
				$credite_curente = $db->loadResult();
				?>
				<form action="<?php echo $link_add_price; ?>" method="post" name="sa_send_offer" id="sa_send_offer">
					<input type="hidden" name="id_anunt" value="<?php echo $id; ?>" />
					<input type="hidden" name="owner_id" value="<?php echo $rezult->proprietar; ?>" />
					<div>
						<?php 
							if ($abonament == 1) {
								echo JText::_('SAUTO_APLICARE_OFERTA_VALUE').' '.JText::sprintf('SAUTO_CURENT_CREDITS', $credite_curente); 
							} else {
								echo JText::_('SAUTO_APLICARE_OFERTA_VALUE_NECONTORIZAT');
							}?>
					</div>
					<table class="sa_table_class">
						<tr class="sa_table_row">
							<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_MESAJ_OFERTA'); ?></td>
							<td valign="top" class="sa_table_cell"><textarea cols="45" rows="5" name="mesaj"></textarea></td>
						</tr>
						<tr class="sa_table_row">
							<td valign="top" class="sa_table_cell"><?php echo JText::_('SAUTO_PRET_OFERTA'); ?></td>
							<td valign="top" class="sa_table_cell">
								<input type="text" name="pret" value="" />
								<select name="moneda">
								<?php
								$query = "SELECT * FROM #__sa_moneda WHERE `published` = '1'";
								$db->setQuery($query);
								$moneda = $db->loadObjectList();
								foreach ($moneda as $m) {
									echo '<option value="'.$m->id.'">'.$m->m_lung.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr class="sa_table_row">
							<td class="sa_table_cell"></td>
							<td class="sa_table_cell">
								<?php
								//verificam daca poate oferta
								$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
								$db->setQuery($query);
								$credite = $db->loadResult();
								if ($credite < 2) {
									echo '<div class="sa_credit_ins">'.JText::_('SAUTO_CREDITE_INSUFICIENTE').'</div>';
								}
								?>
								<div class="sa_table_cell sa_phone sa_min_width_offer sa_cursor sa_hover" onClick="document.forms['sa_send_offer'].submit();">
									<span class="sa_oferte_span">
										<?php echo JText::_('SAUTO_DEALER_MAKE_THIS_OFFER'); ?>
									</span>
								</div>
							</td>
						</tr>
					</table>
				</form>
			</div>
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
$query = "SELECT `r`.`firma`, `r`.`id`, `r`.`mesaj`, `r`.`data_adaugarii`, `r`.`pret_oferit`, `r`.`status_raspuns`, `p`.`companie`, `p`.`calificative`,
		`p`.`poza`, `p`.`telefon`, `ab`.`abonament`,  `l`.`localitate`, `m`.`m_scurt`, `u`.`block`, `p`.`reprezentant`, `p`.`f_principal` 
		FROM #__sa_raspunsuri as `r` 
		JOIN #__sa_profiles as `p` 
		JOIN #__sa_localitati as `l` 
		JOIN #__sa_moneda as `m` 
		JOIN #__sa_abonament as `ab` 
		JOIN #__users AS `u` 
		ON `r`.`anunt_id` = '".$id."' AND `r`.`firma` = `p`.`uid` AND `p`.`localitate` = `l`.`id` AND `r`.`moneda` = `m`.`id` 
		AND `p`.`abonament` = `ab`.`id` AND `p`.`uid` = `u`.`id`";
	//echo $query;
$db->setQuery($query);
$rasps = $db->loadObjectList();
				
$z = 1;

############				
foreach ($rasps as $r) {
	if ($r->block == 0) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	//if ($uid == $r->firma) {
	$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->firma);
	################rand 1
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
			echo '<div style="display:inline">';
				echo '<div style="float:left;">'.JText::_('SAUTO_CITY_TITLE').': '.$r->localitate.'</div>';
				echo '<div style="float:right;">'.JText::_('SAUTO_CALIFICATIV_TITLE').' '.$r->calificative.'% </div>';
			echo '</div>';
			echo '<div style="clear:both;"></div>';
		echo '</td>';
		echo '<td valign="top" colspan="2" class="sa_table_cell" align="center"><div class="sa_tip_abon">'.JText::_('SAUTO_TIP_VANZATOR').': '.$r->abonament.'</div></td>';
	echo '</tr>';
	#######################rand2
	echo '<tr class="sa_table_row '.$style.'">';
		echo '<td colspan="2" valign="top" class="sa_table_cell">';
			echo '<div>'.JText::_('SAUTO_MESAJ_CERERE_TITLE').':</div>';
			echo '<div>'.$r->mesaj.'</div>';
				$data = explode(" ", $r->data_adaugarii);
		echo '</td>';
		echo '<td valign="top" class="sa_table_cell">';
			$display_add_coment = 0;			
			if ($rezult->is_winner == 0) {
				if ($r->firma == $uid) {
					$display_add_coment = 1;
								/*echo '<div onClick="toggle_visibility(\'add_comment\');" class="sa_table_cell sa_phone sa_min_width_offer sa_cursor">';
								echo '<span class="sa_oferte_span">';
								echo JText::_('SAUTO_ADD_COMMENT_BUTTON');
								echo '</span>';
								echo '</div>';*/
				}
								//echo '<a onClick="toggle_visibility(\'add_comment\');" class="sauto_ajax_link">';
									
								//echo '</a>';
			} else {
				if ($r->status_raspuns == 1) {
					if ($r->firma == $uid) {
						$display_add_coment = 1;
									/*echo '<div onClick="toggle_visibility(\'add_comment\');" class="sa_table_cell sa_phone sa_min_width_offer sa_cursor">';
								echo '<span class="sa_oferte_span">';
								echo JText::_('SAUTO_ADD_COMMENT_BUTTON');
								echo '</span>';
								echo '</div>';*/
					}
									//echo '<div><img src="'.$img_path.'icon_bifa_activa.png" /></div>';
				}
			}
							
							
							
						#################
			if ($r->firma == $uid) {
				$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$id."' AND `companie` = '".$r->firma."' AND `proprietar` = '".$rezult->proprietar."'";
				$db->setQuery($query);
				$total_comms = $db->loadResult();
				if ($total_comms != 0) {
					$link_comments = JRoute::_('index.php?option=com_sauto&view=comment_list');
					echo '<form action="'.$link_comments.'" method="post" name="comment_list_'.$z.'" id="comment_list_'.$z.'">';
						echo '<input type="hidden" name="anunt_id" value="'.$id.'" />';
						echo '<input type="hidden" name="proprietar" value="'.$rezult->proprietar.'" />';
						echo '<input type="hidden" name="firma" value="'.$r->firma.'" />';
						//echo '<input type="submit" value="'.JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')" />'; 
					echo '</form>';
					echo '<div onClick="document.forms[\'comment_list_'.$z.'\'].submit();" class="sa_table_cell sa_phone sa_min_width_offer sa_cursor sa_hover">';
						echo '<span class="sa_oferte_span">';
							echo JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')';
						echo '</span>';
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
			}
						#################
			echo '<br /><div>';
				echo '<div class="sa_table_cell sa_phone sa_min_width_offer sa_hover">';
					echo '<span class="sa_oferte_span">';
						echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" width="10" />';
							echo ' <span style="margin-left:15px;">'.$r->telefon.'</span>';
					echo '</span>';
				echo '</div>';	
			echo '</div>';
			echo '<div>'.JText::_('SAUTO_PRET_TITLE').': ';
			if ($r->firma == $uid) {
				echo $r->pret_oferit.' '.$r->m_scurt;	
			} else {
				if ($abonament == 3) {
					echo $r->pret_oferit.' '.$r->m_scurt;
				} else {
					echo JText::_('SAUTO_PRET_ASCUNS');
				}
			}
			echo '</div>';
			echo '<div>'.JText::_('SAUTO_DATA_TITLE').': '.$data[0].'</div>';
		echo '</td>';
		echo '<td class="sa_table_cell">';
			if ($rezult->is_winner == 1) {
				if ($r->status_raspuns == 1) {
					echo '<div><img src="'.$img_path.'icon_bifa_activa.png" /></div>';			
					//verific daca am acordat calificativ deja
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$id."'";
					$db->setQuery($query);
					$t_cals = $db->loadResult();
					if ($t_cals == 0) {
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
				} else {
					echo '<div><img src="'.$img_path.'icon_bifa_inactiva.png" /></div>';
				}
			}
		echo '</td>';
	echo '</tr>';
	################rand3
	echo '<tr class="sa_table_row '.$style.'">';
		echo '<td colspan="4" class="sa_table_cell">';	
			echo '<div id="add_comment_'.$z.'" style="display:none;">';
				if ($total_comms == 0) {
					$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment'); 
					?>
					<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm_<?php echo $r->id; ?>" id="submit_comm_<?php echo $r->id; ?>">
						<?php
						form_comment($r->id, $multiple_id, $id, $rezult->proprietar, $r->firma);
						loadImg($r->id, $multiple_id); ?>					
					</form>
		
					<div onClick="document.forms['submit_comm_<?php echo $r->id; ?>'].submit();" class="sa_add_comment sa_submit_form sa_hover">
						<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
					</div>
					<?php
				}
			echo '</div>';
		echo '</td>';
	echo '</tr>';
	################rand4
	echo '<tr class="sa_table_row '.$style.'">';
		echo '<td colspan="4" class="sa_table_cell">';
			if ($rezult->is_winner == 1) {
				if ($r->status_raspuns == 1) {
					if ($t_cals == 0) {
						echo '<div id="calificativ" style="display:none;">';
							require("calificativ.php");
							$redirect = 'detail';
							calificativ($uid, $rezult->proprietar, $id, $r->id, 'dealer', $redirect);
						echo '</div>';
					}
				}
			} 	
		echo '</td>';
	echo '</tr>';
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


<?php } ?>