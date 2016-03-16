<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();

$query = "SELECT count(*) FROM #__sa_anunturi WHERE `raportat` = '1'";
$db->setQuery($query);
$total = $db->loadResult();

if ($total != 0) {
$total_rezult = $total;
$rezult_pagina = '10';
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

$link = JRoute::_('index.php?option=com_sauto&task=raportate');

$interval=5;
 
if($pagina_curenta > (1+$interval)) {
	$paginare.='<a class="sa_page" href="'.$link.'&page=1"><<</a>';
	$pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'"><</a>';
} elseif (($pagina_curenta > 1) && ($pagina_curenta <= (1+$interval))) {
    $pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'"><</a>';
}

for($x=($pagina_curenta - $interval); $x < (($pagina_curenta + $interval) + 1); $x++) {
    if(($x > 0) && ($x <= $nr_pagini)){  
      if($pagina_curenta != $x){
        $paginare.='<a class="sa_page" href="'.$link.'&page='.$x.'">'.$x.'</a>';
      } else {
        $paginare.='<a class="sa_page" style="background-color:#ffffff; color:#000000;">'.$x.'</a>'; 
      }
    }
}


if(($pagina_curenta != $nr_pagini) && ($pagina_curenta < ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">></a>';
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$nr_pagini.'">>></a>';
} elseif (($pagina_curenta != $nr_pagini) && ($pagina_curenta >= ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">></a>';
}


$inceput=($pagina_curenta - 1) * $rezult_pagina;

$query = "SELECT `a`.`titlu_anunt`, `a`.`anunt`, `a`.`id`, `a`.`raportat`, `a`.`data_adaugarii`, `a`.`is_winner`, `a`.`uid_winner`, `p`.`fullname`, `a`.`tip_anunt`, `p`.`uid` FROM #__sa_anunturi AS `a` JOIN #__sa_profiles AS `p` ON `a`.`proprietar` = `p`.`uid` AND `a`.`raportat` = '1' ORDER BY `a`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JUri::root().'components/com_sauto/assets/';
?>
<h2>Anunturi raportate</h2>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	//obtin oferte
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$l->id."'";
			$db->setQuery($query);
			$oferte = $db->loadResult();
	echo '<tr class="'.$style.'">';
		echo '<td rowspan="2" width="100" valign="top">';
			//obtin poza
			$query = "SELECT `poza` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."' ORDER BY `id` ASC";
			$db->setQuery($query);
			$poza = $db->loadResult();
			if ($poza == '') {
				//fara poza
				echo '<img src="'.$image_path.'images/anunt_type_'.$l->tip_anunt.'.png" width="70" />';
			} else {
				//cu poza
				echo '<img src="'.$image_path.'users/'.$l->uid.'/'.$poza.'" width="70" />';
			}
			
		echo '</td>';
		echo '<td valign="top">';
			echo '<div class="sa_title">';
			$link_anunt = 'index.php?option=com_sauto&task=anunt&id='.$l->id;
				echo '<a href="'.$link_anunt.'" class="sa_link_title">'.$l->titlu_anunt.'</a>';
			echo '</div>';
		echo '</td>';
		echo '<td valign="top">';
			echo '<div class="sa_title">';
			$link_profil = 'index.php?option=com_sauto&task=profil&id='.$l->uid;
				echo '<a href="'.$link_profil.'" class="sa_link_title">'.$l->fullname.'</a>';
			echo '</div>';
		echo '</td>';
		echo '<td rowspan="2" width="200" valign="top">';
			$link_view = 'index.php?option=com_sauto&task=anunt';
			echo '<form action="'.$link_view.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="submit" value="Vizualizare" />';
			echo '</form>';
			$link_edit = 'index.php?option=com_sauto&task=edit_anunt';
			echo '<form action="'.$link_edit.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="submit" value="Editare" />';
			echo '</form>';
			if ($oferte == 0) {
			$link_delete = 'index.php?option=com_sauto&task=delete_anunt';
			echo '<form action="'.$link_delete.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="submit" value="Stergere" />';
			echo '</form>';
			}
		echo '</td>';
	echo '</tr>';	
	echo '<tr class="'.$style.'">';
		echo '<td valign="top">';
			echo substr(strip_tags($l->anunt), 0, 50).' ...';
		echo '</td>';
		echo '<td valign="top">';
			
			//echo '>>> '.$oferte;
			if ($oferte == 0) {
				echo 'Fara oferte';
			} else {
				echo $oferte.' oferte';
			}
		echo '</td>';
	echo '</tr>';
	echo '<tr class="'.$style.'">';
		echo '<td colspan="4">';
			if ($l->raportat == 1) {
				echo '<span class="sa_raportat">Anunt raportat!</span> ';
			}
			echo 'Publicat in data de: '.$l->data_adaugarii;
			if ($l->is_winner == 1) {
				//get winner
				$query = "SELECT `companie` FROM #__sa_profiles WHERE `uid` = '".$l->uid_winner."'";
				$db->setQuery($query);
				$winner = $db->loadResult();
				$link_profile = 'index.php?option=com_sauto&task=profil&id='.$l->uid_winner;
				echo '<span class="sa_winner">Anunt castigat de <a href="'.$link_profile.'">'.$winner.'</a></span>';
			}
		echo '</td>';
	echo '</tr>';
	}
?>
	</tbody>
</table>

<br /><br />
<?php echo $paginare;
echo '<br /><br />';	
}
