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
$image_path = JURI::base()."components/com_sauto/assets/";
//get avatar
$db = JFactory::getDbo();
$user = JFactory::getUser();
$uid = $user->id;
$query = "SELECT `poza` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$avatar = $db->loadResult();
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
	<?php $link_add_request = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
	<a href="<?php echo $link_add_request; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_add_request.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_ADD_REQUEST'); ?>
	</a>
</div>


<div class="sa_menu_div">
	<?php $link_garage = JRoute::_('index.php?option=com_sauto&view=garaj'); ?>
	<a href="<?php echo $link_garage; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_garage.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_GARAGE'); ?>
	</a>
</div>



<div class="sa_menu_div">
	<?php $link_search = JRoute::_('index.php?option=com_sauto&view=search'); ?>
	<a href="<?php echo $link_search; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_search.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_SEARCH'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_my_request = JRoute::_('index.php?option=com_sauto&view=my_request'); ?>
	<a href="<?php echo $link_my_request; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_my_request.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_MY_REQUEST'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_final_request = JRoute::_('index.php?option=com_sauto&view=final_request'); ?>
	<a href="<?php echo $link_final_request; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_final_request.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_FINAL_REQUEST'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_alerts = JRoute::_('index.php?option=com_sauto&view=alerts'); ?>
	<a href="<?php echo $link_alerts; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_alerts.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_ALERTS'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_edit_profile = JRoute::_('index.php?option=com_sauto&view=edit_profile'); ?>
	<a href="<?php echo $link_edit_profile; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_edit_profile.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_EDIT_PROFILE'); ?>
	</a>
</div>

<div class="sa_menu_div">
	<?php $link_logout = JRoute::_('index.php?option=com_sauto&view=logout'); ?>
	<a href="<?php echo $link_logout; ?>" class="sa_lk_profile">
		<img src="<?php echo $img_path; ?>icon_logout.png" border="0" />
		<br />
		<?php echo JText::_('SA_MENU_USERS_LOGOUT'); ?>
	</a>
</div>

</div>
</center>
