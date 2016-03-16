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
$tip_plata =& JRequest::getVar( 'tip_plata', '', 'post', 'string' );
$time = time();
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();
$metoda_plata =& JRequest::getVar( 'metoda_plata', '', 'post', 'string' );
//echo 'tipul platii: '.$tip_plata.'<br />';
if ($tip_plata == 'abonament') {
	//plata pentru abonament
	
	if ($metoda_plata == 'op') {
		//plata prin transfer bancar
		$curs_euro =& JRequest::getVar( 'curs_euro', '', 'post', 'string' );
		//echo '>>> '.$curs_euro;
		
		$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
		$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
		$moneda =& JRequest::getVar( 'moneda', '', 'post', 'string' );
		//echo 'abonament ales: '.$abonament.' la pretul de '.$pret.' '.$moneda.'<br />';

		jimport('joomla.filesystem.file');
		//jimport('joomla.filesystem.folder');
		$image = JRequest::getVar('image', null, 'files','array');
		$image['name'] = JFile::makeSafe($image['name']);
		if ($image['name'] != '') {
		//echo 'poza urcata: '.$image['name'].'<br />';
		$base_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'files'.DS;
		//echo 'calea de upload: '.$base_path.'<br />';
		$newName = 'plata-'.$uid.'-'.$time.'-'.$image['name'];
		$uploadPath = $base_path.$newName;
		JFile::upload($image['tmp_name'], $uploadPath);
		} else {
			$newName = '';
		}
		//adaugam in baza de date
		
		//preluam serie factura curenta
		$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
		$db->setQuery($query);
		$serii = $db->loadObject();
		$nr_crt = $serii->nr_crt + 1;
		//incrementare nr curent
		$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
		$db->setQuery($query);
		$db->query();
		//echo $query.'<hr />';
		//serie factura
		$fact = 'op - '.$serii->serie.' - '.$nr_crt;
		$credit = 'abonament';
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `curs_euro`) 
		VALUES ('".$uid."', '".$fact."', '0', '".$credit."', '',  '".$pret."', '".$moneda."', '".$curs_euro."')";
		$db->setQuery($query);
		$db->query();
		//echo $query.'<hr />';
		$last_fact = $db->insertid();
		
		//$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$pret."', '".$moneda."', '')";
		//$db->setQuery($query);
		//$db->query();
		//echo $query.'<hr />';
		//adaugam tranzactia
		$query = "INSERT INTO #__sa_tranzactii (`tranz_id`, `uid`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `fisier`, `curs_euro`) VALUES ('".$last_fact."', '".$uid."', 'abonament-op', '".$time."', '".$pret."', '".$moneda."', '".$newName."', '".$curs_euro."')";
		$db->setQuery($query);
		$db->query();
		//echo $query;
		//redirectionam
		$link_redirect = JRoute::_('index.php?option=com_sauto');
		$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_CONFIRM_PAY'));
		
	} elseif ($metoda_plata == 'cc') {
		//plata prin card bancar
	}elseif ($metoda_plata == 'pp') {
		//plata prin paypal
	}
} elseif ($tip_plata == 'puncte') {
	//plata pentru credite
	if ($metoda_plata == 'op') {
		//plata prin op
		$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
		$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
		$db->setQuery($query);
		$serii = $db->loadObject();
		$nr_crt = $serii->nr_crt + 1;
		//adaugam factura
		$fact = 'op - '.$serii->serie.' - '.$nr_crt;

		$credit = 'credit';
		
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`) 
		VALUES ('".$uid."', '".$fact."', '0', '".$credit."', '".$pret."', '".$pret."', '1')";
		$db->setQuery($query);
		$db->query();
		$last_fact = $db->insertid();
		
		$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$pret."', '1', '".$pret."')";
		$db->setQuery($query);
		$db->query();
		//incrementare nr curent
		$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
		$db->setQuery($query);
		$db->query();
		
		jimport('joomla.filesystem.file');
		//jimport('joomla.filesystem.folder');
		$image = JRequest::getVar('image', null, 'files','array');
		$image['name'] = JFile::makeSafe($image['name']);
		if ($image['name'] != '') {
		//echo 'poza urcata: '.$image['name'].'<br />';
		$base_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'files'.DS;
		//echo 'calea de upload: '.$base_path.'<br />';
		$newName = 'plata-'.$uid.'-'.$time.'-'.$image['name'];
		$uploadPath = $base_path.$newName;
		JFile::upload($image['tmp_name'], $uploadPath);
		} else {
			$newName = '';
		}
		
		
		$query = "INSERT INTO #__sa_tranzactii (`tranz_id`, `uid`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `fisier`, `curs_euro`) VALUES ('".$last_fact."', '".$uid."', 'credite-op', '".$time."', '".$pret."', '1', '".$newName."', '')";
		$db->setQuery($query);
		$db->query();
		
		$link_ok = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=fn');
		$app->redirect($link_ok, JText::_('SAUTO_SUCCES_CONFIRM_PAY'));
	} elseif ($metoda_plata == 'cc') {
		//plata prin card bancar
	}elseif ($metoda_plata == 'pp') {
		//plata prin paypal
	}	
} else {
	//redirectionat
}
