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

$js_code2 = '
function aratOraseD(val) {
    var xmlHttpReq = false;
    var self6 = this;
    if (window.XMLHttpRequest) {
        self6.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self6.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self6.xmlHttpReq.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/orase2.php", true);
    self6.xmlHttpReq.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self6.xmlHttpReq.onreadystatechange = function() {
        if (self6.xmlHttpReq.readyState == 4) {
            updatepage6(self6.xmlHttpReq.responseText);
        }
    }
    self6.xmlHttpReq.send(getquerystring6(val));
}
function getquerystring6(val) {
    qstr = \'id=\' + escape(val);
    return qstr;
}
function updatepage6(str){
    document.getElementById("sa_city_d").innerHTML = str;
}
';

