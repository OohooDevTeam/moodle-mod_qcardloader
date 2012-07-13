<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of qcardloader
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod
 * @subpackage qcardloader
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(DIRNAME(DIRNAME(DIRNAME(__FILE__))).'/config.php');
        
        
$user = optional_param('user',NULL, PARAM_TEXT);
$pass = optional_param('pass',NULL, PARAM_TEXT);

$download = optional_param('download',NULL, PARAM_TEXT);

	
	if ((isset ($user)) && (isset ($pass)))
	{
            //Checks if user exists
            $auth = authenticate_user_login($user, $pass);
            //User exists
            if($auth == true){
                echo "true";
                
                $userinfo = $DB->get_record('user', array('username'=>$user));
                
                $filenames = $DB->get_records('qcardfiles', array('userid'=>$userinfo->id));
                foreach ($filenames as $file){
                    
                    echo $file->filename;
                    
                }
            //User !exists
            } else {
                echo "false";

            }
	}
        
        if (isset($download)){
            
            
            
        }

?>