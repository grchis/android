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

function sumar() {
	$db = JFactory::getDbo();
	echo '<table width="100%">';
		echo '<tr><td colspan="2">';
			echo '<h3>Informatii generale</h3>';
		echo '</td></tr>';
	//obtinem nunturi raportate
	$query = "SELECT count(*) FROM #__sa_anunturi WHERE `raportat` = '1'";
	$db->setQuery($query);
	$total_raport = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Anunturi raportate: '.$total_raport.'</div>';
		echo '</td><td align="right">';
		if ($total_raport != 0) {
			$link_raportate = 'index.php?option=com_sauto&task=raportate';
			echo ' <a href="'.$link_raportate.'">Vezi raportarile</a>';
		}
		echo '</td></tr>';
	//localitati in asteptare
	$query = "SELECT count(*) FROM #__sa_localitati WHERE `published` = '0'";
	$db->setQuery($query);
	$total_city = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Localitati in asteptarea publicarii: '.$total_city.'</div>';
		echo '</td><td align="right">';
			if ($total_city != 0) {
				$link_city = 'index.php?option=com_sauto&task=city';
				echo ' <a href="'.$link_city.'">Vezi localitatile</a>';
			}
		echo '</td></tr>';
	//marci neaprobate
	$query = "SELECT count(*) FROM #__sa_marca_auto WHERE `published` = '0'";
	$db->setQuery($query);
	$total_marca = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Marci auto nepublicate: '.$total_marca.'</div>';
		echo '</td><td align="right">';
			if ($total_marca != 0) {
				$link_marci = 'index.php?option=com_sauto&task=marci';
				echo ' <a href="'.$link_marci.'">Vezi marci auto</a>';
			}
		echo '</td></tr>';
	//modele neaptobate
	$query = "SELECT count(*) FROM #__sa_model_auto WHERE `published` = '0'";
	$db->setQuery($query);
	$total_model = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Modele auto nepublicate: '.$total_model.'</div>';
		echo '</td><td align="right">';
			if ($total_model != 0) {
				$link_modele = 'index.php?option=com_sauto&task=modele';
				echo ' <a href="'.$link_modele.'">Vezi modele auto</a>';
			}
		echo '</td></tr>';
		echo '<tr><td colspan="2"><hr /></td></tr>';
	//obtinem nr total anunturi
	$query = "SELECT count(*) FROM #__sa_anunturi";
	$db->setQuery($query);
	$total_anunturi = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Total anunturi: '.$total_anunturi.'</div>';
		echo '</td<td></td></tr>';
	//total localitati
	$query = "SELECT count(*) FROM #__sa_localitati";
	$db->setQuery($query);
	$total_cities = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Localitati: '.$total_cities.'</div>';
		echo '</td><td align="right">';
		echo '</td></tr>';
	//total utilizatori
	$query = "SELECT count(*) FROM #__sa_profiles WHERE `tip_cont` = '0'";
	$db->setQuery($query);
	$total_clienti = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Total clienti inregistrati: '.$total_clienti.'</div>';
		echo '</td><td></td></tr>';
	//total firma
	$query = "SELECT count(*) FROM #__sa_profiles WHERE `tip_cont` = '1'";
	$db->setQuery($query);
	$total_firme = $db->loadResult();
		echo '<tr><td>';
			echo '<div>Total firme inregistrate: '.$total_firme.'</div>';
		echo '</td><td></td></tr>';
	echo '</table>';
}
