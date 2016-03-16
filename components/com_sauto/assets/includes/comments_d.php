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
$rezult_pagina = 10;
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$last_visit = $user->lastvisitDate;

$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->loadObject();

$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `raspuns` = '0' ";
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
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_UNREADED_COMMENTS'); ?>
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

$link = JRoute::_('index.php?option=com_sauto&view=comments');

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

$query = "SELECT `c`.`id`, `c`.`readed_d`, `p`.`fullname`, `p`.`poza`,  `p`.`calificative`, `c`.`proprietar`, `c`.`data_adaugarii`, `c`.`mesaj`, `c`.`anunt_id`, `a`.`titlu_anunt` 
FROM #__sa_comentarii as `c` JOIN #__sa_anunturi as `a` JOIN #__sa_profiles as `p` 
ON `c`.`companie` = '".$uid."' AND `c`.`raspuns` = '0' AND `c`.`anunt_id` = `a`.`id` AND `c`.`proprietar` = `p`.`uid` ORDER BY `c`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
//$query = "SELECT `c`.`proprietar`, `c`.`data_adaugarii`, `c`.`mesaj`, `c`.`anunt_id` FROM #__sa_comentarii as `c` WHERE `c`.`proprietar` = '".$uid."' AND `c`.`data_adaugarii` < '".$last_visit."' AND `c`.`data_adaugarii` > '".$profil->data_1."' AND `c`.`raspuns` = '0' ORDER BY `c`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

$i=1;
$image_path = JURI::base()."components/com_sauto/assets/users/";
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<center>
	<table class="sa_table_class" width="100%">
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id); 
	$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
	$link_comment = JRoute::_('index.php?option=com_sauto&view=single_comment&id='.$l->id); 
	echo '<tr class="sa_table_row '.$style.'">';
	echo '<td class="sa_table_cell" valign="top" width="100">';
		if ($l->poza != '') {
				$poza = $image_path.$l->proprietar.DS.$l->poza;
			} else {
				$poza = $img_path.'fi_avatar.png';
			}
		echo '<img src="'.$poza.'" width="100" />';
	echo '</td>';
	echo '<td class="sa_table_cell" valign="top">';
		echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$l->fullname.'</a></div>';
		echo '<hr />';
		echo '<div>';
			if ($l->readed_d == 0) { echo '<img src="'.$img_path.'icon_nou.png" /> '; }
			echo '<a class="sa_public_profile" href="'.$link_anunt.'">'.$l->titlu_anunt.'</a></div>';
		echo '<div>'.substr(strip_tags($l->mesaj), 0, 20).' ...<a href="'.$link_comment.'" class="sa_comments">'.JText::_('SAUTO_TOT_COMENTARIUL').'</a></div>';		
	echo '</td>';
	echo '<td class="sa_table_cell" valign="top">';
		$data_add = explode(" ", $l->data_adaugarii);
		echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
		echo '<div>'.JText::_('SAUTO_PROFILE_FEEDBACKS').' '.$l->calificative.'%</div>';
	echo '</td>';
	echo '</tr>';

}
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `raspuns` = '0' AND `readed_d` = '0'";
	$db->setQuery($query);
	$total = $db->loadResult();
	//echo '>>> '.$total;
	if ($total != 0) {
	?>
	<tr class="sa_table_row">
		<td class="sa_table_cell" colspan="3">
			<?php 
			echo '<div style="float:right;">';
			$link_read = JRoute::_('index.php?option=com_sauto&view=mark_read');
			echo '<a href="'.$link_read.'" class="sa_comments_read">'.JText::_('SA_MARECHEAZA_CITIT').'</a>';
			echo '</div>';
			?>
		</td>
	</tr>
	<?php } ?>
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
