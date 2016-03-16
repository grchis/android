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
$image_path = 'components/com_sauto/assets/images/';

$db = JFactory::getDbo();
$query = "SELECT count(*) FROM #__sa_model_auto WHERE `published` = '0'";
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

$link = JRoute::_('index.php?option=com_sauto&task=modele');

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

$query = "SELECT `m`.`id`, `m`.`model_auto`, `m`.`published`, `mr`.`marca_auto` FROM #__sa_model_auto AS `m` JOIN #__sa_marca_auto AS `mr` ON `m`.`mid` = `mr`.`id` AND `m`.`published` = '0' ORDER BY `m`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

?>
<h3>Modele auto nepublicate</h3>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head" width="30"></th>
			<th class="sa_table_head">Model auto</th>
			<th class="sa_table_head">Marca auto</th>
			<th class="sa_table_head">Sterge Model</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			$link_form = 'index.php?option=com_sauto&task=prelucrari&action=edit_model';
			$link_form_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_model';
			$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_model';
			$return_link = 'index.php?option=com_sauto&task=modele';
			echo '<tr class="'.$style.'">';
			echo '<td class="sa_table_data">';
			if ($l->published == 1) {
		//publicat
		echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
		echo '<input type="hidden" name="tip" value="unpublish" />';
		echo '<input type="hidden" name="id" value="'.$l->id.'" />';
		echo '<input type="hidden" name="mid" value="'.$id.'" />';
		echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
		echo '</form>';
		echo '<img src="'.$image_path.'icon_publish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
	} else {
		//nepublicat
		echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
		echo '<input type="hidden" name="tip" value="publish" />';
		echo '<input type="hidden" name="id" value="'.$l->id.'" />';
		echo '<input type="hidden" name="mid" value="'.$id.'" />';
		echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
		echo '</form>';
		echo '<img src="'.$image_path.'icon_unpublish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
	}
			echo '</td>';
			
				echo '<td class="sa_table_data">';
				echo '<form action="'.$link_form.'" method="post">';
				echo '<input type="text" name="model" value="'.$l->model_auto.'" size="10" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				if ($l->published == 0) {
					echo '<input type="checkbox" name="aprove" value="1" />';
					echo ' Aprob ';
				}
				echo '<input type="submit" value="Edit" />';
				echo '</form>';
				echo '</td>';
				echo '<td class="sa_table_data">';
				echo $l->marca_auto;
			echo '</td>';
				echo '<td class="sa_table_data">';
				echo '<form action="'.$link_form_delete.'" method="post">';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				echo '<input type="submit" value="Sterg model" />';
				echo '</form>';
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
?>

