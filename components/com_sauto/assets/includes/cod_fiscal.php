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
$js_code5 = 'function verificCui(val) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open(\'POST\', "'.$uri_base.'components/com_sauto/assets/ajax/verific_cui.php", true);
    self.xmlHttpReq.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(val));
}
function getquerystring(val) {
    qstr = \'cod_fiscal=\' + escape(val);
    return qstr;
}
function updatepage(str){
    document.getElementById("sa_cf").innerHTML = str;
}';