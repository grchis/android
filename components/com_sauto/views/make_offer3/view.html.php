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
class SautoViewMake_offer3 extends JViewLegacy
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
		$step =& JRequest::getVar( 'step', '', 'get', 'string' );
		if ($step == '') { $step = 1; }
		
		if ($step == 1) {
			//login existing account
			$tpl = '1';
		} elseif ($step == 2) {
			//register new account
			$tpl = '2';
		}  elseif ($step == 3) {
			//confirmam logarea
			$doc =& JFactory::getDocument();
			$meta_title = JText::_('SAUTO_META_TITLE_CONFIRM_LOGIN');	
			$site_title = JText::_('SAUTO_SITE_TITLE_CONFIRM_LOGIN');			
			$doc->setTitle($meta_title);
			$this->assignRef('site_title', $site_title);
			$tpl = '3';
		} 
        parent::display($tpl);
    }//function
}//class
