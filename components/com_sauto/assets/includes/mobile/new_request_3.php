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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

//echo '>>>> '.$request.'<br />';

$document = JFactory::getDocument ();

require("javascript.php");
$document->addScriptDeclaration ($js_code2);

require("register_form.php");
$document->addScriptDeclaration ($js_code);

$document->addStyleSheet( 'components/com_sauto/assets/tabs.css' );

$link_form = JRoute::_('index.php?option=com_sauto&view=register_v');
JHTML::_('behavior.formvalidation');
$app =& JFactory::getApplication();
$names = $app->getUserState('names');
$email = $app->getUserState('email');
$phone = $app->getUserState('phone');

if ($email != '') {
	$v_mail = $email;
} else {
	$v_mail = JText::_('SAUTO_EMAIL_CONFIDENTIAL');
}

if ($phone != '') {
	$v_phone = $phone;
} else {
	$v_phone = JText::_('SAUTO_TEL_CONF');
}

$request =& JRequest::getVar( 'request', '', 'post', 'string' );

if ($request == 1) {
	require("add_request_1.php");
} elseif ($request == 2) {
	require("add_request_2.php");
} elseif ($request == 3) {
	require("add_request_3.php");
} elseif ($request == 4) {
	require("add_request_4.php");
} elseif ($request == 5) {
	require("add_request_5.php");
} elseif ($request == 6) {
	require("add_request_6.php");
} elseif ($request == 7) {
	require("add_request_7.php");
} elseif ($request == 8) {
	require("add_request_8.php");
} elseif ($request == 9) {
	require("add_request_9.php");
}
echo JText::_('SAUTO_STEP_3');
?>
<hr />

<div style="min-height:1650px;">
<ul class="tabs">
	<li>
		<input type="radio" checked name="tabs" id="tab1">
		<label for="tab1"><?php echo JText::_('SAUTO_TABS_AUTH_CLIENT'); ?></label>
		<div id="tab-content1" class="tab-content animated fadeIn">
			<?php 
jimport('joomla.application.module.helper');
$modules = JModuleHelper::getModules($sconfig->login_module2);
	foreach($modules as $module) {
		echo JModuleHelper::renderModule($module);
	}
			?>
		</div>
	</li>
	<li>
		<input type="radio" name="tabs" id="tab2">
		<label for="tab2"><?php echo JText::_('SAUTO_TABS_CLIENT'); ?></label>
		<div id="tab-content2" class="tab-content animated fadeIn">
			<?php //require('register_dealer.php'); ?>
			<form action="<?php echo $link_form; ?>" method="post" class="form-validate">
			<?php echo 
			JHtml::_( 'form.token' ); 
			?>
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_NAME'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
				
			<input type="text" name="names" value="<?php echo $names; ?>" class="required sa_inputbox" />
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
				<input type="text" 
					name="email" 
					value="<?php echo $v_mail; ?>" 
					class="required validate-email sa_inputbox" 
					onBlur="javascript:verificEmail(this.value)" 
					onClick="select()" 
					/>
			</div>
			<div id="sa_email"></div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PASSWORD'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div><input type="password" name="pass1" value="" class="required sa_inputbox" /></div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PASSWORD_RE'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div><input type="password" name="pass2" value="" class="required sa_inputbox" /></div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PHONE'); ?>
			</div>
			
			<div>
				<input type="text" 
					name="phone" 
					value="<?php echo $v_phone; ?>" 
					class="required sa_inputbox" 
					onClick="select()"
					/>
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_REGION'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'">'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_CITY'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div id="sa_city">
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
			</div>
			
			<?php if ($sconfig->enable_captcha == 1) { 
			require("components/com_sauto/assets/libraries/recaptchalib.php");
			$publickey = $sconfig->public_key;
			
			?>
			<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_CAPTCHA'); ?></div>
			<div><?php echo recaptcha_get_html($publickey); ?></div>
			<?php } ?>
			
			<div>
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			echo JText::_('SAUTO_ABONARE_NEWSLETTER'); ?>
			</div>
			
			<div>
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			$link_term = JRoute::_('index.php?option=com_content&view=article&id='.$sconfig->link_terms);
			echo '<a href="'.$link_term.'" class="sauto_link_terms">'.JText::_('SAUTO_AGREE_WITH_TERMS').'</a>'; ?>
			</div>
			<br />
			<input type="hidden" name="register_type" value="customer" />
			
			<div class="sauto_form_label sa_obligatoriu">
				<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
			</div>
	
			<div><input type="submit" value="<?php echo JText::_('SAUTO_FORM_REGISTER_BUTTON'); ?>" class="sauto_button validate" /></div>

			</form>
		</div>
	</li>
</ul>
</div>
