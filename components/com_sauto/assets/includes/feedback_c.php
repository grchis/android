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


$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
//$query = "SELECT `c`.`anunt_id`, `c`.`mesaj`, `c`.`tip`, `a`.`titlu_anunt`, `c`.`data_cal`, `c`.`poster_id` FROM #__sa_calificativ as `c` JOIN #__sa_anunturi as `a` ON `c`.`dest_id` = '".$uid."' AND `c`.`anunt_id` = `a`.`id`";
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' ";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 0) {
	//nu ai anunturi
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php //$link_add = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_FEEDBACK_'); ?>
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

$total_rezult = $total;
$rezult_pagina = '7';
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

$link = JRoute::_('index.php?option=com_sauto&view=feedback');

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

$query = "SELECT `c`.`anunt_id`, `c`.`mesaj`, `c`.`tip`, `a`.`titlu_anunt`, `c`.`data_cal`, `c`.`poster_id` 
FROM #__sa_calificativ as `c` JOIN #__sa_anunturi as `a` 
ON `c`.`dest_id` = '".$uid."' 
AND `c`.`anunt_id` = `a`.`id` 
ORDER BY `c`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<center>
	<table width="100%" class="sa_table_class">
<?php
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}
		
		$query = "SELECT `p`.`telefon`,  `p`.`companie`, `p`.`calificative`, `u`.`registerDate`, `j`.`judet` 
						FROM #__sa_profiles as `p` 
						JOIN  #__users as `u` 
						JOIN #__sa_judete as `j` 
						ON `p`.`uid` = '".$l->poster_id."' 
						AND `p`.`uid` = `u`.`id`
						AND `p`.`judet` = `j`.`id`";
					$db->setQuery($query);
					$usr = $db->loadObject();
					//print_r($usr);
		
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);
			?><tr class="sa_table_row <?php echo $style; ?>">
				<td class="sa_table_cell" rowspan="2" valign="top">
					<table class="sa_table_class">
						<tr class="sa_table_row">
							<td rowspan="2" class="sa_table_cell" width="80" valign="top">
								<?php
								if ($l->tip == 'p') {
									$poza = 'icon_mesaj_pozitiv.png';
								} elseif ($l->tip == 'x') {
									$poza = 'icon_mesaj_negativ.png';
								} elseif ($l->tip == 'n') {
									$poza = 'icon_mesaj_neutru.png';
								}
								?>
								<img src="<?php echo $img_path.$poza; ?>" border="0" />
							</td>
							<td class="sa_table_cell" valign="top">
									<a href="<?php echo $link_anunt; ?>" class="sa_public_profile">
										<?php echo $l->titlu_anunt; ?>
									</a>
							</td>
						</tr>
						<tr class="sa_table_row">
							<td class="sa_table_cell" valign="top">
								<div class="sauto_data_add">
									<?php 
									$data_c = explode(" ", $l->data_cal);
									echo JText::_('SAUTO_DATA_TITLE').' '.$data_c[0]; ?>
								</div>
							</td>
						</tr>
						<tr class="sa_table_row">
							<td colspan="2" class="sa_table_cell">
								<div class="sauto_show_anunt">
									<?php echo $l->mesaj; ?>
								</div></td>
						</tr>
					</table>
				</td>
				<td class="sa_table_cell" valign="top">
					<?php
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->poster_id);
					?>
					<div>
						<a href="<?php echo $link_profile; ?>" class="sa_public_profile">
						<?php echo $usr->companie; ?>
						</a>
					</div>
					<br />
					<?php echo JText::_('SAUTO_FORM_REGION'); ?>
					<?php echo $usr->judet; ?>
					<br />
					<?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$usr->calificative.'%'; ?>
					<br />
					<?php 
					$date_reg = explode(" ", $usr->registerDate);
					echo JText::_('SAUTO_PROFILE_REGISTER_DATE').' '.$date_reg[0]; ?>
				</td>
			</tr>
			<tr class="sa_table_row <?php echo $style; ?>">
				<td class="sa_table_cell">
					<div class="sa_phone">
					<img src="<?php echo $img_path; ?>icon_phone.png" border="0" class="sa_phone_img" />
						<span class="sa_phone_span">
							<?php echo $usr->telefon; ?>
						</span>	
					</div>
				</td>
			</tr>
			<?php
	}
?>
	</table>
</center>
<?php
echo '<br /><br />';
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';
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
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
<?php
}
