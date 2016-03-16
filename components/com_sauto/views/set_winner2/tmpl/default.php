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

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

$rasp_id =& JRequest::getVar( 'rasp_id', '', 'post', 'string' );
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$app->setUserState('rasp_id', $rasp_id);
$app->setUserState('anunt_id', $anunt_id);
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
		<table class="sa_table_class">
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<h2><?php echo JText::_('SAUTO_VIZITATOR_AUTH'); ?></h2>
		<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module4);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
			</td>
			</tr>
		</table>		
	</div>
				
					
</div>

