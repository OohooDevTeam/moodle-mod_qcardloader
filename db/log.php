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

global $DB;

$logs = array(
    array('module'=>'qcardloader', 'action'=>'add', 'mtable'=>'qcardloader', 'field'=>'name'),
    array('module'=>'qcardloader', 'action'=>'update', 'mtable'=>'qcardloader', 'field'=>'name'),
    array('module'=>'qcardloader', 'action'=>'view', 'mtable'=>'qcardloader', 'field'=>'name'),
    array('module'=>'qcardloader', 'action'=>'view all', 'mtable'=>'qcardloader', 'field'=>'name')
);
