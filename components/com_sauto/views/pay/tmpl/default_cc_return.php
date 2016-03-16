<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
$db = JFactory::getDbo();

///////
$objectId = $_GET['orderId'];
$query = "SELECT * FROM #__sa_mobilpay WHERE `orderId` = '".$objectId."'";
$db->setQuery($query);
$rezult = $db->loadObject();
if ($rezult->status == 'confirmed') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_SUCCES');
	echo '</div>';
} elseif ($rezult->status == 'confirmed_pending') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_PENDING');
	echo '</div>';
} elseif ($rezult->status == 'paid_pending') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_VERIFY');
	echo '</div>';
} elseif ($rezult->status == 'paid') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_VERIFY');
	echo '</div>';
} elseif ($rezult->status == 'canceled') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_CANCELED');
	echo '</div>';
} elseif ($rezult->status == 'credit') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_CANCELED');
	echo '</div>';
} elseif ($rezult->status == 'defaut') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_NO_PROCESSING');
	echo '</div>';
} elseif ($rezult->status == 'rejected') {
	echo '<div>';
	echo JText::_('SA_CC_RETURN_REJECTED');
	echo '</div>';
}
///////			


