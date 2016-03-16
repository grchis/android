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
//obtin id anunt
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$db = JFactory::getDbo();

$query = "SELECT `tip_anunt` FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadResult();

$document = JFactory::getDocument();
$document->addScriptDeclaration ($js_code);
$js_code1 = '
function aratMarca(val) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open(\'POST\', "http://localhost/sa2/components/com_sauto/assets/ajax/marca2.php", true);
    self.xmlHttpReq.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(val));
}
function getquerystring(val) {
    qstr = \'id=\' + escape(val);
    return qstr;
}
function updatepage(str){
    document.getElementById("sa_marca").innerHTML = str;
}
';

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
    self2.xmlHttpReq2.open(\'POST\', "http://localhost/sa2/components/com_sauto/assets/ajax/orase2.php", true);
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
switch ($tip) {
	case '1':
	$document->addScriptDeclaration ($js_code1);
	require("edit_anunt_1.php");
	break;
	case '2':
	$document->addScriptDeclaration ($js_code2);
	require("edit_anunt_2.php");
	break;
	case '3':
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require("edit_anunt_3.php");
	break;
	case '4':
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require("edit_anunt_4.php");
	break;
	case '5':
	break;
	case '6':
	$document->addScriptDeclaration ($js_code1);
	require("edit_anunt_6.php");
	break;
	case '7':
	break;
	case '8':
	$document->addScriptDeclaration ($js_code1);
	require("edit_anunt_8.php");
	break;
	case '9':
	$document->addScriptDeclaration ($js_code1);
	require("edit_anunt_9.php");
	break;
}
?>	
