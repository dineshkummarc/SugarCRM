<?php

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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldBool extends SugarFieldBase {
	/**
	 *
	 * @return The html for a drop down if the search field is not 'my_items_only' or a dropdown for all other fields.
	 *			This strange behavior arises from the special needs of PM. They want the my items to be checkboxes and all other boolean fields to be dropdowns.			
	 * @author Navjeet Singh
	 * @param $parentFieldArray - 
	 **/
	function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		if( preg_match("/current_user_only.*/", $vardef['name']) )
			return $this->fetch('include/SugarFields/Fields/Bool/EditView.tpl');
		else
			return $this->fetch('include/SugarFields/Fields/Bool/SearchView.tpl');
		
	}
    	
    public function getEmailTemplateValue($inputField, $vardef, $displayParams = array(), $tabindex = 0){
        global $app_list_strings;
        // This does not return a smarty section, instead it returns a direct value
        if ( $inputField == 'bool_true' || $inputField == true ) {
            return $app_list_strings['checkbox_dom']['1'];
        } else {
            return $app_list_strings['checkbox_dom']['2'];
        }
    }

    public function unformatField($formattedField, $vardef){
        if ( empty($formattedField) ) {
            $unformattedField = 0;
            return $unformattedField;
        }
        if ( $formattedField == '0' || $formattedField == 'off' || $formattedField == 'false' || $formattedField == 'no' ) {
            $unformattedField = 0;
        } else {
            $unformattedField = 1;
        }
        
        return $unformattedField;
    }

}

?>
