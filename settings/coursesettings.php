<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Theme footer settings to be loaded.
 *
 * @package     theme_stream
 * @category    admin
 * @copyright   2023 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Course tab.
$page = new admin_settingpage ('theme_stream_course', get_string('coursesettings', 'backup'));

// Show circle mod icons on the course page and activitychooser.
$name = 'theme_stream/circlemodicons';
$title = get_string('circlemodicons', 'theme_stream');
$description = get_string('circlemodicons_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description, '1');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show course completion on course page.
$name = 'theme_stream/coursecompletion';
$title = get_string('coursecompletion');
$description = get_string('coursecompletion_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description, '1');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show ourse name/shortname in course index.
$choices = [
    0 => 'No extra info',
    'fullname' => 'Fullname',
    'shortname' => 'Shortname',
];
$name = 'theme_stream/courseindexheading';
$title = get_string('courseindexheading', 'theme_stream');
$description = get_string('courseindexheading_desc', 'theme_stream');
$setting = new admin_setting_configselect($name, $title, $description, 'shortname', $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Header logo setting.
$name = 'theme_stream/courseheaderimg';
$title = get_string('courseheaderimg', 'theme_stream');
$description = get_string('courseheaderimg_desc', 'theme_stream');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'courseheaderimg', 0,
['maxfiles' => 1, 'accepted_types' => 'web_image']);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icons outline.
$name = 'theme_stream/modiconoutline';
$title = get_string('modiconoutline', 'theme_stream');
$description = get_string('modiconoutline_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description, '0');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'administration'.
$name = 'theme_stream/modiconcoloradministration';
$title = get_string('modiconcoloradministration', 'theme_stream', '', true);
$description = get_string('modiconcoloradministration_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#5d63f6');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'assessment'.
$name = 'theme_stream/modiconcolorassessment';
$title = get_string('modiconcolorassessment', 'theme_stream', '', true);
$description = get_string('modiconcolorassessment_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#eb66a2');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'collaboration'.
$name = 'theme_stream/modiconcolorcollaboration';
$title = get_string('modiconcolorcollaboration', 'theme_stream', '', true);
$description = get_string('modiconcolorcollaboration_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#f7634d');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'communication'.
$name = 'theme_stream/modiconcolorcommunication';
$title = get_string('modiconcolorcommunication', 'theme_stream', '', true);
$description = get_string('modiconcolorcommunication_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#11a676');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'content'.
$name = 'theme_stream/modiconcolorcontent';
$title = get_string('modiconcolorcontent', 'theme_stream', '', true);
$description = get_string('modiconcolorcontent_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#399be2');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Mod icon color for 'interface'.
$name = 'theme_stream/modiconcolorinterface';
$title = get_string('modiconcolorinterface', 'theme_stream', '', true);
$description = get_string('modiconcolorinterface_desc', 'theme_stream', '', true);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#a378ff');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
