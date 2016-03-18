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
require_once('/mobile/final_request_c_mobile.php');
}else{

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '1' AND `status_anunt` = '1'";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';

if ($total == 0) {
	//nu ai anunturi
	?>
<table class="sa_table_class m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_FINAL_REQUESTS').'<br /><a href="'.$link_add.'" class="sa_lk_profile">'.JText::_('SA_ADD_REQUEST_NOW').'</a>'; ?>
		</div>
	</div>
	</div>
	<div style="clear:both;"></div>
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
	<?php
} else { 
################################################
$total_rezult = $total;
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$rezult_pagina = $sconfig->paginare;
//nr de pagini
$nr_pagini=ceil($total_rezult/$rezult_pagina); 

$page =& JRequest::getVar( 'page', '', 'get', 'string' );
if(isset($page) && is_numeric($page)){
    $pagina_curenta=(int)$page;
} else {
    $pagina_curenta=1;
}

if($pagina_curenta > $nr_pagini) {
    $pagina_curenta=$nr_pagini;
} elseif($pagina_curenta < 1) {
    $pagina_curenta=1;
}

$link = JRoute::_('index.php?option=com_sauto&view=final_request');

$interval=5;
 
if($pagina_curenta > (1+$interval)) {
	$paginare.='<a class="sa_page" href="'.$link.'&page=1">'.JText::_('SA_PRIMA_PAGINA').'</a>';
	$pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
} elseif (($pagina_curenta > 1) && ($pagina_curenta <= (1+$interval))) {
    $pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
}

for($x=($pagina_curenta - $interval); $x < (($pagina_curenta + $interval) + 1); $x++) {
    if(($x > 0) && ($x <= $nr_pagini)){  
      if($pagina_curenta != $x){
        $paginare.='<a class="sa_page" href="'.$link.'&page='.$x.'">'.$x.'</a>';
      } else {
        $paginare.='<a class="sa_page"><span class="sa_page_current">'.$x.'</span></a>'; 
      }
    }
}


if(($pagina_curenta != $nr_pagini) && ($pagina_curenta < ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$nr_pagini.'">'.JText::_('SA_LAST_PAGE').'</a>';
} elseif (($pagina_curenta != $nr_pagini) && ($pagina_curenta >= ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
}


$inceput=($pagina_curenta - 1) * $rezult_pagina;

$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '1' ORDER BY `data_castigare` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();


$image_path = JURI::base()."components/com_sauto/assets/users/";

require("calificativ.php");
?>
<table class="sa_table_class m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<table width="100%" class="sa_table_class m_table">
	<?php
	$i=1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}
		
		$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		?>
		<tr class="sa_table_row <?php echo $style; ?>">
			<td width="15%" valign="top" class="sa_table_cell">
			<center>
				<div>
					<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
						<?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt); ?>
					</a>
				</div>
				<?php
				//verificare poze
				$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
				$db->setQuery($query);
				$pics = $db->loadObject();
					if ($pics->poza != '') {
						$poza = $image_path.$uid."/".$pics->poza;
						$alt = $pics->alt;
					} else {
						$poza = $img_path.$image;
						$alt = '';
					}
					?>
					<div>
						<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
							<img src="<?php echo $poza; ?>" alt="<?php echo $alt; ?>" width="80" border="0" />
						</a>
					</div>
			
					<div>
					<?php
					//obtin pret + moneda
					$query = "SELECT `r`.`pret_oferit`, `m`.`m_scurt` FROM #__sa_raspunsuri as `r` JOIN #__sa_moneda as `m` ON `r`.`anunt_id` = '".$l->id."' AND `r`.`status_raspuns` = '1' AND `r`.`moneda` = `m`.`id`";
					$db->setQuery($query);
					$curency = $db->loadObject();
					echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$curency->pret_oferit.' '.$curency->m_scurt;
					?>
					</div>
			</center>
			</td>
			<td width="55%" valign="top" class="sa_table_cell">
				<?php
				$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
				?>
				<div class="sa_request_title">
					<a href="<?php echo $link_anunt; ?>" class="sa_link_request">
						<?php echo $l->titlu_anunt; ?>
					</a>
				</div>
				<?php
				$data_add = explode(" ", $l->data_adaugarii);
				?>
				<div>
					<?php echo JText::_('SAUTO_SHOW_DATE').' '.$data_add[0]; ?>
				</div>
				<div>
					<?php echo substr(strip_tags($l->anunt), 0, 50).' ...'; ?>
				</div>
<?php
if ($l->accesorii_auto != 0) {
	echo '<div style="display:inline;">';
	//obtin accesoriu
	$query = "SELECT `accesorii` FROM #__sa_accesorii WHERE `id` = '".$l->accesorii_auto."'";
	$db->setQuery($query);
	$acc = $db->loadResult();
	echo '<div style="position:relative;float:left;" class="sa_accesories">'.$acc.'</div>';
	if ($l->subaccesorii_auto != 0) {
	$query = "SELECT `subaccesoriu` FROM #__sa_subaccesorii WHERE `id` = '".$l->subaccesorii_auto."'";
	$db->setQuery($query);
	$subacc = $db->loadResult();
	echo '<div style="position:relative;float:left;margin-left:5px;" class="sa_accesories"> :: '.$subacc.'</div>';
	}
	echo '</div><div style="clear:both;"></div>';
}
if ($l->marca_auto != 0) {
	echo '<div style="display:inline;">';
	//obtin marca si modelul
	$query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadResult();
	echo '<div style="position:relative;float:left;" class="sa_accesories">'.$marca.'</div>';
	if ($l->model_auto != 0) {
	$query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
	$db->setQuery($query);
	$model = $db->loadResult();	
	echo '<div style="position:relative;float:right;margin-left:5px;" class="sa_accesories"> :: '.$model.'</div>';
	}
	echo '</div><div style="clear:both;"></div>';
}
?>
			</td>
			<td valign="top" class="sa_table_cell">
			
			<?php
			//
			$query = "SELECT `companie` FROM #__sa_profiles WHERE `uid` = '".$l->uid_winner."'";
			$db->setQuery($query);
			$companie = $db->loadResult();
			?>
				<table width="100%" class="sa_table_class m_table">
				<?php
				$link_calificativ = JRoute::_('index.php?option=com_sauto&view=calificativ');
				//echo '<form action="'.$link_calificativ.'" method="post" name="calificativ_'.$l->id.'" id="calificativ_'.$l->id.'">';
				?>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
						<?php 
						$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->uid_winner);
						?>
							<div class="sa_request_title">
								<a href="<?php echo $link_profile; ?>" class="sa_link_request">
									<?php echo $companie; ?>
								</a>
							</div>
						</td>
					</tr>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
						<?php
						$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
						$db->setQuery($query);
						$acordate = $db->loadResult();
					
						if ($acordate == 1) {
							//calificativ acordat
							$query = "SELECT `tip`, `mesaj` FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
							$db->setQuery($query);
							$calif = $db->loadObject();
							?>
							<div>
								<?php echo $calif->mesaj; ?>
							</div>
							<div style="display:inline;">
							<?php
							if ($calif->tip == 'p') { $calif_p = 'feedback_pozitiv.png'; } else { $calif_p = 'feedback_pozitiv_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_p; ?>" />
							</div>
							<?php
							if ($calif->tip == 'n') { $calif_n = 'feedback_neutru.png'; } else { $calif_n = 'feedback_neutru_gri.png'; 	}
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_n; ?>" />
							</div>
							<?php
							if ($calif->tip == 'x') { $calif_x = 'feedback_negativ.png'; } else { $calif_x = 'feedback_negativ_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_x; ?>" />
							</div>
						</div>
						<div style="clear:both;"></div>
							<?php
						} else {
							//de acordat
							?>
							<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">
								<div>
									<textarea name="calificativ_mess" cols="15" rows="1"></textarea>
								</div>
								<div>
								<?php
								$calif_p = 'feedback_pozitiv_gri.png';	
								$calif_n = 'feedback_neutru_gri.png';							
								$calif_x = 'feedback_negativ_gri.png';
							/*	echo '<input type="radio" name="calificativ_value" value="p" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="n" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="x" class="sa_feed_select sa_styled" />';
							*/ ?>
								<div id="calificativ_value_<?php echo $l->id; ?>" style="display:inline;">
									<div style="position:relative;float:left;margin-left:14px;">
										<label for="pozitiv_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $l->id; ?>" value="p" />
											<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
										</label>
									</div>
								
									<div style="position:relative;float:left;margin-left:14px;">
										<label for="neutru_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="neutru_<?php echo $l->id; ?>" value="n" />
											<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
										</label>
									</div>
								
									<div style="position:relative;float:left;margin-left:14px;">
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
						</td>
					</tr>
				</table>
			</td>
		</tr> <?php
	if ($i == 5) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						$categ = '';
						echo showAds($pozitionare, $categ);
					echo '</td>';
				echo '</tr>';	
		}
	$i++;
	}
	?>
</table>
<?php
echo '<br /><br />';
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';
}
?>
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

<div id="m_visitors">
	<div class = "m_header">
        <img id="menu-icon" class="menu-button" src="<?php echo $img_path?>menu-icon.png" />
    </div>
	
	<div id="main-menu" style="display: none;">
        <div class="menu-option" data-href="/android/index.php?option=com_sauto&view=add_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text"> Adauga cerere </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=search">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text"> Cauta firme </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?view=final_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text"> Cererile mele </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=final_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text"> Cereri finalizate </span>
        </div>

        <div class="menu-option" data-href="/android/index.php/component/sauto/?view=edit_profile">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text"> Editare profil </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=logout">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text"> Inchide Aplicatia </span>
        </div>
    </div>
    
	<h1>Oferte Finalizate</h1>
	
    <div id="main-container">
        <?php
        $i=1;
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
                    <p>
                        <a href="<?php echo $link_anunt ?>"> <?php $l->titlu_anunt ?></a>
                    </p>
                    <p>
                        <span><?php echo JText::_('SAUTO_SHOW_DATE') ?>: </span><?php echo $data_add[0]; ?>
                    </p>
                    <p> <?php echo strip_tags($l->anunt) ?></p>

                    <?php if ($l->marca_auto != 0) {
                        //obtin marca si modelul
                        $query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
                        $db->setQuery($query);
                        $marca = $db->loadResult();
                    }?>
                    <p> <?php echo $marca ?> </p>
                    <?php if ($l->model_auto != 0) {
                        $query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
                        $db->setQuery($query);
                        $model = $db->loadResult();
                    } ?>
                    <p> <?php echo $model ?> </p>

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
							/*	echo '<input type="radio" name="calificativ_value" value="p" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="n" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="x" class="sa_feed_select sa_styled" />';
							*/ ?>
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

<script>
var isMobile = navigator.userAgent.contains('Mobile');
	if(!isMobile){
		document.getElementById('m_visitors').remove();
	}else {
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
}

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