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

$time = time();
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$rnames =& JRequest::getVar( 'rnames', '', 'post', 'string' );
$email =& JRequest::getVar( 'email', '', 'post', 'string' );
$new_pass1 =& JRequest::getVar( 'new_pass1', '', 'post', 'string' );	
$new_pass2 =& JRequest::getVar( 'new_pass2', '', 'post', 'string' );
$phone =& JRequest::getVar( 'phone', '', 'post', 'string' );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'city', '', 'post', 'string' );
$new_city =& JRequest::getVar( 'new_city', '', 'post', 'string' );
$delete_avatar =& JRequest::getVar( 'delete_avatar', '', 'post', 'string' );
$sediu =& JRequest::getVar( 'sediu', '', 'post', 'string', JREQUEST_ALLOWHTML );
$input = new JInput;
//$domeniu = $input->get('domeniu', '', 'ARRAY');



//echo '>>>>> '.$domm;

if ($rnames != '') { $upd_rnames = ", `reprezentant` = '".$rnames."'"; } else { $upd_rnames = ''; }
if ($phone != '') { $upd_phone = ", `telefon` = '".$phone."'"; } else { $upd_phone = ''; }
if ($sediu != '') { $upd_sediu = ", `sediu` = '".$sediu."'"; } else { $upd_sediu = ''; }
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$jid = $db->loadResult();
$upd_judet = ", `judet` = '".$jid."'";
if ($new_city == '') {
	//oras actual
	$upd_city = ", `localitate` = '".$city."'";
} else {
	//oras nou
	$query = "INSERT INTO #__sa_localitati (`jid`, `localitate`, `published`) VALUES ('".$jid."', '".$new_city."', '0')";
	$db->setQuery($query);
	$db->query();
	$city_id = $db->insertid();
	$upd_city = ", `localitate` = '".$city_id."'";
}

//prelucrare imagini
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$upd_poza = '';
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
$image = JRequest::getVar('image', null, 'files','array');
$image['name'] = JFile::makeSafe($image['name']);
$base_path = JPATH_COMPONENT.DS.'assets'.DS.'users'.DS;
if ($image['name'] != '') {
		//verific daca userul are folder creat
		$folder_path = $base_path.$uid;
		$exista = JFolder::exists($folder_path);
	if ($exista == '') {
		//creaza folderul
		JFolder::create($folder_path);
		$sursa = $base_path.'index.html';
		$destinatie = $base_path.DS.$uid.DS.'index.html';
		JFile::copy($sursa, $destinatie);
	} 
	//upload poza
	if($image['size'] < $sconfig->max_size)	{
		//upload imagine
		$upFileName = explode('.',$image['name']);
		$uploadedFileExtension = array_pop($upFileName);
		$valid_ext = $sconfig->valid_ext;
		$validExt = explode(',', $valid_ext);
		$extOk = false;
			foreach($validExt as $key => $value) {
				if( preg_match("/$value/i", $uploadedFileExtension ) ) {
				$extOk = true;
				}
			}
		
			if ($extOk != false) {
				$imageinfo = getimagesize($image['tmp_name']);
				$mime_types = $sconfig->mime_types;
				$okMIMETypes = $mime_types;
				$validFileTypes = explode(",", $okMIMETypes);

				if( is_int($imageinfo[0]) || is_int($imageinfo[1]) ||  in_array($imageinfo['mime'], $validFileTypes) ) {	
					$image['name'] = preg_replace("/[^A-Za-z.0-9]/i", "-", $image['name']);
					$newName = 'profile-'.$uid.'-'.$time.'-'.$image['name'];
					$newName2 = 'profile-x-'.$uid.'-'.$time.'-'.$image['name'];
					$uploadPath = $base_path.$uid.DS.$newName;	
					$uploadPath2 = $base_path.$uid.DS.$newName2;	
					$file_name = $newName2;
					JFile::upload($image['tmp_name'], $uploadPath);
					####################
					$image = new JImage($uploadPath);
					$properties = JImage::getImageFileProperties($uploadPath);
					$resizedImage = $image->resize('400', '300', true);
					$mime = $properties->mime;
					if ($mime == 'image/jpeg') {
						$type = IMAGETYPE_JPEG;
					} elseif ($mime = 'image/png') {
						$type = IMAGETYPE_PNG;
					} elseif ($mime = 'image/gif') {
						$type = IMAGETYPE_GIF;
					}
					$resizedImage->toFile($uploadPath, $type);
					watermark_image($uploadPath, $uploadPath2, $mime);
					####################
					######adaugare in baza de date
					$upd_poza = ", `poza` = '".$file_name."'";
					//verificam daca avem poza 
					$query = "SELECT `poza` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
					$db->setQuery($query);
					$act_pic = $db->loadResult();
					if ($act_pic != '') {
						//stergem avatarul existent
						$deletePath = $base_path.$uid.DS.$act_pic;
						JFile::delete($deletePath);
					}
				}
			}
		}
	}
if ($delete_avatar == 1) {
	$query = "SELECT `poza` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$act_pic = $db->loadResult();
	if ($act_pic != '') {
		//stergem avatarul existent
		$deletePath = $base_path.$uid.DS.$act_pic;
		JFile::delete($deletePath);
		$upd_poza = ", `poza` = '' ";
	}
}
//update profiles
$query = "UPDATE #__sa_profiles SET `tip_cont` = '1' ".$upd_rnames.$upd_phone.$upd_sediu.$upd_judet.$upd_city.$upd_poza." WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$db->query();
//update mail & pass
if ($email != '') { $upd_email = ", `email` = '".$email."'"; } else { $upd_email = ''; }
$upd_pass = '';
if ($new_pass1 != '') {
	//avem parola 1
	if ($new_pass2 != '') {
		//avem parola 2
		if ($new_pass1 == $new_pass2) {
			//parolele sunt identice
			jimport('joomla.user.helper');
			$salt = JUserHelper::genRandomPassword(32);
			$crypt = JUserHelper::getCryptedPassword($new_pass1, $salt);
			$pass = $crypt.':'.$salt;
			$upd_pass = ", `password` = '".$pass."'";
		}
	}
}
$query = "UPDATE #__users SET `block` = '0' ".$upd_email.$upd_pass." WHERE `id` = '".$uid."'";
$db->setQuery($query);
$db->query();
//echo $query;
$app =& JFactory::getApplication();

//
$delete_cont =& JRequest::getVar( 'delete_cont', '', 'post', 'string' );
if ($delete_cont == 1) {
	//setam contul ca sters si dam logout
	$query = "UPDATE #__sa_profiles SET `deleted` = '1' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
	$query = "UPDATE #__users SET `block` = '1' WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
	$app->logout( $uid );
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect);
} else {
$link_redirect = JRoute::_('index.php?option=com_sauto');
$app->redirect($link_redirect, JText::_('SAUTO_PROFILE_SUCCESSFULY_SAVED'));
}


function watermark_image($oldimage_name, $new_image_name, $mime)
{
$image_path = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'stamp.png';
list($owidth,$oheight) = getimagesize($oldimage_name);
$width = $height = 300;
$im = imagecreatetruecolor($width, $height);
	if ($mime == 'image/jpeg') {
		$img_src = imagecreatefromjpeg($oldimage_name);
	} elseif ($mime == 'image/png') {
		$img_src = imagecreatefrompng($oldimage_name);
	} elseif ($mime == 'image/gif') {
		$img_src = imagecreatefromgif($oldimage_name);
	}
imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
$watermark = imagecreatefrompng($image_path);
list($w_width, $w_height) = getimagesize($image_path);
$pos_x = $width - $w_width;
$pos_y = $height - $w_height;
imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
imagejpeg($im, $new_image_name, 100);
imagedestroy($im);
unlink($oldimage_name);
return true;
}
?>

