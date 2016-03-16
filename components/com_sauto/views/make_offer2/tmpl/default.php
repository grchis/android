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
			require_once("components/com_sauto/assets/includes/make_offer2.php");
		?> 						
	</div>
				
					
</div>


