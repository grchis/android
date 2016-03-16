<?php 
require_once('menu_filter.php');
?>
<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_REQUESTS').'<br /><a href="'.$link_add.'" class="sa_lk_profile">'.JText::_('SA_ADD_REQUEST_NOW').'</a>'; ?>
		</div>
	</div>
	</div>
<style type="text/css">
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
