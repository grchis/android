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

$js_code = 'function verificEmail(val) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open(\'POST\', "http://localhost/sauto/components/com_sauto/assets/ajax/verific_email.php", true);
    self.xmlHttpReq.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(val));
}
function getquerystring(val) {
    estr = \'email=\' + escape(val);
    return estr;
}
function updatepage(str){
    document.getElementById("sa_email3").innerHTML = str;
}';