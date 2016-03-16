<?php 

//
// Functions used in layouts
//

class GKTemplateLayout {
    //
    private $parent;
    // APIs from the parent to use in the loadBlocks functions
    public $API;
    public $cache;
    public $social;
    public $utilities;
    public $menu;
    public $mootools;
    // access to the module styles
    public $module_styles;
    // frontpage detection variables
    public $globalMenuActive = null;
    public $globalMenuLanguage = null;
    //
    
    function __construct($parent) {
    	$this->parent = $parent;
    	$this->API = $parent->API;
    	$this->cache = $parent->cache;
    	$this->social = $parent->social;
    	$this->utilities = $parent->utilities;
    	$this->menu = $parent->menu;
    	$this->mootools = $parent->mootools;
    	$this->module_styles = $parent->module_styles;
    }
	// function to load specified block
	public function loadBlock($path) {
	    jimport('joomla.filesystem.file');
	    
	    if(JFile::exists($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php')) { 
	        include($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php');
	    }
	}   
	// function to generate tablet and mobile width & base CSS urles
	public function generateLayoutWidths() {
		//
		$template_width = $this->API->get('template_width', 1230); // get the template width
		$tablet_width = $this->API->get('tablet_width', 1030); // get the tablet width
		$tablet_small_width = $this->API->get('tablet_small_width', 820); // get the small tablet width
		$mobile_width = $this->API->get('mobile_width', 580); // get the mobile width
		$banner_width = $this->API->get('banner_width', 15); // get the banner width
		//
		$sidebar_left_width = $this->getSidebarWidthOverride('left'); // get the sidebar width
		$sidebar_right_width = $this->getSidebarWidthOverride('right'); // get the sidebar width
        $inset_width = $this->getInsetWidthOverride(); // get the inset width
        $inner_inset_width = $this->getInnerInsetWidthOverride(); // get the inner inset width
        $page_content_width = 100;
        $page_content_div_width = 100;
        $content_width = 100;
        $contentwrap_width = 100;
        $highlights_width = 100;
        //
		if($this->API->modules('sidebar_left')) {
           $page_content_width = 100 - $sidebar_left_width;
           
           if($this->API->get('updates_area', '1') == '1') {
           		$highlights_width = $highlights_width - $sidebar_left_width;
           }
           // generate sidebar width
           $this->API->addCSSRule('#gkSidebarLeft { width: '.$sidebar_left_width.'%; }' . "\n");
           $this->API->addCSSRule('#gkUpdates { width: '.$sidebar_left_width.'%; }' . "\n");
        }
        //
        $old_highlights_width = $highlights_width;
		//
        if($this->API->modules('sidebar_right')) {
           $page_content_div_width = 100 - $sidebar_right_width;
           
           if($this->API->modules('search')) {
           		$highlights_width = $highlights_width - ($sidebar_right_width * ($old_highlights_width / 100));
           }
           // generate sidebar width
           $this->API->addCSSRule('#gkSidebarRight { width: '.$sidebar_right_width.'%; }' . "\n");
           $this->API->addCSSRule('#gkSearch { width: '.($sidebar_right_width * ($old_highlights_width / 100)).'%; }' . "\n");
        }
        
        if(!$this->API->modules('sidebar_left') && $this->API->get('updates_area', '1') == '1') {
        	$highlights_width = $highlights_width - 21.25;
        }
        
        if(!$this->API->modules('sidebar_right') && $this->API->modules('search')) {
        	$highlights_width = $highlights_width - 18.5;
        }
        //
        $this->API->addCSSRule('#gkHighlights { width: '.$highlights_width.'%; }' . "\n");
       //
       if($this->API->modules('inset')) {
               $contentwrap_width = 100 - $inset_width;
               // generate sidebar width
               $this->API->addCSSRule('#gkInset { width: '.$inset_width.'%; }' . "\n");
       } else {
               $this->API->addCSSRule('#gkContent { background-image: none!important; }');
       }
       //
       if($this->API->modules('banner_left and banner_right')) {
       		$left_banner_width = 100 - $banner_width;
       		$this->API->addCSSRule('#gkBannerLeft { width: '.$left_banner_width.'%; }' . "\n");
       		$this->API->addCSSRule('#gkBannerRight { width: '.$banner_width.'%; }' . "\n");
       }
       // generate page content width
       $this->API->addCSSRule('#gkPageContent { width: '.$page_content_width.'%; }' . "\n");
       $this->API->addCSSRule('#gkPageContent > div { width: '.$page_content_div_width.'%; }' . "\n");
       // generate content width
       $this->API->addCSSRule('#gkContent { width: '.$content_width.'%; }' . "\n");
       // set the max width for the page
       $this->API->addCSSRule('.gkPage { max-width: '.$template_width.'px; }' . "\n");
	   // generate content wrap width
	   $this->API->addCSSRule('#gkContentWrap > div { width: '.$contentwrap_width.'%; }' . "\n");
	   // generate the data attributes
	   echo ' data-tablet-width="'.($tablet_width).'" data-tablet-small-width="'.($tablet_small_width).'" data-mobile-width="'.($mobile_width).'"';
	}
    // function to generate blocks paddings
    public function generateLayout() {
		$template_width = $this->API->get('template_width', 1230); // get the template width
		$tablet_width = $this->API->get('tablet_width', 1030); // get the tablet width
		$tablet_small_width = $this->API->get('tablet_small_width', 820); // get the small tablet width
		$mobile_width = $this->API->get('mobile_width', 580); // get the mobile width
		if($this->API->get('rwd', 1)) {
			// set media query for small desktops
			echo '<link rel="stylesheet" href="'.($this->API->URLtemplate()).'/css/small.desktop.css" media="(max-width: '.$template_width.'px)" />' . "\n";	
			// set media query for the tablet.css
			echo '<link rel="stylesheet" href="'.($this->API->URLtemplate()).'/css/tablet.css" media="(max-width: '.$tablet_width.'px)" />' . "\n";
			// set media query for the small tablets
			echo '<link rel="stylesheet" href="'.($this->API->URLtemplate()).'/css/small.tablet.css" media="(max-width: '.$tablet_small_width.'px)" />' . "\n";	
			// set media query for the mobile.css
			echo '<link rel="stylesheet" href="'.($this->API->URLtemplate()).'/css/mobile.css" media="(max-width: '.$mobile_width.'px)" />' . "\n";
	    }
    	// set CSS code for the messages
    	//$this->API->addCSSRule('#system-message-container { margin: 0 -'.$body_padding.'px; }');
      if($this->API->get("css_override", '0')) {
        echo '<link rel="stylesheet" href="'.($this->API->URLtemplate()).'/css/override.css" />' . "\n";
      }
    }
    
    public function getSidebarWidthOverride($side) {
    	// get current ItemID
        $ItemID = JRequest::getInt('Itemid');
        // get current option value
        $option = JRequest::getCmd('option');
        // override array
        $sidebar_width_override = $this->parent->config->get('sidebar_'.$side.'_width_override');
        // check the config
        if (isset($sidebar_width_override[$ItemID])) {
            return $sidebar_width_override[$ItemID];
        } else {
            return (isset($sidebar_width_override[$option])) ? $sidebar_width_override[$option] : $this->API->get('sidebar_'.$side.'_width', 30);
        }   
    }
    
    public function getInsetWidthOverride() {
    	// get current ItemID
        $ItemID = JRequest::getInt('Itemid');
        // get current option value
        $option = JRequest::getCmd('option');
        // override array
        $inset_width_override = $this->parent->config->get('inset_width_override');
        // check the config
        if (isset($inset_width_override[$ItemID])) {
            return $inset_width_override[$ItemID];
        } else {
            return (isset($inset_width_override[$option])) ? $inset_width_override[$option] : $this->API->get('inset_width', 30);
        }   
    }
    
    public function getInnerInsetWidthOverride() {
    	// get current ItemID
        $ItemID = JRequest::getInt('Itemid');
        // get current option value
        $option = JRequest::getCmd('option');
        // override array
        $inner_inset_width_override = $this->parent->config->get('inner_inset_width_override');
        // check the config
        if (isset($inner_inset_width_override[$ItemID])) {
            return $inner_inset_width_override[$ItemID];
        } else {
            return (isset($inner_inset_width_override[$option])) ? $inner_inset_width_override[$option] : $this->API->get('inner_inset_width', 30);
        }   
    }
    
	// function to check if the page is frontpage
	function isFrontpage() {
	    $app = JFactory::getApplication();
	    $menu = $app->getMenu();
	    $lang = JFactory::getLanguage();
	    return ($menu->getActive() == $menu->getDefault($lang->getTag()));    
	}

	public function addTouchIcon() {
	     $touch_image = $this->API->get('touch_image', '');
	    
	     if($touch_image == '') {
	          $touch_image = $this->API->URLtemplate() . '/images/touch-device.png';
	     } else {
	          $touch_image = $this->API->URLbase() . $touch_image;
	     }
	     $doc = JFactory::getDocument();
	     $doc->addCustomTag('<link rel="apple-touch-icon" href="'.$touch_image.'">');
	     $doc->addCustomTag('<link rel="apple-touch-icon-precomposed" href="'.$touch_image.'">');
	}

	public function addTemplateFavicon() {
		$favicon_image = $this->API->get('favicon_image', '');
		
		if($favicon_image == '') {
			$favicon_image = $this->API->URLtemplate() . '/images/favicon.ico';
		} else {
			$favicon_image = $this->API->URLbase() . $favicon_image;
		}
		
		$this->API->addFavicon($favicon_image);
	}
	
	public function getTemplateStyle($type) {
		$template_style = $this->API->get("template_color", 1);
		
		if($this->API->get("stylearea", 1)) {
			if(isset($_COOKIE['gk_'.$this->parent->name.'_'.$type])) {
				$template_style = $_COOKIE['gk_'.$this->parent->name.'_'.$type];
			} else {
				$template_style = $this->API->get("template_color", 1);
			}
		}
		
		return $template_style;
	}
}

// EOF