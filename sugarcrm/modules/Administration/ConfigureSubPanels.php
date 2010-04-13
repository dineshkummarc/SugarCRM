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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Administration/Forms.php');
require_once ('include/SubPanel/SubPanelDefinitions.php') ;
require_once("modules/MySettings/TabController.php");

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;

$mod_list_strings_key_to_lower = array_change_key_case($app_list_strings['moduleList']);

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

	//////////////////  Processing Save
	//if coming from save, iterate through array and save into user preferences
		$panels_to_show = '';
		$panels_to_hide = '';

	if(isset($_REQUEST['Save_or_Cancel']) && $_REQUEST['Save_or_Cancel']=='save'){
		if(isset($_REQUEST['disabled_panels'])) 
			$panels_to_hide = $_REQUEST['disabled_panels'];
		//turn list  into array
		$hidpanels_arr = explode(',',$panels_to_hide);
		$hidpanels_arr = TabController::get_key_array($hidpanels_arr);
		
		//save list of subpanels to hide
		SubPanelDefinitions::set_hidden_subpanels($hidpanels_arr);
		echo "true";
	} else 
	{
	//////////////////  Processing UI
	//create title for form
	$title = get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_CONFIGURE_SUBPANELS'].":", true);
	
	//get list of all subpanels and panels to hide 
	$panels_arr = SubPanelDefinitions::get_all_subpanels();
	$hidpanels_arr = SubPanelDefinitions::get_hidden_subpanels();

	if(!$hidpanels_arr || !is_array($hidpanels_arr)) $hidpanels_arr = array();

	//create array of subpanels to show, used to create Drag and Drop widget
	$enabled = array();
	foreach ($panels_arr as $key)
	{
		if(empty($key)) continue;
		$key = strtolower($key);
		$enabled[] =  array("module" => $key, "label" => $mod_list_strings_key_to_lower[$key]);
	}
	
	//now create array of panels to hide for use in Drag and Drop widget
	$disabled = array();
	foreach ($hidpanels_arr as $key)
	{
		if(empty($key)) continue;
		$key = strtolower($key);
		$disabled[] =  array("module" => $key, "label" => $mod_list_strings_key_to_lower[$key]);
	}


	
		$this->ss->assign('title',  $title);
		$this->ss->assign('description', $mod_strings['LBL_CONFIG_SUBPANELS']);
        $this->ss->assign('enabled_panels', json_encode($enabled));
        $this->ss->assign('disabled_panels', json_encode($disabled));
        $this->ss->assign('mod', $mod_strings);
        $this->ss->assign('APP', $app_strings);

        //echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_CONFIG_SUBPANELS'], true);
        echo $this->ss->fetch('modules/Administration/ConfigureSubPanelsForm.tpl');	
	}

?>
