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

$user =& JFactory::getUser();
$uid = $user->id;

$permit = 0;
if ($uid == 0) {
		//vizitator
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} else {
		//verificam tipul de cont
		$task =& JRequest::getVar( 'task', '', 'get', 'string' );
		$query = "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$tip_cont = $db->loadResult();
		if ($task == 'dealer') {
			//verificam daca e dealer
			if ($tip_cont == 1) {
				//e ok, setam alertele
				$permit = 1;
			} else {
				//redirectionam.....
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			}
		} elseif ($task == 'dealertemp') {
			//verificam daca e dealer
			if ($tip_cont == 1) {
				//e ok, setam alertele
				$permit = 1;
			} else {
				//redirectionam.....
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			}
		} else {
			//nedefinit, redirectionam
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
		//$app->redirect($link_ok, JText::_('SAUTO_ALERT_SET_SUCCESS'));
	}

if ($permit == 1) {
	//afisam formularul detaliat al alertelor
	$document = JFactory::getDocument ();
	$jslink = JUri::base().'components/com_sauto/assets/script/hcsticky.js';
	$document->addScript($jslink);
?>

<h1><?php echo $this->site_title; ?></h1>
<div id="wrapper9">
	<div id="side_bar">
	<?php 
	require_once("components/com_sauto/assets/includes/menu_d.php");
	?> 
	</div>
				
	<div id="content9">
		<?php
		if ($task == 'dealer') {
		require_once("components/com_sauto/assets/includes/setalert.php");
		} elseif ($task == 'dealertemp') {
		require_once("components/com_sauto/assets/includes/setalerttemp.php");	
		}
		?> 						
	</div>
				
					
</div>

<?php
}
?>
