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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//obtin date utilizator
$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `j`.`id`,  `l`.`localitate`, `l`.`id` AS `lid`, `p`.`adresa`, 
		`p`.`cod_postal`, `p`.`poza`, `p`.`calificative`, `u`.`email`, `u`.`registerDate`, `u`.`lastvisitDate`, `p`.`deleted` 
		FROM #__sa_profiles AS `p` 
		JOIN #__users AS `u` 
		JOIN #__sa_judete AS `j` 
		JOIN #__sa_localitati AS `l` 
		ON `p`.`uid` = '".$id."' 
		AND `p`.`uid` = `u`.`id` 
		AND `p`.`judet` = `j`.`id` 
		AND `p`.`localitate` = `l`.`id`";
$db->setQuery($query);
$profil = $db->loadObject();
//print_r($profil);
$image_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS.$id.DS;
$image_path2 = JURI::root()."components".DS."com_sauto".DS."assets".DS;

$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$id."' AND `uid_winner` = '0'";
$db->setQuery($query);
$total_act = $db->loadResult();

$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$id."' AND `uid_winner` != '0'";
$db->setQuery($query);
$total_final = $db->loadResult();
		
?>
<h2>Profilul lui <?php echo $profil->fullname; ?></h2>
<table width="100%">
	<tr>
		<td width="25%" valign="top">Localitate: <?php echo $profil->localitate; ?></td>
		<td width="25%" valign="top">Membru din: <?php echo $profil->registerDate; ?></td>
		<td width="25%" valign="top">Calificative: <?php echo $profil->calificative; ?>%</td>
		<td valign="top" rowspan="3">
		<?php
		if ($profil->poza != '') {
			//avatar
			echo '<img src="'.$image_path.$profil->poza.'" width="70" />'; 
		} else {
			//fara avatar
		}
		?>
		</td>
	</tr>
	<tr>
		<td>Judet: <?php echo $profil->judet; ?></td>
		<td>Ultima vizita: <?php echo $profil->lastvisitDate; ?></td>
		<td>Licitatii active: <?php echo $total_act; ?></td>
	</tr>
	<tr>
		<td>Telefon: <?php echo $profil->telefon; ?></td>
		<td>Cod Postal: <?php echo $profil->cod_postal; ?></td>
		<td>Licitatii castigate: <?php echo $total_final; ?></td>
	</tr>
	<tr>
		<td valign="top">Email: <?php echo $profil->email; ?></td>
		<td valign="top" colspan="3">Adresa:<br /><?php echo $profil->adresa; ?></td>
	</tr>
	<tr>
		<td>
		<?php 
		$link_edit = 'index.php?option=com_sauto&task=edit_user';
		if ($profil->deleted == 0) {
			$link_delete = 'index.php?option=com_sauto&task=delete_profile';
		} else {
			$link_restore = 'index.php?option=com_sauto&task=restore_profile';
		}
		?>
		<form action="<?php echo $link_edit; ?>" method="post">
			<input type="hidden" name="uid" value="<?php echo $id; ?>" />
			<input type="submit" value="Editare utilizator" />
		</form>
		</td>
		<td>
		<?php 
		if ($profil->deleted == 0) {
			//stergere profil
			?>
			<form action="<?php echo $link_delete; ?>" method="post">
				<input type="hidden" name="uid" value="<?php echo $id; ?>" />
				<input type="submit" value="Stergere utilizator" />
			</form>
			<?php
		} else {
			//restaurare profil
			?>
			<form action="<?php echo $link_restore; ?>" method="post">
				<input type="hidden" name="uid" value="<?php echo $id; ?>" />
				<input type="submit" value="Restaurare utilizator" />
			</form>
			<?php
		} ?>
		</td>
		<td colspan="2">
		</td>
	<tr>
		<td>
			<?php
			$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$id."' AND `raspuns` = '1'";
			$db->setQuery($query);
			$comms = $db->loadResult();
			if ($comms != 0) {
				echo '<div>Comentarii: '.$comms.'</div>';
				echo '<form action="index.php?option=com_sauto&task=comment_list" method="post">';
				echo '<input type="hidden" name="uid" value="'.$uid.'" />';
				echo '<input type="hidden" name="tip_cont" value="0" />';
				echo '<input type="submit" value="Lista comentarii" />';
				echo '</form>';
			}
			?>
		
		</td>
		<td colspan="3"></td>
	</tr>
</table>
