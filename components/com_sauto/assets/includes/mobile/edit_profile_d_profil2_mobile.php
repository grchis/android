<style type="text/css">
	h1{
		display:none;
	}
    p{
    margin: 0;
    font-size: 1.3em;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
	
	#info{
		margin-left:5%;
		margin-right:5%;
		margin-top:2%;
	}
    .info-section{
         width: 40%;
        display: inline-block;
    }
    .contact-section{
        width: 42%;
        display: inline-block;
        vertical-align: top;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
	#telefon{
	margin-top: 2%!important;
    margin-left: 2%!important;
    margin-right: 50%!important;
	}
#gkMainbody table tbody{
		width:100%!important;
}
#gkMainbody table:before {
    content: "";
	width:100%;
	
  }
</style>
<?php
defined('_JEXEC') || die('=;)');
$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets";
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$query = "SELECT `p`.`poza`, `p`.`companie`, `p`.`reprezentant`, `p`.`sediu`, `p`.`telefon`, `p`.`uid`, `j`.`judet`, `u`.`registerDate`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_judete as`j` JOIN #__users as `u` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$uid."' AND `p`.`uid` = `u`.`id` AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id`";
 
$db->setQuery($query);
$profil = $db->loadObject();
?>
<div id="m_visitors">
	<div id="reprezentant" style="width:100%;"> 
		<div id="info">
		<p><?php echo JText::_('SAUTO_REPREZENTANT');?>: <?php echo $profil->reprezentant;?></p>
	<p><?php  echo JText::_('SAUTO_PROFILE_CITY'); ?>: <?php  echo $profil->localitate; ?></p>
	<p> <?php  echo JText::_('SAUTO_PROFILE_JUDET'); ?>:    <?php  echo $profil->judet; ?></p>
	<p><?php  echo  JText::_('SAUTO_PROFILE_SEDIU');?>:  <?php echo $profil->sediu; ?></p>
	<p>
	 <?php  echo JText::_('SAUTO_PROFILE_REGISTER_DATE'); ?>
		<?php 	$data_inreg = explode(" ", $profil->registerDate); echo $data_inreg[0]; ?>
	</p>
	<p><span> <?php  echo JText::_('SAUTO_PROFILE_FEEDBACKS');  ?> </span> <?php  
							$neg2 = $poz_3 + $neg_3;
							$feeds = $poz_3/$neg2;
							$all = $poz_3 + $neg_3 + $neu_3;
							echo round(100*$feeds,2).'% ('.$all.')';?></p>
		</div>
		<div id="telefon"style="margin-top:2%;margin-left: 20%; margin-right: 20%;">
			<p class="sa_table_cell sa_phone sa_hover">
		<img src="<?php echo $img_path; ?>icon_phone.png" border="0" class="sa_phone_img" />
		<span class="sa_phone_span">
		<?php echo $profil->telefon;?>
							</span>
	</p>
	</div>
	</div>
	<table class="sa_table_class">
					<tr class="sa_table_feedback_row">
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TYPE'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_LAST_MONTH'); ?></th>
						<th class="sa_table_feedback_cell">6 luni</th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TOTAL'); ?></th>
					</tr>
					<?php
					//obtin calificativele
					$curent_date = time();
					$last_30 = $curent_date - 2592000;
					$last_6 = $curent_date - 15552000;
					//echo '>>> '.$curent_date.'<br />';
					$last_30 = date("Y-m-d h:i:s", $last_30);
					$last_6 = date("Y-m-d h:i:s", $last_6);
					//echo '>>>> '.$last_30.'<br />';
					//echo '>>>>> '.$last_6.'<br />';
					//pozitiv series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$poz_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$poz_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p'";
					$db->setQuery($query);
					$poz_3 = $db->loadResult();
					//negativ series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neg_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neg_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x'";
					$db->setQuery($query);
					$neg_3 = $db->loadResult();
					//neutru series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neu_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neu_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n'";
					$db->setQuery($query);
					$neu_3 = $db->loadResult();
					//echo '???? '.$poz_1.' >>> '.$poz_2.' ???? '.$poz_3;
					?>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_pozitiv.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_POZITIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_neutru.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEUTRU'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_negativ.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEGATIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_3; ?></td>
					</tr>
				</table>
	
<!-- =======================================Feedback history and comments========================================================== -->	
	<div id="comments_list">
		<?php 
			$query = "SELECT `c`.`anunt_id`, `c`.`mesaj`, `c`.`tip`, `a`.`titlu_anunt`, `c`.`data_cal`, `c`.`poster_id` FROM #__sa_calificativ as `c` JOIN #__sa_anunturi as `a` ON `c`.`dest_id` = '".$id."' AND `c`.`anunt_id` = `a`.`id` ORDER BY `c`.`id` DESC LIMIT 0, 5";
			$db->setQuery($query);
			$list = $db->loadObjectList();
			foreach ($list as $l) {			
				$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);		
				if ($l->tip == 'p') {
							$poza = 'icon_mesaj_pozitiv.png';
						} elseif ($l->tip == 'x') {
							$poza = 'icon_mesaj_negativ.png';
						} elseif ($l->tip == 'n') {
							$poza = 'icon_mesaj_neutru.png';
						}		
		?>			
	<div class="request-item">
			<div class="pic-container" data-id="<?php echo $r->companie ?>" data-category="categories">
					<img src="<?php echo $img_path.$poza; ?>" border="0" />
				</div>	
			     <div class="info-section">
					<p>
						<a href="<?php echo $link_anunt; ?>" class="sa_public_profile">
							<?php echo $l->titlu_anunt; ?>
						</a>
					</p>
					<p class="sauto_data_add">
						<?php 
							$data_c = explode(" ", $l->data_cal);
							echo JText::_('SAUTO_DATA_TITLE').' '.$data_c[0]; 
						?>
					</p>
					<p class="sauto_show_anunt">
						<?php echo $l->mesaj; ?>
					</p>
				</div>
				 <div class="contact-section">
					<?php
					if ($tip_cont == 0) {
						$query = "SELECT `p`.`telefon`,  `p`.`companie`, `p`.`calificative`, `u`.`registerDate`, `j`.`judet` FROM #__sa_profiles as `p` JOIN  #__users as `u` ON `p`.`uid` = '".$l->poster_id."' JOIN #__sa_judete as `j` ON `p`.`judet` = `j`.`id`";
					} else {
						$query = "SELECT `p`.`telefon`,  `p`.`fullname`, `p`.`calificative`, `u`.`registerDate`, `j`.`judet` FROM #__sa_profiles as `p` JOIN  #__users as `u` ON `p`.`uid` = '".$l->poster_id."' JOIN #__sa_judete as `j` ON `p`.`judet` = `j`.`id`";
					}
					$db->setQuery($query);
					$usr = $db->loadObject();
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->poster_id);
					?>
					<p>
						<a href="<?php echo $link_profile; ?>" class="sa_public_profile">
						<?php 
						if ($tip_cont == 0) {
							echo $usr->companie; 
						} else {
							echo $usr->fullname; 
						} ?>
						</a>
					</p>
					<p><?php echo JText::_('SAUTO_FORM_REGION'); ?></p>
					<p><?php echo $usr->judet; ?></p>
					<p><?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$usr->calificative.'%'; ?></p>
					<p>
						<?php 
							$date_reg = explode(" ", $usr->registerDate);
							echo JText::_('SAUTO_PROFILE_REGISTER_DATE').$date_reg[0]; 
						?>
					</p>
					<p class="sa_phone sa_hover">
						<img src="<?php echo $img_path; ?>icon_phone.png" border="0" class="sa_phone_img" />
						<span class="sa_phone_span">
						 <?php 
							if ($tip_cont == 0) {
								echo $usr->telefon;
							} else {
								//telefon ascuns
								if ($view_phone == 0) {
									if ($l->poster_id == $uid) {
										//numar propriu, afisam
										echo $usr->telefon;
									} else {
										//nu afisam
										echo JText::_('SAUTO_TELEFON_ASCUNS');
									}
									
								} else {
									echo $usr->telefon;
								}
							} ?>
						</span>	
					</p>
				</div>
			</div>
			</div>
<?php 
}?>
</div>
<script type="text/javascript">
		
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
		
</script>