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
 * @link     http://github.com/marksweep/revisions
 */
 
class CrumbsBehavior extends ModelBehavior {

	public $attach = false;
	
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

        $this->settings[$model->alias] = $config;
    }
    
    public function beforeSave(&$model) {
    
    	if ($model->id) {
    	
    		// Delete crumbs cache for this model
    		$cache_identifier = 'crumbs_node_' . $model_id;
    		Cache::delete($cache_identifier);
    	    	
    	}
    	
    	return true;
    }
    
    public function beforeDelete(&$model) {
    
    	if ($model->id) {
    		
    		// Delete crumbs cache for this model
    		$cache_identifier = 'crumbs_node_' . $model_id;
    		Cache::delete($cache_identifier);
    	    	
    	}
    	
    	return true;
    }
   
    

}
?>