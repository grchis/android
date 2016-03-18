
<style type="text/css">
    p{
        margin: 0;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section{
         width: 39%;
        display: inline-block;
    }
    .contact-section{
        width: 39%;
        display: inline-block;
        vertical-align: top;
    }
	.action-button{
		text-align: center;
		width: 30%;
		max-width: 100px;
		display: inline-block;
		background-color: #509EFF;
		font-size: 20px;
		color: white;
		padding-top: 4px;
		padding-bottom: 4px;
	}
	@media screen and (max-width: 1210px){
		.gkPage {
			padding: 0 !important;
		}
	}
</style>
<?php
//-- No direct access
defined('_JEXEC') || die('=;)');


$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '1' AND `status_anunt` = '1'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
		require_once('fara_anunturi.php');
	}else{
	?>
<div id="m_visitors">
<?php
require_once('menu_filter.php');
?>
	<h1>Oferte Finalizate</h1>
	
    <div id="main-container">
        <?php
        $i=1;
		$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '1' ORDER BY `data_castigare` DESC";
		$db->setQuery($query);
		$list = $db->loadObjectList();
		$image_path = JURI::base()."components/com_sauto/assets/users/";
		require("calificativ_mobile.php");
        foreach ($list as $l) {
            $image = 'anunt_type_'.$l->tip_anunt.'.png';
            $link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);

            $query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
            $db->setQuery($query);
            $pics = $db->loadObject();
            if ($pics->poza != '') {
                $poza = $image_path.$l->proprietar."/".$pics->poza;
                $alt = $pics->alt;
            } else {
                $poza = $img_path.$image;
                $alt = '';
            }
            $data_add = explode(" ",$l->data_adaugarii);
            ?>
            <div class="request-item">
				<a href="/android/index.php?view=categories&amp;id=4" class="sa_lk_profile">
					<div class="pic-container" data-id="<?php echo $l->tip_anunt ?>" data-category="categories">
						<p><?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt) ?> </p>
						<img src="<?php echo $poza ?>" width="80" border="0" />
					</div>
				</a>
                <div class="info-section">
                    <p><strong>
                        <a href="<?php
										$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
										echo $link_anunt;
										?>">
										<?php echo $l->titlu_anunt; ?>
						</a>
					</strong></p>
                    <p> <?php echo strip_tags($l->anunt) ?></p>
	
                    <?php if ($l->marca_auto != 0) {
                        //obtin marca si modelul
                        $query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
                        $db->setQuery($query);
                        $marca = $db->loadResult();
                    }?>
                       <?php if ($l->model_auto != 0) {
                        $query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
                        $db->setQuery($query);
                        $model = $db->loadResult();
                    } ?>
                    <p> <?php echo $marca.': '.$model; ?> </p>
					<p>
                        <span><?php echo JText::_('SAUTO_SHOW_DATE') ?>: </span><?php echo $data_add[0]; ?>
                    </p>
                </div>
                <div class="contact-section">
					<?php
						$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
						$db->setQuery($query);
						$acordate = $db->loadResult();
						if ($acordate == 1) {
							//calificativ acordat
							$query = "SELECT `tip`, `mesaj` FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
							$db->setQuery($query);
							$calif = $db->loadObject();
							echo'<p>'.$calif->mesaj.'</p>';
							echo '<div style="display:inline;">';
							if ($calif->tip == 'p') { $calif_p = 'feedback_pozitiv.png'; } else { $calif_p = 'feedback_pozitiv_gri.png'; }
							echo '<img src="'.$img_path.$calif_p.'" />';
							if ($calif->tip == 'n') { $calif_n = 'feedback_neutru.png'; } else { $calif_n = 'feedback_neutru_gri.png'; 	}
							echo '<img style="margin-left: 6%;" src="'.$img_path.$calif_n.'" />';
							if ($calif->tip == 'x') { $calif_x = 'feedback_negativ.png'; } else { $calif_x = 'feedback_negativ_gri.png'; }
							echo '<img style="margin-left: 6%;" src="'.$img_path.$calif_x.'" />';
						} else { ?>
							<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">
								<textarea name="calificativ_mess" cols="15" rows="1"></textarea>
								<div>
								<?php
								$calif_p = 'feedback_pozitiv_gri.png';	
								$calif_n = 'feedback_neutru_gri.png';							
								$calif_x = 'feedback_negativ_gri.png';
						 ?>
								<div id="calificativ_value_<?php echo $l->id; ?>" >
									<div style="width: 40px; display:inline-block;">
										<label for="pozitiv_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $l->id; ?>" value="p" />
											<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
										</label>
									</div>
								
									<div style="width: 40px; margin-left:4%; display:inline-block;">
										<label for="neutru_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="neutru_<?php echo $l->id; ?>" value="n" />
											<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
										</label>
									</div>
								
									<div style="width: 40px; margin-left:4%; display:inline-block;">
										<label for="negativ_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="negativ_<?php echo $l->id; ?>" value="x" />
											<img src="<?php echo $img_path.$calif_x; ?>" alt="Negativ" />
										</label>
									</div>
								</div>
								<div style="clear:both;"></div>
							</div>
							
							<input type="hidden" name="poster_id" value="<?php echo $uid; ?>" />
							<input type="hidden" name="dest_id" value="<?php echo $l->uid_winner; ?>" />
							<input type="hidden" name="id_anunt" value="<?php echo $l->id; ?>" />
							<input type="hidden" name="type" value="customer" />
							<input type="hidden" name="redirect" value="final" />
							</form>
							
							<div onClick="document.forms['calificativ_<?php echo $l->id; ?>'].submit();" class="sa_send_feedback sa_submit_feed">
								<?php echo JText::_('SAUTO_FEEDBACK_NOW_BUTTON'); ?>
							</div>
						<?php
						}
						?>
                </div>
            </div>
	<?php }}
        ?>
    </div>
</div>


<script>
		var isCollapsed = true;
		jQuery('.m_table').remove();
		 if (document.getElementById('side_bar')){
			document.getElementById('side_bar').remove();
		 }

		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }

		 if (document.getElementById('m_table1')){
			document.getElementById('m_table1').remove();
		 }

		 if (document.getElementById('content119')){
			 document.getElementById('content9').style.all = "none";
		 }

		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }
		 if (document.getElementById('wrapper9')){
		 document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		 }
		jQuery('#menu-icon').on('click', toggleMenu);
		
		document.write('<style type="text/css" >#content9{width: 100% !important;' +
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
		document.write('<style type="text/css">@media="(max-width: 340px)"#gkMainbody table { width: 540px!important; display: block!important;  padding: 30px 0 20px 0;  overflow: hide;  max-width: 100%;</style>');s
function toggleMenu()
{
	if (isCollapsed){
		isCollapsed = false;
		jQuery('#main-menu').show(500);
	}
	else{
		isCollapsed = true;
		jQuery('#main-menu').hide(500);
	}
}
</script>