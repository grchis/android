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
class SautoViewMake_offer2 extends JViewLegacy
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
		$doc =& JFactory::getDocument();
		$meta_title = JText::_('SAUTO_META_TITLE_MAKE_OFFER2');	
		$site_title = JText::_('SAUTO_SITE_TITLE_MAKE_OFFER2');			
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        parent::display($tpl);
    }//function
}//class
