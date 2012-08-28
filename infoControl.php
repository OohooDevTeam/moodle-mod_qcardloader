<?php
/**
**************************************************************************
**                              qcardloader                             **
**************************************************************************
* @package     mod                                                      **
* @subpackage  qcardloader                                              **
* @name        qcardloader                                              **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Theodore Pham                                            **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/

require_once(DIRNAME(DIRNAME(DIRNAME(__FILE__))).'/config.php');
require_once(dirname(__FILE__) . '/locallib.php');     
        
$user = optional_param('user',NULL, PARAM_TEXT);
$pass = optional_param('pass',NULL, PARAM_TEXT);

$downloadAll = optional_param('download',NULL, PARAM_TEXT);

$file_to_DL = optional_param('filename', NULL, PARAM_TEXT);

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
        
        if (count($filenames) != 0){
            //Returns true to app
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
                //Returns course along with associated files to the app
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
            //Finds the courses that the teachers have uploaded files
            if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
                $course_has_loader = array_intersect($registered_courseids, $ordered_course_id);
                $course_has_loader = reorderindex($course_has_loader);
            } else {
                $course_has_loader = array_intersect($ordered_course_id, $registered_courseids);
                $course_has_loader = reorderindex($course_has_loader);
            }
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
    
//Download all the files
} else if (isset($downloadAll)){

    echo "downloaded";      
    
    //return the file contents and the course name
    
} else if (isset($file_to_DL)){
    $fs = get_file_storage();
    $file_property = $DB->get_record('qcardfiles', array('filename'=>$file_to_DL));

    $file_content = $fs->get_file($file_property->contextid, $file_property->component, $file_property->filearea,
    $file_property->itemid, $file_property->filepath, $file_property->filename, $file_property->userid);

    $coursename = $file_property->coursename;

    echo $coursename . "#";
    //Displays the file content
    $file_content->readfile();
    
    return $file_content;
}
?>