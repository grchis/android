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
$document = JFactory::getDocument();

$js_code = 'function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == \'block\')
          e.style.display = \'none\';
       else
          e.style.display = \'block\';
    }';
$document->addScriptDeclaration ($js_code);
$db = JFactory::getDbo();

$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$lista = $db->loadObjectList(); 
?>
<div class="sa_new_city_div" onClick="toggle_visibility('add_reclama');">
	Adauga reclama noua
</div>

<div style="display:none;" id="add_reclama">
	<?php $link_add = 'index.php?option=com_sauto&task=prelucrari&action=add_reclama'; ?>
<form action="<?php echo $link_add; ?>" method="post">
<table>
	<tr>
		<td>Nume reclama</td>
		<td>
			<input type="text" name="reclama" value="" />
		</td>
		<td>Pozitionare</td>
		<td>
			<select name="pozitionare">
				<option value="c">Centru</option>
				<option value="l">Lateral</option>
			</select>
		</td>
		<td>Categorie</td>
		<td>
			<select name="lista">
				<option value="">Toate categoriile</option>
				<?php
				foreach ($lista as $l) {
					echo '<option value="'.$l->id.'">'.$l->tip.'</option>';
				}
				?>
			</select>
		</td>
		<td>Maxim afisari</td>
		<td>
			<input type="text" name="maxim_afisari" value="" size="6" />
		</td>
		<td>Publicat?</td>
		<td><input type="checkbox" name="published" value="1" checked /></td>
		<td>Necontorizat</td>
		<td><input type="checkbox" name="necontorizat" value="1" /></td>
	</tr>
	<tr>
		<td valign="top">Cod reclama</td>
		<td colspan="13">
			<textarea cols="75" rows="5" name="cod_reclama"></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="13"><input type="submit" value="Adauga reclama" /></td>
	</tr>
</table>
</form>
</div>

<?php
$query = "SELECT count(*) FROM #__sa_reclame";
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

$link = JRoute::_('index.php?option=com_sauto&task=setari&action=reclame');

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

$query = "SELECT * FROM #__sa_reclame ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = 'components/com_sauto/assets/images/';
$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_reclama';

?>
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head" width="30"></th>
			<th class="sa_table_head">Reclama</th>
			<th class="sa_table_head">Pozitionare</th>
			<th class="sa_table_head">Categorie</th>
			<th class="sa_table_head">Maxim afis.</th>
			<th class="sa_table_head">Total afis.</th>
			<th class="sa_table_head">Actiuni</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($list as $l) { 
				$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_reclama&id='.$l->id;
				$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_reclama&id='.$l->id;
			if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			echo '<tr class="'.$style.'">';
				echo '<td class="sa_table_data">';
					if ($l->published == 1) {
						//publicata
						echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
						echo '<input type="hidden" name="tip" value="unpublish" />';
						echo '<input type="hidden" name="id" value="'.$l->id.'" />';
						echo '</form>';
						echo '<img src="'.$image_path.'icon_publish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
					} else {
						//nepublicata
						echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
						echo '<input type="hidden" name="tip" value="publish" />';
						echo '<input type="hidden" name="id" value="'.$l->id.'" />';
						echo '</form>';
						echo '<img src="'.$image_path.'icon_unpublish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
					}
				echo '</td>';
				echo '<td class="sa_table_data">';
					echo $l->reclama;
				echo '</td>';
				echo '<td class="sa_table_data">';
					if ($l->pozitionare == 'c') {
						echo 'Centru';
					} elseif ($l->pozitionare == 'l') {
						echo 'Lateral';
					}
				echo '</td>';
				echo '<td class="sa_table_data">';
					if ($l->lista == 0) {
						//toate categoriile
						echo 'Toate categoriile';
					} else {
						//obtin numele categoriei
						$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$l->lista."'";
						$db->setQuery($query);
						$categ = $db->loadResult();
						echo $categ;
					}
				echo '</td>';
				echo '<td class="sa_table_data">';
					if ($l->necontorizat == 1) {
						echo '<span style="color:red;">fara limita</span>';
					} else {
						echo $l->maxim_afisari;
					}
				echo '</td>';
				echo '<td class="sa_table_data">';
					echo $l->afisari_curente;
				echo '</td>';
				echo '<td class="sa_table_data">';
					echo '<a href="'.$link_edit.'">Editare</a> ';
					echo ' | ';
					echo '<a href="'.$link_delete.'">Stergere</a>';
				echo '</td>';
			echo '</tr>';
			echo '<tr class="'.$style.'">';
					echo '<td class="sa_table_data" colspan="7">';
						echo 'Cod reclama: <br />';
						echo $l->cod_reclama;
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
