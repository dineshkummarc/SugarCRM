<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_field} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_field<br>
 * Purpose:  retreives the smarty equivalent for use by TemplateHandler
 * 
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */
require_once('include/SugarFields/SugarFieldHandler.php');

function smarty_function_sugar_field($params, &$smarty)
{
    if (!isset($params['vardef']) || !isset($params['displayType']) || !isset($params['parentFieldArray'])) {
        if(!isset($params['vardef']))
            $smarty->trigger_error("sugar_field: missing 'vardef' parameter");
        if(!isset($params['displayType']))  
            $smarty->trigger_error("sugar_field: missing 'displayType' parameter");
        if(!isset($params['parentFieldArray']))  
            $smarty->trigger_error("sugar_field: missing 'parentFieldArray' parameter");
                             
        return;
    }

    static $sfh;
    if(!isset($sfh)) $sfh = new SugarFieldHandler();
    
    if(!isset($params['displayParams'])) $displayParams = array();
    else $displayParams = $params['displayParams'];
    
    if(isset($params['labelSpan'])) $displayParams['labelSpan'] = $params['labelSpan'];
    else $displayParams['labelSpan'] = null;
    if(isset($params['fieldSpan'])) $displayParams['fieldSpan'] = $params['fieldSpan'];
    else $displayParams['fieldSpan'] = null;

    if(isset($params['typeOverride'])) { // override the type in the vardef?
        $params['vardef']['type'] = $params['typeOverride']; 
    }
    if(isset($params['formName'])) $displayParams['formName'] = $params['formName'];
    
    if(isset($params['field'])) {
        $params['vardef']['name'] = $params['field'];
    }
   
    $_contents = $sfh->displaySmarty($params['parentFieldArray'], $params['vardef'], $params['displayType'], $displayParams, $params['tabindex']);   
    
    return $_contents;
}
?>
