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

function meniu() {
	$link_home = 'index.php?option=com_sauto';
	$link_financiar = 'index.php?option=com_sauto&task=financiar';
	$link_anunturi = 'index.php?option=com_sauto&task=anunturi';
	$link_users = 'index.php?option=com_sauto&task=users';
	$link_dealers = 'index.php?option=com_sauto&task=dealers';
	$link_raportate = 'index.php?option=com_sauto&task=raportate';
	$link_city = 'index.php?option=com_sauto&task=city';
	$link_marci = 'index.php?option=com_sauto&task=marci';
	$link_modele = 'index.php?option=com_sauto&task=modele';
	$link_config = 'index.php?option=com_sauto&task=config';
	$link_setari = 'index.php?option=com_sauto&task=setari';
	$link_promo = 'index.php?option=com_sauto&task=promo';
?>
<table width="100%">
	<tr>
		<td>
			<div>
				<a href="<?php echo $link_home; ?>">Acasa</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_financiar; ?>">Financiar</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_anunturi; ?>">Lista anunturi</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_users; ?>">Lista utilizatori</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_dealers; ?>">Lista companii</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_raportate; ?>">Anunturi raportate</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_promo; ?>">Promotii</a>
			</div>
		</td>
		<?php /*<td>
			<div>
				<a href="<?php echo $link_city; ?>">Orase nepublicate</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_marci; ?>">Marci auto nepublicate</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_modele; ?>">Modele auto nepublicate</a>
			</div>
		</td>*/ ?>
		<td>
			<div>
				<a href="<?php echo $link_setari; ?>">Setari</a>
			</div>
		</td>
		<td>
			<div>
				<a href="<?php echo $link_config; ?>">Configurare</a>
			</div>
		</td>
	</tr>
</table>
<?php 
}
?>
