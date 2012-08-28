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
//exit();
require_login();

$files = $_REQUEST['files'];
$contextid = $_REQUEST['contextid'];
$cmid = $_REQUEST['cmid'];
$courseid = $_REQUEST['courseid'];

$file = json_decode($files);

for ($i=0; $i < sizeof($file); $i++){

    $DB->delete_records('qcardfiles', array('filename'=>$file[$i], 'cmid'=>$cmid, 'contextid'=>$contextid, 'courseid'=>$courseid));
    $DB->delete_records('files', array('filename'=>$file[$i],'contextid'=>$contextid));

}

// Finish the page
echo $OUTPUT->footer();

?>