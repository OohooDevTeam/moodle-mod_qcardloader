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

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

// Output starts here
echo $OUTPUT->header();

global $DB;

require_login();

//Required Params
$coursename = required_param('coursename', PARAM_TEXT);
$courseid = required_param('courseid', PARAM_INT);
$cmid = required_param('cmid', PARAM_INT);
$contextid = required_param('contextid', PARAM_INT);

$i = 0;
$fs = get_file_storage();

//Creates new object for storing file information
$newfile = new stdClass();
$newfile->coursename = $coursename;
$newfile->courseid = $courseid;
$newfile->cmid = $cmid;
$newfile->contextid = $contextid;
$newfile->userid = $USER->id;
$newfile->time_modified = date('(m/d/Y H:i:s)', time());

for ($i; $i < count($_FILES['file']['name']); $i++){
    // Prepare file record object
    $fileinfo = array(
        'contextid' => $contextid,
        'component' => 'mod_qcardloader',     // usually = table name
        'filearea' => 'qcardloader',     // usually = table name
        'itemid' => 0,               // usually = ID of row in table
        'filepath' => '/' . 'mod/qcardloader/files' . '/',           // any path beginning and ending in /
        'filename' => $_FILES['file']['name'][$i], // any filename
        'userid' => $USER->id);

    // Create file and saves in database "files"
    $fs->create_file_from_pathname($fileinfo, $_FILES['file']['tmp_name'][$i]);

    //Stores file info(required)
    $newfile->filename = $_FILES['file']['name'][$i];
    $newfile->filesize = $_FILES['file']['size'][$i];
    $newfile->component = 'mod_qcardloader';
    $newfile->filearea = 'qcardloader';
    $newfile->itemid = 0;
    $newfile->filepath = '/' . 'mod/qcardloader/files' . '/';

    //Stores file info
    $DB->insert_record('qcardfiles', $newfile);

    // Get file
    $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename'], $fileinfo['userid']);

    //Outputs content of file
    $file->readfile();

    //Prints out content of file if it exists
    if ($file) {
        $contents = $file->get_content();
    } else {
        // file doesn't exist - do something
    }
}
// Finish the page
echo $OUTPUT->footer();

?>