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
class SautoViewAll extends JViewLegacy
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
		$id =& JRequest::getVar( 'id', '', 'get', 'string' );
		$db = JFactory::getDbo();
		$query = "SELECT `tip_cont`, `fullname` FROM #__sa_profiles WHERE `uid` = '".$id."'";
		$db->setQuery($query);
		$tip = $db->loadObject();
		if ($tip->tip_cont == 0) {
		$doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_ALL_REQUESTS').' '.$tip->fullname;	
		$site_title = JText::_('SAUTO_SITE_TITLE_ALL_REQUESTS').' '.$tip->fullname;			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        parent::display($tpl);
		} else {
			$app =& JFactory::getApplication();
			$link_redirect = JRoute::_('index.php?option=com_sauto');
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} 
    }//function
}//class
