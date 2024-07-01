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
 * Plugin version and other meta-data are defined here.
 *
 * @package     theme_stream
 * @copyright   2022 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace theme_stream\output;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_stream
 * @copyright  2022 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {
    /**
     * Returns course-specific information to be output immediately above content on any course page
     * (for the current course)
     *
     * @param bool $onlyifnotcalledbefore output content only if it has not been output before
     * @return string
     */
    public function course_content_header($onlyifnotcalledbefore = false) {
        global $CFG;
        static $functioncalled = false;
        if ($functioncalled && $onlyifnotcalledbefore) {
            // We have already output the content header.
            return '';
        }

        // Output any session notification.
        $notifications = \core\notification::fetch();

        $bodynotifications = '';
        foreach ($notifications as $notification) {
            $bodynotifications .= $this->render_from_template(
                    $notification->get_template_name(),
                    $notification->export_for_template($this)
                );
        }

        $output = \html_writer::span($bodynotifications, 'notifications', ['id' => 'user-notifications']);
        // Prints course visibility warning - Start. If hidden and in course main page hribeiro July 2022.
        $layout = ($this->page->pagelayout);
        if ($this->page->course->visible == 0 && $layout == "course") {
            $output = \html_writer::div('<span class="icon fa fa-eye-slash"></span>' . get_string('hiddencourse',
            'theme_stream'), 'alert alert-danger hiddencourse');
        }
        // Prints course visibility warning - Ending.

        if ($this->page->course->id == SITEID) {
            // Return immediately and do not include /course/lib.php if not necessary.
            return $output;
        }

        require_once($CFG->dirroot.'/course/lib.php');
        $functioncalled = true;
        $courseformat = course_get_format($this->page->course);
        if (($obj = $courseformat->course_content_header()) !== null) {
            $output .= \html_writer::div($courseformat->get_renderer($this->page)->render($obj), 'course-content-header');
        }
        return $output;
    }

    /**
     * Wrapper for header elements.
     *
     * @return string HTML to display the main header.
     */
    public function full_header() {
        global $CFG;
        $pagetype = $this->page->pagetype;
        $homepage = get_home_page();
        $homepagetype = null;

        // Gets course files to print course image in the header.
        if (empty($CFG->courseoverviewfileslimit)) {
            return '';
        }
        $fs = get_file_storage();
        $context = \context_course::instance($this->page->course->id);
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', false, 'filename', false);
        if (count($files)) {
            $overviewfilesoptions = course_overviewfiles_options($this->page->course->id);
            $acceptedtypes = $overviewfilesoptions['accepted_types'];
            if ($acceptedtypes !== '*') {
                foreach ($files as $key => $file) {
                    if (!file_extension_in_typegroup($file->get_filename() , $acceptedtypes)) {
                        unset($files[$key]);
                    }
                }
            }
            if (count($files) > $CFG->courseoverviewfileslimit) {
                // Return no more than $CFG->courseoverviewfileslimit files.
                $files = array_slice($files, 0, $CFG->courseoverviewfileslimit, true);
            }
        }

         // Get course overview files as images - set $courseimage.
        // The loop means that the LAST stored image will be the one displayed if >1 image file.
        // Shapes URL by using the last image (in the event there's more than 1).
        $courseimage = '';
        foreach ($files as $file) {
            $isimage = $file->is_valid_image();
            if ($isimage) {
                $courseimage = \moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", '/' . $file->get_contextid() . '/'
                . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename() ,
                !$isimage);
            }
        }
        // Sets paths for printing different images depending on the existing files hribeiro 2022.
        // If there's a course image set it.
        if ((!empty($courseimage))) {
             $head = $courseimage;
        } else if (!empty($this->page->theme->setting_file_url('courseheaderimg', 'courseheaderimg'))) {
            // If there isn't set it from the theme settings.
             $head = $this->page->theme->setting_file_url('courseheaderimg', 'courseheaderimg');
        } else {
            // If all previous fail get a global image from the actual theme files.
             $head = parent::image_url('default/header', 'theme');
        }
        // Add a special case since /my/courses is a part of the /my subsystem.
        if ($homepage == HOMEPAGE_MY || $homepage == HOMEPAGE_MYCOURSES) {
            $homepagetype = 'my-index';
        } else if ($homepage == HOMEPAGE_SITE) {
            $homepagetype = 'site-index';
        }
        if ($this->page->include_region_main_settings_in_header_actions() &&
                !$this->page->blocks->is_block_present('settings')) {
            // Only include the region main settings if the page has requested it and it doesn't already have
            // the settings block on it. The region main settings are included in the settings block and
            // duplicating the content causes behat failures.
            $this->page->add_header_action(\html_writer::div(
                $this->region_main_settings_menu(),
                'd-print-none',
                ['id' => 'region-main-settings-menu']
            ));
        }

        $header = new \stdClass();
        $header->settingsmenu = $this->context_header_settings_menu();
        $header->contextheader = $this->context_header();
        $header->hasnavbar = empty($this->page->layout_options['nonavbar']);
        $header->navbar = $this->navbar();
        $header->pageheadingbutton = $this->page_heading_button();
        $header->courseheader = $this->course_header();
        $header->headeractions = $this->page->get_header_actions();
        $header->image = $head;

        // Shows completion rate in the header if it exists and theme option is on. hribeiro 2022.
        $showcompletion = get_config('theme_stream', 'coursecompletion');
        if ($showcompletion) {
            $completionrate = \core_completion\progress::get_course_progress_percentage($this->page->course, 0);
            $header->hascompletion = $this->page->course->enablecompletion;
            $header->completionrate = (int)$completionrate;
        }
        // End of completion rate.

        if (!empty($pagetype) && !empty($homepagetype) && $pagetype == $homepagetype) {
            $header->welcomemessage = \core_user::welcome_message();
        }
        return $this->render_from_template('core/full_header', $header);
    }

    /**
     * Returns the url of the custom favicon.
     *
     * @return moodle_url|string
     */
    public function favicon() {
        $favicon = $this->page->theme->setting_file_url('favicon', 'favicon');

        if (empty($favicon)) {
            return $this->page->theme->image_url('favicon', 'theme');
        } else {
            return $favicon;
        }
    }
    /**
     * Reads external_fonts to use print them in head.mustache
     * hribeiro 2023
     * @return string
     */
    public function external_fonts() {
        // Loads theme settings.
        $theme = \theme_config::load('stream');
        if ($theme->settings->externalfonts) {
            $sitefont = $theme->settings->bunnyfonts;
            $loadbunnyfont =
            '<link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family='. $sitefont .':400" rel="stylesheet" />';

            return $loadbunnyfont;
        }

    }
}
