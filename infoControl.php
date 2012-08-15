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
require_once(dirname(__FILE__) . '/locallib.php');     
require_once(dirname(__FILE__) . '/locallib.php');     

//require_once(dirname(__FILE__).'/lib.php');

$user = optional_param('user',NULL, PARAM_TEXT);
$pass = optional_param('pass',NULL, PARAM_TEXT);

$downloadAll = optional_param('download',NULL, PARAM_TEXT);
$file_to_DL = optional_param('filename', NULL, PARAM_TEXT);
$request = optional_param('request', NULL, PARAM_TEXT);

//checks if request is coming from app or web
if ($request != 'app'){
    require_login();
} else {
    //do nothing
}

if ((isset ($user)) && (isset ($pass)))
{
    //Checks if user exists
    $auth = authenticate_user_login($user, $pass);
    
    //User exists
    if($auth == true){
        $userinfo = $DB->get_record('user', array('username'=>$user));

        //Gets all the courses the user is enrolled in
        $courses = enrol_get_users_courses($userinfo->id);
        $registered_courseids = array();
        $registered_courseids = array_keys($courses);
        
        $fs = get_file_storage();

        //Grabs the files
        $filenames = $DB->get_records('qcardfiles', array('userid'=>$userinfo->id));

        //Check if there are any files stored
        if (count($filenames) != 0){
            echo "true\n";
            foreach ($filenames as $file){

                $courseid_array[] = $file->courseid;
                $coursename_array[] = $file->coursename;

                $files = $fs->get_file($file->contextid, $file->component, $file->filearea,
                $file->itemid, $file->filepath, $file->filename, $file->userid);

            }               
            //Filters out the duplicate course ids and names and then reorders them
            $conditions_list = array(TRUE, FALSE, NULL);
            $unique_course_id = array_unique($courseid_array);
            $ordered_course_id = reorderindex($unique_course_id, $conditions_list);    

            $unique_course_name = array_unique($coursename_array);
            $ordered_course_name = reorderindex($unique_course_name, $conditions_list);
            for($i=0; $i < sizeof($ordered_course_name); $i++){
                echo "course:\n";
                echo $ordered_course_name[$i];
                echo "\n";
                
                foreach ($filenames as $file){
                    if($file->coursename == $ordered_course_name[$i]){
                        echo "file:\n";
                        echo $file->filename;
                        echo "\n";
                    }  
                }
            }
            //Finds the courses that the teachers have uploaded files in 
            if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
                $course_has_loader = array_intersect($registered_courseids, $ordered_course_id);
                $course_has_loader = reorderindex($course_has_loader);
            } else {
                $course_has_loader = array_intersect($ordered_course_id, $registered_courseids);
                $course_has_loader = reorderindex($course_has_loader);
            }
        //database has no records
        } else {
            echo "empty";
        }
    //User !exists
    } else if (user_exists($user) == false){
        echo "DNE";
    } else {
        //Authetication failed
        echo "false";
    }
    
//download all the files
} else if (isset($downloadAll)){

    echo "downloaded";      
    
//return the file contents and the course name
} else if (isset($file_to_DL)){
    $fs = get_file_storage();
    $file_property = $DB->get_record('qcardfiles', array('filename'=>$file_to_DL));

    $file_content = $fs->get_file($file_property->contextid, $file_property->component, $file_property->filearea,
    $file_property->itemid, $file_property->filepath, $file_property->filename, $file_property->userid);

    $coursename = $file_property->coursename;

    //returns the coursename along with a delimiter for parsing in the app
    echo $coursename . "#";
    //Displays the file content
    $file_content->readfile();
    
    
    //return $file_content;
}
?>