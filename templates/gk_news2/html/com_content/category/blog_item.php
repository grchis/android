<?php

// no direct access
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = &$this->item->params;
$images = json_decode($this->item->images);
$canEdit	= $this->item->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.framework');

?>

<article<?php if ($this->item->state == 0) : ?> class="system-unpublished"<?php endif; ?>>		
	<?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
	<div class="img-intro-<?php echo $images->float_intro ? $images->float_intro : $params->get('float_intro'); ?> itemImageBlock">
		<img
			<?php if ($images->image_intro_caption):
				echo 'class="caption"'.' title="' .$images->image_intro_caption .'"';
			endif; ?>
			<?php if (!empty($images->image_intro)):?>
				style="float:<?php echo  $params->get('float_intro') ?>"
			<?php else: ?>
				style="float:<?php echo  $images->float_intro ?>"
			<?php endif; ?>
			src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>"/>
	</div>
	<?php endif; ?>
	
	<div class="itemBlock">
		<?php if ($params->get('show_title')) : ?>
		<header>
			<h2>
				<?php if ($params->get('access-view')) : ?>
					<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>">
					<?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
					<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
			</h2>
		</header>
		<?php endif; ?>
			
		<div class="itemBody<?php if (!$params->get('show_publish_date')) : ?> nodate<?php endif; ?>">
			<?php if (!$params->get('show_intro')) : ?>
				<?php echo $this->item->event->afterDisplayTitle; ?>
			<?php endif; ?>
			
			<?php echo $this->item->event->beforeDisplayContent; ?>
			
			<?php echo $this->item->introtext; ?>
		</div>
		
		<?php if (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date')) or ($params->get('show_parent_category')) or ($params->get('show_hits')) or ($params->get('show_create_date'))) : ?>
		 <ul>			
			<?php if ($params->get('show_publish_date')) : ?>
			<li><time datetime="<?php echo JHtml::_('date', $this->item->publish_up, JText::_(DATE_W3C)); ?>"><?php echo JHtml::_('date', $this->item->publish_up, 'F j, Y'); ?></time></li>
			<?php endif; ?>
			
			<?php if ($params->get('show_modify_date')) : ?>
			<li class="modified"><time datetime="<?php echo JHtml::_('date', $this->item->modified, JText::_(DATE_W3C)); ?>"><?php echo JHtml::_('date', $this->item->modified, 'F j, Y'); ?></time></li>
			<?php elseif ($params->get('show_create_date')) : ?>
			<li class="created"><time datetime="<?php echo JHtml::_('date', $this->item->created, JText::_(DATE_W3C)); ?>"><?php echo JHtml::_('date', $this->item->created, 'F j, Y'); ?></time></li>
			<?php endif; ?>

			<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
			<li class="createdby">
				<?php $author =  $this->item->author; ?>
				<?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>
		
					<?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
						<?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' ,
						 JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid), $author)); ?>
		
					<?php else :?>
						<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
					<?php endif; ?>
			</li>
			<?php endif; ?>
			
			<?php if ($params->get('show_parent_category') && $this->item->parent_id != 1) : ?>
			<li class="parent-category-name">
					<?php $title = $this->escape($this->item->parent_title);
						$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_id)) . '">' . $title . '</a>'; ?>
					<?php if ($params->get('link_parent_category')) : ?>
						<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
						<?php else : ?>
						<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
					<?php endif; ?>
			</li>
			<?php endif; ?>
			<?php if ($params->get('show_category')) : ?>
			<li class="category-name"><?php $title = $this->escape($this->item->category_title);
							$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)) . '">' . $title . '</a>'; ?><?php if ($params->get('link_category')) : ?><?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?><?php else : ?><?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?><?php endif; ?>
			</li>
			<?php endif; ?>
		
			<?php if ($params->get('show_hits')) : ?>
			<li class="hits"><?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>	
	</div>
</article>

<?php echo $this->item->event->afterDisplayContent; ?>