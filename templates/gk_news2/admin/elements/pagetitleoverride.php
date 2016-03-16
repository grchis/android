<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldPageTitleOverride extends JFormField
{
	public $type = 'PageTitleOverride';

	protected function getInput() {		
		$html = '';
		$html .= '<div id="page_title_override_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="page_title_override_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_STATE') . '</div>';
		$html .= '<select type="text" value="off" id="page_title_override_select">';
		$html .= '<option value="on">'. JText::_('TPL_GK_LANG_ON').'</option>';
		$html .= '<option value="off">'. JText::_('TPL_GK_LANG_OFF').'</option>';
		$html .= '</select>';
		$html .= '<input class="btn" type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="page_title_override_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="page_title_override_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
