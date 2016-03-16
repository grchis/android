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
function  furnizor() {
?>
	<div>Furnizor:</div>
	<div>SC Site auto SRL</div>
	<div>Nr. Reg. J54/123/2011</div>
	<div>CIF: 123123123</div>
	<div>Adresa: strada cu case la etaj</div>
	<div>Cont: ro21brb000111000111</div>
	<div>Banca: BRB</div>
	<div>Capital social: -7lei</div>
	<div>Telefon: 123123112233</div>
	<div>Site: www.siteauto.ro</div>
	<div>Mail: office@siteauto.ro</div>
<?php 
}

function client($uid) {
	$db = JFactory::getDbo();
	$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$list = $db->loadObject();
	?>
	<div>Cumparator:</div>
	<div><?php echo $list->companie; ?></div>
	<div>CIF: <?php echo $list->cod_fiscal; ?></div>
	<div>Nr. Reg.: <?php echo $list->nr_registru; ?></div>
	<div>Adresa: <?php echo $list->sediu; ?></div>
	<div>Telefon: <?php echo $list->telefon; ?></div>
	<?php
}
