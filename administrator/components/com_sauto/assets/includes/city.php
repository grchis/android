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


function city() {
	$image_path = 'components/com_sauto/assets/images/';
	echo '<h3>Lista localitati neaprobate</h3>';
	$db = JFactory::getDbo();
	$query = "SELECT count(*) FROM #__sa_localitati WHERE `published` = '0'";
	$db->setQuery($query);
	$total = $db->loadResult();
	if ($total == 0) {
		echo '<div>NU sunt localitati nepublicate!</div>';
	} else {
	$query = "SELECT `l`.`localitate`, `j`.`judet`, `l`.`id` FROM #__sa_localitati as `l` JOIN #__sa_judete as `j` ON `l`.`jid` = `j`.`id` AND `published` = '0'";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$i=1;
	?>
	<table width="100%">
		<thead>
			<th class="sa_table_head" width="70">Nr. crt.</th>
			<th class="sa_table_head">Localitate</th>
			<th class="sa_table_head">Aprobare</th>
			<th class="sa_table_head">Stergere</th>
			<th class="sa_table_head">Judet</th>
		</thead>
		<?php
		foreach ($list as $l) {
			if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_city';
			$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_city';
			$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_city';
			$return_link = 'index.php?option=com_sauto&task=city';
		echo '<tr class="'.$style.'">';
			echo '<td class="sa_table_data">'.$i.'</td>';
			echo '<td class="sa_table_data">';
				echo '<form action="'.$link_edit.'" method="post">';
				echo '<input name="city" type="text" value="'.$l->localitate.'" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				echo '<input type="checkbox" name="aprove" value="1" /> Aprobare';
				echo '<input type="submit" value="Editare" />';
				echo '</form></td>';
			echo '<td class="sa_table_data">';
				echo '<form method="post" action="'.$link_frm.'" name="submit_form_'.$l->id.'" id="submit_form_'.$l->id.'">';
				echo '<input type="hidden" name="tip" value="publish" />';
				echo '<input type="hidden" name="id" value="'.$l->id.'" />';
				echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
				echo '</form>';
				echo '<div class="sa_cursor" onClick="document.forms[\'submit_form_'.$l->id.'\'].submit();">';
				echo '<img src="'.$image_path.'icon_unpublish.png" width="10" />';
				echo 'Aprobare';
				echo '</div>';
			echo '</td>';
			echo '<td class="sa_table_data">';
				echo '<form action="'.$link_delete.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$l->id.'" />';
			echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
			echo '<input type="submit" value="Sterge" />';
			echo '</form>';
			echo '</td>';
			echo '<td class="sa_table_data">'.$l->judet.'</td>';
		echo '</tr>';
		$i++;	
		}
		?>
	</table>
	<?php
	}
}
