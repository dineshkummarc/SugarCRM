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

class TemplateDatetimecombo extends TemplateText{
	var $type = 'datetimecombo';
	var $len = '';
	var $dateStrings = array(
        'today'=>'now',
        'yesterday'=> '-1 day',
        'tomorrow'=>'+1 day',
        'next week'=> '+1 week',
        'next monday'=>'next monday + 1 day',
        'next friday'=>'next friday + 1 day',
        'two weeks'=> '+2 weeks',
        'next month'=> '+1 month',
        'first day of next month'=> 'first of next month', // must handle this non-GNU date string in SugarBean->populateDefaultValues; if we don't this will evaluate to 1969...
        'three months'=> '+3 months',  //kbrill Bug #17023
        'six months'=> '+6 months',
        'next year'=> '+1 year',
    );
    
    var $hoursStrings = array(
    	'01' => '01',	
    	'02' => '02',
    	'03' => '03',
    	'04' => '04',
    	'05' => '05',
    	'06' => '06',
    	'07' => '07',
    	'08' => '08',
    	'09' => '09',
    	'10' => '10',
    	'11' => '11',
    	'12' => '12',
    );
    
    var $minutesStrings = array(
    	'00' => '00',	
    	'15' => '15',
    	'30' => '30',
    	'45' => '45',
    );
    
    var $meridiemStrings = array(
    	'am' => 'am',
    	'pm' => 'pm',
    );
    
	function get_db_type(){
	    if($GLOBALS['db']->dbType == 'oracle'){
	        return " DATE ";
	    } else {
	        return " DATETIME ";
	    }
	}
	
	function get_db_default($modify=false){
			return '';
	}

	function get_field_def(){
		$def = parent::get_field_def();
		if($GLOBALS['db']->dbType == 'oracle'){
	        $def['dbType'] = 'date';
	    } else {
	        $def['dbType'] = 'datetime';
	    }
	    if(!empty($def['default'])){
			$def['display_default'] = $def['default'];
			$def['default'] = '';
		}
		return $def;
	}
	
	function save($df){
    	parent::save($df);
    } 
    
    function populateFromPost(){
    	if(!empty($_REQUEST['defaultDate']) && !empty($_REQUEST['defaultTime'])){
    		$_REQUEST['default'] = $_REQUEST['defaultDate'].'&'.$_REQUEST['defaultTime'];
    	}else{
    		$_REQUEST['default'] = '';
    	}
    	unset($_REQUEST['defaultDate']);
    	unset($_REQUEST['defaultTime']);
		foreach($this->vardef_map as $vardef=>$field){
			if(isset($_REQUEST[$vardef])){
				$this->$vardef = $_REQUEST[$vardef];
				if($vardef != $field){
					$this->$field = $this->$vardef;
				}
			}
		}
		$GLOBALS['log']->debug('populate: '.print_r($this,true));
	}
	
}
?>
