<?php

	// no direct access
	defined('_JEXEC') or die;
	
	JHtml::_('behavior.keepalive');

?>
<?php if ($type == 'logout') : ?>

<form action="index.php" method="post" id="login-form">
		<div class="logout-button">
				<?php if ($params->get('greeting')) : ?>
				<div class="login-greeting">
						<?php if($params->get('name') == 0) : {
					echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
				} else : {
					echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('username'));
				} endif; ?>
				</div>
				<?php endif; ?>
				<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
		</div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
</form>
<?php else : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
		<fieldset class="userdata">
				<p id="form-login-username">
						<div class="sauto_form_label"><?php echo JText::_('SA_MOD_LOGIN_EMAIL') ?></div>
						<input id="modlgn-username" type="text" name="username" class="inputbox"  size="24" />
				</p>
				<p id="form-login-password">
						<div  class="sauto_form_label"><?php echo JText::_('JGLOBAL_PASSWORD') ?></div>
						<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="24"  />
				</p>
<div style="display:block;">
				<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	<div class="sauto_div_remember">
		<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
		<label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
	</div>
				<?php endif; ?>
	<div class="sauto_div_recover" style="position:relative;float:right;margin-right:75px;margin-top:7px;">
		<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
	</div>
</div>
<div style="clear:both;"></div>
<div style="display:inline;">
	<div style="postition:relative;float:left;">
			<input type="submit" name="Submit" class="sauto_button sauto_half" value="<?php echo JText::_('JLOGIN') ?>" />
	</div>
	<div style="postition:relative;float:left;">
		<?php $link_register = JRoute::_('index.php?option=com_sauto&view=reg_form'); ?>
		<a href="<?php echo $link_register; ?>" class="sauto_button_half" />
		<?php echo JText::_('SA_MOD_CREATE_ACOUNT'); ?>
		</a>
	</div>
</div>
<div style="clear:both;"></div>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.login" />
				<input type="hidden" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>
				<gavern:fblogin> <span id="fb-auth"><small>fb icon</small><?php echo JText::_('TPL_GK_LANG_FB_LOGIN_TEXT'); ?></span> </gavern:fblogin>
		</fieldset>
		<div class="posttext"> <?php echo $params->get('posttext'); ?> </div>
</form>
<?php endif; ?>
