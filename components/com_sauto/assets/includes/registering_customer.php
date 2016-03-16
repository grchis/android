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
$link_redirect = JRoute::_('index.php?option=com_sauto&view=register_customer');
$link_redirect2 = JRoute::_('index.php?option=com_sauto');

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
if ($sconfig->enable_captcha == 1) {
	$captcha_enabled = 1;
	require("components/com_sauto/assets/libraries/recaptchalib.php");
	$privatekey = $sconfig->private_key;
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	
} else {
	$captcha_enabled = 0;
}


$app =& JFactory::getApplication();
$agree =& JRequest::getVar( 'agree', '', 'post', 'string' );
$register_account = 0;
if ($agree == 1) {
	//clientul este de acord cu termenii si conditiile
	//verificari suplimentare......
	$email =& JRequest::getVar( 'email', '', 'post', 'string' );
	$names =& JRequest::getVar( 'names', '', 'post', 'string' );
	$phone =& JRequest::getVar( 'phone', '', 'post', 'string' );
	$pass1 =& JRequest::getVar( 'pass1', '', 'post', 'string' );
	$pass2 =& JRequest::getVar( 'pass2', '', 'post', 'string' );
	$app->setUserState('names', $names);
	$app->setUserState('email', $email);
	$app->setUserState('phone', $phone);
	if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
		//mail ok
		//verificam sa nu fie duplicat
		$query = "SELECT count(*) FROM #__users WHERE `email` = '".$email."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total == 1) {
			//adresa de mail exista			
			$app->redirect($link_redirect, JText::_('SAUTO_DUPLICATE_EMAIL'));
		} else {
		//verificam daca este introdus numarul de telefon
			//if ($phone != '') {
				//avem numar de telefon
				//verificam parolele.....
				if ($pass1 == '') {
					//parola 1 nu este introdusa
					$app->redirect($link_redirect, JText::_('SAUTO_NO_PASS1_ADDED'));
				} else {
					if ($pass2 == '') {
						//parola 2 nu este introdusa
						$app->redirect($link_redirect, JText::_('SAUTO_NO_PASS2_ADDED'));
					} else {
						if ($pass1 != $pass2) {
							//parolele nu se potrivesc
							$app->redirect($link_redirect, JText::_('SAUTO_NO_PASS_MATCH'));
						} else {
							//verificam captcha
							if ($captcha_enabled == 1) {
								//verificare captcha
								if (!$resp->is_valid) {
									// cod incorect, redirectionare
									$app->redirect($link_redirect, JText::_('SAUTO_NO_CAPTCHA'));
									//$register_account = 1;
								} else {
									// cod corect, permitem inregisrarea contului
									//echo 'acu e buna si captcha<br />';
									$register_account = 1;
								}
							} else {
								//inregistrare cont
								$register_account = 1;
							}
						}
					}
				}
			//} else {
				//nu avem telefonul, redirectionam
				//$app->redirect($link_redirect, JText::_('SAUTO_PHONE_WRONG'));
			//}
		}
	} else {
		//mail gresit, redirectionam
		$app->redirect($link_redirect, JText::_('SAUTO_EMAIL_WRONG'));
	}
} else {
	//redirectam pe pagina de inregistrare
	$app->redirect($link_redirect, JText::_('SAUTO_TERMS_NOT_AGREE'));
}
?>

<?php
if ($register_account == 1) {
	//echo 'inregistram contul.....<br />';
	//preluare date aditionale
	$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
	$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
	$new_city =& JRequest::getVar( 'new_city', '', 'post', 'string' );
	if ($judet == '') {
		//nu e adaugat judetul, redirectionam....
		$app->redirect($link_redirect, JText::_('SAUTO_NO_REGION'));
	} else {
		//verificam localitatea
		if ($new_city == '') {
			//verificam daca avem localitatea selectata
			if ($city == '') {
				//nu este selectata localitatea, redirectionam
				$app->redirect($link_redirect, JText::_('SAUTO_NO_CITY'));
			}
		}
	//get judet id
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$judet_id = $db->loadResult();
		$new_city_id = $city;
	//inregistram userul datele in baza de date
	/*jimport('joomla.user.helper');
    $salt = JUserHelper::genRandomPassword(32);
    $crypt = JUserHelper::getCryptedPassword($pass1, $salt);
    $pass = $crypt.':'.$salt;
    $time = time();
	$registerDate = date('Y-m-d H:i:s', $time);
	$n_name = explode(" ", $names);
	$username = $n_name[0].$time;
    $query = "INSERT INTO #__users (`name`, `username`, `password`, `params`, `email`, `block`, `registerDate`) VALUES 
				('".$names."', '".$username."', '".$pass."', '', '".$email."', '0', '".$registerDate."')";
	$db->setQuery($query);
	$db->query();
	$last_id = $db->insertid();
	$query = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$last_id."', '2')";
	$db->setQuery($query);
	$db->query();*/
	//////////////
	require("function_register.php");
	$block = 0;
	$last_id = addUser($username, $names, $email, $pass1, $block);

	///////////////
	$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'c'";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	$new_var = '';
		foreach ($list as $l) {
			$new_var .= 's-'.$l->id.'_1';
			$new_var .= ',';
		}
				
	$query = "INSERT INTO #__sa_profiles (`uid`, `fullname`, `telefon`, `judet`, `localitate`, `tip_cont`, `alerte`) 
	VALUES ('".$last_id."', '".$names."', '".$phone."', '".$judet_id."', '".$new_city_id."', '0', '".$new_var."')";
	$db->setQuery($query);
	$db->query();
	
	$app->setUserState('names', '');
	$app->setUserState('email', '');
	$app->setUserState('phone', '');
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	//create user folder
	$folder_path = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id;
	JFolder::create($folder_path);
	//copy index.html
	$src = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.'index.html';
	$dest = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id.DS.'index.html';
	JFile::copy($src, $dest);
	
	$credentials = array();
	$credentials['username'] = $email;
	$credentials['password'] = $pass1;
	$options = array();
	$app->login( $credentials, $options );
	/* trimitem mail */
	$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
		
		$text_subiect = 'Salut '.$names;
		$text_corp_mail = 'Bun venit pe site-ul www.siteauto.ro. Pentru a te autentifica foloseste adresa ta de email: '.$email.' iar parola este aceasta: '.$pass1.'.';
		$text_titlu_mail = 'Bun venit';
		
		
		$mailer->addRecipient($email);
		$body = $text_subiect; 
		$body .= $text_corp_mail;
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setSubject($text_titlu_mail);
		$mailer->setBody($body);
		$send = $mailer->Send();
	/* end code */
	$app->redirect($link_redirect2, JText::_('SAUTO_SUCCESFULY_REGISTERED'));
	}
}
?>
