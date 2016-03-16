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
$link_home = 'index.php?option=com_sauto&task=financiar';
$link_facturi = 'index.php?option=com_sauto&task=financiar&action=facturi';
$link_platite = 'index.php?option=com_sauto&task=financiar&action=platite';
$link_solicitate = 'index.php?option=com_sauto&task=financiar&action=solicitate';
$link_abonati = 'index.php?option=com_sauto&task=financiar&action=abonati';

?>
<div>
	<a href="<?php echo $link_home; ?>">Sumar</a>
</div>

<div>
	<a href="<?php echo $link_platite; ?>">Lista plati</a>
</div>

<div>
	<a href="<?php echo $link_facturi; ?>">Facturi</a>
</div>

<div>
	<a href="<?php echo $link_solicitate; ?>">Facturi cerute</a>
</div>

<div>
	<a href="<?php echo $link_abonati; ?>">Abonati</a>
</div>


