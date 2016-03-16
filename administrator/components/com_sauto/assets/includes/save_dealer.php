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
$uid =& JRequest::getVar( 'uid', '', 'post', 'string' );

$companie =& JRequest::getVar( 'companie', '', 'post', 'string' );
$email =& JRequest::getVar( 'email', '', 'post', 'string' );
$telefon =& JRequest::getVar( 'telefon', '', 'post', 'string' );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$localitate =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$sediu =& JRequest::getVar( 'sediu', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$cod_postal =& JRequest::getVar( 'cod_postal', '', 'post', 'string' );
$delete_avatar =& JRequest::getVar( 'delete_avatar', '', 'post', 'string' );

$reprezentant =& JRequest::getVar( 'reprezentant', '', 'post', 'string' );
$cod_fiscal =& JRequest::getVar( 'cod_fiscal', '', 'post', 'string' );
$nr_registru =& JRequest::getVar( 'nr_registru', '', 'post', 'string' );
$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );

$delete_user =& JRequest::getVar( 'delete_user', '', 'post', 'string' );
$restore_user =& JRequest::getVar( 'restore_user', '', 'post', 'string' );

/*echo 'nume > '.$fullname.'<br />';
echo 'email > '.$email.'<br />';
echo 'telefon > '.$telefon.'<br />';
echo 'judet > '.$judet.'<br />';
echo ' city > '.$localitate.'<br />';
echo 'adresa > '.$adresa.'<br />';
echo 'cod postal > '.$cod_postal.'<br />';
echo 'delete > '.$delete_avatar.'<br />';
*/
if ($companie == '') {
	$upd_companie = '';
} else {
	$upd_companie = " `companie` = '".$companie."', ";
} 
if ($telefon == '') {
	$upd_telefon = '';
} else {
	$upd_telefon = " `telefon` = '".$telefon."', ";
}
if ($sediu == '') {
	$upd_sediu = ''; 
} else {
	$upd_sediu = " `sediu` = '".$sediu."', ";
}
if ($delete_avatar != 1) {
	$upd_poza = '';
} else {
	$query = "SELECT `poza` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$poza = $db->loadResult();
	$upd_poza = " `poza` = '', ";
}
if ($judet == '') {
	$upd_judet = '';
} else {
	//get judet id
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	$upd_judet = " `judet` = '".$judet."', ";
}
if ($localitate == '') {
	$upd_city = '';
} else {
	$upd_city = " `localitate` = '".$localitate."', ";
}
if ($reprezentant == '') {
	$upd_repr = '';
} else {
	$upd_repr = " `reprezentant` = '".$reprezentant."', ";
}
if ($cod_fiscal == '') {
	$upd_cf = '';
} else {
	$upd_cf = " `cod_fiscal` = '".$cod_fiscal."', ";
}
if ($nr_registru == '') {
	$upd_nrreg = '';
} else {
	$upd_nrreg = " `nr_registru` = '".$nr_registru."', ";
}

//domenii
$query = "SELECT * FROM #__sa_tip_anunt";
$db->setQuery($query);
$vars = $db->loadObjectList();
	$x = 1;
	$domm = '';
	foreach ($vars as $v) {
		//obtin variabilele
		$nume_var = 'domeniu_'.$v->id;
		$post_var =& JRequest::getVar( $nume_var, '', 'post', 'string' );
		if ($post_var != '') {
			if ($x == 1) {
				$domm .= $post_var;
			} else {
				$domm .= ','.$post_var;
			}
		$x++;			
		}
	}
	$upd_domeniu = ", `categorii_activitate` = '".$domm."'";
	//echo $upd_domeniu.'<br />';
//end domenii
$query = "UPDATE #__sa_profiles SET ".$upd_companie." ".$upd_telefon." ".$upd_sediu." ".$upd_poza." ".$upd_judet." ".$upd_city." ".$upd_repr." ".$upd_cf." ".$upd_nrreg." `uid` = '".$uid."' , `abonament` = '".$abonament."' ".$upd_domeniu." WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$db->query();
//echo $query.'<br />';

if ($delete_avatar == 1) {
	//stergem fizic avatarul
	jimport('joomla.filesystem.file');
	$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$uid.DS;
	$path_delete = $path.$poza;
	JFile::delete($path_delete);
	//echo $path_delete.'<br />';
}

if ($email == '') {
	$upd_email = '';
} else {
	$upd_email = " `email` = '".$email."', ";
} 
$query = "UPDATE #__users SET ".$upd_email." `id` = '".$uid."' WHERE `id` = '".$uid."'";
$db->setQuery($query);
$db->query();
//echo $query;

if ($delete_user == 1) {
	//obtin adresa de mail
	$query = "SELECT `email` FROM #__users WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$email = $db->loadResult();
	$n_email = $email.'.deleted';
	$query = "UPDATE #__users SET `email` = '".$n_email."', `block` = '1' WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
	
	//obtin telefonul
	$query = "SELECT `telefon` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$tel = $db->loadResult();
	$n_tel = $tel.'d';
	$query = "UPDATE #__sa_profiles SET `deleted` = '1', `telefon` = '".$n_tel."' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
}
if ($restore_user == 1) {
	$query = "UPDATE #__users SET `block` = '0' WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$db->query();

	$query = "UPDATE #__sa_profiles SET `deleted` = '0' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
}

$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=dealers';
$app->redirect($link_redirect, 'Profilul companiei a fost editat cu succes');
?>

