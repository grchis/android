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
class SautoViewRequest_detail extends JViewLegacy
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
		$query = "SELECT `titlu_anunt` FROM #__sa_anunturi WHERE `id` = '".$id."'";
		$db->setQuery($query);
		$title = $db->loadResult();
		$doc =& JFactory::getDocument();
		$meta_title = $title.JText::_('SAUTO_META_TITLE_REQUEST_DETAIL');	
		$site_title = JText::_('SAUTO_SITE_TITLE_REQUEST_DETAIL');			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
		//$this->assignRef('site_title', $title);
        parent::display($tpl);
    }//function
}//class
