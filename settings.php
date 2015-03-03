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
 * Old courses removal plugin.
 *
 * This plugin automatically remove old courses based on some criterias.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('tool_oldcoursesremoval_settings', get_string('settings', 'tool_oldcoursesremoval'));

    $plugin = new tool_oldcoursesremoval_base();

    // General settings.
    $settings->add(new admin_setting_heading('tool_oldcoursesremoval_generalsettings', get_string('generalsettings', 'admin'),
            $plugin->get_string('description')));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/sendemail', $plugin->get_string('sendemail'),
            $plugin->get_string('sendemail_desc'), 1));

    // Filter options.
    $settings->add(new admin_setting_heading('tool_oldcoursesremoval_filterrules', $plugin->get_string('filterrules'),
            $plugin->get_string('filterrules_desc')));

    $settings->add(new admin_setting_configduration('tool_oldcoursesremoval/keepyoungerthan',
            $plugin->get_string('keepyoungerthan'), $plugin->get_string('keepyoungerthan_desc'), YEARSECS));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepvisible',
            $plugin->get_string('keepvisible'), $plugin->get_string('keepvisible_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepmodified',
            $plugin->get_string('keepmodified'), $plugin->get_string('keepmodified_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepwithactionlogs',
            $plugin->get_string('keepwithactionlogs'), $plugin->get_string('keepwithactionlogs_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepwithmodules',
            $plugin->get_string('keepwithmodules'), $plugin->get_string('keepwithmodules_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepwithquestions',
            $plugin->get_string('keepwithquestions'), $plugin->get_string('keepwithquestions_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepwithmanualgrading',
            $plugin->get_string('keepwithmanualgrading'), $plugin->get_string('keepwithmanualgrading_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/keepmetacourses',
            $plugin->get_string('keepmetacourses'), $plugin->get_string('keepmetacourses_desc'), 1));

    // Cron setup.
    $settings->add(new admin_setting_heading('tool_oldcoursesremoval/cronsetupheader',
            $plugin->get_string('cronsetupheader'), $plugin->get_string('cronsetupheader_desc')));

    $settings->add(new admin_setting_configcheckbox('tool_oldcoursesremoval/cronenabled', $plugin->get_string('cronenabled'),
            $plugin->get_string('cronenabled_desc'), 0));

    $settings->add(new admin_setting_configtime('tool_oldcoursesremoval/cronstarthour', 'tool_oldcoursesremoval_cronstartminute',
            $plugin->get_string('cronstarttime'), $plugin->get_string('cronstarttime_desc'), array('h' => 0, 'm' => 0)));

    $settings->add(new admin_setting_configtime('tool_oldcoursesremoval/cronstophour', 'tool_oldcoursesremoval_cronstopminute',
            $plugin->get_string('cronstoptime'), $plugin->get_string('cronstoptime_desc'), array('h' => 23, 'm' => 55)));

    $settings->add(new admin_setting_configduration('tool_oldcoursesremoval/processingtime',
            $plugin->get_string('cronprocessingtime'), $plugin->get_string('cronprocessingtime_desc'), 4 * HOURSECS));

    $ADMIN->add('courses', new admin_category('tool_oldcoursesremovalfolder', $plugin->get_string('pluginname')));
    $ADMIN->add('tool_oldcoursesremovalfolder', $settings);
    $ADMIN->add('tool_oldcoursesremovalfolder', new admin_externalpage('tool_oldcoursesremoval_list',
            $plugin->get_string('showelligiblecourses'), $plugin->get_url('listtoberemoved')));
}
