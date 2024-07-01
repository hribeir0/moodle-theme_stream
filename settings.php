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
 * Plugin strings are defined here.
 *
 * @package     theme_stream
 * @category    admin
 * @copyright   2022 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingstream',
    get_string('configtitle', 'theme_stream'), 'theme/stream:changesettings');
    $page = new admin_settingpage ('theme_stream_general', get_string('generalsettings', 'theme_stream'));

    $page->add(new admin_setting_heading('theme_stream/colours', get_string('colours', 'theme_stream'), ''));
    // Variable $primary.
    $name = 'theme_stream/primarycolour';
    $title = get_string('primarycolour', 'theme_stream');
    $description = get_string('primarycolour_desc', 'theme_stream');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#daaa00');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $secondary.
    $name = 'theme_stream/secondarycolour';
    $title = get_string('secondarycolour', 'theme_stream');
    $description = get_string('secondarycolour_desc', 'theme_stream');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#298976');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $page->add(new admin_setting_heading('theme_stream/fonts', get_string('fonts', 'theme_stream'), ''));

    // External Fonts source.
    $name = 'theme_stream/externalfonts';
    $title = get_string('externalfonts', 'theme_stream');
    $description = get_string('externalfonts_desc', 'theme_stream');
    $setting = new admin_setting_configcheckbox($name, $title, $description, '1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Fonts settings.
    $name = 'theme_stream/bunnyfonts';
    $title = get_string('bunnyfonts', 'theme_stream');
    $description = get_string('bunnyfonts_desc', 'theme_stream');
    $choices = [
        'Abel' => 'Abel',
        'Roboto' => 'Roboto',
        'roboto-condensed' => 'Roboto Condensed',
        'Nunito' => 'Nunito',
        'Montserrat' => 'Montserrat',
        'Lato' => 'Lato',
        'Poppins' => 'Poppins',
        'Oswald' => 'Oswald',
        'Mukta' => 'Mukta',
    ];
    $setting = new admin_setting_configselect($name, $title, $description, 'Nunito', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $page->add(new admin_setting_heading('theme_stream/customstylessettings',
    get_string('customstylessettings', 'theme_stream'), ''));

    // Favicon.
    $name = 'theme_stream/favicon';
    $title = get_string('favicon', 'theme_stream');
    $description = get_string('favicon_desc', 'theme_stream');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0,
    ['maxfiles' => 1, 'accepted_types' => ['.ico', '.png' ]]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Page Image.
    $name = 'theme_stream/loginimg';
    $title = get_string('loginimg', 'theme_stream');
    $description = get_string('loginimg_desc', 'theme_stream');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginimg', 0,
    ['maxfiles' => 1, 'accepted_types' => 'web_image']);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Full-width setting.
    $name = 'theme_stream/fullwidthpage';
    $title = get_string('fullwidthpage', 'theme_stream');
    $description = get_string('fullwidthpage_desc', 'theme_stream');
    $setting = new admin_setting_configcheckbox($name, $title, $description, '1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include before the content. As per Boost.
    $setting = new admin_setting_scsscode('theme_stream/scsspre',
    get_string('rawscsspre', 'theme_boost'), get_string('rawscsspre_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content. As per Boost.
    $setting = new admin_setting_scsscode('theme_stream/scss', get_string('rawscss', 'theme_boost'),
    get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show back to top icon.
    $name = 'theme_stream/backtotopbutton';
    $title = get_string('backtotopbutton', 'theme_stream');
    $description = get_string('backtotopbutton_desc', 'theme_stream');
    $setting = new admin_setting_configcheckbox($name, $title, $description, '1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Hide primary navigation nodes.
    $choices = [
        'home' => get_string('home'),
        'myhome' => get_string('myhome'),
        'courses' => get_string('mycourses'),
    ];
      $name = 'theme_stream/hideprimarynodes';
      $title = get_string('hideprimarynodes', 'theme_stream');
      $description = get_string('hideprimarynodes_desc', 'theme_stream');
      $setting = new admin_setting_configmulticheckbox($name, $title, $description, null, $choices);
      $setting->set_updatedcallback('theme_reset_all_caches');
      $page->add($setting);

    $settings->add($page);

    require_once('settings/frontpagesettings.php');
    require_once('settings/coursesettings.php');
    require_once('settings/footersettings.php');
}

