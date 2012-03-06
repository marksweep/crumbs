<?php
if (isset($breadcrumbs)) {

	// Home link
	if ((isset($homeLinkTitle) && $homeLinkTitle !== false) || !isset($homeLinkTitle)) {
		$homeLinkTitle = 'Home';
	} else {
		$homeLinkTitle = false;
	}
	
	// Loop through the breadcrumbs
	$content = '<div class="breadcrumbs">';
	
	$crumbs = '';
	if ($homeLinkTitle) {
		$crumbs 	= array($this->Html->link($homeLinkTitle, '/'));
	}
	foreach ($breadcrumbs as $crumb) {
		$class = '';
		if (isset($node['Node']['id']) && $crumb['Node']['id'] == $node['Node']['id']) {
			$crumbs[] = '<span class="current">' . $crumb['Node']['title'] . '</span>';	
		} else {
		$crumbs[] = $this->Html->link($crumb['Node']['title'], array( 'plugin'=> false, 'controller' => 'nodes', 'type' => 'page', 'action' => 'view', 'slug' => $crumb['Node']['slug']));
		}
	}
	
	// Explode out the breadcrumbs
	if (!isset($separator)) {
		$separator = ' / ';
	}
	$content .= implode($separator, $crumbs);
	echo $content . '</div>';
}
?>