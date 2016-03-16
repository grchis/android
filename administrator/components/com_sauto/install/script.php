<?php
/**
 * @package    sauto
 * @subpackage C:
 * @author     dacian strain {@link http://shop.elbase.eu}
 * @author     Created on 01-May-2015
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


/**
 * Script file for sauto component.
 */
class com_sautoInstallerScript
{
    /**
     * Method to run before an install/update/uninstall method.
     *
     * @param $type
     * @param $parent
     *
     * @return void
     */
    public function preflight($type, $parent)
    {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        echo '<p>'.JText::_('COM_SAUTO_PREFLIGHT_'.$type.'_TEXT').'</p>';
    }

    /**
     * Method to install the component.
     *
     * @param $parent
     *
     * @return void
     */
    public function install($parent)
    {
        // $parent is the class calling this method
        //	$parent->getParent()->setRedirectURL('index.php?option=com_sauto');
        echo '<p>'.JText::_('COM_SAUTO_INSTALL_TEXT').'</p>';
    }

    /**
     * Method to update the component.
     *
     * @param $parent
     *
     * @return void
     */
    public function update($parent)
    {
        // $parent is the class calling this method
        echo '<p>'.JText::_('COM_SAUTO_UPDATE_TEXT').'</p>';
    }

    /**
     * Method to run after an install/update/uninstall method.
     *
     * @param $type
     * @param $parent
     *
     * @return void
     */
    public function postflight($type, $parent)
    {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        echo '<p>'.JText::_('COM_SAUTO_POSTFLIGHT_'.$type.'_TEXT').'</p>';
    }

    /**
     * Method to uninstall the component.
     *
     * @param $parent
     *
     * @return void
     */
    public function uninstall($parent)
    {
        // $parent is the class calling this method
        echo '<p>'.JText::_('COM_SAUTO_UNINSTALL_TEXT').'</p>';
    }
}
