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
 * This file contains the pagination form to show a list of eligible courses to be removed.

 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir . '/formslib.php');

/**
 * The pagination form of the list of iligible courses to be removed.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oldcoursesremoval_pagination_form extends moodleform {

    /**
     * Define this form - called from the parent constructor
     */
    public function definition() {
        $mform = $this->_form;

        $plugin = new tool_oldcoursesremoval_base();

        $mform->addElement('header', 'general', $plugin->get_string('coursesperpage'));
        // Visible elements.
        $options = array(10 => '10', 20 => '20', 50 => '50', 100 => '100', 250 => '250', 500 => '500');
        $mform->addElement('select', 'perpage', $plugin->get_string('coursesperpage'), $options);

        // Hidden params.
        $mform->addElement('hidden', 'action', 'saveoptions');
        $mform->setType('action', PARAM_ALPHA);

        // Buttons.
        $this->add_action_buttons(false, $plugin->get_string('updatetable'));
    }
}

