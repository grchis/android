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


//jimport('joomla.application.component.view');

/**
 * HTML View class for the sauto Component.
 *
 * @package    sauto
 */
class SautoViewEditing_profile extends JViewLegacy
{
    /**
     * sauto view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
	$app =& JFactory::getApplication();
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$user =& JFactory::getUser();
	$uid = $user->id;
	if ($uid == 0) {
		//vizitator
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} else {
		$db = JFactory::getDbo();
		$query = "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$type = $db->loadResult();
		if ($type == 0) {
			//cont customer
			$tpl = '0';
		} elseif ($type == 1) {
			//cont dealer
			$tpl = '1';
		} else {
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
        parent::display($tpl);
	}
    }//function
}//class
