
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
<?php
defined('_JEXEC') || die('=;)');
$document = JFactory::getDocument ();
require("tab_js_mobile.php");
$document->addScriptDeclaration ($js_code_tab);

//$jslink = JUri::base().'components/com_sauto/assets/script/tabtastic.js';
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);
$type =& JRequest::getVar( 'type', '', 'get', 'string' );
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile');

?>
 <div id="m_visitors">
      <div class = "m_header">
          <img id="filter-button" class="menu-button" style="right: 80px;"src="<?php echo $img_path?>filter-icon.png" />
		  	<a href="./android/index.php"><img src="./components/com_sauto/assets/images/menu_logo.png"/></a>
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
            <?php require("edit_profile_d_profil_mobile.php"); ?>
          </div>
           <div id="abonament" class="hidden tab-module">
            <?php require("edit_profile_d_abonament_mobile.php"); ?>
          </div>
          <div id="facturi" class="hidden tab-module">
            <?php require("edit_profile_d_facturi_mobile.php"); ?>
          </div>
          <div id="filiale" class="hidden tab-module">
            <?php require("edit_profile_d_filiale_mobile.php"); ?>
          </div>
		    <div id="financiar" class="hidden tab-module">
            <?php require("edit_profile_d_financiar_mobile.php"); ?>
          </div>
		<div id="profile" class="hidden tab-module">
            <?php require("edit_profile_d_profil2_mobile.php"); ?>
          </div>
		</div>
  </div>



<script type="text/javascript">
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

    jQuery('#filter-button').on('click', toggleFilterMenu);

    jQuery('#menu-icon').on('click', toggleMenu);

    jQuery('.filter-category-option').on('click', reloadRequiredModule);

    jQuery('.menu-option-text').on('click', redirectToMenuOption);

    document.write('<style type="text/css" >#content9{width: 100% !important;' +
                    'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
                    'width: 100% !important;}</style>'
    );
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
		var url=jQuery(event.target).data("href");
   		window.location.href = url;
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


</script>





