<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright(C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/


logThis('Upgrade Wizard At Layout Commits');

global $mod_strings;
$curr_lang = 'en_us';
if(isset($GLOBALS['current_language']) && ($GLOBALS['current_language'] != null))
	$curr_lang = $GLOBALS['current_language'];

return_module_language($curr_lang, 'UpgradeWizard');
error_reporting(E_ERROR);
set_time_limit(0);
set_upgrade_progress('layouts','in_progress');

//If the user has seleceted which modules they want to merge, perform the filtering and 
//execute the merge.
if( isset($_POST['layoutSelectedModules']) )
{
    logThis('Layout Commits about to merge metadata');
    
    $availableModulesForMerge = $_SESSION['sugarMergeDryRunResults'];
    $selectedModules  = explode("^,^",$_POST['layoutSelectedModules']);
    $filteredModules = array();
    foreach ( $selectedModules as $moduleKey)
    {
        if(array_key_exists($moduleKey , $availableModulesForMerge))
        {
            logThis("Adding $moduleKey module to filtered layout module list for merge.");
            $filteredModules[] = $moduleKey;
        } 
    }
    
    if(file_exists('modules/UpgradeWizard/SugarMerge/SugarMerge.php'))
    {
        require_once('modules/UpgradeWizard/SugarMerge/SugarMerge.php');
        if(isset($_SESSION['unzip_dir']) && isset($_SESSION['zip_from_dir']))
        {
            logThis('Layout Commits starting three way merge with filtered list ' . print_r($filteredModules, TRUE));
            $merger = new SugarMerge($_SESSION['unzip_dir'].'/'.$_SESSION['zip_from_dir']);
            $layoutMergeData = $merger->mergeAll($filteredModules);
            logThis('Layout Commits finished merged');
        }
    }
	
    $stepBack = $_REQUEST['step'] - 1;
    $stepNext = $_REQUEST['step'] + 1;
    $stepCancel = -1;
    $stepRecheck = $_REQUEST['step'];
    $_SESSION['step'][$steps['files'][$_REQUEST['step']]] = 'success';
    
    logThis('Layout Commits completed successfully');
    $smarty->assign("CONFIRM_LAYOUT_HEADER", $mod_strings['LBL_UW_CONFIRM_LAYOUT_RESULTS']);
    $smarty->assign("CONFIRM_LAYOUT_DESC", $mod_strings['LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC']);
}
else 
{
    //Fist visit to the commit layout page.  Display the selection table to the user.
    logThis('Layout Commits about to show selection table');
    $smarty->assign("CONFIRM_LAYOUT_HEADER", $mod_strings['LBL_UW_CONFIRM_LAYOUTS']);
    $smarty->assign("CONFIRM_LAYOUT_DESC", $mod_strings['LBL_LAYOUT_MERGE_DESC']);
    $layoutMergeData = $_SESSION['sugarMergeDryRunResults'];
}

$smarty->assign("APP", $app_strings);
$smarty->assign("APP_LIST", $app_list_strings);
$smarty->assign("MOD", $mod_strings);
$layoutMergeData = formatLayoutMergeDataForDisplay($layoutMergeData);
$smarty->assign("METADATA_DATA", $layoutMergeData);
$uwMain = $smarty->fetch('modules/UpgradeWizard/tpls/layoutsMerge.tpl');
    
$showBack = FALSE;
$showCancel = FALSE;
$showRecheck = FALSE;
$showNext = TRUE;

set_upgrade_progress('layouts','done');

/**
 * Format dry run results from SugarMerge output to be used in the selection table.
 *
 * @param array $layoutMergeData
 * @return array
 */
function formatLayoutMergeDataForDisplay($layoutMergeData)
{
    global $mod_strings,$app_list_strings;
    
    $curr_lang = 'en_us';
    if(isset($GLOBALS['current_language']) && ($GLOBALS['current_language'] != null))
    	$curr_lang = $GLOBALS['current_language'];

    $module_builder_language = return_module_language($curr_lang, 'ModuleBuilder');

    $results = array();
    foreach ($layoutMergeData as $k => $v)
    {
        $layouts = array();
        foreach ($v as $layoutPath)
        {
            if( preg_match('/listviewdefs.php/i', $layoutPath) )
                $label = $module_builder_language['LBL_LISTVIEW'];
            else if( preg_match('/detailviewdefs.php/i', $layoutPath) )
                $label = $module_builder_language['LBL_DETAILVIEW'];
            else if( preg_match('/editviewdefs.php/i', $layoutPath) )
                $label = $module_builder_language['LBL_EDITVIEW'];
            else if( preg_match('/quickcreatedefs.php/i', $layoutPath) )
                $label = $module_builder_language['LBL_QUICKCREATE'];
            else if( preg_match('/searchdefs.php/i', $layoutPath) )
                $label = $module_builder_language['LBL_SEARCH'];
            else 
                continue;

            $layouts[] = array('path' => $layoutPath, 'label' => $label);
        }

        $results[$k]['layouts'] = $layouts; 
        $results[$k]['moduleName'] = $app_list_strings['moduleList'][$k]; 
    }

    return $results;
}