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

$i = 0;
$fs = get_file_storage();
    
print_object($fs);

print_object($_FILES);

for ($i; $i < count($_FILES['file']['name']); $i++){
    // Prepare file record object
    $fileinfo = array(
    //    'contextid' => $context->id, // ID of context
        'contextid' => $_REQUEST['contextid'],
        'component' => 'mod_qcardloader',     // usually = table name
        'filearea' => 'qcardloader',     // usually = table name
        'itemid' => 0,               // usually = ID of row in table
        'filepath' => '/' . 'testest' . '/',           // any path beginning and ending in /
        'filename' => $_FILES['file']['name'][$i], // any filename
        'userid' => $USER->id);
    // Create file containing text 'hello world'
    $fs->create_file_from_pathname($fileinfo, $_FILES['file']['tmp_name'][0]);


// Get file
$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
        $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename'], $fileinfo['userid']);
 
$file->readfile();
echo"\n";
// Read contents
if ($file) {
    echo"TOP\n";
    
    $contents = $file->get_content();
    print_object($contents);
    
    echo"BOT\n";
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