<style type="text/css">
.sauto_main_left{
	width:100%;
	float:none!important;
}
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php
defined('_JEXEC') || die('=;)');
$link_redirect = JUri::base().'components/com_sauto/assets/ajax/orase.php';
$document = JFactory::getDocument ();

require("javascript_mobile.php");
$document->addScriptDeclaration ($js_code2);

require("register_form_mobile.php");
$document->addScriptDeclaration ($js_code);

require("verific_email_mobile.php");
$document->addScriptDeclaration ($js_code_email);

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();
$link_form = JRoute::_('index.php?option=com_sauto&view=registering');
JHTML::_('behavior.formvalidation');
$app = JFactory::getApplication();
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

?>
<div style="display:inline;">
	<div class="sauto_main_left">
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
					onKeyUp="javascript:verificEmailC(this.value)" 
					onClick="select()" 
					/>
			</div>
			
			<div id="sa_email_c"></div>
			
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
			
			<div class="sauto_form_label">
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			echo JText::_('SAUTO_ABONARE_NEWSLETTER'); ?>
			</div>
			
			<div class="sauto_form_label">
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			$link_term = JRoute::_('index.php?option=com_content&view=article&id='.$sconfig->link_terms);
			echo '<a href="'.$link_term.'" class="sauto_link_terms" target="_blank">'.JText::_('SAUTO_AGREE_WITH_TERMS').'</a>'; ?>
			</div>
			
			<div class="sauto_form_label sa_obligatoriu">
				<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
			</div>
	
			<br />
			<input type="hidden" name="register_type" value="customer" />
			<div><input type="submit" value="<?php echo JText::_('SAUTO_FORM_REGISTER_BUTTON'); ?>" class="sauto_button validate" /></div>

		</form>
	</div>
	
	<div class="sauto_main_right">
		<?php echo $login_article; ?>
	</div>
</div>

<div style="clear:both;"></div>

<br /><br />
<script>
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').remove();
		document.getElementsByTagName('h1')[0].remove();
		document.getElementsByName('t1')[0].text = Client;
		document.getElementsByName('t2')[0].text = firma;
</script>
