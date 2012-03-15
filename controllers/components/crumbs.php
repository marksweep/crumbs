<?php
/**
 * Crumbs Component
 *
 * An Crumbs hook component for demonstrating hook system.
 *
 * @category Component
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CrumbsComponent extends Object {

	var $controller;
/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param object $controller Controller with components to startup
 * @return void
 */
    public function startup(&$controller) {
        $controller->set('CrumbsComponent', 'CrumbsComponent startup');
	}
/**
 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
 * Controller::render()
 *
 * @param object $controller Controller with components to beforeRender
 * @return void
 */
    public function beforeRender(&$controller) {
    	
    	if (isset($controller->viewVars['node'])) {
    		// Find the parent node
    		$p 				= $controller->viewVars['node'];
    		
    		// Are the crumbs cached?
    		$cache_identifier = 'crumbs_node_' . $p['Node']['id'];
    		if (($crumbs = Cache::read($cache_identifier)) === false){
    
	    		$breadcrumbs 	= array($p);
	    		while ($parent = $controller->Node->getparentnode($p['Node']['id'])) {
	    			// Build the breadcrumbs
	    			array_unshift($breadcrumbs, $parent);
	    			if (isset($p['Node']['id']) && $p['Node']['id'] == $parent['Node']['id']) {
	    				break;
	    			}
	    			$p = $parent;
	    		}
	    		if (!$p) {
	    			$p = $controller->viewVars['node'];
	       		}
	       		
	       		// Recurse down and find all my subpages
				$subpages = array(array('child' => $p, 'children' => self::recurseSubpages($controller->Node, $p)));	
				$treelist = $controller->Node->generatetreelist();
			
				// Cache these items into our crumbs array
				$crumbs = array(
					'breadcrumbs' 	=> $breadcrumbs,
					'subpages' 		=> $subpages,
					'treelist'		=> $treelist
				);
				
				Cache::write($cache_identifier, $crumbs);
			}			
			// Set some view variables	
			$controller->viewVars['subpages'] 		= $crumbs['subpages'];	
			$controller->viewVars['breadcrumbs'] 	= $crumbs['breadcrumbs'];
			$controller->viewVars['treelist'] 		= $crumbs['treelist'];
    	}
    }
    
    /**
     * recurseSubpages function.
     * 
     * @access public
     * @param mixed &$controller
     * @param mixed $node
     * @return void
     */
    public static function recurseSubpages(&$Node, $node) {

    	if (!isset($node['Node']['id'])) {
    		return false;
    	}
    	
    	// Find the children of this node
    	$children = $Node->children($node['Node']['id'], true, array('id', 'path', 'parent_id', 'title', 'slug'));
    	$all = array();
    	foreach ($children as $child) {
    		$leaf = array('child'=>$child, 'children' => self::recurseSubpages(&$Node, $child));
    		$all[] = $leaf;
    	}
    	
    	return $all;
    
    }
        
/**
 * Called after Controller::render() and before the output is printed to the browser.
 *
 * @param object $controller Controller with components to shutdown
 * @return void
 */
    public function shutdown(&$controller) {
    }
    
}
?>