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

//http://stackoverflow.com/questions/3042312/jquery-find-file-extension-from-string
function validateFile(userfiles) {
        if(userfiles != "") {

           var files = $('input[type="file"]')[0].files;
           console.log(files);
                for (var i = 0; i < files.length; i++)
                {
                    alert(files[i].name);
                    var extension = files[i].name.substr( (files[i].name.lastIndexOf('.') +1) );

                    switch(extension) {
                        case 'jpg':case 'png':case 'gif':case 'pdf':
                            alert('was jpg png gif pdf');
                            break;
                        case 'zip':case 'rar':
                            alert('was zip rar');
                            break;
                         case 'txt':
                            alert('was txt');
                            break;
                        default:
                            alert('Unknown Type');
                    }
                    //Display selected files
                document.getElementById('list').innerHTML = '<ul>' + files[i].name + '</ul>';

                }
        } else {
            alert("No files chosen");
        }
};

function deleteFiles(contextid, cmid, courseid){
    var files = new Array();
    var rowIndx = new Array();
    var i =0;
    //Grab all the selected files
    $("input[type=checkbox]:checked").each ( function() {
        //Stores the names of the selected files
       files[i] = $(this).val();

       //Find the row for each file on the table
       rowIndx[i] = $(this).closest('tr')[0].rowIndex;

       console.log(rowIndx[i]);
       //Increment to next array position
       i++;
    });

    //Converts the javascript object into a string
    var file_array = JSON.stringify(files);

// window.location.href = 'delete_files.php?files=' + file_array +'&contextid=' + contextid + '&cmid=' + cmid + '&courseid=' + courseid;

    //Pass information to delete the selected files from the database
    $.post('delete_files.php', {
        'files' : file_array,
        'contextid' : contextid,
        'cmid' : cmid,
        'courseid' : courseid
    });

    //Grabs the table id
    var table = document.getElementById('tbl');
    console.log(rowIndx.length);
    for(j=rowIndx.length-1; j>=0; j--){
        table.deleteRow(rowIndx[j]);
        console.log(rowIndx[j]);
    }
}

/**
 * Displays the files the user has selected for uploading
 */
//function handleFileSelect(evt) {
//    var files = evt.target.files; // FileList object
//
//    // files is a FileList of File objects. List some properties.
//    var output = [];
//    for (var i = 0, f; f = files[i]; i++) {
//      output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//                  f.size, ' bytes, last modified: ',
//                  f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
//                  '</li>');
//    }
//    document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
//  }
//
//  document.getElementById('myfile').addEventListener('change', handleFileSelect, false);â€‹

//function handleFileSelect(evt) {
//    var files = evt.target.files; // FileList object
//
//    // files is a FileList of File objects. List some properties.
//    var output = [];
//    for (var i = 0, f; f = files[i]; i++) {
//      output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//                  f.size, ' bytes, last modified: ',
//                  f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
//                  '</li>');
//    }
//    document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
//  }
//
//  document.getElementById('myfile').addEventListener('change', handleFileSelect, false);â€‹