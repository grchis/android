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
$document = JFactory::getDocument ();
$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'includes'.DS;

require($path."toggle_js.php");
require($path."javascript.php");
$document->addScriptDeclaration ($js_code);

$document->addScriptDeclaration ($js_code2);

$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
?>

<h1><?php echo $this->site_title; ?></h1>
<div id="wrapper9">
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
			require_once("components/com_sauto/assets/includes/edit_profile_c.php");
		} elseif ($tip == 1) {
			//dealer
			require_once("components/com_sauto/assets/includes/edit_profile_d.php");
		}
		?> 						
	</div>
				
					
</div>


