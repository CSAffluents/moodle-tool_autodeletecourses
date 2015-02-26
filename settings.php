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

use tool_autodeletecourses\helper;

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('tool_autodeletecourses_settings', get_string('settings', 'tool_autodeletecourses'));

    // General settings.
    $settings->add(new admin_setting_heading('tool_autodeletecourses_generalsettings', get_string('generalsettings', 'admin'),
            helper::get_string('description')));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/sendemail', helper::get_string('sendemail'),
            helper::get_string('sendemail_desc'), 1));

    // Filter options.
    $settings->add(new admin_setting_heading('tool_autodeletecourses_filterrules', helper::get_string('filterrules'),
            helper::get_string('filterrules_desc')));

    $settings->add(new admin_setting_configduration('tool_autodeletecourses/keepyoungerthan',
            helper::get_string('keepyoungerthan'), helper::get_string('keepyoungerthan_desc'), YEARSECS));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepvisible',
            helper::get_string('keepvisible'), helper::get_string('keepvisible_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepmodified',
            helper::get_string('keepmodified'), helper::get_string('keepmodified_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepwithactionlogs',
            helper::get_string('keepwithactionlogs'), helper::get_string('keepwithactionlogs_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepwithmodules',
            helper::get_string('keepwithmodules'), helper::get_string('keepwithmodules_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepwithquestions',
            helper::get_string('keepwithquestions'), helper::get_string('keepwithquestions_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepwithmanualgrading',
            helper::get_string('keepwithmanualgrading'), helper::get_string('keepwithmanualgrading_desc'), 1));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/keepmetacourses',
            helper::get_string('keepmetacourses'), helper::get_string('keepmetacourses_desc'), 1));

    // Cron setup.
    $settings->add(new admin_setting_heading('tool_autodeletecourses/cronsetupheader',
            helper::get_string('cronsetupheader'), helper::get_string('cronsetupheader_desc')));

    $settings->add(new admin_setting_configcheckbox('tool_autodeletecourses/cronenabled', helper::get_string('cronenabled'),
            helper::get_string('cronenabled_desc'), 0));

    $settings->add(new admin_setting_configtime('tool_autodeletecourses/cronstarthour', 'cronstartminute',
            helper::get_string('cronstarttime'), helper::get_string('cronstarttime_desc'), array('h' => 0, 'm' => 0)));

    $settings->add(new admin_setting_configtime('tool_autodeletecourses/cronstophour', 'cronstopminute',
            helper::get_string('cronstoptime'), helper::get_string('cronstoptime_desc'), array('h' => 23, 'm' => 55)));

    $settings->add(new admin_setting_configduration('tool_autodeletecourses/processingtime',
            helper::get_string('cronprocessingtime'), helper::get_string('cronprocessingtime_desc'), 4 * HOURSECS));

    $ADMIN->add('courses', new admin_category('tool_autodeletecoursesfolder', helper::get_string('pluginname')));
    $ADMIN->add('tool_autodeletecoursesfolder', $settings);
    $ADMIN->add('tool_autodeletecoursesfolder', new admin_externalpage('tool_autodeletecourses_list',
            helper::get_string('showelligiblecourses'), helper::get_url('listtobedeleted')));
}
