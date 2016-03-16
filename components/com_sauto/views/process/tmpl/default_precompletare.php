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

$db = JFactory::getDbo();

$link_redirect = JRoute::_('index.php?option=com_sauto&view=register_dealer');

$cf =& JRequest::getVar( 'cod_fiscal', '', 'post', 'string' );
$rnames =& JRequest::getVar( 'rnames', '', 'post', 'string' );
$email =& JRequest::getVar( 'email', '', 'post', 'string' );
$pass1 =& JRequest::getVar( 'pass1', '', 'post', 'string' );
$pass2 =& JRequest::getVar( 'pass2', '', 'post', 'string' );

$app =& JFactory::getApplication();

$app->setUserState('cod_fiscal', $cf);
$rnames = $app->setUserState('rnames', $rnames);
$email = $app->setUserState('email', $email);

if ($pass1 != '') {
	if ($pass1 == $pass2) {
		$pswd = $app->setUserState('pswd', $pass1);
	}
}

$filiala =& JRequest::getVar( 'filiala', '', 'post', 'string' );
//echo '>>>> '.$filiala;

if ($filiala == 1) {
	$query = "SELECT * FROM #__sa_profiles WHERE `cod_fiscal` = '".$cf."' AND `f_principal` = '1'";
	$db->setQuery($query);
	$dates = $db->loadObject();

	$app->setUserState('company_name', $dates->companie);
	$app->setUserState('nr_reg', $dates->nr_registru);
	$app->setUserState('filiala', $filiala);
	//echo '>>>> '.$app->getUserState('filiala');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_PRECOMPLETARE')); 
} else {

$xml_exist = is_url_exist('http://openapi.ro/api/companies/'.$cf.'.xml');
if ($xml_exist == true) {
	$old_cf = $cf;
	$filtru = array('RO', 'ro', 'Ro', 'rO');
	$cf = str_ireplace($filtru, '', $cf);
	//echo '<br />???? > '.$cf; 
	$result = JFactory::getXML('http://openapi.ro/api/companies/'.$cf.'.xml',true);

	$g_firma = $result->name;
	$g_adresa  = $result->address;
	$g_city = $result->city;
	$g_phone = $result->phone;
	$var = 'registration-id';
	$g_reg = $result->$var;
	$g_region = $result->state;
	$g_zip = $result->zip;

	
	$query = "INSERT INTO #__sa_temp_firme (`cui`, `firma`, `sediu`, `city`, `phone`, `nr_reg`, `judet`, `cp`) 
	VALUES ('".$old_cf."', '".$g_firma."', '".$g_adresa."', '".$g_city."', '".$g_phone."', '".$g_reg."', '".$g_region."', '".$g_zip."')";
	$db->setQuery($query);
	$db->query();

	
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_PRECOMPLETARE'));
	} else {
	$app->redirect($link_redirect, JText::_('SAUTO_EROARE_PRECOMPLETARE')); 
}

}
function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}

?>