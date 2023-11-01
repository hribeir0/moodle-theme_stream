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
 * Theme frontpage based on Boost drawers.
 *
 * @package   theme_stream
 * @copyright 2022 Hugo Ribeiro ribeiro.hugo@gmail.com
 * @copyright based on 2021 Bas Brands
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();

if (isloggedin()) {
    $courseindexopen = (get_user_preferences('drawer-open-index', true) == true);
    $blockdraweropen = (get_user_preferences('drawer-open-block') == true);
} else {
    $courseindexopen = false;
    $blockdraweropen = false;
}

if (defined('BEHAT_SITE_RUNNING') && get_user_preferences('behat_keep_drawer_closed') != 1) {
    $blockdraweropen = true;
}

$extraclasses = [];
$topblockshtml = $OUTPUT->blocks('topblock');
$hastopblocks = (strpos($topblockshtml, 'data-block=') !== false || !empty($addblockbutton));

// Methods to print top block region.
$addtopblock = $OUTPUT->addblockbutton('topblock');
$topblock = $OUTPUT->custom_block_region('topblock');

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
if (!$hasblocks) {
    $blockdraweropen = false;
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

$secondarynavigation = false;
$overflow = '';
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions() && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

// Loads theme settings.
$theme = theme_config::load('stream');

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'primarymoremenu' => $primarymenu['moremenu'],
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'overflow' => $overflow,
    'addblockbutton' => $addblockbutton,
    'addtopblock' => $addtopblock,
    'topblock' => $topblock,
];
// Include the content for the footer.
require_once(__DIR__ . '/includes/footer.php');

// Carousel content.
// Sets a default hero image if none exists on the theme settings.
$defaultimage = $OUTPUT->image_url('default/homepagehero', 'theme');

// Get nº of selected slides.
$slidestotal = $theme->settings->slidestotal;
$i = 0;
// Check for single carousel item to avoid uneeded html elements.
$slidestotal <= 1 ? $data['slides'][$i]['single'] = 1 : $data['slides'][$i]['single'] = 0;
// Cycle through the slider elements.
while ($i < $slidestotal) {
    // Dynamic name fields.
    $title = "herotitle{$i}";
    $motto = "heromotto{$i}";
    $link = "herolink{$i}";
    $sliderimage = "homepageheroimage{$i}";
    $sliderbutton = "sliderbutton{$i}";
    // Matching mustache data and info.
    $data['slides'][$i]['herotitle'] = format_string($theme->settings->$title);
    $data['slides'][$i]['slidermotto'] = format_string($theme->settings->$motto);
    $data['slides'][$i]['sliderlink'] = $theme->settings->$link;
    $data['slides'][$i]['sliderbutton'] = format_string($theme->settings->$sliderbutton);
    $data['slides'][$i]['active'] = $i === 0; // Defining the starting point.
    $data['slides'][$i]['index'] = $i; // To trace pace.
    // If no image was uploaded use theme's default hero image.
    if (empty($theme->settings->$sliderimage)) {
        $data['slides'][$i]['sliderimage'] = $defaultimage;
    } else {
        $data['slides'][$i]['sliderimage'] = $theme->setting_file_url($sliderimage, $sliderimage);;
    }
    $i++;
}
// Add carousel data to template context.
$templatecontext = array_merge($templatecontext, $data);

// Categories Widget.
if ($theme->settings->catwidget ) {
    $templatecontext = array_merge($templatecontext, theme_stream_show_catfrontpage());
}

// Promobox Widget.
// Sets a default promobox image if none exists on the theme settings.
$homepagepromoboximage = $OUTPUT->image_url('default/homepagepromobox', 'theme');
if ($theme->setting_file_url('homepagepromoboximage', 'homepagepromoboximage')) {
    $homepagepromoboximage = $theme->setting_file_url('homepagepromoboximage', 'homepagepromoboximage');
}
$promodata = [
    'promoboxwidget' => $theme->settings->homepagepromoboxwidget,
    'promoboxtitle' => format_string($theme->settings->homepagepromoboxtitle),
    'promoboxtext' => format_text($theme->settings->homepagepromoboxtext),
    'promoboxbutton' => format_string($theme->settings->homepagepromoboxbutton),
    'promoboxurl' => $theme->settings->homepagepromoboxurl,
    'promoboximage' => $homepagepromoboximage,
];
$templatecontext = array_merge($templatecontext, $promodata);

// Loads backtotop button.
$backtotopbutton = $theme->settings->backtotopbutton;
if ($backtotopbutton) {
    $PAGE->requires->js_call_amd('theme_stream/backtotop', 'init');
}

// Featured courses Widget.
if ($theme->settings->featuredcourseswidget) {
    $templatecontext = array_merge($templatecontext, theme_stream_show_featured_courses());
}
echo $OUTPUT->render_from_template('theme_stream/frontpage', $templatecontext);
