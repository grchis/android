<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');

?>
<?php if(JRequest::getCmd('tmpl') !== 'blankpage') : ?>

<section class="login<?php echo $this->pageclass_sfx?>">
          <?php 
		if(
			$this->params->get('show_page_heading') || 
			(
				($this->params->get('logindescription_show') == 1 && 
				str_replace(' ', '', $this->params->get('login_description')) != ''
			) || 
			$this->params->get('login_image') != '')
		) : ?>
          <header>
                    <?php if ($this->params->get('show_page_heading')) : ?>
                    <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
                    <?php endif; ?>
                    <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
                    <div>
                              <?php endif ; ?>
                              <?php if (($this->params->get('login_image')!='')) :?>
                              <img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USERS_LOGIN_IMAGE_ALT')?>"/>
                              <?php endif; ?>
                              <?php if($this->params->get('logindescription_show') == 1) : ?>
                              <div><?php echo $this->params->get('login_description'); ?></div>
                              <?php endif; ?>
                              <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
                    </div>
                    <?php endif ; ?>
          </header>
          <?php endif; ?>
          <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" id="com-login-form">
                    <fieldset>
                              <?php foreach ($this->form->getFieldset('credentials') as $field): ?>
                              <?php if (!$field->hidden): ?>
                              <div class="login-fields"> <?php echo $field->label; ?> <?php echo $field->input; ?> </div>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              
                              <?php if ($this->tfa): ?>
                              	<?php echo $this->form->getField('secretkey')->input; ?>
								<?php echo $this->form->getField('secretkey')->label; ?>		
                  			<?php endif; ?>
                  
                  			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                  				<div class="login-fields">
                  				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
                  				<label><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
                  				</div>
                  			<?php endif; ?>
                              
                              <button type="submit" class="button"><?php echo JText::_('JLOGIN'); ?></button>
                              <gavern:fblogin>
                              <span id="fb-auth"><small>fb icon</small><?php echo JText::_('TPL_GK_LANG_FB_LOGIN_TEXT'); ?></span>
                              <gavern:fblogin>
                              <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
                              <?php echo JHtml::_('form.token'); ?>
                    </fieldset>
          </form>
          <ul>
                    <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a> </li>
                    <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a> </li>
                    <?php
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
                    <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a> </li>
                    <?php endif; ?>
          </ul>
</section>
<?php else : ?>
<section class="login">
          <header>
                    <h1> <?php echo JText::_('TPL_GK_LANG_LOGIN_AREA'); ?>
                              <?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
                              <?php echo JText::_('TPL_GK_LANG_LOGIN_OR'); ?> <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&tmpl=blankpage'); ?>"> <?php echo JText::_('TPL_GK_LANG_REGISTER_AREA'); ?></a>
                              <?php endif; ?>
                    </h1>
          </header>
          <?php
          $usersConfig = JComponentHelper::getParams('com_users');
          if ($usersConfig->get('allowUserRegistration')) : ?>
          <div>
                    <h2><?php echo JText::_('TPL_GK_LANG_LOGIN_HEADER1'); ?></h2>
                    <p><?php echo JText::_('TPL_GK_LANG_LOGIN_TEXT1'); ?></p>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&tmpl=blankpage'); ?>" class="readon"> <?php echo JText::_('TPL_GK_LANG_REGISTER_AREA'); ?></a> </div>
          <?php endif; ?>
          <div>
                    <h2><?php echo JText::_('TPL_GK_LANG_LOGIN_HEADER2'); ?></h2>
                    <p><?php echo JText::_('TPL_GK_LANG_LOGIN_TEXT2'); ?></p>
                    <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" id="com-login-form">
                              <fieldset>
                                        <?php foreach ($this->form->getFieldset('credentials') as $field): ?>
                                        <?php if (!$field->hidden): ?>
                                        <div class="login-fields"> <?php echo str_replace('>', ' placeholder="' . strip_tags($field->label) . '">', $field->input); ?> </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="button"><?php echo JText::_('JLOGIN'); ?></button>
                                        <gavern:fblogin>
                                        <span id="fb-auth"><small>fb icon</small><?php echo JText::_('TPL_GK_LANG_FB_LOGIN_TEXT'); ?></span>
                                        <gavern:fblogin>
                                        <input type="hidden" name="return" value="<?php echo base64_encode('index.php?option=com_users&view=login'); ?>" />
                                        <?php echo JHtml::_('form.token'); ?>
                              </fieldset>
                    </form>
                    <ul>
                              <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a> </li>
                              <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"> <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a> </li>
                    </ul>
                    
          </div>
          
</section>
<div class="jcancel"><span><?php echo JText::_('COM_USERS_OR');?> <a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>" ><?php echo JText::_('JCANCEL');?></a></span></div>
<?php endif; ?>
