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
require("tab_js.php");
$document->addScriptDeclaration ($js_code_tab);

//$jslink = JUri::base().'components/com_sauto/assets/script/tabtastic.js';
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);



$type =& JRequest::getVar( 'type', '', 'get', 'string' );
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile');
$width = 'style="width:800px;"';

?>

<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<div class="domtab">
  <ul class="domtabs">
    <li><a href="#t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></li>
    <li><a href="#t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a></li>
	<li><a href="#t3"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></a></li>
	<li><a href="#t4"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></a></li>
	<li><a href="#t5"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></a></li>
	<li><a href="#t6"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></a></li>
  </ul>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t1" id="t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></h2>
   <?php require("edit_profile_d_profil.php"); ?>
  </div>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t2" id="t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a> 	</h2>
   <?php require("edit_profile_d_profil2.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t3" id="t3"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></a> 	</h2>
   <?php require("edit_profile_d_financiar.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t4" id="t4"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></a> 	</h2>
   <?php require("edit_profile_d_abonament.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t5" id="t5"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></a> 	</h2>
   <?php require("edit_profile_d_facturi.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t6" id="t6"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></a> 	</h2>
   <?php require("edit_profile_d_filiale.php"); ?>
  </div>
</div>

		
<?php /*
<ul class="tabset_tabs">
   <li><a href="<?php echo $link; ?>#tab1" <?php if ($type == '') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a>
	</li>
	<li><a href="<?php echo $link; ?>#tab2" <?php if ($type == 'pr') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a>
	</li>
   <li><a href="<?php echo $link; ?>#tab3" <?php if ($type == 'fn') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab4" <?php if ($type == 'ab') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab5" <?php if ($type == 'fc') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FACTURI'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab6" <?php if ($type == 'fl') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FILIALE'); ?>
   </a></li>
</ul>

<div id="tab1" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></h2>
   <?php require("edit_profile_d_profil.php"); ?>
</div>

<div id="tab2" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></h2>
   <?php require("edit_profile_d_profil2.php"); ?>
</div>

<div id="tab3" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></h2>
   <?php require("edit_profile_d_financiar.php"); ?>
</div>

<div id="tab4" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></h2>
   <?php require("edit_profile_d_abonament.php"); ?>
</div>

<div id="tab5" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></h2>
   <?php require("edit_profile_d_facturi.php"); ?>
</div>
<div id="tab6" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></h2>
   <?php require("edit_profile_d_filiale.php"); ?>
</div>
*/ ?>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>	
 
 <div id="m_visitors">
      <div class = "m_header">
          <img id="filter-button" class="menu-button" style="right: 80px;"src="<?php echo $img_path?>filter-icon.png" />
          <img id="menu-icon" class="menu-button" src="<?php echo $img_path?>menu-icon.png" />
      </div>

      <div id="main-menu" style="display: none;">
        <div class="menu-option" data-href="/android/index.php?view=requests">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text"> Cereri </span>
        </div>

        <div class="menu-option" data-href="/android/index.php/component/sauto/?view=my_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text"> Ofertele Mele </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?view=final_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text"> Oferte Finalizate </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?view=alerts">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text"> Alerte </span>
        </div>

        <div class="menu-option" data-href="/android/index.php/component/sauto/?view=edit_profile">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text"> Editare profil </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=logout">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text"> Inchide Aplicatia </span>
        </div>
      </div>

      <div id="filter-menu" class="hidden">
          <p class="filter-category-option selected" data-tab="#edit-profile">Editare Profil</p>
          <p class="filter-category-option" data-tab="#profile">Profil</p>
          <p class="filter-category-option" data-tab="#financiar">Financiar</p>
          <p class="filter-category-option" data-tab="#abonament">Abonament</p>
          <p class="filter-category-option" data-tab="#facturi">Lista Facturi</p>
          <p class="filter-category-option" data-tab="#filiale">Filiale</p>
      </div>

      <div id="main-container">
          <div id="edit-profile"class="tab-module">
            <?php require("edit_profile_d_profil.php"); ?>
          </div>
          <div id="profile" class="hidden tab-module">
            <?php require("edit_profile_d_profil2.php"); ?>
          </div>
          <div id="financiar" class="hidden tab-module">
            <?php require("edit_profile_d_financiar.php"); ?>\
          </div>
          <div id="abonament" class="hidden tab-module">
            <?php require("edit_profile_d_abonament.php"); ?>
          </div>
          <div id="facturi" class="hidden tab-module">
            <?php require("edit_profile_d_facturi.php"); ?>
          </div>
          <div id="filiale" class="hidden tab-module">
            <?php require("edit_profile_d_filiale.php"); ?>
          </div>
      </div>
  </div>



<script type="text/javascript">

	var isMobile = navigator.userAgent.contains('Mobile');

if (!isMobile) {
	jQuery('#m_visitors').remove();
}else {
    var isFilterCollapsed = true;
    var isMenuCollapsed = true;

    if (document.getElementsByTagName('h1')[0])
    {
        document.getElementsByTagName('h1')[0].remove();
    }
    if (document.getElementById("side_bar"))
    {
        document.getElementById("side_bar").remove();
    }
    if(document.getElementsByTagName('center')[0])
    {
        document.getElementsByTagName('center')[0].remove();
    }
    if(document.getElementById('gkTopBar'))
    {
        document.getElementById('gkTopBar').remove();
    }
    if(document.getElementById('m_table'))
    {
        document.getElementById('m_table').remove();
    }

    jQuery('#filter-button').on('click', toggleFilterMenu);

    jQuery('#menu-icon').on('click', toggleMenu);

    jQuery('.filter-category-option').on('click', reloadRequiredModule);

    jQuery('.menu-option-text').on('click', redirectToMenuOption);

    document.write('<style type="text/css" >#content9{width: 100% !important;' +
                    'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
                    'width: 100% !important;}</style>'
    );
}

function redirectToMenuOption (event) {
  event.preventDefault();
  event.stopPropagation();

  window.location.href = jQuery(event).data('href');
}

function reloadRequiredModule () {
  jQuery('.filter-category-option').removeClass('selected');
  jQuery(this).addClass('selected');

  var moduleId = jQuery(this).data('tab');
  console.log(moduleId)

  jQuery('.tab-module').hide();
  jQuery(moduleId).show();
}

function toggleFilterMenu () {
    if (isFilterCollapsed){
        isFilterCollapsed = false;
        jQuery('#filter-menu').show(500);
    }
    else{
        isFilterCollapsed = true;
        jQuery('#filter-menu').hide(500);
    }
}

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

</script>

<style type="text/css">
.hidden{
  display: none;
}
.selected{
  background-color: grey;
}
 @media screen and (max-width: 1210px){
    .gkPage {
        padding: 0 !important;
    }
}
</style>




