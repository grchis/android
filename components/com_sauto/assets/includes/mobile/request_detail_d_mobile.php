<style type="text/css">
#detalii_firma{
	float:right;
}
.sa_submit_form{
    margin-left:2%;
}
p {
     margin: 0.5em 2% 0.5em;
}
.sa_reported_div{
	width:36%;
}
.sa_phone {
    background-color: #509eff;
    float: right;
    margin-right: 2%;
}
.sa_min_width {
    width: 25%;
}
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	  .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section1{
         width: 45%;
        display: inline-block;
    }
	    .info-section2{
        width: 35%;
        display: inline-block;
        vertical-align: top;
    }
	    .contact-section{
        width: 100%;
        display: inline-block;
        vertical-align: top;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php
$document = JFactory::getDocument();
require("toggle_js_mobile.php");
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
require("function_load_img_mobile.php");
require("function_form_comment_mobile.php");
require("function_report_mobile.php");

//verific tipul de abonament
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$abonament = $db->loadResult();
//$abonament  = 3;
$width = 'style="width:100%!important;"';
?>
<div id="m_visitors">
	<?php
require("menu_filter_d.php");
	?>
	<div id="hidden-values">
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
				require("display_request_1_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 2) {
				//2
				require("display_request_2_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 3) {
				//3
				require("display_request_3_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 4) {
				//4
				require("display_request_4_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 5) {
				//5
				require("display_request_5_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 6) {
				//6
				require("display_request_6_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 7) {
				//7
				require("display_request_7_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 8) {
				//8
				require("display_request_8_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 9) {
				//9
				require("display_request_9_mobile.php");
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
		require('display_proprietar_mobile.php');
		getMobileDetails($rezult->proprietar, $tip, $id, '');	 
	?>
<div id="main-container">
		<p><strong>Detalii Cerere</strong></p>
	</div>
	<!--=================================================Comentarii=======================================================----------------->
	<?php echo JText::_('SAUTO_MESAJ_CERERE'); ?>
	<div class="comments_list">
			<?php
			$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$id."'";
			$db->setQuery($query);
			$total = $db->loadResult();
			if ($total != 0) {
				//avem poze
				require("display_pictures_mobile.php");
				view_pictures($id, $rezult->proprietar);
				//echo 'avem poze > '.$total;
			}
			echo $rezult->anunt; 
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
				<br>
					<p class="sa_phone sa_min_width_offer sa_hover">
						<span class="sa_oferte_span">
							<?php echo JText::_('SAUTO_DEALER_MAKED_OFFER'); ?>
						</span>
					</p>
					<?php
				} else {
					?>
					<p onClick="toggle_visibility('add_price');" class="sa_phone sa_min_width_offer sa_cursor sa_hover">
						<span class="sa_oferte_span">
							<?php echo JText::_('SAUTO_DEALER_MAKE_OFFER'); ?>
						</span>
					</p>				
				<?php 
				}
			}
			} ?>
				<?php 
				report_now($rezult->raportat, $id, $uid);
				?>

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
				<p><?php echo JText::_('SAUTO_MESAJ_OFERTA'); ?></p>
							<p><textarea cols="45" rows="5" name="mesaj"></textarea></p>
					<p><?php echo JText::_('SAUTO_PRET_OFERTA'); ?></p>
					<p><input type="text" name="pret" value="" /></p>
								<p><select name="moneda">
								<?php
								$query = "SELECT * FROM #__sa_moneda WHERE `published` = '1'";
								$db->setQuery($query);
								$moneda = $db->loadObjectList();
								foreach ($moneda as $m) {
									echo '<option value="'.$m->id.'">'.$m->m_lung.'</option>';
								}
								?>
								</select>
							</p>
					<?php
								//verificam daca poate oferta
								$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
								$db->setQuery($query);
								$credite = $db->loadResult();
								if ($credite < 2) {
									echo '<p class="sa_credit_ins">'.JText::_('SAUTO_CREDITE_INSUFICIENTE').'</p>';
								}
								?>
								<p class="sa_phone sa_min_width_offer sa_cursor sa_hover" onClick="document.forms['sa_send_offer'].submit();">
									<span class="sa_oferte_span">
										<?php echo JText::_('SAUTO_DEALER_MAKE_THIS_OFFER'); ?>
									</span>
								</p>
					</form>
			</div>
</div>
<!--  ======================================================================================OFERTE FACUTE=============================================-->
<div class="oferte_facute">
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
	echo '<hr class="sauto_hr"/>';
	if ($r->block == 0) {
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->firma);
							if ($r->poza == '') {
								//fara avatar
								$poza=$img_path.'fi_avatar.png';
							} else {
								//cu avatar
								$poza=$img_path2.$r->firma.'/'.$r->poza;
							}
			?>
	<div class="request-item">
				<div class="pic-container" data-id="<?php echo $r->companie ?>" data-category="categories">
					<img src="<?php echo $poza ?>" width="80" border="0" />
				</div>	
			     <div class="info-section1">
                    <p>
					   <?php 
						echo '<a class="sa_public_profile" href="'.$link_profile.'">'.$r->companie.'</a>';
						if ($r->f_principal == 0) {
							echo JText::sprintf('SAUTO_FILIALA_REPREZENTATA DE', $r->reprezentant);
						}
						?>
					</p>
					<p> <?php echo JText::_('SAUTO_CITY_TITLE').': '.$r->localitate.' '; ?> </p>
					
					<p> <?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$r->calificative.'%'; ?> </p>
					<p class="sa_tip_abon"> <?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$r->abonament; ?> </p>
					</div>
					<div class="info-section2">
					<p class="sa_mesaj_oferta"> <?php echo JText::_('SAUTO_MESAJ_OFERTA_TITLE'); ?> </p>
					<p> <?php echo $r->mesaj; ?> </p>
					<div style="display:inline;">
						<?php
						if ($rezult->proprietar == $uid) {
								echo '<p>'.JText::_('SAUTO_PRET_TITLE').': '.$r->pret_oferit.' '.$r->m_scurt.'</p>';
						} else {
								echo '<p>'.JText::_('SAUTO_PRET_TITLE').': '.JTEXT::_('SA_VIZIBIL_DOAR_PROPRIETARULUI').'</p>';
								}
						$data = explode(" ", $r->data_adaugarii);
						?>
					</div>
					 <p>
                        <span><?php echo JText::_('SAUTO_DATA_TITLE'); ?>: </span><?php echo $data[0]; ?>
                    </p>
					<div style="clear:both;"></div>
					<?php
						$display_add_coment = 0;
						if ($rezult->proprietar == $uid) 
						{		if ($rezult->is_winner == 0) {
									$display_add_coment = 1;
								}else {
										if ($r->status_raspuns == 1) {
														$display_add_coment = 1;	
																	 }
									  }
						}
					?>
                </div>

</div>					
	<div class="contact-section">						
<?php							
	#################
			if ($r->firma == $uid) {
					{
						$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$id."' AND `companie` = '".$r->firma."' AND `proprietar` = '".$rezult->proprietar."'";
						$db->setQuery($query);
						$total_comms = $db->loadResult();
						if ($total_comms != 0)
							{
									$link_comments = JRoute::_('index.php?option=com_sauto&view=comment_list');
									?>
									<form action="<?php echo $link_comments; ?>" method="post" name="<?php echo 'sa_list_comm_'.$r->id;?>" id="<?php echo 'sa_list_comm_'.$r->id;?>">
										<input type="hidden" name="anunt_id" value="<?php echo $id; ?>"/>
										<input type="hidden" name="proprietar" value="<?php echo $rezult->proprietar; ?>" />
										<input type="hidden" name="firma" value="<?php echo $r->firma; ?>" />
									</form>
									<div onClick="document.forms[<?php echo "'sa_list_comm_".$r->id."'" ?>].submit();" class="sa_add_comment sa_submit_form sa_hover">
										<p> <?php echo JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')'; ?> </p>
									</div>
							<?php
							} else {		
									if ($display_add_coment == 1) 
									{
										?>								
								<a onClick="toggle_visibility(<?php echo "'add_comment_".$z."'"?>);" class="sauto_ajax_link">
									<p style="width: 50%;float:left;padding-top: 3px;background-color: #509EFF;" class="sa_phone sa_add_comment sa_hover">
										Adaugare comentariu
									</p>
									</a>
									<?php
									}
								}
					}
#############	
	echo '<p class="sa_phone sa_min_width_offer sa_hover">';
					echo '<span class="sa_oferte_span">';
						echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" width="10" />';
							echo ' <span style="margin-left:15px;">'.$r->telefon.'</span>';
					echo '</span>';
				echo '</p>';	
	echo '<p>'.JText::_('SAUTO_PRET_TITLE').': ';
			if ($r->firma == $uid) {
				echo $r->pret_oferit.' '.$r->m_scurt;	
			} else {
				if ($abonament == 3) {
					echo $r->pret_oferit.' '.$r->m_scurt;
				} else {
					echo JText::_('SAUTO_PRET_ASCUNS');
				}
			}
			echo '</p>';
			echo '<p>'.JText::_('SAUTO_DATA_TITLE').': '.$data[0].'</p>';
			if ($rezult->is_winner == 1) {
				if ($r->status_raspuns == 1) {
					echo '<p><img src="'.$img_path.'icon_bifa_activa.png" /></p>';			
					//verific daca am acordat calificativ deja
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$id."'";
					$db->setQuery($query);
					$t_cals = $db->loadResult();
					if ($t_cals == 0) {
						echo '<p>';
							echo '<a onClick="toggle_visibility(\'calificativ\');" class="sauto_ajax_link">';
							echo JText::_('SAUTO_OFERA_CALIFICATIV');
							echo '</a>';
						echo '</p>';
					} else {
						echo '<p>';
							echo JText::_('SAUTO_CALIFICATIV_ACORDAT');
						echo '</p>';
					}			
				} else {
					echo '<p><img src="'.$img_path.'icon_bifa_inactiva.png" /></p>';
				}
			}
	################rand3
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
	################rand4
			if ($rezult->is_winner == 1) {
				if ($r->status_raspuns == 1) {
					if ($t_cals == 0) {
						echo '<p id="calificativ" style="display:none;">';
							require("calificativ_mobile.php");
							$redirect = 'detail';
							calificativ($uid, $rezult->proprietar, $id, $r->id, 'dealer', $redirect);
						echo '</p>';
					}
				}
			} 	
	$z = $z+1;
	} else {
		if ($blocked == 0) { $blocked = 1; } else { $blocked = $blocked+1; }
	}
}
?>
	</div>
			<?php
			if ($blocked != 0) {
				echo '<p class="sa_warnings">'.JText::sprintf('SAUTO_OFERTE_IN_ASTEPTARE', $blocked).'</p>';
			}
			?>
		<p><button onclick="window.history.go(-1)"><?php echo JText::_('SAUTO_BACK_BUTTON'); ?></button></p>
<?php } ?>
</div>
</div>

<script type="text/javascript">

var element = document.getElementById('hidden-values');
		var textValues = element.innerHTML.split('<br>');
		var appendElement = '';
		for(var i = 0;i < textValues.length - 1; i++){
			var splitValues = textValues[i].split(':');
			var appendElement = '<p><span class="some-class">' + splitValues[0] + ': </span>' + splitValues[1] + '</p>';
			document.getElementById('main-container').innerHTML += appendElement;
		}
		document.getElementById('hidden-values').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementsByTagName('center')[0].remove();
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.getElementById('m_table').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
	

</script>