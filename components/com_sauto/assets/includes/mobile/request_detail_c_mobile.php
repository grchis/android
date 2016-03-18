<style type="text/css">
#detalii_firma{
	
		float:right;
}
p {
     margin: 0.5em 2% 0.5em;
}
.sa_reported_div{
	width:36%;
}
.sa_phone {
    background-color: #509eff;
    /* padding: 2px; */
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
    .info-section{
         width: 45%;
        display: inline-block;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php

$id = JRequest::getVar( 'id', '', 'get', 'string' );
$db = JFactory::getDbo();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
$document = JFactory::getDocument();
require("toggle_js_mobile.php");

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
require("function_load_img_mobile.php");
require("function_report_mobile.php");
require("function_form_comment_mobile.php");
$width = 'style="width:800px;"';

?>
<div id="m_visitors">
	<?php
require("menu_filter.php");
	?>
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
			require('display_pictures_mobile.php');
			view_pictures($id, $rezult->proprietar);
		
		}
			echo $rezult->anunt; 
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$id."'";
			$db->setQuery($query);
			$oferte = $db->loadResult();
			if ($oferte == 0) {
				$link_edit = JRoute::_('index.php?option=com_sauto&view=edit_request');
				echo '<form action="'.$link_edit.'" method="post" name="edit_form_'.$id.'" id="edit_form_'.$id.'">';
							echo '<input type="hidden" name="anunt_id" value="'.$id.'" />';
				echo '</form>';
				echo '<div style="float:left;" class="sa_table_cell sa_phone sa_min_width sa_cursor sa_hover" onClick="document.forms[\'edit_form_'.$id.'\'].submit();">';
							echo '<span class="sa_oferte_span">';
							echo JText::_('SAUTO_EDIT_REQUEST');
							echo '</span>';
				echo '</div>';
				echo '<div style="float:right;" class="sa_table_cell sa_phone sa_min_width sa_hover">';
							echo '<span class="sa_oferte_span">';
										$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=delete&id='.$id);
										echo '<a href="'.$link_delete_anunt.'" class="sa_delete_box">';
										echo JText::_('SAUTO_DELETE_REQUEST');
										echo '</a>';
							echo '</span>';
				echo '</div>';
			 } ?>
		</div>
<!--  ======================================================================================OFERTE FACUTE=============================================-->
<div class="oferte_facute">

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
			     <div class="info-section">
                    <p>
                        <a class="sa_public_profile" href="<?php echo $link_profile ?>"> <?php $r->companie; ?></a>
                    </p>
					<?php
						if ($r->f_principal == 0) {
				echo '<p>'.JText::sprintf('SAUTO_FILIALA_REPREZENTATA DE', $r->reprezentant).'</p>';
							}
					?>
					<p> <?php echo JText::_('SAUTO_CITY_TITLE').': '.$r->localitate.' '; ?> </p>
					
					<p> <?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$r->calificative.'%'; ?> </p>
					<p class="sa_tip_abon"> <?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$r->abonament; ?> </p>
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
					   <p class="sa_phone sa_phone_oferte sa_hover" style="background-color: #509EFF;" data-phone="<?php echo $r->telefon ?>">
                        <?php echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />'; ?>
						<span class="sa_phone_span"><?php echo $r->telefon; ?></span>
                    </p>
					<?php
						if ($rezult->proprietar == $uid) {
							if ($rezult->is_winner == 1) {
								if ($r->status_raspuns == 1) {
									$status_oferta = JText::_('SAUTO_OFERTA_CASTIGATOARE');
								} else {
									$status_oferta = JText::_('SAUTO_OFERTA_NECASTIGATOARE');
								} 
							} else {
					?>
								<p><button id="popup_window" data-popup-target="<?php echo '#winner-popup_'.$r->id;?>" class="sa_hover">
								<?php echo JText::_('SAUTO_SELECT_OFERTA_BUTTON')?></button></p>
								<img src="<?php echo $img_path.'icon_bifa_inactiva.png';?>" border="1" class="sauto_bifa_inactiva" />
								<div id="winner-popup_<?php echo $r->id; ?>" class="popup">
									<div class="popup-body"><span class="popup-exit"></span>
										<div class="popup-content">
											<h2 class="popup-title">Apasa Esc pentru anulare</h2>
											<?php
											$link_form_winner = JRoute::_('index.php?option=com_sauto&view=set_winner');
											?>
											<form action="<?php echo $link_form_winner; ?>" method="post" name="<?php echo 'select-'.$r->id; ?>" id="<?php echo 'select-'.$r->id; ?>" >
												<input type="hidden" name="rasp_id" value="'.$r->id.'" />';
												<input type="hidden" name="anunt_id" value="'.$id.'" />';
												<p>Sigur doresti sa setezi aceasta oferta ca si castigatoare?</p>
													<?php
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
											?>	
							<div class="sa_oferta_castig">
									<p><?php echo $status_oferta; ?></p>
							<img src="<?php echo $img_path.'icon_bifa_activa.png';?>" border="0" />
							<?php
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
							echo '<img src="'.$img_path.'icon_bifa_inactiva.png" border="1" class="sauto_bifa_inactiva" />'; 
						}						
						if ($r->status_raspuns == 1) {
							if ($t_cals == 0) {
									echo '<div id="calificativ" style="display:none;">';
									require("calificativ.php");
									$redirect = 'detail';
									calificativ($uid, $r->firma, $id, $r->id, 'customer', $redirect);
									echo '</div>';
								}
						}
$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment');
//=================adauga comentariu===========================
	if ($rezult->proprietar == $uid) 
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
?>
<div id="<?php echo 'add_comment_'.$z;?>" style="display:none;">						
	<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm_<?php echo $r->id; ?>" id="submit_comm_<?php echo $r->id; ?>">
			<?php
			form_comment($r->id, $multiple_id, $id, $rezult->proprietar, $r->firma);
			?>
			<?php loadImg($r->id, $multiple_id); ?>					
	</form>		
	<div onClick="document.forms['submit_comm_<?php echo $r->id; ?>'].submit();" class="sa_add_comment sa_submit_form">
		<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>
</div>
</div>	
<?php
$z = $z+1;
		} else {
				if ($blocked == 0) { $blocked = 1; } else { $blocked = $blocked+1; }
				}
}
if ($blocked != 0) {
				echo '<div class="sa_warnings">'.JText::sprintf('SAUTO_OFERTE_IN_ASTEPTARE', $blocked).'</div>';
			}
			?>												
					                

		</div>
	</div>			
</div>			
<script type="text/javascript">
		var element = document.getElementById('hidden-values');
		//element.getElementsByClassName('m_header')[0].remove();
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