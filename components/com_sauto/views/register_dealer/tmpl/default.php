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
			//redirectionare spre pagina de profil
			$app =& JFactory::getApplication();
			$link_redirect = JRoute::_('index.php?option=com_sauto&view=profile');
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
	?> 
	</div>
				
	<div id="content9">
				<?php
		if ($uid == 0) {
			//vizitator
			require_once("components/com_sauto/assets/includes/register_dealer.php");
		} 
		?> 						
	</div>
				
					
</div>


