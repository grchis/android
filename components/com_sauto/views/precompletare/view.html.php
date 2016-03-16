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
class SautoViewPrecompletare extends JViewLegacy
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
		
		$db = JFactory::getDbo();
		$user =& JFactory::getUser();
		$uid = $user->id;
		$app =& JFactory::getApplication();
		if ($uid == 0) {
			//vizitator
			$link_redirect = JRoute::_('index.php');
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} else {
			$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$tip = $db->loadResult();
				if ($tip == 0) {
				//client
				$anunt_type =& JRequest::getVar( 'request', '', 'post', 'string' );
		if ($anunt_type == 1) {
			$tpl = '1';
		} elseif ($anunt_type == 2) {
			$tpl = '2';
		} elseif ($anunt_type == 3) {
			$tpl = '3';
		} elseif ($anunt_type == 4) {
			$tpl = '4';
		} elseif ($anunt_type == 5) {
			$tpl = '5';
		} elseif ($anunt_type == 6) {
			$tpl = '6';
		} elseif ($anunt_type == 7) {
			$tpl = '7';
		} elseif ($anunt_type == 8) {
			$tpl = '8';
		} elseif ($anunt_type == 9) {
			$tpl = '9';
		}
				} else {
					$link_redirect = JRoute::_('index.php');
					$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));	
				}
		}


		
        parent::display($tpl);
    }//function
    


}//class
