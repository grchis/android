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
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} else {
			//verificare tip utilizator
			$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$tip = $db->loadResult();
			if ($tip == 0) {
				//client
				require_once("components/com_sauto/assets/includes/menu_c.php");
			} elseif ($tip == 1) {
				//dealer
				require_once("components/com_sauto/assets/includes/menu_d.php");
			} else {
				//nedefinit, redirectionam la prima pagina
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} 
		}
	?> 
	</div>
				
	<div id="content9">
		<?php
		//verificare tip utilizator
		if ($tip == 0) {
			//client
			require_once("components/com_sauto/assets/includes/all_comments_c.php");
		} elseif ($tip == 1) {
			//dealer
			require_once("components/com_sauto/assets/includes/all_comments_d.php");
		}
		?> 						
	</div>
				
					
</div>

