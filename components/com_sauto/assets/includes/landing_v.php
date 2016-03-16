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
$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
$db = JFactory::getDbo();
//get id articol
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();
?>
<div style="display:inline;">
	<div class="sauto_main_left">
		<div class="sa_logo_start">
			<img src="<?php echo $img_path; ?>logo_client_mare.png" />
		</div>
		
		<div class="sauto_login_title">
			<?php echo JText::_('SAUTO_ACOUNT_EXIST'); ?>
		</div>
		
		<div class="sauto_login_module">
			<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
		</div>
			
		<hr class="sauto_hr" />
			
		<div class="sauto_login_title">
			<?php echo JText::_('SAUTO_ACOUNT_NOT_EXIST'); ?>
		</div>
			
		<div class="sauto_login_module">
			<?php
			$link_register = JRoute::_('index.php?option=com_sauto&view=register_type');
			?>
			<form action="<?php echo $link_register; ?>" method="post">
			<input type="submit" value="<?php echo JText::_('SA_MOD_CREATE_ACOUNT'); ?>" class="sauto_button" />
			</form>
		</div>
	</div>
	<div class="sauto_main_right">
		<div class="sauto_right_text">
			<?php echo $login_article; ?>
		</div>
	</div>
</div>
<div style="clear:both;"></div>

