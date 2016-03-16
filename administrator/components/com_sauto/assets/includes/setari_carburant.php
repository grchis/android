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
$document = JFactory::getDocument();

$js_code = 'function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == \'block\')
          e.style.display = \'none\';
       else
          e.style.display = \'block\';
    }';
$document->addScriptDeclaration ($js_code);

?>
<h3>Editare carburant</h3>

<div class="sa_new_city_div" onClick="toggle_visibility('add_carburant');">
Adauga carburant
</div>

<div style="display:none;" id="add_carburant">
	<?php $link_add = 'index.php?option=com_sauto&task=prelucrari&action=add_carburant'; ?>
<form action="<?php echo $link_add; ?>" method="post">
<table>
	<tr>
		<td>Carburant</td>
		<td>
			<input type="text" name="carburant" value="" />
		</td>
		<td><input type="submit" value="Adauga carburant" /></td>
	</tr>
</table>
</form>
</div>

<table width="100%" class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head">Carburant</th>
			<th class="sa_table_head">Stergere</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT * FROM #__sa_carburant";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_carburant';
	$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_carburant';
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		echo '<tr class="'.$style.'">';
			
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_edit.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="text" name="carburant" value="'.$l->carburant.'" />';
			echo '<input type="submit" value="Editare" />';
			echo '</form>';
			echo '</td>';
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_delete.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="submit" value="Sterge" />';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	}
	?>
	</tbody>
</table>
