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

?>
<h3>Editare moneda</h3>

<div class="sa_new_city_div" onClick="toggle_visibility('add_moneda');">
Adauga moneda noua
</div>

<div style="display:none;" id="add_moneda">
	<?php $link_add = 'index.php?option=com_sauto&task=prelucrari&action=add_moneda'; ?>
<form action="<?php echo $link_add; ?>" method="post">
<table>
	<tr>
		<td>Moneda</td>
		<td>
			<input type="text" name="m_lung" value="" />
		</td>
		<td>Prescurtare</td>
		<td>
			<input type="text" name="m_scurt" value="" />
		</td>
		<td><input type="submit" value="Adauga moneda" /></td>
	</tr>
</table>
</form>
</div>

<table width="100%" class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head" width="30"></th>
			<th class="sa_table_head">Moneda</th>
			<th class="sa_table_head">Prescurtare</th>
			<th class="sa_table_head">Stergere</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT * FROM #__sa_moneda";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_moneda';
	$link_edit_s = 'index.php?option=com_sauto&task=prelucrari&action=edit_moneda_s';
	$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_moneda';
	$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_moneda';
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		echo '<tr class="'.$style.'">';
			echo '<td class="sa_table_data">';
			if ($l->published == 1) {
				//publicat
				echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
				echo '<input type="hidden" name="tip" value="unpublish" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '</form>';
				echo '<img src="'.$image_path.'icon_publish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
			} else {
				//nepublicat
				echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
				echo '<input type="hidden" name="tip" value="publish" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '</form>';
				echo '<img src="'.$image_path.'icon_unpublish.png" width="10" class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();" />';
			}
		echo '</td>';
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_edit.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="text" name="m_lung" value="'.$l->m_lung.'" size="8" />';
			echo '<input type="submit" value="Editare" />';
			echo '</form>';
			echo '</td>';
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_edit_s.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="text" name="m_scurt" value="'.$l->m_scurt.'" size="6" />';
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
