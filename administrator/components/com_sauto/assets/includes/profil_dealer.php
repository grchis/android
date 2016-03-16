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
$query = "SELECT `p`.`companie`, `p`.`reprezentant`, `p`.`cod_fiscal`, `p`.`nr_registru`, `p`.`categorii_activitate`, `p`.`telefon`, `j`.`judet`, 
		`j`.`id`,  `l`.`localitate`, `l`.`id` AS `lid`, `p`.`sediu`, `p`.`cod_postal`, `p`.`poza`, `p`.`calificative`, `u`.`email`, 
		`u`.`registerDate`, `u`.`lastvisitDate`, `ab`.`abonament`, `p`.`deleted` 
		FROM #__sa_profiles AS `p` 
		JOIN #__users AS `u` 
		JOIN #__sa_judete AS `j` 
		JOIN #__sa_localitati AS `l` 
		JOIN #__sa_abonament AS `ab` 
		ON `p`.`uid` = '".$id."' 
		AND `p`.`uid` = `u`.`id` 
		AND `p`.`judet` = `j`.`id` 
		AND `p`.`localitate` = `l`.`id` 
		AND `p`.`abonament` = `ab`.`id`";
$db->setQuery($query);
$profil = $db->loadObject();
//print_r($profil);
$image_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS.$id.DS;
$image_path2 = JURI::root()."components".DS."com_sauto".DS."assets".DS;

$query = "SELECT count(*) FROM #__sa_anunturi WHERE `uid_winner` = '".$uid."'";
$db->setQuery($query);
$total_castig = $db->loadResult();

$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `firma` = '".$id."' ";
$db->setQuery($query);
$total_oferte = $db->loadResult();
		
?>
<h2>Profilul lui <?php echo $profil->companie; ?></h2>
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
		<td>Licitatii castigate: <?php echo $total_castig; ?></td>
	</tr>
	<tr>
		<td>Telefon: <?php echo $profil->telefon; ?></td>
		<td>Cod Postal: <?php echo $profil->cod_postal; ?></td>
		<td>Oferte facute: <?php echo $total_oferte; ?></td>
	</tr>
	<tr>
		<td>Reprezentant: <?php echo $profil->reprezentant; ?></td>
		<td>Cod fiscal: <?php echo $profil->cod_fiscal; ?></td>
		<td>Nr. Reg. com.: <?php echo $profil->nr_registru; ?></td>
		<td></td>
	</tr>
	<tr>
		<td>Abonament: <?php echo $profil->abonament; ?></td>
	</tr>
	<tr>
		<td valign="top">Email: <?php echo $profil->email; ?></td>
		<td valign="top" colspan="2"><div>Sediu:</div><?php echo $profil->sediu; ?></td>
		<td valign="top">
			<div>Domenii activitate:</div>
			<?php 
			$cats = explode(",", $profil->categorii_activitate);
					$query = "SELECT * FROM #__sa_tip_anunt";
					$db->setQuery($query);
					$tip = $db->loadObjectList();
					foreach ($tip as $t) {
						$valoare = $t->id.'-1';
							if (in_array($valoare, $cats)) {
								echo '<div>'.$t->tip.'</div>';
							}
					}
			?>
		</td>
	</tr>
	<tr>
		<td>
		<?php 
		$link_edit = 'index.php?option=com_sauto&task=edit_dealer';
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
		<tr>
		<td>
			<?php
			$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$id."' AND `raspuns` = '0'";
			$db->setQuery($query);
			$comms = $db->loadResult();
			if ($comms != 0) {
				echo '<div>Comentarii: '.$comms.'</div>';
				echo '<form action="index.php?option=com_sauto&task=comment_list" method="post">';
				echo '<input type="hidden" name="uid" value="'.$uid.'" />';
				echo '<input type="hidden" name="tip_cont" value="1" />';
				echo '<input type="submit" value="Lista comentarii" />';
				echo '</form>';
			}
			?>
		
		</td>
		<td colspan="3"></td>
	</tr>
</table>
