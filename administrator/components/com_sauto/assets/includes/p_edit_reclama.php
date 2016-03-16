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

$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_reclame WHERE `id` = '".$id."'";
$db->setQuery($query);
$list = $db->loadObject(); 


$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$lista = $db->loadObjectList(); 

$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=editing_reclama';
?>
<h2>Editare reclama</h2>
<form action="<?php echo $link_edit; ?>" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table>
	<tr>
		<td>Nume reclama</td>
		<td>
			<input type="text" name="reclama" value="<?php echo $list->reclama; ?>" />
		</td>
		<td>Pozitionare</td>
		<td>
			<select name="pozitionare">
				<option value="c" <?php if ($list->pozitionare == 'c') { echo ' selected '; } ?>>Centru</option>
				<option value="l" <?php if ($list->pozitionare == 'l') { echo ' selected '; } ?>>Lateral</option>
			</select>
		</td>
		<td>Categorie</td>
		<td>
			<select name="lista">
				<option value="" <?php if ($list->lista == '') { echo ' selected '; } ?>>Toate categoriile</option>
				<?php
				foreach ($lista as $l) {
					echo '<option value="'.$l->id.'" ';
						if ($l->id == $list->lista) { echo 'selected'; }
					echo '>'.$l->tip.'</option>';
				}
				?>
			</select>
		</td>
		<td>Maxim afisari</td>
		<td>
			<input type="text" name="maxim_afisari" value="<?php echo $list->maxim_afisari; ?>" size="6" />
		</td>
		<td>Afisari curente</td>
		<td>
			<input type="text" name="afisari_curente" value="<?php echo $list->afisari_curente; ?>" size="6" />
		</td>
		<td>Publicat?</td>
		<td><input type="checkbox" name="published" value="1" <?php if ($list->published == 1) { echo 'checked'; } ?> /></td>
		<td>Necontorizat</td>
		<td><input type="checkbox" name="necontorizat" value="1" <?php if ($list->necontorizat == 1) { echo 'checked'; } ?>/></td>
	</tr>
	<tr>
		<td valign="top">Cod reclama</td>
		<td colspan="13">
			<textarea cols="75" rows="5" name="cod_reclama"><?php echo $list->cod_reclama; ?></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="13"><input type="submit" value="Editare reclama" /></td>
	</tr>
</table>
</form>
