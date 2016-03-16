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
?>
<h3>Editare plati</h3>
<table width="100%" class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head" width="30"></th>
			<th class="sa_table_head">Nr. Crt.</th>
			<th class="sa_table_head">Tip plata</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT * FROM #__sa_plati";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$i = 1;
	$link_form = 'index.php?option=com_sauto&task=prelucrari&action=plati';
	$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_plati';
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
			echo '<td class="sa_table_data">'.$i.'</td>';
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_form.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="text" name="procesator" value="'.$l->procesator.'" />';
			echo '<input type="submit" value="Editare" />';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
		$i++;
	}
	?>
	</tbody>
</table>
