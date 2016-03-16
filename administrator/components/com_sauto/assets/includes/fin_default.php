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
$query = "SELECT count(*) FROM #__sa_tranzactii WHERE `aprobata` = '0'";
$db->setQuery($query);
$neaprobate = $db->loadResult();
JHTML::_('behavior.modal'); 
echo '<h3>Plati neaprobate: '.$neaprobate.'</h3>';
if ($neaprobate != 0) {
	$total_rezult = $neaprobate;
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

$link = JRoute::_('index.php?option=com_sauto&task=financiar');

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

$query = "SELECT * FROM #__sa_tranzactii WHERE `aprobata` = '0' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$i=1;
?>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
			<th class="sa_table_head" width="70">Nr. Crt.</th>
			<th class="sa_table_head">Tip tranz.</th>
			<th class="sa_table_head">Data tranz.</th>
			<th class="sa_table_head">Valoare</th>
			<th class="sa_table_head">Nou</th>
			<th class="sa_table_head">Fisier</th>
			<th class="sa_table_head">Actiuni</th>
		</thead>
		<tbody>
<?php
$path = JUri::root().'administrator/components/com_sauto/assets/files/';
$path2 = JUri::root().'administrator/components/com_sauto/assets/images/';
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	echo '<tr class="'.$style.'">';
		echo '<td class="sa_table_data">'.$i.'</td>';
		echo '<td class="sa_table_data">'.$l->tip_tranzactie.'</td>';
		echo '<td class="sa_table_data">'.date("Y-m-d H:i:s", $l->data_tranzactie).'</td>';
		echo '<td class="sa_table_data">';
			if ($l->tip_tranzactie == 'abonament-op') {
				echo $l->curs_euro*$l->pret;
			} else {
				echo $l->pret;
			}
		echo ' lei</td>';
		echo '<td class="sa_table_data">';
		if ($l->new_upload == 1) {
					echo '<img src="'.$path2.'star_blue.png" />';
				}
		echo '</td>';
		echo '<td class="sa_table_data">';
			if ($l->fisier == '') {
				echo 'Fara fisier';
			} else {
				
				//afisare fisier
				
				//echo $path;
				echo '<a href="'.$path.$l->fisier.'" class="modal"><img src="'.$path.$l->fisier.'" width="50" /></a>';
			}
		echo '</td>';
		echo '<td class="sa_table_data">';
			if ($l->fisier != '') {
			echo '<a href="'.$path.$l->fisier.'" download >Descarca fisier</a>';
			echo '<br /><br />';
			}
		$link = JRoute::_('index.php?option=com_sauto&task=financiar&action=aproba&id='.$l->tranz_id);
			echo '<a href="'.$link.'">Aproba plata</a>';
			echo '<br /><br />';
		$link_d = JRoute::_('index.php?option=com_sauto&task=financiar&action=delete&id='.$l->tranz_id);
			echo '<a href="'.$link_d.'">Stergere</a>';
		echo '</td>';
	echo '</tr>';
$i++;
}
?>
</tbody>
</table>
<br /><br />
<?php echo $paginare;
echo '<br /><br />';
}
?>

