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
 * Automactic old courses deletion plugin.
 *
 * This plugin automatically delete old courses based on some criterias.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_autodeletecourses;

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../../../config.php');

/**
 * Automactic old courses deletion report class.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report {

    /**
     * @var status $coursestatus The courses status list.
     */
    private $coursesstatus = array();

    /**
     * @var int $remainingcount The course count remaining to delete.
     */
    private $remainingcount = 0;

    /**
     * Add a status in the report.
     * 
     * @param status $status The status to add.
     */
    public function add_status($status) {
        $this->coursesstatus[] = $status;
    }

    /**
     * Set the course count remaining to delete.
     *
     * @param int $count The remaining counts.
     */
    public function set_remaining_count($count) {
        $this->remainingcount = $count;
    }

    /**
     * Compose the message body of the email report.
     * @return string The message body.
     */
    private function compose_message() {

        $lines = array();
        $formattedstatus = array();
        $linebreak = "\n";

        $lines[] = helper::get_string('reportintro') . $linebreak;

        // Count number of successfull deletion and add the status of each courses.
        $successcount = 0;
        $formattedstatus[] = helper::get_string('reportdeletestatus');
        foreach ($this->coursesstatus as $status) {
            if ($status instanceof status_ok) {
                $successcount++;
                $formattedstatus[] = $status->output();
            }
        }
        $formattedstatus[] = $linebreak;

        $lines[] = helper::get_string('reportsuccesscount', $successcount);
        if (empty($this->remainingcount)) {
            $lines[] = helper::get_string('reportrenocourseremaining');
        } else {
            $lines[] = helper::get_string('reportremainingcount', $this->remainingcount);
        }
        $lines[] = '';

        $lines = array_merge($lines, $formattedstatus);

        return implode($linebreak, $lines);
    }

    /**
     * Send by email to all admins the report.
     * @return boolean If the email was successfuly sended.
     */
    public function send_by_email() {
        global $SITE;

        $result = true;

        $subject = helper::get_string('reportsubject', $SITE->shortname);
        $body = $this->compose_message();

        $userfrom = \core_user::get_noreply_user();
        $userfrom->maildisplay = true;

        // For each admins, email the report.
        $admins = get_admins();
        foreach ($admins as $admin) {
            if (!email_to_user($admin, $userfrom, $subject, $body)) {
                $result = false;
            }
        }
        return $result;
    }
}

/**
 * Abstract class status for the report.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class status {

    /**
     * @var stdclass the course object.
     */
    protected $course = null;

    /**
     * The constructor of the class.
     * @param stdClass $course The course for this status.
     */
    public function __construct($course) {
        $this->course = $course;
    }

    /**
     * The message to output corresponding of the status.
     * Must be implemented.
     */
    public abstract function output();
}

/**
 * class status_ok for the report.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class status_ok extends status {

    /**
     * The message output corresponding of the ok status.
     * @return string the status;
     */
    public function output() {
        return helper::get_string('reportstatusok', $this->course);
    }
}

/**
 * class status_incomplete for the report.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class status_incomplete extends status {

    /**
     * The message output corresponding of the failed status.
     * @return string the status;
     */
    public function output() {
        return helper::get_string('reportstatusincomplete', $this->course);
    }
}

/**
 * class status_missing for the report.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class status_missing extends status {

    /**
     * The message output corresponding of the failed status.
     * @return string the status;
     */
    public function output() {
        return helper::get_string('reportstatusmissing', $this->course);
    }
}
