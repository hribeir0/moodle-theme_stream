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

    // Footer tab.
    $page = new admin_settingpage ('theme_stream_footer', get_string('footersettings', 'theme_stream'));
    // Social Networks.
    $page->add(new admin_setting_heading('theme_stream/socialmedia', get_string('socialmedia', 'theme_stream'), ''));
    $name = 'theme_stream/facebookurl';
    $title = get_string('facebookurl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://www.facebook.com/myfacebookpage/');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/instagramurl';
    $title = get_string('instagramurl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://www.instagram.com/myinstagrampage/');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/pinteresturl';
    $title = get_string('pinteresturl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://www.pinterest.pt/mypinterestpage/');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/linkedinurl';
    $title = get_string('linkedinurl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://www.linkedin.com/company/mylinkedinpage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/twitterurl';
    $title = get_string('twitterurl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://x.com/myxhandle');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/youtubeurl';
    $title = get_string('youtubeurl', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, '' , 'https://www.youtube.com/myyoutubepage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer color.
    $name = 'theme_stream/footercolor';
    $title = get_string('footercolor', 'theme_stream', '', true);
    $description = get_string('footercolor_desc', 'theme_stream', '', true);
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#495057');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Different columns settings.
    $listalinks = '
    <h5>External links</h5>
    <ul class="list-unstyled ms-0">
        <li>Link a</li>
        <li>Link b</li>
        <li>Link c</li>
    </ul>
    ';
    $name = 'theme_stream/leftcolumn';
    $title = get_string('leftcolumn', 'theme_stream');
    $description = get_string('leftcolumn_desc', 'theme_stream');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $listalinks, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_stream/centercolumn';
    $title = get_string('centercolumn', 'theme_stream');
    $description = get_string('centercolumn_desc', 'theme_stream');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $listalinks, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
