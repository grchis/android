<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldSidebarLeftWidthOverride extends JFormField
{
	public $type = 'SidebarLeftWidthOverride';

	protected function getInput() {		
		$html = '';
		$html .= '<div id="sidebar_left_width_for_pages_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="sidebar_left_width_for_pages_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_WIDTH') . '</div>';
		$html .= '<div class="input-prepend"><input type="text" value="" id="sidebar_left_width_for_pages_select" /><span class="add-on">%</span>';
		$html .= '<input type="button" class="btn" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="sidebar_left_width_for_pages_add_btn" /></div>';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="sidebar_left_width_for_pages_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
