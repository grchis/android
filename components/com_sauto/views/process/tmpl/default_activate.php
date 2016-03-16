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
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
?>


<div id="wrapper9">
<h1><?php echo $this->site_title; ?></h1>
	<div id="side_bar">
	<?php 
	$user =& JFactory::getUser();
	$uid = $user->id;
		if ($uid == 0) {
			//vizitator
			require_once("components/com_sauto/assets/includes/menu_v.php");
		} else {
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
	?> 
	</div>
				
	<div id="content9">
		<?php			
		//preluam restul de variabile.....
		//echo 'obtinem....';
		$code =& JRequest::getVar( 'code', '', 'get', 'string' );
		$email =& JRequest::getVar( 'email', '', 'get', 'string' );
		echo '1> cod > '.$code .' si email > '.$email;
			if ($code == '' ) {
			$code =& JRequest::getVar( 'code', '', 'post', 'string' ); 
			$email =& JRequest::getVar( 'email', '', 'post', 'string' );
			}
		
		
		//verificam daca se potriveste codul:
		$query = "SELECT `u`.`id`, `p`.`activation_code`, `p`.`incercari`, `p`.`reprezentant` FROM #__sa_profiles AS `p` 
			JOIN #__users AS `u` ON `u`.`id` = `p`.`uid` AND `u`.`email` = '".$email."'";
		$db->setQuery($query);
		//echo '<br />';
		//echo $query;
		//echo '<br />';
		$rez = $db->loadObject();
		//print_r($rez); echo '<br />';
		//verificam 
		if ($rez->activation_code == $code) {
			//cod corect, validam
			//deblocam contul
			$query = "UPDATE #__users SET `block` = '0' WHERE `id` = '".$rez->id."'";
			$db->setQuery($query);
			$db->query();
			$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_UNLOCK_ACCOUNT'));	
		} else {
			//cod incorect, afisam formularul...
			//incrementam incercarile
			if ($rez->incercari >= 5) {
				echo '<div  class="sauto_form_important">'.JText::_('SAUTO_BLOCKED_ACTIVATION_CODE').'</div>';
			} else {
				if ($rez->incercari == 0) {
					$new_i = 1;
				} else {
					$new_i = $rez->incercari + 1;
				}
				//echo '>>>'.$new_i;
				$query = "UPDATE #__sa_profiles SET `incercari` = '".$new_i."' WHERE `uid` = '".$rez->id."'";
				$db->setQuery($query);
				$db->query();
				$link_form = JRoute::_('index.php?option=com_sauto&view=process&task=activate');
				echo '<div  class="sauto_form_important">'.JText::_('SAUTO_WRONG_ACTIVATION_CODE').'</div>';
			?>
<form action="<?php echo $link_form; ?>" method="post">
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
	</div>
	<div>
		<input type="text" name="email" value="" class="sa_inputbox" />
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_ACTIVATION_CODE'); ?>
	</div>
	
	<div>
		<input type="text" name="code" value="" class="sa_inputbox" />
	</div>
	<br />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_FORM_VALIDATE_ACCOUNT_BUTTON'); ?>" class="sauto_button validate" onclick="this.form;return true;" />
	</div>
</form>
			<?php
			}
		}
		?> 						
	</div>
				
					
</div>


