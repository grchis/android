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
class SautoViewPay extends JViewLegacy
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
		$tpl = null;
		$task =& JRequest::getVar( 'task', '', 'get', 'string' );
		switch ($task) 
		{
		case '':
		default:
		
		$doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_PAY');	
		$site_title = JText::_('SAUTO_SITE_TITLE_PAY');			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        break;
        case 'paypal_cancel':
        $tpl = 'paypal_cancel';
        $doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_PAY_PP_CANCEL');	
		$site_title = JText::_('SAUTO_SITE_TITLE_PAY_PP_CANCEL');			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        break;
        case 'return_url':
        $tpl = 'return_url';
        $doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_PAY_PP_RETURN');	
		$site_title = JText::_('SAUTO_SITE_TITLE_PAY_PP_RETURN');			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        break;
        case 'notify_url':
        $tpl = 'notify_url';
        break;
        case 'card_redirect':
        $tpl = 'card_redirect';
        break;
        case 'cc_confirm':
         $tpl = 'cc_confirm';
        break;
        case 'cc_return':
         $tpl = 'cc_return';
        break;
        case 'proforma':
        $tpl = 'proforma';
        break;
        case 'load_file':
        $tpl = 'load_file';
        break;
		}
        parent::display($tpl);
    }//function
}//class
