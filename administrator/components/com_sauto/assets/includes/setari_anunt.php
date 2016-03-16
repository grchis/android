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
?>
<h3>Editare tip anunt</h3>
<table width="100%" class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head">Nr. Crt.</th>
			<th class="sa_table_head">Tip anunt</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT * FROM #__sa_tip_anunt";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$i = 1;
	$link_form = 'index.php?option=com_sauto&task=prelucrari&action=anunt';
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		echo '<tr class="'.$style.'">';
			echo '<td class="sa_table_data">'.$i.'</td>';
			echo '<td class="sa_table_data">';
			echo '<form action="'.$link_form.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="text" name="tip" value="'.$l->tip.'" />';
			echo '  <input type="checkbox" name="published" value="1" ';
				if ($l->published == 1) { echo 'checked'; }
			echo '/> Publicat ';
			echo '<input type="submit" value="Editare" />';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
		$i++;
	}
	?>
	</tbody>
</table>
