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
class SautoViewEdit_profile extends JViewLegacy
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

		$task =& JRequest::getVar( 'task', '', 'get', 'string' );
		switch ($task) {
			case '':
			default:
				$tpl = null;	
				$doc =& JFactory::getDocument();
				$meta_title = JText::_('SAUTO_META_TITLE_EDIT_PROFILE_C_PAGE');	
				$site_title = JText::_('SAUTO_SITE_TITLE_EDIT_PROFILE_C_PAGE');			
				$doc->setTitle($meta_title);
				$this->assignRef('site_title', $site_title);
			break;
			case 'alert_edit':
				$tpl = 'alert_edit';	
				$doc =& JFactory::getDocument();
				$meta_title = JText::_('SAUTO_META_TITLE_EDIT_PROFILE_ALERT_EDIT_PAGE');	
				$site_title = JText::_('SAUTO_SITE_TITLE_EDIT_PROFILE_ALERT_EDIT_PAGE');			
				$doc->setTitle($meta_title);
				$this->assignRef('site_title', $site_title);
			break;
			case 'alert_enable':
				$tpl = 'alert_enable';	
				$doc =& JFactory::getDocument();
				$meta_title = JText::_('SAUTO_META_TITLE_EDIT_PROFILE_ALERT_ENABLE_PAGE');	
				$site_title = JText::_('SAUTO_SITE_TITLE_EDIT_PROFILE_ALERT_ENABLE_PAGE');			
				$doc->setTitle($meta_title);
				$this->assignRef('site_title', $site_title);
			break;
			case 'alert_save':
				$tpl = 'alert_save';
			break;
			case 'edit_filiala':
				$tpl = 'edit_filiala';
			break;
			case 'editing_filiala':
				$tpl = 'editing_filiala';
			break;
			case 'delete_filiala':
				$tpl = 'delete_filiala';
			break;
			case 'aprove_filiala':
				$tpl = 'aprove_filiala';
			break;
			case 'categ_act':
				$tpl = 'categ_act';
				$doc =& JFactory::getDocument();
				$meta_title = JText::_('SAUTO_META_TITLE_EDIT_PROFILE_SET_CATEG_ACT_PAGE');	
				$site_title = JText::_('SAUTO_SITE_TITLE_EDIT_PROFILE_SET_CATEG_ACT_PAGE');			
				$doc->setTitle($meta_title);
				$this->assignRef('site_title', $site_title);
			break;
		}
		
        parent::display($tpl);
    }//function
}//class
