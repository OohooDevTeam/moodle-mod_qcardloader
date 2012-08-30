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

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');

global $DB, $PAGE;

//Optional Params
$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$q = optional_param('n', 0, PARAM_INT);  // qcardloader instance ID - it should be named as the first character of the module

if ($id) {
    $cm = get_coursemodule_from_id('qcardloader', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $qcardloader = $DB->get_record('qcardloader', array('id' => $cm->instance), '*', MUST_EXIST);
    $courseid = $course->id;

} elseif ($q) {
    $qcardloader = $DB->get_record('qcardloader', array('id' => $q), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $qcardloader->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('qcardloader', $qcardloader->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

$PAGE->set_url('/mod/qcardloader/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($qcardloader->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

//CSS for buttons
$PAGE->requires->css(new moodle_url('/mod/qcardloader/css/bootstrap.min.css'));
//CSS for hiding the default button layout
$PAGE->requires->css(new moodle_url('/mod/qcardloader/css/jquery.fileupload-ui.css'));
//CSS for the display table
$PAGE->requires->css(new moodle_url('/mod/qcardloader/css/table.css'));

//Jquery
$PAGE->requires->js(new moodle_url('/mod/qcardloader/js/jquery-1.7.2.js'));
$PAGE->requires->js(new moodle_url('/mod/qcardloader/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'));
//Checks file extension
$PAGE->requires->js(new moodle_url('/mod/qcardloader/js/ext_check.js'));

// Output starts here
echo $OUTPUT->header();

//	<!-- The file element -- NOTE: it has an ID -->
//Uploading mulitple files using one input field
echo "<form id='fileupload' enctype='multipart/form-data' action='store_file.php?coursename=$course->fullname&courseid=$course->id&cmid=$cm->id&contextid=$context->id' method = 'POST'>";

//Allows users to select files they want to upload
echo '<span class="btn btn-success fileinput-button">';
echo '      <i class="icon-plus icon-white"></i>';
echo '      <span>'. get_string('addfile', 'qcardloader') .'</span>';
echo '      <input id="myfile" type="file" name="file[]" onchange="validateFile(this.value)" multiple="multiple"/>';
echo '</span>';

//Stores files in the database
echo '<button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>'. get_string('upload', 'qcardloader') .'</span>
                </button>';

//Remove file user has chosen to upload
echo '<button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>'. get_string('cancel', 'qcardloader') .'</span>
                </button>';

//Delete Files button
echo '<button type="button" class="btn btn-danger delete" onclick="deleteFiles('.$context->id . ',' . $cm->id. ',' . $courseid.')">
                    <i class="icon-trash icon-white"></i>
                    <span>'. get_string('delete', 'qcardloader') .'</span>
                </button>';

echo '<table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"><tr class="template-upload fade in">
    </tr></tbody></table>';

//Displays the selected files
//http://jsfiddle.net/xUzcS/
echo '<output id="list"></output>';

echo"<BR><BR><BR><BR>";
echo'</form>';

//Checkboxes
echo "<form id='check' method='post' action=''>";
//Grab all the files to display
$files = $DB->get_records('qcardfiles', array('courseid'=>$courseid, 'cmid'=>$id));
check_all();
echo'<div class="datagrid"><table id="tbl">';
echo'<thead>';
echo'    <tr>';
echo'        <th>'. get_string('filename', 'qcardloader') .'</th>';
echo'        <th>'. get_string('filesize', 'qcardloader') .'</th>';
echo'        <th>'. get_string('datetime', 'qcardloader') .'</th>';
echo"        <th><input type='checkbox' id='checkall' name='checkall' onclick='checkedAll(); return false;' /><br /></th>";
echo'    </tr>';
echo'</thead>';
echo"<tbody>";

$iterator = 0;
//Display all the files that the prof has uploaded
foreach ($files as $file){
echo"    <tr id='$iterator'>";
echo"        <td class='cell'>$file->filename</td>";
echo"        <td class='cell'>$file->filesize</td>";
echo"        <td class='cell'>$file->time_modified</td>";
echo"        <td class='cell'><input type='checkbox' id='$iterator'  name='checkbox[]' value='$file->filename' /><br /></td>";
echo"    </tr>";
}
echo "</form>";
echo'</tbody>';
echo'</table></div>';


// Finish the page
echo $OUTPUT->footer();