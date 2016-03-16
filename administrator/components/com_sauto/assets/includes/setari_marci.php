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
$image_path = 'components/com_sauto/assets/images/';
$document = JFactory::getDocument();

$js_code = 'function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == \'block\')
          e.style.display = \'none\';
       else
          e.style.display = \'block\';
    }';
$document->addScriptDeclaration ($js_code);

$query = "SELECT count(*) FROM #__sa_marca_auto";
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

$link = JRoute::_('index.php?option=com_sauto&task=setari&action=marci');

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

$query = "SELECT * FROM #__sa_marca_auto ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
?>
<div class="sa_new_city_div" onClick="toggle_visibility('add_marca');">
Adauga marca noua
</div>

<div style="display:none;" id="add_marca">
	<?php $link_add = 'index.php?option=com_sauto&task=prelucrari&action=add_marca'; ?>
<form action="<?php echo $link_add; ?>" method="post">
<table>
	<tr>
		<td>Marca auto</td>
		<td>
			<input type="text" name="marca" value="" />
			<input type="hidden" name="redirect" value="<?php echo $link; ?>" />
		</td>
		<td><input type="submit" value="Adauga marca" /></td>
	</tr>
</table>
</form>
</div>

<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head" width="30"></th>
			<th class="sa_table_head">Marca auto</th>
			<th class="sa_table_head">Sterge Marca</th>
			<th class="sa_table_head">Nr. modele</th>
			<th class="sa_table_head">Adauga model</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT * FROM #__sa_marca_auto ORDER BY `marca_auto` ASC";
	$db->setQuery($query);
	$marca_list = $db->loadObjectList();
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			$link_form = 'index.php?option=com_sauto&task=prelucrari&action=edit_marca';
			$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_marca';
			$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_marca';
			$return_link = 'index.php?option=com_sauto&task=setari&action=marci';
			echo '<tr class="'.$style.'">';
			echo '<td class="sa_table_data">';
			if ($l->published == 1) {
		//publicat
		echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
		echo '<input type="hidden" name="tip" value="unpublish" />';
		echo '<input type="hidden" name="id" value="'.$l->id.'" />';
		echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
		echo '</form>';
		echo '<img src="'.$image_path.'icon_publish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
	} else {
		//nepublicat
		echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
		echo '<input type="hidden" name="tip" value="publish" />';
		echo '<input type="hidden" name="id" value="'.$l->id.'" />';
		echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
		echo '</form>';
		echo '<img src="'.$image_path.'icon_unpublish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
	}
			echo '</td>';
				echo '<td class="sa_table_data">';
				echo '<form action="'.$link_form.'" method="post">';
				echo '<input type="text" name="marca" value="'.$l->marca_auto.'" size="10" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				if ($l->published == 0) {
					echo '<input type="checkbox" name="aprove" value="1" /> Aprob ';
				}
				echo '<input type="submit" value="Edit" />';
				echo '</form>';
				echo '</td>';
				echo '<td class="sa_table_data">';
				echo '<form action="'.$link_delete.'" method="post">';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				echo '<input type="submit" value="Sterge marca" />';
				echo '</form>';
				echo '</td>';
				echo '<td class="sa_table_data">';
				//obtin numar modele
				$query = "SELECT count(*) FROM #__sa_model_auto WHERE `mid` = '".$l->id."'";
				$db->setQuery($query);
				$modele = $db->loadResult();
				$lista_modele = 'index.php?option=com_sauto&task=setari&action=lista_modele&id='.$l->id;
				if ($modele != 0) {
					echo '<a href="'.$lista_modele.'">'.$modele.' modele</a>'; 
				} else {
					echo $modele.' modele';
				}
				echo '</td>';
				echo '<td class="sa_table_data">';
				echo '<div class="sa_new_model_div" onClick="toggle_visibility(\'add_model_'.$l->id.'\');">';
				echo 'Adaug model';
				echo '</div>';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr class="'.$style.'">';
				echo '<td colspan="5" class="sa_table_data">';
				echo '<div style="display:none;" id="add_model_'.$l->id.'">';
				$link_add = 'index.php?option=com_sauto&task=prelucrari&action=add_model';
				echo '<form action="'.$link_add.'" method="post">';
				echo 'Model: <input type="text" name="model" value="" size="10" />';
				echo '  ';
				echo 'Marca: <select name="marca">';
				foreach ($marca_list as $ml) {
					echo '<option value="'.$ml->id.'"';
						if ($ml->id == $l->id) { echo ' selected '; }
					echo '>'.$ml->marca_auto.'</option>';
				}
				echo '</select>';
				echo '  ';
				echo '<input type="submit" value="Adauga model" />';
				echo '</form>';
				echo '</div>';
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
