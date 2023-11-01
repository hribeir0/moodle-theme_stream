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
 * Frontpage settings to be loaded.
 *
 * @package     theme_stream
 * @category    admin
 * @copyright   2023 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Frontpage tab.
$page = new admin_settingpage ('theme_stream_frontpage', get_string('frontpagestream', 'theme_stream'));

$page->add(new admin_setting_heading('theme_stream/slidersettingheading', get_string('slidersettingheading', 'theme_stream'), ''));

// Slider slots.
$choices = [
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5',
];
$name = 'theme_stream/slidestotal';
$title = get_string('slidestotal', 'theme_stream');
$description = get_string('slidestotal_desc', 'theme_stream');
$setting = new admin_setting_configselect($name, $title, $description , '1', $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


$slidestotal = get_config('theme_stream', 'slidestotal');
$i = 0;
while ($i < $slidestotal ) {
    // Prints slider title settings per total.
    $name = 'theme_stream/herotitle' . $i;
    $title = get_string('herotitle', 'theme_stream') . $i;
    $description = get_string('herotitle_desc', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, $description , 'Hogwarts Academy', PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Prints slider motto settings per total.
    $name = 'theme_stream/heromotto' . $i;
    $title = get_string('heromotto', 'theme_stream') . $i;
    $description = get_string('heromotto_desc', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, $description ,
    'The finest school of witchcraft and wizardry in the world.' , PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Hero link.
    $name = 'theme_stream/herolink' . $i;
    $title = get_string('herolink', 'theme_stream') . $i;
    $description = get_string('herolink_desc', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, $description , null , PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Button text.
    $name = 'theme_stream/sliderbutton' . $i;
    $title = get_string('sliderbutton', 'theme_stream') . $i;
    $description = get_string('sliderbutton_desc', 'theme_stream');
    $setting = new admin_setting_configtext($name, $title, $description , null , PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Hero image setting.
    $name = 'theme_stream/homepageheroimage' . $i;
    $title = get_string('homepageheroimage', 'theme_stream') . $i;
    $description = get_string('homepageheroimage_desc', 'theme_stream');
    $filearea = 'homepageheroimage' . $i;
    $setting = new admin_setting_configstoredfile($name, $title, $description, $filearea, 0,
    ['maxfiles' => 1, 'accepted_types' => 'web_image']);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Overlay Opacity.
    $name = 'theme_stream/homepageheroopacity' . $i;
    $title = get_string('homepageheroopacity', 'theme_stream') . $i;
    $description = get_string('homepageheroopacity_desc', 'theme_stream');
    $choices = [
        '0' => '0',
        '0.1' => '1',
        '0.2' => '2',
        '0.3' => '3',
        '0.4' => '4',
        '0.5' => '5',
        '0.6' => '6',
        '0.7' => '7',
        '0.8' => '8',
        '0.9' => '9',
        '1' => '10',
    ];
    $setting = new admin_setting_configselect($name, $title, $description, '0.5', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->hide_if('theme_stream/catwidgetcolumns', 'theme_stream/catwidget', 'notchecked');
    $page->add($setting);

    $i++;
}

// Cat Widget heading.
$page->add(new admin_setting_heading('theme_stream/catwidgetheading', get_string('catwidgetheading', 'theme_stream'), ''));

// Categories Widget.
$name = 'theme_stream/catwidget';
$title = get_string('catwidget', 'theme_stream');
$description = get_string('catwidget_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Add category list as autocomplete field.
$choices = \core_course_category::make_categories_list();
$name = 'theme_stream/choosencats';
$title = get_string('choosencats', 'theme_stream');
$description = get_string('choosencats_desc', 'theme_stream');
$args = ['multiple' => true, 'manageurl' => false];
$setting = new \core_admin\local\settings\autocomplete($name, $title, $description, null , $choices, $args);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/choosencats', 'theme_stream/catwidget', 'notchecked');
$page->add($setting);

// Coursecat widget heading copy.
$name = 'theme_stream/featuredcategoriescopy';
$title = get_string('featuredcategoriessubtitle', 'theme_stream');
$description = get_string('featuredcategoriessubtitle_desc', 'theme_stream');
$setting = new admin_setting_configtext($name, $title, $description , '', PARAM_TEXT);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcategoriescopy', 'theme_stream/catwidget', 'notchecked');
$page->add($setting);

// Show courses count.
$name = 'theme_stream/showcoursescount';
$title = get_string('showcoursescount', 'theme_stream');
$description = get_string('showcoursescount_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/showcoursescount', 'theme_stream/catwidget', 'notchecked');
$page->add($setting);

$name = 'theme_stream/counthiddencourses';
$title = get_string('counthiddencourses', 'theme_stream');
$description = get_string('counthiddencourses_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 0);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/counthiddencourses', 'theme_stream/showcoursescount', 'notchecked');
$page->add($setting);

$name = 'theme_stream/catwidgetcolumns';
$title = get_string('catwidgetcolumns', 'theme_stream');
$description = get_string('catwidgetcolumns_desc', 'theme_stream');
$choices = [
    '12' => '1',
    '6' => '2',
    '4' => '3',
    '3' => '4',
    '2' => '6',
];
$setting = new admin_setting_configselect($name, $title, $description , '4', $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/catwidgetcolumns', 'theme_stream/catwidget', 'notchecked');
$page->add($setting);

// Category standard image.
$name = 'theme_stream/catwidgetimage';
$title = get_string('catwidgetimage', 'theme_stream');
$description = get_string('catwidgetimage_desc', 'theme_stream');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'catwidgetimage', 0,
['maxfiles' => 1, 'accepted_types' => 'web_image']);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/catwidgetimage', 'theme_stream/catwidget', 'notchecked');
$page->add($setting);

// Promox Widget heading.
$page->add(new admin_setting_heading('theme_stream/promoboxwidgetheading',
    get_string('promoboxwidgetheading', 'theme_stream'), ''));

// Promobox Widget.
$name = 'theme_stream/homepagepromoboxwidget';
$title = get_string('homepagepromoboxwidget', 'theme_stream');
$description = get_string('homepagepromoboxwidget_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Promobox Title.
$name = 'theme_stream/homepagepromoboxtitle';
$title = get_string('homepagepromoboxtitle', 'theme_stream');
$description = get_string('homepagepromoboxtitle_desc', 'theme_stream');
$default = 'The best Wizarding School';
$setting = new admin_setting_configtext($name, $title, $description , $default, PARAM_TEXT);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/homepagepromoboxtitle', 'theme_stream/homepagepromoboxwidget', 'notchecked');
$page->add($setting);

// Promobox Text.
$name = 'theme_stream/homepagepromoboxtext';
$title = get_string('homepagepromoboxtext', 'theme_stream');
$description = get_string('homepagepromoboxtext_desc', 'theme_stream');
$default = get_string('homepagepromoboxtext_default', 'theme_stream');
$setting = new admin_setting_confightmleditor($name, $title, $description, $default, PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/homepagepromoboxtext', 'theme_stream/homepagepromoboxwidget', 'notchecked');
$page->add($setting);

// Promobox Button text.
$name = 'theme_stream/homepagepromoboxbutton';
$title = get_string('homepagepromoboxbutton', 'theme_stream');
$description = get_string('homepagepromoboxbutton_desc', 'theme_stream');
$default = 'Register now!';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/homepagepromoboxbutton', 'theme_stream/homepagepromoboxwidget', 'notchecked');
$page->add($setting);

// Promobox Button URL.
$name = 'theme_stream/homepagepromoboxurl';
$title = get_string('homepagepromoboxurl', 'theme_stream');
$description = get_string('homepagepromoboxurl_desc', 'theme_stream');
$default = $CFG->wwwroot .'/login/signup.php';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/homepagepromoboxurl', 'theme_stream/homepagepromoboxwidget', 'notchecked');
$page->add($setting);


// Promobox Image.
$name = 'theme_stream/homepagepromoboximage';
$title = get_string('homepagepromoboximage', 'theme_stream');
$description = get_string('homepagepromoboximage_desc', 'theme_stream');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'homepagepromoboximage', 0,
['maxfiles' => 1, 'accepted_types' => 'web_image']);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/homepagepromoboximage', 'theme_stream/homepagepromoboxwidget', 'notchecked');
$page->add($setting);

// Featured Courses Widget heading.
$page->add(new admin_setting_heading('theme_stream/featuredcourseswidgetheading',
    get_string('featuredcourseswidgetheading', 'theme_stream'), ''));

// Featured Courses Widget.
$name = 'theme_stream/featuredcourseswidget';
$title = get_string('featuredcourseswidget', 'theme_stream');
$description = get_string('featuredcourseswidget_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show category.
$name = 'theme_stream/featuredcoursesshowcat';
$title = get_string('featuredcoursesshowcat', 'theme_stream');
$description = get_string('featuredcoursesshowcat_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesshowcat', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Show 1st level category.
$name = 'theme_stream/featuredcoursesshowcatfirst';
$title = get_string('featuredcoursesshowcatfirst', 'theme_stream');
$description = get_string('featuredcoursesshowcatfirst_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 0);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesshowcatfirst', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Standard img for courses missing one.
$name = 'theme_stream/coursecardimage';
$title = get_string('coursecardimage', 'theme_stream');
$description = get_string('coursecardimage_desc', 'theme_stream');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'coursecardimage', 0,
['maxfiles' => 1, 'accepted_types' => 'web_image']);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/coursecardimage', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Max courses number to show.
$name = 'theme_stream/featuredcoursesmax';
$title = get_string('featuredcoursesshowcatmax', 'theme_stream');
$description = get_string('featuredcoursesshowcatmax_desc', 'theme_stream');
$choices = [
    '3' => '3',
    '6' => '6',
    '9' => '9',
    '12' => '12',
    '15' => '15',
];
$setting = new admin_setting_configselect($name, $title, $description , '6', $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesmax', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Include hidden courses in the widget.
$name = 'theme_stream/featuredcourseshidden';
$title = get_string('featuredcourseshidden', 'theme_stream');
$description = get_string('featuredcourseshidden_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 0);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcourseshidden', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Show only future courses.
$name = 'theme_stream/featuredcoursesfuture';
$title = get_string('featuredcoursesfuture', 'theme_stream');
$description = get_string('featuredcoursesfuture_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesfuture', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Show course ratings.
$name = 'theme_stream/featuredcoursesrating';
$title = get_string('featuredcoursesrating', 'theme_stream');
$description = get_string('featuredcoursesrating_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesrating', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

// Show course startdate.
$name = 'theme_stream/featuredcoursesstartdate';
$title = get_string('featuredcoursesstartdate', 'theme_stream');
$description = get_string('featuredcoursesstartdate_desc', 'theme_stream');
$setting = new admin_setting_configcheckbox($name, $title, $description , 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->hide_if('theme_stream/featuredcoursesstartdate', 'theme_stream/featuredcourseswidget', 'notchecked');
$page->add($setting);

$settings->add($page);
