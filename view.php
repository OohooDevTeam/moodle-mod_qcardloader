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

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');


global $DB, $PAGE;

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n = optional_param('n', 0, PARAM_INT);  // qcardloader instance ID - it should be named as the first character of the module

if ($id) {
    $cm = get_coursemodule_from_id('qcardloader', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $qcardloader = $DB->get_record('qcardloader', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $qcardloader = $DB->get_record('qcardloader', array('id' => $n), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $qcardloader->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('qcardloader', $qcardloader->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

//add_to_log($course->id, 'qcardloader', 'view', "view.php?id={$cm->id}", $qcardloader->name, $cm->id);
/// Print the page header

$PAGE->set_url('/mod/qcardloader/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($qcardloader->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);


//$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/style.css');
//$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/jquery.fileupload-ui.css.css');
//echo'<link rel="stylesheet" href="../qcardloader/jq-uploader/css/bootstrap.min.css">
//<link rel="stylesheet" href="../qcardloader/jq-uploader/css/bootstrap-responsive.min.css">
//<link rel="stylesheet" href="../qcardloader/jq-uploader/css/bootstrap-image-gallery.min.css">
//
//<link rel="stylesheet" href="../qcardloader/jq-uploader/css/style.css">
//<link rel="stylesheet" href="../qcardloader/jq-uploader/css/jquery.fileupload-ui.css">
//';

$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/bootstrap.min.css');
$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/bootstrap-responsive.min.css');
$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/bootstrap-image-gallery.min.css');
//$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/style.css');
$PAGE->requires->css('/mod/qcardloader/jq-uploader/css/jquery.fileupload-ui.css');



// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('qcardloader-'.$somevar);
// Output starts here
echo $OUTPUT->header();
// Replace the following lines with you own code
//echo $OUTPUT->heading('Yay! It works!');
//if ($qcardloader->intro) { // Conditions to show the intro can change to look for own settings or whatever
//    echo $OUTPUT->box(format_module_intro('qcardloader', $qcardloader, $cm->id), 'generalbox mod_introbox', 'qcardloaderintro');
//}
//echo "<button onclick='console.log(\"HELLO\")'>Upload new file</button>";
//$fs = get_file_storage();
//    
//print_object($fs);
//echo "<input type='file' multiple >\n";
//
//
//
//
//echo"<BR><BR><BR><BR>";
//	<!-- The file element -- NOTE: it has an ID -->
//Uploading mulitple files using one input field
echo"<form enctype='multipart/form-data' action='store_file.php' method = 'POST' id='fileupload'>

	<input id='my_file_element' type='file' name='file[]' multiple>
	<input type='submit'>
        
<BR><BR><BR><BR>

        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class='row fileupload-buttonbar'>
            <div class='span7'>
            
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class='btn btn-success fileinput-button'>
                    <i class='icon-plus icon-white'></i>
                    <span>Add files...</span>
                    <input type='file' name='files[]' multiple>
                </span>
                <button type='submit' class='btn btn-primary start'>
                    <i class='icon-upload icon-white'></i>
                    <span>Start upload</span>
                </button>
                <button type='reset' class='btn btn-warning cancel'>
                    <i class='icon-ban-circle icon-white'></i>
                    <span>Cancel upload</span>
                </button>
                <button type='button' class='btn btn-danger delete'>
                    <i class='icon-trash icon-white'></i>
                    <span>Delete</span>
                </button>
                <input type='checkbox' class='toggle'>
            </div>
            
            <!-- The global progress information -->
            <div class='span5 fileupload-progress fade'>
                <!-- The global progress bar -->
                <div class='progress progress-success progress-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100'>
                    <div class='bar' style='width:0%;'></div>
                </div>
                
                <!-- The extended global progress information -->
                <div class='progress-extended'>&nbsp;</div>
            </div>
        </div>
        
        <!-- The loading indicator is shown during file processing -->
        <div class='fileupload-loading'></div>
        <br>
        
        <!-- The table listing the files available for upload/download -->
        <table role='presentation' class='table table-striped'><tbody class='files' data-toggle='modal-gallery' data-target='#modal-gallery'></tbody></table>
</form>";



//echo"Files:";
//
//echo"<div id='files_list'></div>";
//echo <<<SCRIPT
//<script type='text/javascript'>
//	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 5 );
//	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
//</script>
//SCRIPT;
// Finish the page
echo $OUTPUT->footer();

echo'<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>';
//<!-- The template to display files available for download -->

echo'<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&\'gallery\'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>';

echo'<script src="../qcardloader/js/jquery-1.7.2.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

<script src="../qcardloader/jq-uploader/js/vendor/jquery.ui.widget.js"></script>

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="../qcardloader/jq-uploader/js/downloaded/tmpl.min.js"></script>

<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="../qcardloader/jq-uploader/js/downloaded/load-image.min.js"></script>

<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="../qcardloader/jq-uploader/js/downloaded/canvas-to-blob.min.js"></script>

<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="../qcardloader/jq-uploader/js/downloaded/bootstrap.min.js"></script>

<script src="../qcardloader/jq-uploader/js/downloaded/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->


<script src="../qcardloader/jq-uploader/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../qcardloader/jq-uploader/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="../qcardloader/jq-uploader/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="../qcardloader/jq-uploader/js/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="../qcardloader/jq-uploader/js/locale.js"></script>
<!-- The main application script -->
<script src="../qcardloader/jq-uploader/js/main.js"></script>';



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
//    $file->readfile();
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
?>

<!--Browser detection-->
<!--<script type="text/javascript">

var BrowserDetect = {
        init: function () {
                this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
                this.version = this.searchVersion(navigator.userAgent)
                        || this.searchVersion(navigator.appVersion)
                        || "an unknown version";
                this.OS = this.searchString(this.dataOS) || "an unknown OS";
        },
        searchString: function (data) {
                for (var i=0;i<data.length;i++)	{
                        var dataString = data[i].string;
                        var dataProp = data[i].prop;
                        this.versionSearchString = data[i].versionSearch || data[i].identity;
                        if (dataString) {
                                if (dataString.indexOf(data[i].subString) != -1)
                                        return data[i].identity;
                        }
                        else if (dataProp)
                                return data[i].identity;
                }
        },
        searchVersion: function (dataString) {
                var index = dataString.indexOf(this.versionSearchString);
                if (index == -1) return;
                return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
        },
        dataBrowser: [
                {
                        string: navigator.userAgent,
                        subString: "Chrome",
                        identity: "Chrome"
                },
                { 	string: navigator.userAgent,
                        subString: "OmniWeb",
                        versionSearch: "OmniWeb/",
                        identity: "OmniWeb"
                },
                {
                        string: navigator.vendor,
                        subString: "Apple",
                        identity: "Safari",
                        versionSearch: "Version"
                },
                {
                        prop: window.opera,
                        identity: "Opera",
                        versionSearch: "Version"
                },
                {
                        string: navigator.vendor,
                        subString: "iCab",
                        identity: "iCab"
                },
                {
                        string: navigator.vendor,
                        subString: "KDE",
                        identity: "Konqueror"
                },
                {
                        string: navigator.userAgent,
                        subString: "Firefox",
                        identity: "Firefox"
                },
                {
                        string: navigator.vendor,
                        subString: "Camino",
                        identity: "Camino"
                },
                {		// for newer Netscapes (6+)
                        string: navigator.userAgent,
                        subString: "Netscape",
                        identity: "Netscape"
                },
                {
                        string: navigator.userAgent,
                        subString: "MSIE",
                        identity: "Explorer",
                        versionSearch: "MSIE"
                },
                {
                        string: navigator.userAgent,
                        subString: "Gecko",
                        identity: "Mozilla",
                        versionSearch: "rv"
                },
                { 		// for older Netscapes (4-)
                        string: navigator.userAgent,
                        subString: "Mozilla",
                        identity: "Netscape",
                        versionSearch: "Mozilla"
                }
        ],
        dataOS : [
                {
                        string: navigator.platform,
                        subString: "Win",
                        identity: "Windows"
                },
                {
                        string: navigator.platform,
                        subString: "Mac",
                        identity: "Mac"
                },
                {
                           string: navigator.userAgent,
                           subString: "iPhone",
                           identity: "iPhone/iPod"
            },
                {
                        string: navigator.platform,
                        subString: "Linux",
                        identity: "Linux"
                }
        ]

};
BrowserDetect.init();

// 
</script>

<script type="text/javascript">

//document.write('<p class="accent">You\'re using ' + BrowserDetect.browser + ' ' + BrowserDetect.version + ' on ' + BrowserDetect.OS + '!</p>');
if (BrowserDetect.browser == "Chrome")
    {
        console.log('chrome');
    }
// 
</script>-->