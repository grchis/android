<?php

// no direct access
defined('_JEXEC') or die;

?>
<h2><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h2>

<ol>
<?php foreach ($this->link_items as &$item) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>">
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ol>
