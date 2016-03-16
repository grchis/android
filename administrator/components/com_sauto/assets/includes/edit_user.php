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
$db = JFactory::getDbo();

$document = JFactory::getDocument();
$js_code2 = '
function aratOrase(val) {
    var xmlHttpReq2 = false;
    var self2 = this;
    if (window.XMLHttpRequest) {
        self2.xmlHttpReq2 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self2.xmlHttpReq2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self2.xmlHttpReq2.open(\'POST\', "http://www.siteauto.ro/final/components/com_sauto/assets/ajax/orase2.php", true);
    self2.xmlHttpReq2.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self2.xmlHttpReq2.onreadystatechange = function() {
        if (self2.xmlHttpReq2.readyState == 4) {
            updatepage2(self2.xmlHttpReq2.responseText);
        }
    }
    self2.xmlHttpReq2.send(getquerystring2(val));
}
function getquerystring2(val) {
    qstr = \'id=\' + escape(val);
    return qstr;
}
function updatepage2(str){
    document.getElementById("sa_city").innerHTML = str;
}
';

$document->addScriptDeclaration ($js_code2);

$uid =& JRequest::getVar( 'uid', '', 'post', 'string' );
//obtin date utilizator
$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `j`.`id`,  `l`.`localitate`, `l`.`id` AS `lid`, `p`.`deleted`, 
		`p`.`adresa`, `p`.`cod_postal`, `p`.`poza`, `p`.`calificative`, `u`.`email`, `u`.`registerDate`, `u`.`lastvisitDate` 
		FROM #__sa_profiles AS `p` 
		JOIN #__users AS `u` 
		JOIN #__sa_judete AS `j` 
		JOIN #__sa_localitati AS `l` 
		ON `p`.`uid` = '".$uid."' 
		AND `p`.`uid` = `u`.`id` 
		AND `p`.`judet` = `j`.`id` 
		AND `p`.`localitate` = `l`.`id`";
$db->setQuery($query);
$profil = $db->loadObject();
$image_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS.$uid.DS;
?>
<h2>Editare utilizator</h2>
<form action="index.php?option=com_sauto&task=save_user" method="post">
	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
<div>Nume</div>
<div><input type="text" name="fullname" value="<?php echo $profil->fullname; ?>" /></div>

<div>Setari alerte</div>
<div>
	<?php 
$link_alerts = 'index.php?option=com_sauto&task=alerte&action=customer&uid='.$uid;
echo '<a href="'.$link_alerts.'">Editeaza alertele</a>';
	?></div>
	
<div>Email</div>
<div><input type="text" name="email" value="<?php echo $profil->email; ?>" /></div>

<div>Telefon</div>
<div><input type="text" name="telefon" value="<?php echo $profil->telefon; ?>" /></div>

<div>Judet</div>
<div>
	<select name="judet" onChange="javascript:aratOrase(this.value)">
	<option value="">Alege judet</option>
	<?php
	$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
	$db->setQuery($query);
	$judete = $db->loadObjectList();
		foreach ($judete as $j) {
			echo '<option id="'.$j->id.'"';
			if ($j->id == $profil->id) { echo ' selected '; }
				echo '>'.$j->judet.'</option>';
			}
		?>
	</select>	
</div>
<div>Localitate</div>
<div id="sa_city">
	<?php if ($profil->judet == '') { ?>
	<select name="none"><option value="">Alege localitate</option></select>
	<?php 
	} else { 
	//obtin localitatile judetului selectat
	$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$profil->id."' AND `published` = '1'";
	$db->setQuery($query);
	$cities = $db->loadObjectList();
	echo '<select name="localitate">';
		echo '<option value="">Alege localitate</option>';
		foreach ($cities as $c) {
			echo '<option value="'.$c->id.'"';
				if ($c->id == $profil->lid) { echo ' selected '; }
			echo '>'.$c->localitate.'</option>';
		}
	echo '</select>'; 
	} ?> 
</div>
	

<div>Adresa</div>
<div>
<?php
$editor =& JFactory::getEditor();
echo $editor->display('adresa', $profil->adresa, '300', '150', '60', '20', false);
?>
</div>
<br /><br />
<div>Cod postal</div>
<div><input type="text" name="cod_postal" value="<?php echo $profil->cod_postal; ?>" /></div>

<div>Membru din</div>
<div><?php echo $profil->registerDate; ?></div>

<div>Ultima vizita</div>
<div><?php echo $profil->lastvisitDate; ?></div>

<div>Calificative</div>
<div><?php echo $profil->calificative; ?>%</div>

<div>Avatar</div>
<div>
<?php
if ($profil->poza == '') {
	echo 'Fara avatar personalizat!';
} else {
	echo '<img src="'.$image_path.$profil->poza.'" width="70" />';
}
?>
</div>

<?php
if ($profil->poza != '') {
	?>
	<div>
	<input type="checkbox" name="delete_avatar" value="1" /> 
	Sterge avatar
	</div>
	<?php
}
?>

	<?php if ($profil->deleted == 0) { ?>
	<div class="sa_deleted">
		<input type="checkbox" name="delete_user" value="1" /> 
		Sterge utilizatorul
	</div>
	<?php } else { ?>
	<div class="sa_restore">
		<input type="checkbox" name="restore_user" value="1" /> 
		Restaurare utilizator
	</div>
	<?php } ?>
<div><input type="submit" value="Editare date utilizator" /></div>
</form>
<br /><br />
