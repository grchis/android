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
class SautoViewSearch_request2 extends JViewLegacy
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
		$request =& JRequest::getVar( 'request', '', 'post', 'string' );
		$db = JFactory::getDbo();
		$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$request."'";
		$db->setQuery($query);
		$tip_anunt = $db->loadResult();
				
		$doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_SEARCH_REQUEST2').' '.$tip_anunt;	
		$site_title = JText::_('SAUTO_SITE_TITLE_SEARCH_REQUEST2').' '.$tip_anunt;			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        parent::display($tpl);
    }//function
}//class
