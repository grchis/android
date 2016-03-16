<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$raspuns_id =& JRequest::getVar( 'raspuns_id', '', 'post', 'string' );
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$db = JFactory::getDbo();
$query = "SELECT `r`.`mesaj`, `r`.`pret_oferit`, `m`.`m_scurt`, `r`.`moneda` FROM #__sa_raspunsuri AS `r` JOIN #__sa_moneda AS `m` ON `r`.`id` = '".$raspuns_id."' AND `r`.`moneda` = `m`.`id`";
$db->setQuery($query);
$rasp = $db->loadObject();
$link_edit = 'index.php?option=com_sauto&task=prelucrari&action=edit_oferta';
?>
<h3>Editare oferta facuta</h3>
<form action="<?php echo $link_edit; ?>" method="post">
	<table class="sa_table_class" width="100%">
		<tr>
			<td valign="top" width="100">Oferta</td>
			<td>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('oferta', $rasp->mesaj, '300', '150', '60', '20', false);
			?>
			</td>
		</tr>
		<tr>
			<td>Pret oferit</td>
			<td>
				<input type="text"size="6" name="pret" value="<?php echo $rasp->pret_oferit; ?>" />
				<select name="moneda">
					<?php
					$query = "SELECT * FROM #__sa_moneda WHERE `published` = '1'";
					$db->setQuery($query);
					$mon = $db->loadObjectList();
						foreach ($mon as $m) {
							echo '<option value="'.$m->id.'"';
								if ($rasp->moneda == $m->id) { echo ' selected '; }
							echo '>'.$m->m_scurt.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="anunt_id" value="<?php echo $anunt_id; ?>" />
				<input type="hidden" name="raspuns_id" value="<?php echo $raspuns_id; ?>" />
				<input type="submit" value="Editare oferta" /></td>
		</tr>
	</table>
</form>
