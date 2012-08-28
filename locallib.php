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

defined('MOODLE_INTERNAL') || die();

/**
 * Reorders the arrays indexes consecutively
 * 
 * @param array $source This array contains the array to be reindexed
 * @param array $conditions_list This array contains the conditions for indexing
 * @return array Returns the reordered array 
 */
function reorderindex(array $source, $conditions_list = array()) {
    $i = 0;
    foreach ($source as $key => $val) {
        if ($key != $i) {
            unset($source[$key]);
            $source[$i] = $val;
        }
        $i++;
    }

    foreach ($source as $key => $val) {
        foreach ($conditions_list as $var) {
            if ($val === $var) {
                unset($source[$key]);
                $source = reorderindex($source, $conditions_list);
            }
        }
    }
    return $source;
}

/**
 * This function checks if the user exists or not
 *
 * @global moodle_database $DB
 * @param string $username This string contains the user name
 * @return boolean Returns whether the user exists or not 
 */
function user_exists($username) {
	global $DB;
	if($DB->get_records('user', array('username' => $username))) {
		return true;
	}

	return false;
}

/**
 * Selects all the checkboxes
 */
function check_all() {

    echo "<script type='text/javascript'>

      checked = false;
      function checkedAll () {
        if (checked == false){
        checked = true

        } else {
        checked = false
        }

	for (var i = 1; i < document.getElementById('check').elements.length; i++) {
	  document.getElementById('check').elements[i].checked = checked;
	}
      }
";
    echo "</script>";
}