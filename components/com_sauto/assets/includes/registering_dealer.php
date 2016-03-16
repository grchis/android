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
$credite_initiale = '10';
$link_redirect = JRoute::_('index.php?option=com_sauto&view=register_dealer');
$link_redirect2 = JRoute::_('index.php?option=com_sauto');
$filiala =& JRequest::getVar( 'filiala', '', 'post', 'string' );


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
	$pass1 =& JRequest::getVar( 'pass1', '', 'post', 'string' );
	$pass2 =& JRequest::getVar( 'pass2', '', 'post', 'string' );
	$company_name =& JRequest::getVar( 'company_name', '', 'post', 'string' );
	$app->setUserState('company_name', $company_name);
	$email =& JRequest::getVar( 'email', '', 'post', 'string' );
	$app->setUserState('email', $email);
	$phone =& JRequest::getVar( 'phone', '', 'post', 'string' );
	$app->setUserState('phone', $phone);
	$rnames =& JRequest::getVar( 'rnames', '', 'post', 'string' );
	$app->setUserState('rnames', $rnames); 
	$cod_fiscal =& JRequest::getVar( 'cod_fiscal', '', 'post', 'string' );
	$app->setUserState('cod_fiscal', $cod_fiscal);
	$nr_reg =& JRequest::getVar( 'nr_reg', '', 'post', 'string' );
	$app->setUserState('nr_reg', $nr_reg);
	$sediu =& JRequest::getVar( 'sediu', '', 'post', 'string' );
	$cp =& JRequest::getVar( 'cp', '', 'post', 'string' );
	if ($cp == 0) { $cp = ''; }
	$app->setUserState('cp', $cp);
	
	if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
		$query = "SELECT count(*) FROM #__users WHERE `email` = '".$email."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total == 1) {
			//adresa de mail exista
			$app->redirect($link_redirect, JText::_('SAUTO_DUPLICATE_EMAIL'));
		} else {
			//verificam daca este introdus numarul de telefon
			if ($phone != '') {
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
							//verificam reprezentantul
							if ($rnames == '') {
								//reprezentatul nu este introdus, redirectionam....
								$app->redirect($link_redirect, JText::_('SAUTO_NO_REPREZENTANT_ADDED'));
							} else {
								//verificam codul fiscal
								if ($cod_fiscal == '') {
									//cod fiscal neintrodus, redirectionam
									$app->redirect($link_redirect, JText::_('SAUTO_NO_COD_FISCAL_ADDED'));
								} else {
									//verificam nr reg
									if ($nr_reg == '') {
										//nr reg nu este introdus
										$app->redirect($link_redirect, JText::_('SAUTO_NO_NR_REG_ADDED'));
									} else {
										//verificam sediu
										if ($sediu == '') {
											//nu este sediul introdus
											$app->redirect($link_redirect, JText::_('SAUTO_NO_SEDIU_ADDED'));
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
							}
						}
					}
				}
			} else {
				//nu avem telefonul, redirectionam
				$app->redirect($link_redirect, JText::_('SAUTO_PHONE_WRONG'));
			}
		}
	} else {
		//mail gresit, redirectionam
		$app->redirect($link_redirect, JText::_('SAUTO_EMAIL_WRONG'));
	}
	
}  else {
	//redirectam pe pagina de inregistrare
	$app->redirect($link_redirect, JText::_('SAUTO_TERMS_NOT_AGREE'));
}




if ($register_account == 1) {
	//echo 'inregistram contul.....<br />';
	//preluare date aditionale
	$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
	$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
	$app->setUserState('judet', $judet);
	if ($judet == '') {
		//nu e adaugat judetul, redirectionam....
		$app->redirect($link_redirect, JText::_('SAUTO_NO_REGION'));
	} else {
		
		//verificam daca avem localitatea selectata
		if ($city == '') {
			//nu este selectata localitatea, redirectionam
			$app->redirect($link_redirect, JText::_('SAUTO_NO_CITY'));
		}

		//get judet id
		$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
		$db->setQuery($query);
		$judet_id = $db->loadResult();
		if ($new_city != '') {
			//avem localitate noua
			//introducem in baza de date
			$query = "INSERT INTO #__sa_localitati (`jid`, `localitate`) VALUES ('".$judet_id."', '".$new_city."')";
			$db->setQuery($query);
			$db->query();
			$new_city_id = $db->insertid();
		} else {
			//localitate existenta
			$new_city_id = $city;
		}
		//inregistram userul datele in baza de date
		/*jimport('joomla.user.helper');
		$salt = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($pass1, $salt);
		$pass = $crypt.':'.$salt;
		$time = time();
		$registerDate = date('Y-m-d H:i:s', $time);
		$n_name = explode(" ", $rnames);
		$username = $n_name[0].$time;
		$query = "INSERT INTO #__users (`name`, `username`, `password`, `params`, `email`, `block`, `registerDate`) VALUES 
					('".$rnames."', '".$username."', '".$pass."', '', '".$email."', '1', '".$registerDate."')";
		$db->setQuery($query);
		$db->query();
		$last_id = $db->insertid();
		$query = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$last_id."', '2')";
		$db->setQuery($query);
		$db->query();*/
		#################
		require("function_register.php");
		$block = 1;
		$last_id = addUser($username, $rnames, $email, $pass1, $block);
		#################
	
		$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'd'";
		$db->setQuery($query);
		$list = $db->loadObjectList();

		$new_value = '';
		foreach ($list as $l) {
			if ($l->multiple == 0) {
				$tip = 's';
			} else {
				$tip = 'm';
			}
			$valoare = $tip.'-'.$l->id.'_1';
			$new_value .= $valoare.',';
		}
		if ($filiala == 1) {
			$fil = '0';
		} else {
			$fil = '1';
		}

		//creare cod de activare
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$activationCode = '';
		$length = 16;
		for ($i = 0; $i < $length; $i++) {
			$activationCode .= $characters[rand(0, strlen($characters) - 1)];
		}
		$incercari = 0;
		if ($filiala == 1) {
			$activationCode = '';
			$incercari = 5;
		}
	
		$query = "INSERT INTO #__sa_profiles 
				(`uid`, `reprezentant`, `telefon`, `judet`, `localitate`, `tip_cont`, `sediu`, `companie`, `cod_fiscal`, `nr_registru`, `abonament`, 
				`alerte`, `cod_postal`, `f_principal`, `activation_code`, `incercari`) 
			VALUES 
				('".$last_id."', '".$rnames."', '".$phone."', '".$judet_id."', '".$new_city_id."', '1', '".$sediu."', '".$company_name."', 
				'".$cod_fiscal."', '".$nr_reg."', '1', '".$new_value."', '".$cp."', '".$fil."', '".$activationCode."', '".$incercari."')";
		$db->setQuery($query);
		$db->query();
	
		$app->setUserState('rnames', '');
		$app->setUserState('email', '');
		$app->setUserState('phone', '');
		$app->setUserState('cod_fiscal', '');
		$app->setUserState('nr_reg', '');
		$app->setUserState('company_name', '');
		$app->setUserState('cp', '');
	
		//adaugam creditele initiale
		$query = "INSERT INTO #__sa_financiar (`uid`, `credite`) VALUES ('".$last_id."', '".$credite_initiale."')";
		$db->setQuery($query);
		$db->query();
	
		//create user folder
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$folder_path = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id;
		JFolder::create($folder_path);
		//copy index.html
		$src = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.'index.html';
		$dest = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id.DS.'index.html';
		JFile::copy($src, $dest);
	
		$query = "DELETE FROM #__sa_temp_firme WHERE `firma` = '".$company_name."'";
		$db->setQuery($query);
		$db->query();
	
		//$credentials = array();
		//$credentials['username'] = $email;
		//$credentials['password'] = $pass1;
		//$options = array();
		//$app->login( $credentials, $options );


		######## trimitem mail 

		if ($filiala == 1) {
			$query = "SELECT `u`.`email`, `p`.`reprezentant` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`cod_fiscal` = '".$cod_fiscal."' AND `p`.`uid` = `u`.`id` AND `p`.`f_principal` = '1'";
			$db->setQuery($query);
			$owner = $db->loadObject();
		}
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
			$uri = JUri::base();
		$link_activate = $uri.'index.php?option=com_sauto&view=process&task=activate&email='.$email.'&code='.$activationCode.'&email='.$email.' ';
		$text_subiect = 'Salut '.$rnames;
		$text_corp_mail = 'Bun venit pe site-ul www.siteauto.ro.<br />';
		if ($filiala == 1) {
			$text_corp_mail .= 'Pentru a putea folosi acest cont acesta va trebui aprobat de catre detinatorul adresei de email: '.$owner->email.' \n';
		} else {
			$text_corp_mail .= 'Pentru a activa acest cont te rugam sa accesezi acest link: '.$link_activate.' sau folositi acest cod: '.$activationCode.' \n'; 
		}
		$text_corp_mail .= 'Pentru a te autentifica foloseste adresa ta de email: '.$email.' iar parola este aceasta: '.$pass1.'.';
		$text_titlu_mail = 'Bun venit';
		
		
		$mailer->addRecipient($email);
		$body = $text_subiect; 
		$body .= $text_corp_mail;
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setSubject($text_titlu_mail);
		$mailer->setBody($body);
		$send = $mailer->Send();
		
		if ($filiala == 1) {
			//trimitem mail si detinatorului de companie
			$text_subiect = 'Salut '.$owner->reprezentant;
			$text_corp_mail = 'Pe site-ul www.siteauto.ro a fost inregistrata o noua firma cu acelasi cod fiscal ca si al firmei reprezentata de dvs<br /><br />';
			$text_corp_mail .= 'Daca aceasta firma noua apartine de dvs. va rugam sa activati contul acesteia din profilul dvs. de pe site.<br />'; 
			$text_corp_mail .= 'Va multumim.';
			$text_titlu_mail = 'Notificare';
			echo $text_corp_mail;
			
			$mailer->addRecipient($owner->email);
			$body = $text_subiect; 
			$body .= $text_corp_mail;
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->setSubject($text_titlu_mail);
			$mailer->setBody($body);
			$send = $mailer->Send();
			
		}

	##### end code 


	$app->redirect($link_redirect2, JText::_('SAUTO_SUCCESFULY_REGISTERED'));
	}
}
?>
