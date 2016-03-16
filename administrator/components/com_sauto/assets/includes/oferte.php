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
$uid =& JRequest::getVar( 'uid', '', 'get', 'string' );

$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `firma` = '".$uid."'";
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

$link = JRoute::_('index.php?option=com_sauto&task=oferte&uid='.$uid);

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

$query = "SELECT `r`.`id`, `r`.`anunt_id`, `r`.`proprietar`, `r`.`mesaj`, `r`.`data_adaugarii`, `r`.`pret_oferit`,`a`.`titlu_anunt`, `p`.`poza`, `m`.`m_scurt` FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi AS `a` JOIN #__sa_poze AS `p` JOIN #__sa_moneda AS `m` ON `r`.`firma` = '".$uid."' AND `r`.`anunt_id` = `a`.`id` AND `r`.`anunt_id` = `p`.`id_anunt` AND `r`.`moneda` = `m`.`id` ORDER BY `r`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JUri::root().'components/com_sauto/assets/';
//obtin numele firmei
$query = "SELECT `companie` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$firma = $db->loadResult();
?>
<h2>Oferte facute de catre <?php echo $firma; ?>		</h2>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	echo '<tr class="'.$style.'">';
		echo '<td valign="top" width="100">';
			if ($l->poza == '') {
				//fara poza
				echo '<img src="'.$image_path.'images/icon_profile.png" width="70" />';
			} else {
				//cu poza
				echo '<img src="'.$image_path.'users/'.$l->proprietar.'/'.$l->poza.'" width="70" />';
			}
		echo '</td>';
		echo '<td valign="top">';
			$link_anunt = 'index.php?option=com_sauto&task=anunt&id='.$l->anunt_id;
			echo '<div class="sa_title"><a href="'.$link_anunt.'">'.$l->titlu_anunt.'</a></div>';
			echo '<div>'.$l->mesaj.'</div>';
			echo '<div>Pret: '.$l->pret_oferit.' '.$l->m_scurt.'</div>';
			echo '<div>Data: '.$l->data_adaugarii.'</div>';
		echo '</td>';
		echo '<td valign="top">';
			echo '<div><form action="index.php?option=com_sauto&task=edit_oferta" method="post">';
				echo '<input type="hidden" name="raspuns_id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="anunt_id" value="'.$l->anunt_id.'" />';
				echo '<input type="submit" value="Editare oferta" />';
				echo '</form></div>';
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
