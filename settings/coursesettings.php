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

// Sticky secondary navigation.
$name = 'theme_stream/stickynav';
$title = get_string('stickynav', 'theme_stream');
$description = get_string('stickynav_desc', 'theme_stream');
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

$settings->add($page);
