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
/// (Replace qcardloader with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // qcardloader instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('qcardloader', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $qcardloader  = $DB->get_record('qcardloader', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $qcardloader  = $DB->get_record('qcardloader', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $qcardloader->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('qcardloader', $qcardloader->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

add_to_log($course->id, 'qcardloader', 'view', "view.php?id={$cm->id}", $qcardloader->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/qcardloader/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($qcardloader->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('qcardloader-'.$somevar);

// Output starts here
echo $OUTPUT->header();
// Replace the following lines with you own code
echo $OUTPUT->heading('Yay! It works!');
echo"<script src='js/multifile.js'></script>";



//if ($qcardloader->intro) { // Conditions to show the intro can change to look for own settings or whatever
//    echo $OUTPUT->box(format_module_intro('qcardloader', $qcardloader, $cm->id), 'generalbox mod_introbox', 'qcardloaderintro');
//}



global $DB;

echo "<button onclick='console.log(\"HELLO\")'>Upload new file</button>";

$fs = get_file_storage();
    
print_object($fs);
    
echo "<input type='file' multiple >\n";

echo"<BR><BR><BR><BR>";




//	<!-- The file element -- NOTE: it has an ID -->
echo"<form enctype='multipart/form-data' action='your_script_here.script' method = 'post'>

	<input id='my_file_element' type='file' name='file_1'>
	<input type='submit'>
</form>";
echo"Files:";

echo"<div id='files_list'></div>";

echo <<<SCRIPT
<script type='text/javascript'>
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 5 );
	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
</script>
SCRIPT;




$fs = get_file_storage();
 
// Prepare file record object
$fileinfo = array(
    'contextid' => $context->id, // ID of context
    'component' => 'mod_qcardloader',     // usually = table name
    'filearea' => 'qcardloader',     // usually = table name
    'itemid' => 0,               // usually = ID of row in table
    'filepath' => '/',           // any path beginning and ending in /
    'filename' => 'testdata1.txt'); // any filename
 
// Create file containing text 'hello world'
$fs->create_file_from_pathname($fileinfo, 'hello world');



    
// Finish the page
echo $OUTPUT->footer();


//function vidtrans_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload) {
//
//	global $DB, $CFG;
//
//    $fileinfo = array(
//        'component' => 'mod_vidtrans', // usually = table name
//        'filearea' => $filearea, // usually = table name
//        'itemid' => $args[1], // usually = ID of row in table
//        'contextid' => $context->id, // ID of context
//        'filepath' => '/' . $args[0] . '/', // any path beginning and ending in /
//        'filename' => $args[2]); // any filename
//
//    $fs = get_file_storage();
//    $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
//
//    header("Content-Type: " . $file->get_mimetype());
//    header("Content-Length: " . $file->get_filesize());
//
//    $file->readfile();
//
//
//    die();
//}
//
//---
//To force a file download:
//
//$file_address = $CFG->wwwroot . '/pluginfile.php/' . $file->get_contextid()
//                    . '/' . $file->get_component() . '/' . $file->get_filearea()
//                    . '/' . $file->get_filepath() . $file->get_itemid()
//                    . '/' . $file->get_filename();
//					
//output the header:
//header('location: ' . $file_address);
//		http://us.battle.net/d3/en/forum/topic/5889888966
//		
//		
//		    header("Content-Disposition: attachment; filename='{$fileinfo['filename']}'");