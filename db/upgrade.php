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
 * Execute qcardloader upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_qcardloader_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

    if ($oldversion < 2012083000) {
    }

    return true;
}
