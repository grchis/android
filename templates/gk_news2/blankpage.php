<?php

/**
 *
 * Error view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */

// No direct access.
defined('_JEXEC') or die;
JHTML::_('behavior.framework');
jimport('joomla.factory');

// get the URI instance
$uri = JURI::getInstance();
// include framework classes and files
require_once('lib/gk.framework.php');
require_once('lib/framework/gk.const.php');
// run the framework
$tpl = new GKTemplate($this, $GK_TEMPLATE_MODULE_STYLES, true);

// get necessary template parameters
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
$pageName = JFactory::getDocument()->getTitle();

// get style configuration
$template_style = $tpl->layout->getTemplateStyle('style');

// get logo configuration
$logo_type = $templateParams->get('logo_type');
$logo_image = $templateParams->get('logo_image');

if(($logo_image == '') || ($templateParams->get('logo_type') == 'css')) {
     $logo_image = JURI::base() . '../images/logo.png';
} else {
     $logo_image = JURI::base() . $logo_image;
}

$logo_text = $templateParams->get('logo_text', '');
$logo_slogan = $templateParams->get('logo_slogan', '');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<title><?php echo $pageName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/blankpage.style<?php echo $template_style; ?>.css" type="text/css" />
<jdoc:include type="head" />

</head>
<body>
<div id="gkPage">
          <div id="gkPageWrap">
                    <!--<?php if ($logo_type !=='none'): ?>
                    <?php if($logo_type == 'css') : ?>
                    <a href="./" id="gkLogo" class="cssLogo"></a>
                    <?php elseif($logo_type =='text') : ?>
                    <a href="./" id="gkLogo" class="text"> <span><?php echo preg_replace('/__(.*?)__/i', '<sup>${1}</sup>', $logo_text); ?></span> <small class="gkLogoSlogan"><?php echo $logo_slogan; ?></small> </a>
                    <?php elseif($logo_type =='image') : ?>
                    <a href="./" id="gkLogo"> <img src="<?php echo $logo_image; ?>" alt="<?php echo $pageName; ?>" /></a>
                    <?php endif; ?>
                    <?php endif; ?>-->
                    <jdoc:include type="message" />
                    <jdoc:include type="component" />
          </div>
          <div id="gkfb-root"></div>
          <script type="text/javascript">
          //<![CDATA[
             	window.fbAsyncInit = function() {
          		FB.init({ appId: '<?php echo $templateParams->get('fb_api_id'); ?>', 
          			status: true, 
          			cookie: true,
          			xfbml: true,
          			oauth: true
          		});
             		    
          	  	<?php if($templateParams->get('fb_login') == 1) : ?>
          	  	function updateButton(response) {
          	    	var button = document.getElementById('fb-auth');
          		
          			if(button) {   
          			    if (response.authResponse) {
          			    // user is already logged in and connected
          			    button.onclick = function() {
          			        if(document.id('login-form')){
          			            document.id('modlgn-username').set('value','Facebook');
          			            document.id('modlgn-passwd').set('value','Facebook');
          			            document.id('login-form').submit();
          			        } else if(document.id('com-login-form')) {
          			           document.id('username').set('value','Facebook');
          			           document.id('password').set('value','Facebook');
          			           document.id('com-login-form').submit();
          			        }
          			    }
          			} else {
          			    //user is not connected to your app or logged out
          			    button.onclick = function() {
          			        FB.login(function(response) {
          			           if (response.authResponse) {
          			              if(document.id('login-form')){
          			                document.id('modlgn-username').set('value','Facebook');
          			                document.id('modlgn-passwd').set('value','Facebook');
          			                document.id('login-form').submit();
          			              } else if(document.id('com-login-form')) {
          			                 document.id('username').set('value','Facebook');
          			                 document.id('password').set('value','Facebook');
          			                 document.id('com-login-form').submit();
          			              }
          			          } else {
          			            //user cancelled login or did not grant authorization
          			          }
          			        }, {scope:'email'});   
          			    }
          	    	}
          	    }
          	  }
          	  // run once with current status and whenever the status changes
          	  FB.getLoginStatus(updateButton);
          	  FB.Event.subscribe('auth.statusChange', updateButton);	
          	  <?php endif; ?>
          	};
              //      
             window.addEvent('load', function(){
                  (function(){
                  		
                          if(!document.getElementById('fb-root')) {
                               var root = document.createElement('div');
                               root.id = 'fb-root';
                               document.getElementById('gkfb-root').appendChild(root);
                               var e = document.createElement('script');
                           e.src = document.location.protocol + '//connect.facebook.net/<?php echo $templateParams->get('fb_lang'); ?>/all.js';
                               e.async = true;
                           document.getElementById('fb-root').appendChild(e);   
                          }
                  }());
              }); 
              //]]>
          </script>
          
</div>
</body>
</html>