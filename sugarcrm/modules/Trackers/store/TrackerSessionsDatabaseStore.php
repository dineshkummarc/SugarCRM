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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
require_once('modules/Trackers/store/Store.php');
class TrackerSessionsDatabaseStore implements Store {
    
    public function flush($monitor) {

       $metrics = $monitor->getMetrics();
       $columns = array();
       $values = array();
       foreach($metrics as $name=>$metric) {
       	  if(!empty($monitor->$name)) {
       	  	 $columns[] = $name;
       	  	 if($metrics[$name]->_type == 'int' || $metrics[$name]->_type == 'double') {
                $values[] = $GLOBALS['db']->quote($monitor->$name);
             } else if ($metrics[$name]->_type == 'datetime') {
             	$values[] = ($GLOBALS['db']->dbType == 'oci8') ? db_convert("'".$monitor->$name."'",'datetime') : "'".$monitor->$name."'";
       	  	 } else {
                $values[] = "'".$GLOBALS['db']->quote($monitor->$name)."'";
             }     
       	  }
       } //foreach
       
       if(empty($values)) {
       	  return;
       }
       
       if ( !isset($monitor->round_trips) ) $monitor->round_trips = 0;
       if ( !isset($monitor->active) ) $monitor->active = 1;
       if($monitor->round_trips == 1) {
		  $query = "INSERT INTO $monitor->table_name (" .implode("," , $columns). " ) VALUES ( ". implode("," , $values). ')';
		  $GLOBALS['db']->query($query);
       } else {
       	  $query = "UPDATE $monitor->table_name SET date_end = '{$monitor->date_end}' , seconds = {$monitor->seconds}, active = '{$monitor->active}', round_trips = $monitor->round_trips WHERE session_id = '{$monitor->session_id}'";
       	  $GLOBALS['db']->query($query);
       }
    }
}

?>
