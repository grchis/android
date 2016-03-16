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

function marci() {
	$image_path = 'components/com_sauto/assets/images/';
	echo '<h3>Lista marci neaprobate</h3>';
	$db = JFactory::getDbo();
	$query = "SELECT count(*) FROM #__sa_marca_auto WHERE `published` = '0'";
	$db->setQuery($query);
	$total = $db->loadResult();
	if ($total == 0) {
	//nu avem
	echo '<div>NU sunt marci auto nepublicate!</div>';
	} else {
		$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '0'";
		$db->setQuery($query);
		$list = $db->loadObjectList();
		$i = 1;
	//avem
	?>
	<table width="100%">
		<thead>
			<th class="sa_table_head" width="70">Nr. Crt.</th>
			<th class="sa_table_head">Marca auto</th>
			<th class="sa_table_head">Aprobare</th>
			<th class="sa_table_head">Stergere</th>
			<th class="sa_table_head">Anunturi</th>
		</thead>
		<?php
		foreach ($list as $l) {
			if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_marca';
			$link_delete = 'index.php?option=com_sauto&task=prelucrari&action=delete_marca';
			$link_aprob = 'index.php?option=com_sauto&task=prelucrari&action=aprob_marca&id='.$l->id;
			$link_list = 'index.php?option=com_sauto&task=prelucrari&action=lista_anunt_marca&id='.$l->id;
			$link_frm = 'index.php?option=com_sauto&task=prelucrari&action=publish_marca';
			$return_link = 'index.php?option=com_sauto&task=marci';
			echo '<tr class="'.$style.'">';
				echo '<td class="sa_table_data">'.$i.'</td>';
				echo '<td class="sa_table_data">';
					echo '<form action="'.$link_edit.'" method="post">';
					echo '<input type="hidden" name="id" value="'.$l->id.'" />';
					echo '<input type="text" name="marca" value="'.$l->marca_auto.'" />';
					echo '<input type="checkbox" name="aprove" value="1" />Aprobare';
					echo '<input type="hidden" name="return_link" value="'.$return_link.'" />';
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
					echo '<input type="submit" value="Sterge marca" />';
					echo '</form>';
				echo '</td>';
				echo '<td class="sa_table_data"><a href="'.$link_list.'">Anunturi</a></td>';
			echo '</tr>';
			$i++;
		}
		?>
	</table>
	<?php
	}
}
