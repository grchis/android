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
class SautoViewProcess extends JViewLegacy
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
		
		$task =& JRequest::getVar( 'task', '', 'get', 'string' );
		switch ($task) {
		case '':
		default:
		$tpl = null;
		break;
		case 'precompletare':
		$tpl = 'precompletare';
		break;
		case 'precompletare2':
		$tpl = 'precompletare2';
		break;
		case 'activate':
		$tpl = 'activate';
		$meta_title = JText::_('SAUTO_META_ACTIVARE_CONT');	
		$site_title = JText::_('SAUTO_SITE_ACTIVARE_CONT');
		break;
		case 'z_alert':
		$tpl = 'zalert';
		break;
		}
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);
        parent::display($tpl);
    }//function
}//class
