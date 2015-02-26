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
 * Strings for component 'tool_autodeletecourses', language 'en'.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['courseid'] = 'Course ID';
$string['coursesperpage'] = 'Courses per page';
$string['createdsince'] = 'Create since';
$string['cronenabled'] = 'Cron enabled';
$string['cronenabled_desc'] = 'Check this if you want to process the deletion of the old courses with the system cron.';
$string['croninstructions'] = 'You can enable cron to automatically delete old courses based on some criterias. Cron will run between set hours on the day (according to server local time). Each time cron runs, it will process a number of deletions until Time limit amount of time has been used, then it will stop and wait for the next cron run.';
$string['cronprocessingtime'] = 'Processing time';
$string['cronprocessingtime_desc'] = 'The processing time each cron run.';
$string['cronsetupheader'] = 'Configure cron';
$string['cronsetupheader_desc'] = 'You can configure cron to complete the upgrade of quiz attempt data automatically.';
$string['cronstarttime'] = 'Start time';
$string['cronstarttime_desc'] = 'The time in a day the cron will begin to be available for the deletion.';
$string['cronstoptime'] = 'Stop time';
$string['cronstoptime_desc'] = 'The time in a day the cron will stop to be available for the deletion.';
$string['description'] = 'This admin tool allow to delete the old courses based on many criterias like the course visibility, the creation date or if the course has been modified.';
$string['editsettings'] = 'Edit settings';
$string['filterrules'] = 'Filter rules';
$string['filterrules_desc'] = 'These settings control which courses will be deleted and which ones will be kept.';
$string['keepmetacourses'] = 'Keep meta courses';
$string['keepmetacourses_desc'] = 'Check this to delete only courses not used in a meta course enrolment.';
$string['keepmodified'] = 'Keep modified courses';
$string['keepmodified_desc'] = 'Check this to delete only not modified courses.';
$string['keepvisible'] = 'Keep visible courses';
$string['keepvisible_desc'] = 'Check this to delete only invisible courses.';
$string['keepyoungerthan'] = 'Keep courses younger that';
$string['keepyoungerthan_desc'] = 'Check this to delete only courses older than this duration.';
$string['keepwithactionlogs'] = 'Keep courses with action logs';
$string['keepwithactionlogs_desc'] = 'Check this to delete only courses with no add, delete or update logs';
$string['keepwithmanualgrading'] = 'Keep courses with manual gradings';
$string['keepwithmanualgrading_desc'] = 'Check this to delete only courses with no manual grade items.';
$string['keepwithmodules'] = 'Keep courses with modules';
$string['keepwithmodules_desc'] = 'Check this to delete only courses with no activity or ressource modules added.';
$string['keepwithquestions'] = 'Keep courses with questions';
$string['keepwithquestions_desc'] = 'Check this to delete only courses with no questions in the questions bank.';
$string['nocoursetodelete'] = 'There is currently no courses to delete. You may edit if needed the filter rules in the plugin settings.';
$string['matchingcourses'] = 'There are currently {$a} courses corresponding to the current filter rules.';
$string['pluginname'] = 'Auto old courses deletion';
$string['reportdeletestatus'] = 'Automatic courses deletion status for each course:';
$string['reportintro'] = 'Here is automatic courses deletion report.';
$string['reportsuccesscount'] = 'There was {$a} courses deleted with success.';
$string['reportremainingcount'] = 'There was {$a} courses who remain to delete based on the current deletion settings.';
$string['reportrenocourseremaining'] = 'There is no course remaining to delete.';
$string['reportsubject'] = '{$a}: automatic courses deletion report';
$string['reportstatusincomplete'] = 'INCONPLETE: The course named {$a->fullname} was not completely deleted because of an error.';
$string['reportstatusmissing'] = 'MISSING: The course named {$a->fullname} was already deleted.';
$string['reportstatusok'] = 'DELETED: The course named {$a->fullname} was successfully deleted.';
$string['sendemail'] = 'Send email to administrators';
$string['sendemail_desc'] = 'Check this to send an email to all administrators each time a process finnish';
$string['settings'] = 'Settings';
$string['showelligiblecourses'] = 'Show eligible courses';
$string['showelligiblecourses_desc'] = 'Affiche la liste de tous les cours qui sont admissibles à la suppression. Cela vous permet de faire une vérification avant de lancer le processus.';
$string['updatetable'] = 'Mettre à jour la table';
