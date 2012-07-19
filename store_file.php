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

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

// Output starts here
echo $OUTPUT->header();

global $DB, $CFG, $PAGE;

require_login();

$coursename = required_param('coursename', PARAM_TEXT);
$courseid = required_param('courseid', PARAM_INT);
$cmid = required_param('cmid', PARAM_INT);
$contextid = required_param('contextid', PARAM_INT);

$i = 0;
$fs = get_file_storage();

//Works, but not safe
//if (($_REQUEST['coursename'] & $_REQUEST['courseid'] & $_REQUEST['cmid'] & $_REQUEST['contextid']) != NULL)

print_object($_FILES);
print_object($fs);

$newfile = new stdClass();
$newfile->coursename = $coursename;
$newfile->courseid = $courseid;
$newfile->cmid = $cmid;
$newfile->contextid = $contextid;
$newfile->userid = $USER->id;
$newfile->time_created = date('(m/d/Y H:i:s)', time());

for ($i; $i < count($_FILES['file']['name']); $i++){
    // Prepare file record object
    $fileinfo = array(
    //    'contextid' => $context->id, // ID of context
        'contextid' => $contextid,
        'component' => 'mod_qcardloader',     // usually = table name
        'filearea' => 'qcardloader',     // usually = table name
        'itemid' => 0,               // usually = ID of row in table
        'filepath' => '/' . 'mod/qcardloader/files' . '/',           // any path beginning and ending in /
        'filename' => $_FILES['file']['name'][$i], // any filename
        'userid' => $USER->id);
    // Create file and saves in database "files"
    $fs->create_file_from_pathname($fileinfo, $_FILES['file']['tmp_name'][$i]);

    $newfile->filename = $_FILES['file']['name'][$i];
    $newfile->filesize = $_FILES['file']['size'][$i]; 
    $newfile->component = 'mod_qcardloader';
    $newfile->filearea = 'qcardloader';
    $newfile->itemid = 0;
    $newfile->filepath = '/' . 'mod/qcardloader/files' . '/';
    
    $DB->insert_record('qcardfiles', $newfile);
    
    
    // Get file
    $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename'], $fileinfo['userid']);

    //Outputs content of file
    $file->readfile();
    echo"\n";
    
    //Prints out content of file if it exists
    if ($file) {
        echo"START\n";

        $contents = $file->get_content();
        print_object($contents);

        echo"END\n";
    } else {
        // file doesn't exist - do something
    }
}

//$file_address = $CFG->wwwroot . '/store_file.php/' . $file->get_contextid()
//                    . '/' . $file->get_component() . '/' . $file->get_filearea()
//                    . '/' . $file->get_filepath() . $file->get_itemid()
//                    . '/' . $file->get_filename();
//					
////output the header:
//header('location: ' . $file_address);

// Finish the page
echo $OUTPUT->footer();

?>