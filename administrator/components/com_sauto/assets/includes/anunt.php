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
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
if ($id == '') {
	$id =& JRequest::getVar( 'id', '', 'get', 'string' );
} 
$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$anunt = $db->loadObject();
?>
<table width="100%">
	<tr>
		<td colspan="2">
			<h3><?php echo $anunt->titlu_anunt; ?></h3>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
			<?php
			//echo '------------<br />';
			//echo $anunt->tip_anunt.'<br />';
			//echo '------------<br />';
			//obtin tipul de anunt
			if ($anunt->tip_anunt == 1) {
			//1
			require("display_request_1.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 2) {
			//2
			require("display_request_2.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 3) {
			//3
			require("display_request_3.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 4) {
			//4
			require("display_request_4.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 5) {
			//5
		} elseif ($anunt->tip_anunt == 6) {
			//6
			require("display_request_6.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 7) {
			//7
		} elseif ($anunt->tip_anunt == 8) {
			//8
			require("display_request_8.php");
			view_detail($anunt);
		} elseif ($anunt->tip_anunt == 9) {
			//9
			require("display_request_9.php");
			view_detail($anunt);
		}
			?>
		</td>
		<td valign="top">
			<?php
			require("display_proprietar.php");
			view_proprietar($anunt->proprietar);
			?>
		</td>
	</tr>
	<tr>
		<td valign="bottom">
			<?php echo JText::_('SAUTO_MESAJ_CERERE'); ?>
		</td>
		<td>
			<?php
		$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$id."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total != 0) {
			//avem poze
			require("display_pictures.php");
			view_pictures($id, $anunt->proprietar);
			//echo 'avem poze > '.$total;
		}
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo $anunt->anunt; ?>
		</td>
	</tr>
	<tr>
		<td>
			<div style="display:inline;">
		<?php
		$link_edit = 'index.php?option=com_sauto&task=edit_anunt';
			echo '<div style="float:left;"><form action="'.$link_edit.'" method="post">';
			echo '<input type="hidden" name="id" value="'.$anunt->id.'" />';
			echo '<input type="submit" value="Editare" />';
			echo '</form></div>';
		if ($anunt->uid_winner == 0) {
			$link_delete = 'index.php?option=com_sauto&task=delete_anunt';
			echo '<div style="float:left;margin-left:10px;"><form action="'.$link_delete.'" method="post">';
			echo '<input type="hidden" name="anunt_id" value="'.$anunt->id.'" />';
			echo '<input type="submit" value="Stergere" />';
			echo '</form></div>';
		}
		?>
			</div><div style="clear:both;"></div>
		</td>
		<td align="right">
		<?php
		if ($anunt->raportat == 0) {
			echo '<div>Anuntul nu este raportat</div>';
		} else {
			echo '<span class="sa_raportat">Anunt raportat!</span>';
			//obtin numele celui ce a raportat anuntul
			$query = "SELECT `uid` FROM #__sa_reported  WHERE `anunt_id` = '".$anunt->id."' ORDER BY `data_rep` DESC";
			$db->setQuery($query);
			$rep_uid = $db->loadResult();
			echo '<div>Raportat de catre: ';
			if ($rep_uid == 0) {
				//vizitator
				echo 'Vizitator';
			} else {
				//get info
$query = "SELECT `tip_cont`, `fullname`, `companie` FROM #__sa_profiles WHERE `uid` = '".$rep_uid."'";
$db->setQuery($query);
$usr = $db->loadObject();
			$link_profile_rep = 'index.php?option=com_sauto&task=profil&id='.$rep_uid;
				echo '<a href="'.$link_profile_rep.'">';
				if ($usr->tip_cont == 0) {
					//client
					echo $usr->fullname;
				} else {
					//dealer
					echo $usr->companie;
				}
				echo '</a>';
			}
			echo '</div>';
			echo '<div>';
				$link_reported="index.php?option=com_sauto&task=prelucrari&action=raportat";
				echo '<form action="'.$link_reported.'" method="post">';
				echo '<input type="hidden" name="anunt_id" value="'.$anunt->id.'" />';
				echo '<input type="submit" value="Dezactivare raportare" />';
				echo '</form>';
			echo '</div>';
		}
		//verificam lista de raportari
		$query = "SELECT count(*) FROM #__sa_reported WHERE `anunt_id` = '".$anunt->id."'";
		$db->setQuery($query);
		$all_reported = $db->loadResult();
		if ($all_reported != 0) {
			echo '<a href="index.php?option=com_sauto&task=list_reported&anunt_id='.$anunt->id.'">Lista rapoarte</a>';
		}
			
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php
			//verficam daca sunt oferte facute
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$anunt->id."'";
			$db->setQuery($query);
			$total = $db->loadResult();
			if ($total == 0) {
				echo 'Nu sunt oferte facute!';
			} else {
				$image_path = JUri::root().'components/com_sauto/assets/';
				
				echo '<table class="sa_table_class" width="100%">';
				$query = "SELECT `r`.`id`, `r`.`firma`, `r`.`mesaj`, `r`.`data_adaugarii`, `r`.`status_raspuns`, `r`.`pret_oferit`, `p`.`poza`, `p`.`companie`, `p`.`calificative`, `l`.`localitate` , `m`.`m_scurt` FROM  #__sa_raspunsuri AS `r` JOIN #__sa_profiles AS `p` JOIN #__sa_localitati AS `l` JOIN #__sa_moneda AS `m` ON `r`.`anunt_id` = '".$anunt->id."' AND `r`.`firma` = `p`.`uid` AND `p`.`localitate` = `l`.`id` AND `r`.`moneda` = `m`.`id`";
				$db->setQuery($query);
				//echo $query;
				$rasp = $db->loadObjectList();
				//print_r($rasp);
				foreach ($rasp as $r) {
					if ($style == ' sa-row1 ') { 
						$style = ' sa-row0 '; 
					} else { 
						$style = ' sa-row1 '; 
					}
					echo '<tr class="'.$style.'">';
						echo '<td valign="top" width="90">';
							if ($r->poza == '') {
								//avatar standard
								echo '<img src="'.$image_path.'images/icon_profile.png" width="70" />';
							} else {
								//avatar custom
								echo '<img src="'.$image_path.'users/'.$r->firma.'/'.$r->poza.'" width="70" />';
							}
						echo '</td>';
						echo '<td valign="top">';
						$link_profile = 'index.php?option=com_sauto&task=profil&id='.$r->firma;
							echo '<div class="sa_title"><a href="'.$link_profile.'">'.$r->companie.'</a></div>';
							echo '<div style="display:inline;">';
								echo '<div style="float:left;">Localitate: '.$r->localitate.'</div>';
								echo '<div style="float:right;">Calificative: '.$r->calificative.'%</div>';
							echo '</div><div style="clear:both;"></div>';
							echo '<div>'.$r->mesaj.'</div>';
							echo '<div>Data ofertei: '.$r->data_adaugarii.'</div>';
							//echo 'pret + moneda';
						echo '</td>';
						echo '<td valign="top">';
							echo '<div>Pret oferit: '.$r->pret_oferit.' '.$r->m_scurt.'</div>';
								$link_edit = 'index.php?option=com_sauto&task=edit_oferta';
							echo '<div>';
								echo '<form action="'.$link_edit.'" method="post">';
									echo '<input type="hidden" name="raspuns_id" value="'.$r->id.'" />';
									echo '<input type="hidden" name="anunt_id" value="'.$anunt->id.'" />';
									echo '<input type="submit" value="Editare" />';
								echo '</form>';
							echo '</div>';
							echo '<div>';
								if ($r->status_raspuns == 1) {
									echo '<div>Oferta castigatoare</div>';
								}
							echo '</div>';
						echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			?>
		</td>
	</tr>
</table>
