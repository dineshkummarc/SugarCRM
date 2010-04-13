<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/



require_once('include/tabConfig.php');

class GroupedTabStructure
{
	/** 
     * Prepare the tabs structure.
     * Uses 'Other' tab functionality.
     * If $modList is not specified, $modListHeader is used as default.
     * 
     * @param   array   optional list of modules considered valid
     * @param   array   optional array to temporarily union into the root of the tab structure 
    * @param bool  if  we set this param true, the other group tab will be returned no matter  $sugar_config['other_group_tab_displayed'] is true or false
     * @param bool  We use label value as return array key by default. But we can set this param true, that we can use the label name as return array key.
     * 
     * @return  array   the complete tab-group structure
	 */
    function get_tab_structure($modList = '', $patch = '', $ignoreSugarConfig=false, $labelAsKey=false)
    {
    	global $modListHeader, $app_strings, $modInvisListActivities;
        
        /* Use default if not provided */
        if(!$modList)
        {
        	$modList =& $modListHeader;
        }
        
        /* Apply patch, use a reference if we can */
        if($patch)
        {
        	$tabStructure = $GLOBALS['tabStructure'];
        	
            foreach($patch as $mainTab => $subModules)
            {
                $tabStructure[$mainTab]['modules'] = array_merge($tabStructure[$mainTab]['modules'], $subModules);
            }
        }
        else
        {
        	$tabStructure =& $GLOBALS['tabStructure'];
        }
        
        $retStruct = array();
        $mlhUsed = array();
		//the invisible list should be merged if activities is set to be hidden
        if(in_array('Activities', $modList)){
        	$modList = array_merge($modList,$modInvisListActivities);
		}
		
		//Add any iFrame tabs to the 'other' group.
		$moduleExtraMenu = array();
		if(!should_hide_iframes()) {
			$iFrame = new iFrame();
			$frames = $iFrame->lookup_frames('tab');	
	        foreach($frames as $key => $values){
	        	$moduleExtraMenu[$key] = $values;
	        }
		} else if(isset($modList['iFrames'])) {
		    unset($modList['iFrames']);
		}
				
        $modList = array_merge($modList,$moduleExtraMenu);
                
        /* Only return modules which exists in the modList */
        foreach($tabStructure as $mainTab => $subModules)
        {
            //Ensure even empty groups are returned
        	if($labelAsKey){
                $retStruct[$subModules['label']]['modules'] = array();
            }else{
                $retStruct[$app_strings[$subModules['label']]]['modules']= array();
            }
            
            foreach($subModules['modules'] as $key => $subModule)
            {
               /* Perform a case-insensitive in_array check
                * and mark whichever module matched as used.
                */ 
                foreach($modList as $module)
                {
                    if(is_string($module) && strcasecmp($subModule, $module) === 0)
                    {
                    	if($labelAsKey){
                    		$retStruct[$subModules['label']]['modules'][] = $subModule;
                    	}else{
                    		$retStruct[$app_strings[$subModules['label']]]['modules'][] = $subModule;
                    	}                        
                        $mlhUsed[$module] = true;
                        break;
                    }
                }
            }
			//remove the group tabs if it has no sub modules under it	        
            if($labelAsKey){
                    if (empty($retStruct[$subModules['label']]['modules'])){
                    unset($retStruct[$subModules['label']]);
                    }
                    }else{
                    if (empty($retStruct[$app_strings[$subModules['label']]]['modules'])){
                    unset($retStruct[$app_strings[$subModules['label']]]);
                    }
			}
        }
        
       //The other tab is shown by default . If the other_group_tab_displayed was set false in sugar config, we will not show the 'Other' tab in Group Tab List.
        global $sugar_config;
        //If return result ignore sugar config or $sugar_config['other_group_tab_displayed'] is not set ever or $sugar_config['other_group_tab_displayed'] is true 
        if($ignoreSugarConfig || ( !isset($sugar_config['other_group_tab_displayed']) || $sugar_config['other_group_tab_displayed'])){
        /* Put all the unused modules in modList
         * into the 'Other' tab.
         */
	        foreach($modList as $module)
	        {
	        	if(is_array($module) || !isset($mlhUsed[$module]))
	            {
		            	if($labelAsKey){
		            		$retStruct['LBL_TABGROUP_OTHER']['modules'] []= $module;
	            		}else{
			            	$retStruct[$app_strings['LBL_TABGROUP_OTHER']]['modules'] []= $module;
			            }
	            }
	        }
        }else{
        	//If  the 'Other' group tab was not allowed returned, we should check the $retStruct array to make sure there is no 'Other' group tab in it.
        	if(isset($retStruct[$app_strings['LBL_TABGROUP_OTHER']])){
        		if($labelAsKey){
            		unset($retStruct['LBL_TABGROUP_OTHER']);
        		}else{
        			unset($retStruct[$app_strings['LBL_TABGROUP_OTHER']]);
        		}
        
        	}	        	
        }
//        _pp($retStruct);
        return $retStruct;
    }
}

?>
