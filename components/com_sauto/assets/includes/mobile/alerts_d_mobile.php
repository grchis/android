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
$document = JFactory::getDocument ();
$app =& JFactory::getApplication();
$app->setUserState('url_alert', 'alerte');


require("toggle_js_mobile.php");
$document->addScriptDeclaration ($js_code);

JHTML::_('behavior.tooltip');

$user =& JFactory::getUser();
$uid = $user->id;

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->alerts_article."'";
$db->setQuery($query);
$alerts_article = $db->loadResult();

$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->alert_det_article."'";
$db->setQuery($query);
$alert_det_article = $db->loadResult();
$width = 'style="width:800px;"';

$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$prf = $db->loadObject();
//print_r($prf);
//echo '>>>> '.$prf->categorii_activitate;
$alerta = $prf->alerte;

$query = "SELECT * FROM #__sa_alerte WHERE `tip_alerta` = 'd'";
$db->setQuery($query);
$alerts = $db->loadObjectList();
$link_form = JRoute::_('index.php?option=com_sauto&view=set_alert');
$sep = ',';
$exploded = explode(',', $alerta);
?>
<div id="m_visitors">   
 <?php
require_once("menu_filter_d.php");

        $cats = explode(",", $prf->categorii_activitate);
        $query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
        $db->setQuery($query);
        $tip = $db->loadObjectList();
    ?>
    <div class="domain-header">
        <div class="domain-status"> <?php echo JText::_('SAUTO_STATUS_TRANZ'); ?> </div>
        <div class="domain-description"> <?php echo JText::_('SAUTO_DEALER_DOMENIU_ACT'); ?> </div>
    </div>

    <div class="domain-content">
        <?php
        $cats = explode(",", $prf->categorii_activitate);
        foreach ($tip as $t) {
            $link_alerts_edit = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_edit&id=' . $t->id);
            $link_alerts_enable = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_enable&id=' . $t->id);
            $valoare = $t->id . '-1';
            $link = in_array($valoare, $cats) ? $link_alerts_edit : $link_alerts_enable;

            echo"<div class=\"domain-option\"><a href=\"" . $link . "\">";
            //pun imaginea daca e acceptat sau nu
            if (in_array($valoare, $cats)) {
                echo "<div class=\"domain-status\"><img src=\"" . $img_path . "check_yes.png\" width=\"30px\" /></div>";
            } else {
                echo "<div class=\"domain-status\"><img src=\"" . $img_path . "check_no.png\" width=\"30px\" /></div>";
            }

            echo '<div class="domain-description">' . $t->tip . '</div>';
            echo "</a></div>";
				}
        ?>
    </div>
</div>

<style type="text/css">
    .domain-option{
        margin-top: 15px;
    }
    .domain-status{
        display: inline-block;
        width: 20%;
        font-size: 1.6em;
        vertical-align: top;
    }
   
    .domain-description{
        display: inline-block;
        font-size: 1.6em;
        width: 78%;
        vertical-align: top;
    }

    @media screen and (max-width: 1210px){
    .gkPage {
        padding: 0 !important;
    }
}

</style>

<script type="text/javascript">
    	var isMenuCollapsed = true;
    	var isFilterCollapsed = true;

        jQuery('#m_table').remove();
        jQuery('#side_bar').remove();
        jQuery('#gkTopBar').remove();
        document.getElementById('content9').style.all = "none";
        document.getElementsByTagName('h1')[0].remove();

        jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);
    function toggleMenu () {
	   if (isMenuCollapsed){
	        isMenuCollapsed = false;
	        jQuery('#main-menu').show(500);
	    }
	    else{
	        isMenuCollapsed = true;
	        jQuery('#main-menu').hide(500);
	    }
	}

	function redirectToMenuOption (event) {
  		event.preventDefault();
  		event.stopPropagation();

  		window.location.href = jQuery(event).data('href');
	}
</script>

