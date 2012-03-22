<?php
/**
 * Crumbs Behavior
 *
 * PHP version 5
 *
 * @category Behavior
 * @package  Crumbs
 * @version  1.0
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/marksweep/crumbs
 */
 App::import('component', 'Crumbs');
 
class CrumbsBehavior extends ModelBehavior {

	public $attach = false;
	
	protected $currentModel;
	
	/**
	 * Setup
	 *
	 * @param object $model
	 * @param array  $config
	 * @return void
	 */
    public function setup(&$model, $config = array()) {
        if (is_string($config)) {
            $config = array($config);
        }
		$this->currentModel = $model;
        $this->settings[$model->alias] = $config;
    }
    
    public function beforeSave(&$model) {
    
    	if ($model->id) {
    	
    		// Delete crumbs cache for this model
    		// We will traverse the tree to make sure
    		// everthing is cached out
    		$this->deleteCacheTree($model);
    	    	
    	}
    	
    	return true;
    }
    
    public function afterSave($created) {
    
    	// Delete crumbs cache for this model 
    	// We do this again because we might have a new parent
    	// that needs to be flushed
    	$this->deleteCacheTree();
    
    	return true;
    }
    
    public function beforeDelete(&$model) {
    
    	if ($model->id) {
    		
    		// Delete crumbs cache for this model
    		$this->deleteCacheTree($model);
    	    	
    	}
    	
    	return true;
    }
   
    public function deleteCacheTree($model = null) {
    
    	if (!$model) {
    		$model = $this->currentModel;
    	}
    	$p = $model->data;
    	if (isset($p['Node']['id'])) {
			while ($parent = $model->getparentnode($p['Node']['id'])) {
				// Build the breadcrumbs
				if (isset($p['Node']['id']) && $p['Node']['id'] == $parent['Node']['id']) {
					break;
				}
				$p = $parent;
			}
			$subpages = $model->children($p['Node']['id']);
			
			foreach ($subpages as $child) {
				$model_id = $child['Node']['id'];
	    		$cache_identifier = 'crumbs_node_' . $model_id;
	    		Cache::delete($cache_identifier);
	    	}
	    }
    }

}
?>