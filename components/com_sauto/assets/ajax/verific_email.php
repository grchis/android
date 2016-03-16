<?php
define( '_JEXEC', 1);
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', realpath(dirname(__FILE__) .'/../../../..' ) );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$user =JFactory::getUser();
$session =& JFactory::getSession();
$db = JFactory::getDBO();	

$lang =& JFactory::getLanguage();
$lang->load('com_sauto',JPATH_ROOT);

if (isset($_POST['email'])) {
	$email = trim(stripslashes($_POST['email']));          // Preia datele primite
    //$content .= 'Textul "<i>'.$region.'"</i> contine '. strlen($region). ' caractere si '. str_word_count($region, 0). ' cuvinte.';
    //get region id
    $query = "SELECT count(*) FROM #__users WHERE `email` = '".$email."'";
    $db->setQuery($query);
    $total = $db->loadResult();
	if ($total == 0) {
		if ($email == JText::_('SAUTO_EMAIL_CONFIDENTIAL')) {
			$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_NON_EXISTENT').'</span>';
		} elseif ($email == '') {
			$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_NON_VALUE').'</span>';
		} else {
			//verificam tipul de email
			//verificam daca avem in componenta caracterul @
			if (strpos($email,'@') !== false) {
				//true
				$mail = explode("@", $email);
				if (strpos($mail[1],'.') !== false) {
					$mail2 = explode(".", $mail[1]);
					//$content = $mail2[0].' -- '.$mail2[1];
					if ($mail2[1] == '') {
						$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_FARA_DOMENIU').'</span>';
					} else {
						if (strlen($mail2[1]) == 1) {
							//false
							$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_FARA_DOMENIU').'</span>';
						} else {
							//true
							$content .= '<span class="sa_mail_nou">'.JText::_('SAUTO_MAIL_NOU').'</span>';
						}
					}
				} else {
					$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_FARA_DOMENIU').'</span>';
				}
			} else {
				//false
				$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_INCOMPLETE').'</span>';
			}
			
		}
	} else {
		$content = '<span class="sa_mail_exist">'.JText::_('SAUTO_MAIL_EXISTENT').'</span>';
	}

}

print $content;
?>