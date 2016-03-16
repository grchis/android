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
$query = "SELECT count(*) FROM #__sa_promotii";
$db->setQuery($query);
$total = $db->loadResult();

$link = 'index.php?option=com_sauto&task=promo';

if ($total == 0) {
	echo '<div>Nu aveti nici o promotie introdusa!</div>';
	echo '<div><a href="'.$link.'">Creeaza promotie</a></div>';
} elseif ($total != 0) {
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

$link = JRoute::_('index.php?option=com_sauto&task=promo');

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


$query = "SELECT * FROM #__sa_promotii ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
//$image_path = JUri::root().'components/com_sauto/assets/';
?>
<h2>Toate promotiile</h2>
<div><a href="<?php echo $link; ?>">Creeaza promotie</a></div>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
		<th class="sa_table_head" width="70">Nr. Crt.</th>
		<th class="sa_table_head">Data start</th>
		<th class="sa_table_head">Data stop</th>
	</thead>
	<tbody>
<?php
$i = 1;
foreach ($list as $l) {
	
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	
	echo '<tr class="'.$style.'">';
		echo '<td>';
			echo $i;
		echo '</td>';
		echo '<td valign="top">';
			echo $l->start;
		echo '</td>';
		echo '<td valign="top">';
			echo $l->stop;
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
