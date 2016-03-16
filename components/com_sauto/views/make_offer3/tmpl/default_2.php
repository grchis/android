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
$link_redirect = JRoute::_('index.php?option=com_sauto&view=make_offer3&step=2');
$link_redirect2 = JRoute::_('index.php?option=com_sauto&view=make_offer3&step=1');
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
	jimport('joomla.user.helper');
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
	$db->query();
	
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
		
	$query = "INSERT INTO #__sa_profiles 
				(`uid`, `reprezentant`, `telefon`, `judet`, `localitate`, `tip_cont`, `sediu`, `companie`, `cod_fiscal`, `nr_registru`, 
				`abonament`, `alerte`, `cod_postal`, `f_principal`) 
			VALUES 
				('".$last_id."', '".$rnames."', '".$phone."', '".$judet_id."', '".$new_city_id."', '1', '".$sediu."', '".$company_name."', 
				'".$cod_fiscal."', '".$nr_reg."', '1', '".$new_value."', '".$cp."', '".$fil."')";
	$db->setQuery($query);
	$db->query();
	
	$app->setUserState('rnames', '');
	$app->setUserState('email', $email);
	$app->setUserState('phone', '');
	$app->setUserState('cod_fiscal', '');
	$app->setUserState('nr_reg', '');
	$app->setUserState('company_name', '');
	$app->setUserState('password', $pass1);
	$app->setUserState('cp', '');
	
	//adaugam creditele initiale
	$query = "INSERT INTO #__sa_financiar (`uid`, `credite`) VALUES ('".$last_id."', '".$credite_initiale."')";
	$db->setQuery($query);
	$db->query();
	
	//create user folder
	$folder_path = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id;
	JFolder::create($folder_path);
	//copy index.html
	$src = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.'index.html';
	$dest = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$last_id.DS.'index.html';
	JFile::copy($src, $dest);
	
	


	//$credentials = array();
	//$credentials['username'] = $email;
	//$credentials['password'] = $pass1;
	//$options = array();
	//$app->login( $credentials, $options );
	
	//$user =& JFactory::getUser();
	
	$id_anunt = $app->getUserState('id_anunt');
	if ($id_anunt != '') {
		$mesaj = $app->getUserState('mesaj');
		$pret = $app->getUserState('pret');
		$moneda = $app->getUserState('moneda');
	} else {
	$filtru = array('RO', 'ro', 'Ro', 'rO');
	$cf = str_ireplace($filtru, '', $cod_fiscal);

	//obtin datele anuntului
	
	$query = "SELECT * FROM #__sa_temp_firme WHERE `cui` = '".$cf."'";
	$db->setQuery($query);
	$anunt = $db->loadObject();
	$id_anunt = $anunt->id_anunt;
	$mesaj = $anunt->mesaj;
	$pret = $anunt->pret;
	$moneda = $anunt->moneda;
	}
	$query = "SELECT `oferte`, `proprietar` FROM #__sa_anunturi WHERE `id` = '".$id_anunt."'";
	$db->setQuery($query);
	$list = $db->loadObject();
	$new_oferte = $list->oferte + 1;
	//echo '>>>> '.$list->oferte.' >>> '.$new_oferte.' >>> '.$list->proprietar;
	
	$time = time();
	$curentDate = date('Y-m-d H:i:s', $time);
	
	//verificam alertele proprietarului
		$query = "SELECT `p`.`fullname`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$list->proprietar."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		//echo '>>>> '.$rez->alerte.'<br />';
		$alerte = explode(",", $rez->alerte);
		//print_r($alerte);
		//echo '<br />';
		if (in_array("1-1", $alerte)) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->getValue( 'config.mailfrom' ),
				$config->getValue( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);

			$body   = "Salut ".$rez->fullname."<br />";
			$body .= "Ati primit o oferta noua, va rugam accesati acest link pentru a vedea oferta: <a href=\"".$oferta."\">".$oferta."</a><br />";
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->setSubject('Oferta noua!');
			$mailer->setBody($body);
			$send = $mailer->Send();
		}
			
	//scadem 2 credite
	
	//adaugam oferta noua
	$query = "INSERT INTO #__sa_raspunsuri (`anunt_id`, `proprietar`, `firma`, `mesaj`, `data_adaugarii`, `status_raspuns`, `pret_oferit`, `moneda`) 
	VALUES ('".$id_anunt."', '".$list->proprietar."', '".$last_id."', '".$mesaj."', '".$curentDate."', '0', '".$pret."', '".$moneda."')";
	$db->setQuery($query);
	$db->query();
	$last_rasp_id = $db->insertid();
	
	//actualizam partea financiara
	$new_credit = $credite_initiale - 2;
	$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$last_id."'";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__sa_financiar_det (`uid`, `anunt_id`, `raspuns_id`, `credite`) VALUES ('".$last_id."', '".$id_anunt."', '".$last_rasp_id."', '2')";
	$db->setQuery($query);
	$db->query();
	
	$query = "UPDATE #__sa_anunturi SET `oferte` = '".$new_oferte."' WHERE `id` = '".$id_anunt."'";
	$db->setQuery($query);
	$db->query();
	
	$query = "DELETE FROM #__sa_temp_firme WHERE `firma` = '".$company_name."'";
	$db->setQuery($query);
	$db->query();
	
	
	
	if ($filiala == 1) {
			$query = "SELECT `u`.`email`, `p`.`reprezentant` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`cod_fiscal` = '".$cod_fiscal."' AND `p`.`uid` = `u`.`id` AND `p`.`f_principal` = '1'";
			$db->setQuery($query);
			$owner = $db->loadObject();
		}
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->getValue( 'config.mailfrom' ),
			$config->getValue( 'config.fromname' ) );
		$link_activate = 'http://www.siteauto.ro/final/index.php?option=com_sauto&view=process&task=activate&code='.$activationCode.'&email='.$email.' ';
		$text_subiect = 'Salut '.$rnames;
		$text_corp_mail = 'Bun venit pe site-ul www.siteauto.ro.\n\n';
		if ($filiala == 1) {
			$text_corp_mail .= 'Pentru a putea folosi acest cont acesta va trebui aprobat de catre detinatorul adresei de email: '.$owner->email.' \n';
		} else {
			$text_corp_mail .= 'Pentru a activa acest cont te rugam sa accesezi acest link: '.$link_activate.' sau folositi acest cod: '.$activationCode.' \n'; 
		}
		$text_corp_mail .= 'Pentru a te autentifica foloseste adresa ta de email: '.$email.' iar parola este aceasta: '.$pass1.'.';
		$text_titlu_mail = 'Bun venit';
		
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->addRecipient($email);
		$body = $text_subiect; 
		$body .= $text_corp_mail;
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
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->addRecipient($owner->email);
			$body = $text_subiect; 
			$body .= $text_corp_mail;
			$mailer->setSubject($text_titlu_mail);
			$mailer->setBody($body);
			$send = $mailer->Send();
			
		}
	//redirectionam....
	$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
	
	$app->redirect($link_ok, JText::_('SAUTO_SUCCESFULY_REGISTERED'));
	}
}
?>
