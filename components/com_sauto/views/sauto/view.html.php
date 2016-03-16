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
class SautoViewSauto extends JViewLegacy
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
		$doc = JFactory::getDocument();
		$user = JFactory::getUser();
		$uid = $user->id;
		if ($uid == 0) {
			$meta_title = JText::_('SAUTO_WELCOME_VIZITOR');	
			$site_title = JText::_('SAUTO_WELCOME_VIZITOR');
		} else {
			$db = JFactory::getDbo();
			$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$profil = $db->loadObject();
			if ($profil->tip_cont == 0) {
				//client
				$site_title = JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->fullname;
				$meta_title = JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->fullname;
			} else {
				//firma
				$site_title = JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->companie;
				$meta_title = JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->companie;
			}
		}
		
					
		$doc->setTitle($meta_title);
        $this->assignRef('site_title', $site_title);

        parent::display($tpl);
    }//function
}//class
