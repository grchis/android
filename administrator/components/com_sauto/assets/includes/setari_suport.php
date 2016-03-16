<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$link_form = 'index.php?option=com_sauto&task=setari&action=suport_edit';
$editor =& JFactory::getEditor();
$db = JFactory::getDbo();
$query = "SELECT `suport` FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$suport = $db->loadResult();
?>
<h3>Editare pagina de suport</h3>
<form method="post" action="<?php echo $link_form; ?>">
<?php
echo $editor->display('suport', $suport, '300', '150', '60', '20', false);
?>
<br /><br />
<input type="submit" value="Actualizare pagina suport" />
</form>
