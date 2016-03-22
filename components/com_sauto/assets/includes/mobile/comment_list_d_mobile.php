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
        width: 45%;
        display: inline-block;
    }
    .info-section{
         width: 50%;
        display: inline-block;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php
defined('_JEXEC') || die('=;)');
$user =& JFactory::getUser();
$uid = $user->id;


$document = JFactory::getDocument();
require("toggle_js_mobile.php");
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
require("function_load_img_mobile.php");
require("function_report_mobile.php");
require("function_form_comment_mobile.php");
$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment'); 

$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$rezult->tip_anunt);	
$width = 'style="width:800px;"';
?>
<div id="m_visitors">
	<?php
require("menu_filter_d.php");
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

		<?php
		$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total != 0) {
			//avem poze
			require("display_pictures_mobile.php");
			view_pictures($anunt_id, $rezult->proprietar);
		}
		?>
		<p><?php echo $rezult->anunt; ?></p>
			<?php 
			report_now($rezult->raportat, $anunt_id, $uid);
			?>
<div id="firma" style="width:100%;">
				<?php 
							//preluam ofertele facute
					$img_path2 = JURI::base()."components/com_sauto/assets/users/";
					$query = "SELECT `p`.`companie`, `p`.`calificative`, `p`.`poza`, `p`.`telefon`, `l`.`localitate`, `a`.`abonament` 
					FROM #__sa_profiles as `p` 
					JOIN #__sa_localitati as `l` 
					JOIN #__sa_abonament as `a` 
					ON `p`.`uid` = '".$firma."' AND `p`.`localitate` = `l`.`id` AND `p`.`abonament` = `a`.`id`";
							$db->setQuery($query);
							$r = $db->loadObject();
							$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$firma);
								if ($r->poza == '') {
											//fara avatar
											$poza=$img_path.'fi_avatar.png';
										} else {
											//cu avatar
											$poza=$img_path2.$firma.'/'.$r->poza;
										}
					echo '<hr class="sauto_hr"/>';
		?>
<div class="request-item">
				<div class="pic-container" data-id="<?php echo $r->companie ?>" data-category="categories">
					<img src="<?php echo $poza ?>" width="80" border="0" />
				</div>	
			     <div class="info-section">
                    <p>	<?php 	echo '<a class="sa_public_profile" href="'.$link_profile.'">'.$r->companie.'</a>';	?></p>
					<p> <?php echo JText::_('SAUTO_CITY_TITLE').': '.$r->localitate.' '; ?> </p>
					
					<p> <?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$r->calificative.'%'; ?> </p>
					<p class="sa_tip_abon"> <?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$r->abonament; ?> </p>
					<p class="sa_mesaj_oferta"> <?php echo JText::_('SAUTO_MESAJ_OFERTA_TITLE'); ?> </p>
					<?php
					//obtin oferta
					$query = "SELECT `r`.`mesaj`, `r`.`data_adaugarii`, `r`.`pret_oferit`, `r`.`moneda`, `m`.`m_scurt`  
						FROM #__sa_raspunsuri AS `r` JOIN #__sa_moneda AS `m` 
						ON `r`.`anunt_id` = '".$anunt_id."' AND `r`.`proprietar` = '".$rezult->proprietar."' 
						AND `r`.`firma` = '".$firma."' AND `r`.`moneda` = `m`.`id`";
					$db->setQuery($query);
					//echo $query;
					$r = $db->loadObject();
					?>
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
</div>
						
						
						<div class="sa_demarcare"><hr class="sauto_hr" /></div>
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
						if ($l->raspuns == 0) {
							//proprietar
							echo '<div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_CLIENT').': </div>';
							echo '<div style="display:inline;">';
							echo '<div style="float:left;">'.$l->data_adaugarii.'</div>';
							echo '<div class="sa_link_profile" style="float:right;"><a class="sa_public_profile" href="'.$link_profile.'">'.$l->fullname.'</a></div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
							echo '<p>'.$l->mesaj.'</p>';
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
						} else {
							//companie
							echo '<div class="sa_client_comment">'.JText::_('SAUTO_COMENTARIU_DEALER').': </div>';
							echo '<div style="display:inline;">';
							echo '<div class="sa_link_profile" style="float:left;"><a class="sa_public_profile" href="'.$link_profile.'">'.$company->companie.'</a></div>';
							echo '<div style="float:right;">'.$l->data_adaugarii.'</div>';
							echo '</div>';
							echo '<div style="clear:both;"></div>';
							echo '<p>'.$l->mesaj.'</p>';
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

						}
					}
					?>
					<hr class="sauto_hr" />
					<?php
					if ($rezult->is_winner == 0) { 
					?>
							<div class="sa_comment_reply"><?php echo JText::_('SAUTO_COMMENT_REPLY'); ?></div>
							<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm" id="submit_comm">
							<?php
							form_comment($r_id, $multiple_id, $anunt_id, $proprietar, $firma);
							echo loadImg($r_id, $multiple_id); ?>					
	</form>
<div onClick="document.forms['submit_comm'].submit();" class="sa_add_comment sa_submit_form sa_hover">
	<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>
						<?php } else {
								if ($rezult->uid_winner == $firma) {
								?>
<div class="sa_comment_reply"><?php echo JText::_('SAUTO_COMMENT_REPLY'); ?></div>
<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm" id="submit_comm">
<?php
form_comment($r_id, $multiple_id, $anunt_id, $proprietar, $firma);
echo loadImg($r_id, $multiple_id); 
?>					
	</form>
		
	<div onClick="document.forms['submit_comm'].submit();" class="sa_add_comment sa_submit_form sa_hover">
	<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
	</div>
								<?php
								}
							} ?>

							<button style="float:right"onclick="window.history.go(-1)"><?php echo JText::_('SAUTO_BACK_ANUNT_BUTTON'); ?></button>
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
</div>
<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')
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