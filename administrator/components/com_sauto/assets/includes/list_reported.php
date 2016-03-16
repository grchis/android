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
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'get', 'string' );
$db = JFactory::getDbo();
//$query = "SELECT `r`.`uid`, `r`.`data_rep`, `r`.`stare`, `p`.`fullname`, `p`.`companie`, `p`.`tip_cont` FROM #__sa_reported AS `r` JOIN #__sa_profiles AS `p` ON `anunt_id` = '".$anunt_id."' AND `r`.`uid` = `p`.`uid`";
$query = "SELECT * FROM #__sa_reported WHERE `anunt_id` = '".$anunt_id."'";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = 'components/com_sauto/assets/images/';
$link_anunt = 'index.php?option=com_sauto&task=anunt&id='.$anunt_id;
?>
<h3>Lista cu cei care au raportat acest anunt</h3>
<div>
	<a href="<?php echo $link_anunt; ?>">
		Inapoi la articol
	</a>
</div>
<table width="100%">
	<thead>
		<th class="sa_table_head" width="70">Nr. crt.</th>
		<th class="sa_table_head">Raportat de</th>
		<th class="sa_table_head">Data</th>
		<th class="sa_table_head">IP</th>
		<th class="sa_table_head">Status</th>
	</thead>
	<?php
	$i=1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		echo '<tr class="'.$style.'">';
			echo '<td>'.$i.'</td>';
			echo '<td>';
			if ($l->uid == 0) {
				echo 'Vizitator';
			} else {
				$link_profile_rep = 'index.php?option=com_sauto&task=profil&id='.$l->uid;
				echo '<a href="'.$link_profile_rep.'">';
				$query = "SELECT `tip_cont`, `fullname`, `companie` FROM #__sa_profiles WHERE `uid` = '".$l->uid."'";
				$db->setQuery($query);
				$usr = $db->loadObject();
				if ($usr->tip_cont == 0) {
				//client
				echo $usr->fullname;
				} else {
				//dealer
				echo $usr->companie;
				}
			}
			echo '</a>';
			echo '</td>';
			echo '<td>'.$l->data_rep.'</td>';
			echo '<td>'.$l->ip.'</td>';
			echo '<td>';
				if ($l->stare == 1) {
					//setat, ok
					echo '<img src="'.$image_path.'icon_publish.png" width="10" /> Resetat';
				} else {
					//nesetat, nu e ok
					echo '<img src="'.$image_path.'icon_unpublish.png" width="10" /> Setat';
				}
			echo '</td>';
		echo '</tr>';
		$i++;
	}
	?>
</table>
