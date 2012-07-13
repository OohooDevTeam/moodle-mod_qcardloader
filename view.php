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

print_object($context);
echo $course->fullname;

echo $cm->id;

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



// Output starts here
echo $OUTPUT->header();

//	<!-- The file element -- NOTE: it has an ID -->
//Uploading mulitple files using one input field
echo"<form enctype='multipart/form-data' action='store_file.php?coursename=$course->fullname&courseid=$course->id&cmid=$cm->id&contextid=$context->id' method = 'POST' id='fileupload'>";

echo"	<input id='my_file_element' type='file' name='file[]' multiple>";
echo"	<input type='submit'>";
       

    
echo"<BR><BR><BR><BR>";

////echo"        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->";
//echo"        <div class='row fileupload-buttonbar'>";
//echo"            <div class='span7'>";
//            
////echo"               <!-- The fileinput-button span is used to style the file input field as button -->";
//echo"                <span class='btn btn-success fileinput-button'>";
//echo"                    <i class='icon-plus icon-white'></i>";
//echo"                    <span>Add files...</span>";
//echo"                    <input type='file' name='files[]' multiple>";
//echo"                </span>";
//echo"                <button type='submit' class='btn btn-primary start'>";
//echo"                    <i class='icon-upload icon-white'></i>";
//echo"                    <span>Start upload</span>";
//echo"                </button>";
//echo"                <button type='reset' class='btn btn-warning cancel'>";
//echo"                    <i class='icon-ban-circle icon-white'></i>";
//echo"                    <span>Cancel upload</span>";
//echo"                </button>";
//echo"                <button type='button' class='btn btn-danger delete'>";
//echo"                    <i class='icon-trash icon-white'></i>";
//echo"                    <span>Delete</span>";
//echo"                </button>";
//echo"                <input type='checkbox' class='toggle'>";
//echo"            </div>";
//            
////echo"            <!-- The global progress information -->";
//echo"            <div class='span5 fileupload-progress fade'>";
////echo"                <!-- The global progress bar -->";
//echo"                <div class='progress progress-success progress-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100'>";
//echo"                    <div class='bar' style='width:0%;'></div>";
//echo"                </div>";
//                
////echo"                <!-- The extended global progress information -->";
//echo"                <div class='progress-extended'>&nbsp;</div>";
//echo"            </div>";
//echo"        </div>";
//        
////echo"        <!-- The loading indicator is shown during file processing -->";
//echo"        <div class='fileupload-loading'></div>";
//echo"        <br>";
//        
////echo"        <!-- The table listing the files available for upload/download -->";
//echo"        <table role='presentation' class='table table-striped'><tbody class='files' data-toggle='modal-gallery' data-target='#modal-gallery'></tbody></table>";
echo"</form>";


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
//
//echo'<script id="template-upload" type="text/x-tmpl">
//{% for (var i=0, file; file=o.files[i]; i++) { %}
//    <tr class="template-upload fade">
//        <td class="preview"><span class="fade"></span></td>
//        <td class="name"><span>{%=file.name%}</span></td>
//        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//        {% if (file.error) { %}
//            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
//        {% } else if (o.files.valid && !i) { %}
//            <td>
//                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
//            </td>
//            <td class="start">{% if (!o.options.autoUpload) { %}
//                <button class="btn btn-primary">
//                    <i class="icon-upload icon-white"></i>
//                    <span>{%=locale.fileupload.start%}</span>
//                </button>
//            {% } %}</td>
//        {% } else { %}
//            <td colspan="2"></td>
//        {% } %}
//        <td class="cancel">{% if (!i) { %}
//            <button class="btn btn-warning">
//                <i class="icon-ban-circle icon-white"></i>
//                <span>{%=locale.fileupload.cancel%}</span>
//            </button>
//        {% } %}</td>
//    </tr>
//{% } %}
//</script>';
////<!-- The template to display files available for download -->
//
//echo'<script id="template-download" type="text/x-tmpl">
//{% for (var i=0, file; file=o.files[i]; i++) { %}
//    <tr class="template-download fade">
//        {% if (file.error) { %}
//            <td></td>
//            <td class="name"><span>{%=file.name%}</span></td>
//            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
//        {% } else { %}
//            <td class="preview">{% if (file.thumbnail_url) { %}
//                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
//            {% } %}</td>
//            <td class="name">
//                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&\'gallery\'%}" download="{%=file.name%}">{%=file.name%}</a>
//            </td>
//            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//            <td colspan="2"></td>
//        {% } %}
//        <td class="delete">
//            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
//                <i class="icon-trash icon-white"></i>
//                <span>{%=locale.fileupload.destroy%}</span>
//            </button>
//            <input type="checkbox" name="delete" value="1">
//        </td>
//    </tr>
//{% } %}
//</script>';
//
//echo'<script src="../qcardloader/js/jquery-1.7.2.js"></script>';
//
////echo'<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->';
//echo'<script src="../qcardloader/jq-uploader/js/vendor/jquery.ui.widget.js"></script>';
//
////echo'<!-- The Templates plugin is included to render the upload/download listings -->';
//echo'<script src="../qcardloader/jq-uploader/js/downloaded/tmpl.min.js"></script>';
//
////echo'<!-- The Load Image plugin is included for the preview images and image resizing functionality -->';
//echo'<script src="../qcardloader/jq-uploader/js/downloaded/load-image.min.js"></script>';
//
////echo'<!-- The Canvas to Blob plugin is included for image resizing functionality -->';
//echo'<script src="../qcardloader/jq-uploader/js/downloaded/canvas-to-blob.min.js"></script>';
//
////echo'<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->';
//echo'<script src="../qcardloader/jq-uploader/js/downloaded/bootstrap.min.js"></script>';
//
//echo'<script src="../qcardloader/jq-uploader/js/downloaded/bootstrap-image-gallery.min.js"></script>';
//
//
////echo'<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->';
//echo'<script src="../qcardloader/jq-uploader/js/jquery.iframe-transport.js"></script>';
//
////echo'<!-- The basic File Upload plugin -->';
//echo'<script src="../qcardloader/jq-uploader/js/jquery.fileupload.js"></script>';
//
////echo'<!-- The File Upload file processing plugin -->';
//echo'<script src="../qcardloader/jq-uploader/js/jquery.fileupload-fp.js"></script>';
//
////echo'<!-- The File Upload user interface plugin -->';
//echo'script src="../qcardloader/jq-uploader/js/jquery.fileupload-ui.js"></script>';
//
////echo'<!-- The localization script -->';
//echo'<script src="../qcardloader/jq-uploader/js/locale.js"></script>';
//
////echo'<!-- The main application script -->';
//echo'<script src="../qcardloader/jq-uploader/js/main.js"></script>';

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