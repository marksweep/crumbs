<?php

	/**
	 * recurseSubpages function.
	 * Recurses through a subpage datastructure ((Node)child, (Array)children)
	 * Building a submenu of nested <ul>s.
	 * @param $view View object for this current view
	 * @param $subpages mixed Array of child and children nodes
	 *
	 * @return string Returns html string.
	 */
	function recurseSubpages($view, $subpages, $current, $parent_ids, $isChild = null) {
		if ($subpages) {
			$content = '<ul>';
			$isFirst = true;
			
			// Loop through children of this page
			foreach ($subpages as $page) {
				$class = '';
				if (isset($current) && $current['Node']['id'] == $page['child']['Node']['id']) {
					$class = 'current';
				} else if (in_array($page['child']['Node']['id'], $parent_ids)) {
					$class = 'parent';
				} else if ($isChild) {
					$class = 'child';
				}
			
				// Tag the first child with a special class
				$content .= '<li class="' . ($isFirst ? 'first' : '') . '">' . $view->Html->link($page['child']['Node']['title'], array('plugin' => false, 'controller' => 'nodes', 'type'=>'page', 'action' => 'view', 'slug' => $page['child']['Node']['slug']), array('class' => $class));
				
				$content .= recurseSubpages($view, $page['children'], $current, $parent_ids, ($class == 'current'));
				
				$content .= '</li>';
				
				$isFirst = false;
			}
			$content .= '</ul>';
			return $content;
		}
	}
	
	if (isset($subpages)) {
?>
	<div class="subnav">
<?php
		$current = null;
		if (isset($node['Node']['id'])) {
			$current = $node;
		}
		// Extract breadcrumbs
		$parent_ids = Set::extract($breadcrumbs, '{n}.Node.id');
		echo recurseSubpages($this, $subpages, $current, $parent_ids);
?>
	</div>
<?php }	?>

