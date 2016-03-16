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
$img_path = JURI::base()."components/com_sauto/assets/images/";
JHTML::_('behavior.tooltip');
?>
<center>
<div class="sa_main_menu">
	<div class="sa_menu_div">
	<?php $link_profile = JRoute::_('index.php?option=com_sauto'); ?>
	<a href="<?php echo $link_profile; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_home.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_HOME'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_request = JRoute::_('index.php?option=com_sauto&view=new_request'); ?>
	<a href="<?php echo $link_request; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_add_request.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_ADD_REQUEST'); ?>
	</a>
</div>


<div class="sa_menu_div">
	<?php $link_garage = JRoute::_('index.php?option=com_sauto&view=garaj'); ?>
	<?php
	echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_garage_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_GARAGE'); ?>
</div>



<div class="sa_menu_div">
	<?php
	echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_search_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_USERS_SEARCH'); ?>
</div>

<div class="sa_menu_div">
	<?php
	echo JHTML::tooltip(JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_my_request_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_USERS_MY_REQUEST'); ?>
</div>

<div class="sa_menu_div">
	<?php
	echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_final_request_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_USERS_FINAL_REQUEST'); ?>
</div>

<div class="sa_menu_div">
	<?php
	echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_edit_profile_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_USERS_EDIT_PROFILE'); ?>
</div>

<div class="sa_menu_div">
	<?php
	echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE'), JText::_('SA_TOOLTIP_TITLE'), $img_path.'icon_logout_gray.png', '', '', false);
	?>
		<br />
		<?php echo JText::_('SA_MENU_USERS_LOGOUT'); ?>
</div>

</div>

</center>
