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
$uri_base = JURI::base();
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
    self.xmlHttpReq.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/marca2.php", true);
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
//$document->addScriptDeclaration ($js_code1);

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
    self2.xmlHttpReq2.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/orase2.php", true);
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
//$document->addScriptDeclaration ($js_code2);

$js_code3 = '
function aratOrase3(val) {
    var xmlHttpReq2 = false;
    var self3 = this;
    if (window.XMLHttpRequest) {
        self3.xmlHttpReq3 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self3.xmlHttpReq3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self3.xmlHttpReq3.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/orase3.php", true);
    self3.xmlHttpReq3.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self3.xmlHttpReq3.onreadystatechange = function() {
        if (self3.xmlHttpReq3.readyState == 4) {
            updatepage3(self3.xmlHttpReq3.responseText);
        }
    }
    self3.xmlHttpReq3.send(getquerystring3(val));
}
function getquerystring3(val) {
    qstr = \'id=\' + escape(val);
    return qstr;
}
function updatepage3(str){
    document.getElementById("sa_city2").innerHTML = str;
}
';


$js_code4 = '
function aratSubacc(val) {
    var xmlHttpReq4 = false;
    var self4 = this;
    if (window.XMLHttpRequest) {
        self4.xmlHttpReq4 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self4.xmlHttpReq4 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self4.xmlHttpReq4.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/subacc.php", true);
    self4.xmlHttpReq4.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self4.xmlHttpReq4.onreadystatechange = function() {
        if (self4.xmlHttpReq4.readyState == 4) {
            updatepage4(self4.xmlHttpReq4.responseText);
        }
    }
    self4.xmlHttpReq4.send(getquerystring4(val));
}
function getquerystring4(val) {
    qstr = \'id=\' + escape(val);
    return qstr;
}
function updatepage4(str){
    document.getElementById("sa_subacc").innerHTML = str;
}
';