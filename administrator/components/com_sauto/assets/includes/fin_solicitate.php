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
$query = "SELECT count(*) FROM #__sa_facturi WHERE `original` = '1'";
$db->setQuery($query);
$solicitate = $db->loadResult();
echo '<h3>Facturi solicitate: '.$solicitate.'</h3>';
if ($solicitate != 0) {
	$total_rezult = $solicitate;
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

$link = JRoute::_('index.php?option=com_sauto&task=financiar&action=solicitate');

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

$query = "SELECT * FROM #__sa_facturi WHERE `original` = '1' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$i=1;
?>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
			<th class="sa_table_head" width="70">Nr. Crt.</th>
			<th class="sa_table_head">Factura</th>
			<th class="sa_table_head">Cumparator</th>
			<th class="sa_table_head">Data tranz.</th>
			<th class="sa_table_head">Valoare</th>
			<th class="sa_table_head">Tip plata</th>
			<th class="sa_table_head">Actiuni</th>
		</thead>
		<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	echo '<tr class="'.$style.'">';
		echo '<td class="sa_table_data">'.$i.'</td>';
		echo '<td class="sa_table_data">';
		$link_fact = JRoute::_('index.php?option=com_sauto&task=financiar&action=factura&id='.$l->id);
			echo '<a href="'.$link_fact.'">'.$l->factura.'</a>';
		echo '</td>';
		echo '<td class="sa_table_data">';
			$query = "SELECT `companie` FROM #__sa_profiles WHERE `uid` = '".$l->uid."'";
			$db->setQuery($query);
			$owner = $db->loadResult();
			$link_firm = JRoute::_('index.php?option=com_sauto&task=profil&id='.$l->uid);
			echo '<a href="'.$link_firm.'">'.$owner.'</a>';
		echo '</td>';
		echo '<td class="sa_table_data">'.$l->data_tr.'</td>';
		echo '<td class="sa_table_data">';
			if ($l->tip_plata == 'abonament') {
				echo $l->curs_euro*$l->pret;
			} else {
				echo $l->credite;
			}
		echo ' lei</td>';
		echo '<td class="sa_table_data">';
			echo $l->tip_plata;
		echo '</td>';
		echo '<td class="sa_table_data">';
		$link_sent = JRoute::_('index.php?option=com_sauto&task=financiar&action=sent&id='.$l->id);
		$link_del = JRoute::_('index.php?option=com_sauto&task=financiar&action=del&id='.$l->id);
			echo '<a href="'.$link_sent.'">Trimite!</a>';
			echo  ' | ';
			echo '<a href="'.$link_del.'">Sterge!</a>';
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

