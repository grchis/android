<?php

// No direct access.
defined('_JEXEC') or die;

?>

<footer id="gkFooter">
	<div class="gkPage">
		<?php if($this->API->modules('footer') || $this->API->get('back_to_top') == '1') : ?>
		<div id="gkFooterArea">
			<?php if($this->API->get('back_to_top') == '1') : ?>
			<a href="#gkBg" id="gkBackToTop"><?php echo JText::_('TPL_GK_LANG_BACKTOTOP'); ?></a>
			<?php endif; ?>
			
			<?php if($this->API->modules('footer')) : ?>
			<div>
				<jdoc:include type="modules" name="footer" style="<?php echo $this->module_styles['footer']; ?>" modnum="<?php echo $this->API->modules('footer'); ?>" />
			</div>
			<?php endif; ?>	
		</div>
		<?php endif; ?>
		
		<?php if($this->API->modules('footer_nav')) : ?>
		<div id="gkFooterNav">
			<jdoc:include type="modules" name="footer_nav" style="<?php echo $this->module_styles['footer_nav']; ?>" modnum="<?php echo $this->API->modules('footer_nav'); ?>" />
		</div>
		<?php endif; ?>
		
		<?php if($this->API->get('copyrights', '') !== '') : ?>
		<p id="gkCopyrights"><?php echo $this->API->get('copyrights', ''); ?></p>
		<?php else : ?>
		<p id="gkCopyrights">Joomla Template by <a href="https://www.gavick.com">GavickPro</a>.</p>
		<?php endif; ?>
		
		<?php if($this->API->get('stylearea', '0') == '1') : ?>
		<div id="gkStyleArea">
	    	<a href="#" id="gkColor1"><?php echo JText::_('TPL_GK_LANG_COLOR_1'); ?></a>
	    	<a href="#" id="gkColor2"><?php echo JText::_('TPL_GK_LANG_COLOR_2'); ?></a>
	  		<a href="#" id="gkColor3"><?php echo JText::_('TPL_GK_LANG_COLOR_3'); ?></a>
	  		<a href="#" id="gkColor4"><?php echo JText::_('TPL_GK_LANG_COLOR_4'); ?></a>
	  		<a href="#" id="gkColor5"><?php echo JText::_('TPL_GK_LANG_COLOR_5'); ?></a>
	  		<a href="#" id="gkColor6"><?php echo JText::_('TPL_GK_LANG_COLOR_6'); ?></a>
	  	</div>
		<?php endif; ?>
		
		<?php if($this->API->get('framework_logo', '0') == '1') : ?>
		<a href="//gavick.com" rel="nofollow" id="gkFrameworkLogo" title="Gavern Framework">Gavern Framework</a>
		<?php endif; ?>
	</div>
</footer>

<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
	var isMobile = navigator.userAgent.contains('Mobile');
	if (isMobile){
		document.getElementById('gkFooter').remove();

	}
</script>
