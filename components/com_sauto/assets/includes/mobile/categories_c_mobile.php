<style type="text/css">
	h1{
		display:none;
	}
    p{
        margin: 0;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section{
         width: 45%;
        display: inline-block;
    }
    .contact-section{
        width: 33%;
        display: inline-block;
        vertical-align: top;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );

$link_this = JRoute::_('index.php?option=com_sauto&view=categories&id='.$id);
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f&id='.$id.'&cat=1');

##################
$db_oferte = "";
$db_piese = "";
$app =& JFactory::getApplication();
$oferte =& JRequest::getVar( 'oferte', '', 'post', 'string' );
$judete =& JRequest::getVar( 'judete', '', 'post', 'string' );
$marci =& JRequest::getVar( 'marci', '', 'post', 'string' );
$modele =& JRequest::getVar( 'modele', '', 'post', 'string' );
$orase =& JRequest::getVar( 'orase', '', 'post', 'string' );

if ($marci != '') {
	$app->setUserState('marci', $marci);
}

if ($modele != '') {
	$app->setUserState('modele', $modele);
}

if ($judete != '') {
	$app->setUserState('judete', $judete);
}

if ($orase != '') {
	$app->setUserState('orase', $orase);
}

if ($oferte == '1') {
	$app->setUserState('oferte', '1');
} elseif ($oferte == '0') {
	$app->setUserState('oferte', '0');
} elseif ($oferte == '2') {
	$app->setUserState('oferte', '2');
}

$ck_marci = $app->getUserState('marci');
if ($ck_marci == 0) {
	$db_marci = "";
} else {
	$db_marci = " AND `marca_auto` = '".$ck_marci."'";
}

$ck_modele = $app->getUserState('modele');
if ($ck_modele == 0) {
	$db_modele = "";
} else {
	$db_modele = " AND `model_auto` = '".$ck_modele."'";
}

$ck_judete = $app->getUserState('judete');
if ($ck_judete == 0) {
	$db_judete = "";
} else {
	$db_judete = " AND `judet` = '".$ck_judete."'";
}

$ck_orase = $app->getUserState('orase');
if ($ck_orase == 0) {
	$db_orase = "";
} else {
	$db_orase = " AND `city` = '".$ck_orase."'";
}
$ck_oferte = $app->getUserState('oferte');
if ($ck_oferte == '') { $ck_oferte = 2; } 
if ($ck_oferte == 1) {
	$db_oferte .= " AND `oferte` != '0'";
} elseif ($ck_oferte == 0) {
	$db_oferte .= " AND `oferte` = '0'";
} elseif ($ck_oferte == '2') {
	$db_oferte .= "";
}
$db_piese .= "";

$max_litere = 80;

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0' AND `tip_anunt` = '".$id."' 
".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 0) {
	//nu ai anunturi
	require_once('fara_anunturi.php');
} else { 
################################################
$total_rezult = $total;
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$query = "SELECT * FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0' AND `tip_anunt` = '".$id."' ".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ORDER BY `id` ";
echo '<input  type="hidden" id="anunt_id" value="'.$id.'"/>';
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JURI::base()."components/com_sauto/assets/users/";	 
?>
<div id="m_visitors">
    <div class = "m_header">
        <img id="filter-button" class="menu-button" style="right: 80px;"src="<?php echo $img_path?>filter-icon.png" />
        <img id="menu-icon" class="menu-button" src="<?php echo $img_path?>menu-icon.png" />
    </div>
    <div id="filter-menu" style="display: none;">
        <p class="filter-category-name">Oferte</p>
        <ul class="filter-category">
            <li class="category-item" data-category="oferte" data-id="2"> Toate Cererile </li>
            <li class="category-item" data-category="oferte" data-id="1"> Cu oferte </li>
            <li class="category-item" data-category="oferte" data-id="0"> Fara Oferte</li>
        </ul>

        <p class="filter-category-name">Judet</p>
        <ul class="filter-category">
		<li class="category-item" data-category="judete" data-id="0">Toate Judetele</li>
            <?php
            $query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
            $db->setQuery($query);
            $regions = $db->loadObjectList();
            foreach ($regions as $rg) { ?>
                <li class="category-item" data-category="judete" data-id="<?php echo $rg->id ?>"><?php echo $rg->judet ?></li>
            <?php }
            ?>
        </ul>

        <p class="filter-category-name">Marca</p>
        <ul class="filter-category">
		  <li class="category-item" data-category="marci" data-id="0">Toate Marcile</li>
            <?php
            $query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
            $db->setQuery($query);
            $marci = $db->loadObjectList();
            foreach ($marci as $mc) {?>
                <li class="category-item" data-category="marci" data-id="<?php echo $mc->id ?>"><?php echo $mc->marca_auto ?></li>
            <?php }
            ?>
        </ul>
    </div>

<div id="main-container">
        <?php
        $i=1;
        foreach ($list as $l) {
            $image = 'anunt_type_'.$l->tip_anunt.'.png';
            $link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
            $db->setQuery($query);
            $pics = $db->loadObject();
            if ($pics->poza != '') {
                $poza = $image_path.$l->proprietar."/".$pics->poza;
                $alt = $pics->alt;
            } else {
                $poza = $img_path.$image;
                $alt = '';
            }
            $data_add = explode(" ",$l->data_adaugarii);
            ?>
          	<div class="pic-container" data-id="<?php echo $l->tip_anunt ?>" data-category="categories">
						<p><?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt) ?> </p>
						<img src="<?php echo $poza ?>" width="80" border="0" />
			</div>	
			<div class="request-item">
			     <div class="info-section">
                    <p>
                        <a href="<?php echo $link_anunt ?>"> <?php $l->titlu_anunt ?></a>
                    </p>
                    <p>
                        <span><?php echo JText::_('SAUTO_SHOW_DATE') ?>: </span><?php echo $data_add[0]; ?>
                    </p>
                    <p> <?php echo strip_tags($l->anunt) ?></p>

                    <?php if ($l->marca_auto != 0) {
                        //obtin marca si modelul
                        $query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
                        $db->setQuery($query);
                        $marca = $db->loadResult();
                    }?>
                    <p> <?php echo $marca ?> </p>
                    <?php if ($l->model_auto != 0) {
                        $query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
                        $db->setQuery($query);
                        $model = $db->loadResult();
                    } ?>
                    <p> <?php echo $model ?> </p>

                </div>
				<?php 
					$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
					$db->setQuery($query);
					//echo $query;
					$userd = $db->loadObject();
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
					echo '<div class="sa_request_title"><a class="sa_public_profile" href="'.$link_profile.'">'.$userd->fullname.'</a></div>';
				?>
                <div class="contact-section">
                    <p><span><?php echo JText::_('SAUTO_DISPLAY_JUDET') ?>: </span> <?php echo $userd->judet ?> </p>
                    <p style="background-color: #509EFF;" data-phone="<?php echo $userd->telefon ?>">
                        <?php echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />'; ?>
						<span class="sa_phone_span"><?php echo $userd->telefon; ?></span>
                    </p>
					<?php
						$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `proprietar` = '".$l->proprietar."' AND `anunt_id` = '".$l->id."'";
						$db->setQuery($query);
						$oferte = $db->loadResult();
                    ?>
                    <p><?php 
							if ($oferte == 0) {
								echo JText::_('SAUTO_FARA_OFERTE') ;
							} else if ($oferte == 1){
								echo JText::_('SAUTO_O_OFERTA');
							}else{
								 echo JText::_('SAUTO_NR_OFERTE');
							}						  
					?></p>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>
<?php
}
?>
</div>
<script type="text/javascript">
    var isCollapsed = true;
	var anuntId=document.getElementById("anunt_id").value;
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

        jQuery('#filter-button').on('click', toggleFilterMenu);
        jQuery('.filter-category-name').on('click', collapseCategoryItems);
        jQuery('.category-item').on('click', getFilteredList);
        jQuery('.pic-container').on('click', getFilteredList);
       function getFilteredList(){
        var requestedUrl = 'http://localhost/android/index.php/component/sauto/?view=';
        var key = jQuery(this).data('category');
        var value = jQuery(this).data('id');
        var requestType;
        var obj = {};
        if (key === 'categories'){
            requestedUrl += 'categories&id='+anuntId;
            requestType = "GET";
            obj["id"] = value;
        } else {
           requestedUrl += 'categories&id='+anuntId;
            requestType = "POST";
            obj[key] = value;
        }

        jQuery('#filter-menu').hide(500);
        jQuery.ajax({
            type: requestType,
            url: requestedUrl,
            data: obj,
            contentType: "application/x-www-form-urlencoded"
        }).success(function(data) {
            var html = jQuery.parseHTML(data);
            jQuery('#main-container').html(jQuery(html).find('#m_visitors').find('#main-container'));
        }).error(function () {
            alert('error')
        });
    }

    function collapseCategoryItems(){
        var requiredSibling = jQuery(this).next('ul');
        if (jQuery(requiredSibling).is(":visible")){
            jQuery(requiredSibling).hide();
        }else{
            jQuery(requiredSibling).show();
        }
    }

    function toggleFilterMenu()
    {
        if (isCollapsed){
            isCollapsed = false;
            jQuery('#filter-menu').show(500);
        }
        else{
            isCollapsed = true;
            jQuery('#filter-menu').hide(500);
        }
    }
</script>

