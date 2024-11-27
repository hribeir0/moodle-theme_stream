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
 * Theme lib containing functions.
 *
 * @package     theme_stream
 * @copyright   2022 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_stream_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    // Settings fileareas. Any new uploadsetting filearea should be added to array.
    $uploadsettings = ['loginimg', 'homepagepromoboximage', 'favicon', 'catwidgetimage', 'coursecardimage', 'courseheaderimg',
    'homepageheroimage0', 'homepageheroimage1', 'homepageheroimage2', 'homepageheroimage3', 'homepageheroimage4', ];

    if ($context->contextlevel == CONTEXT_SYSTEM && in_array($filearea, $uploadsettings)) {
        $theme = theme_config::load('stream');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Returns the main SCSS content.
 *
 * @return string
 */
function theme_stream_get_main_scss_content() {
    global $CFG;
        $scss = file_get_contents($CFG->dirroot . '/theme/stream/scss/stream.scss');

    return $scss;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_stream_get_pre_scss($theme) {
    $scss = '';

    $configurable = [
        // Config key => [variableName, ...].
        // Array with all the settings and SCSS variables to define.
        // Setting => SCSS variable.
        'primarycolour' => ['primary'],
        'secondarycolour' => ['secondary'],
        'fullwidthpage' => ['fullwidthpage'],
        'bunnyfonts' => ['sitefont'],
        'stickynav' => ['isticky'],
        'footercolor' => ['footercolor'],
    ];

    // Deal with slides opacity.
    $slidesmaxtotal = 4;
    $i = 0;
    while ($i <= $slidesmaxtotal) {
        // Pushes to the array.
        $configurable['homepageheroopacity'.$i] = ['slideropacity'.$i];
        // If the setting is empty we set a default value to compile scss.
        if ( get_config('theme_stream', 'homepageheroopacity'.$i) == null) {
            set_config('homepageheroopacity'.$i, 0.5, 'theme_stream');
        }
        $i++;
    }

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);

    }
    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }
    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_stream_get_extra_scss($theme) {
    $content = '';

    // Always return the background image with the scss when we have it.
    return !empty($theme->settings->scss) ? $theme->settings->scss . ' ' . $content : $content;
}

/**
 * Get course image.
 *
 * @param  int $id
 * @return string
 */
function theme_stream_get_course_image($id) {
    global $CFG;
    $url = '';
    require_once( $CFG->libdir . '/filelib.php' );
    $context = context_course::instance( $id );
    $fs = get_file_storage();
    $files = $fs->get_area_files( $context->id, 'course', 'overviewfiles', 0 );
    foreach ($files as $f) {
        if ($f->is_valid_image()) {
            $url = moodle_url::make_pluginfile_url( $f->get_contextid(),
                $f->get_component(), $f->get_filearea(), null, $f->get_filepath(), $f->get_filename(), false );
        }
    }
    return $url;
}

/**
 * Collect data to print categories in the frontpage.
 *
 * @return array
 */
function theme_stream_show_catfrontpage() {
    global $OUTPUT;
    // Loads theme settings.
    $theme = theme_config::load('stream');

    // Sets the number of rows for the grid layout.
    $templatecontext['catwidgetcolumns'] = $theme->settings->catwidgetcolumns;
    // Sets catwidget confirmation for the widget heading since we are.
    $templatecontext['catwidget'] = 1;
    $counthiddencourses = $theme->settings->counthiddencourses;

    // Widget heading subtitle.
    $templatecontext['catwidgetheadingsubtitle'] = format_string($theme->settings->featuredcategoriescopy);
    // Choosen cats to array from setting.
    $categories = explode(',', $theme->settings->choosencats);
    // If user has choosen categories to show.
    if (!empty($theme->settings->choosencats)) {
        $n = 0;
        foreach ($categories as $choosencat) {
            $category = \core_course_category::get($choosencat);
            $courses = get_courses($category->id);
            // If we should we count courses.
            if ($theme->settings->showcoursescount) {
                // Check to count hidden courses or not.
                if ($counthiddencourses) {
                    $count = $category->coursecount;
                } else {
                    // Counts the number of visible courses on each category.
                    $count = array_reduce($courses, function ($carry, $course) {
                        return $carry + ($course->visible == 1);
                    }, 0);
                    // Skips the category if no course is visible to students.
                    if ($count < 1) {
                        continue;
                    }
                }
                $templatecontext['categories'][$n]['total'] = $count;
                // Deal with plural and single 'course' string.
                if ($count == 1) {
                    $templatecontext['categories'][$n]['coursecountstring'] = get_string('course');
                } else {
                    $templatecontext['categories'][$n]['coursecountstring'] = get_string('courses');
                }
            }
            $templatecontext['categories'][$n]['name'] = $category->name;
            $templatecontext['categories'][$n]['id'] = $category->id;
            if (!empty($courses)) {
                foreach ($courses as $course) {
                    $imgurl = theme_stream_get_course_image($course->id);
                    if (!empty($imgurl)) {
                        $templatecontext['categories'][$n]['imgurl'] = $imgurl;
                        break;
                    }
                }
            }

            // If there isn't any course with an image get a standard one from the settings or from the default pix folder.
            if (!isset($templatecontext['categories'][$n]['imgurl'])) {
                $imgurl = $theme->setting_file_url('catwidgetimage', 'catwidgetimage');
                if (!isset($imgurl)) {
                    $imgurl = $OUTPUT->image_url('default/category', 'theme');
                }
                $templatecontext['categories'][$n]['imgurl'] = $imgurl;
            }
            $n++;

        }
    }
    // If empty setting or no courses on any cat.
    if (!isset($templatecontext['categories'])) {
        $templatecontext['nocategory'] = 1;
    }
    return $templatecontext;
}

/**
 * Collect data to print featured courses in the frontpage.
 *
 * @return array
 */
function theme_stream_show_featured_courses() {
    global $DB, $OUTPUT;
    // Loads theme settings.
    $theme = theme_config::load('stream');
    $count = $theme->settings->featuredcoursesmax;
    $sql = 'SELECT  c.id, c.fullname, c.shortname, c.summary, c.startdate, c.category, c.visible ';
    $sql .= 'FROM {course} c ';
    // Exclude the site itself.
    $sql .= 'WHERE c.id > 1 ';
    // Query all courses or just the visible ones.
    if (!$theme->settings->featuredcourseshidden) {
        $sql .= 'and c.visible = 1';
    }
    $now = time();
    if ($theme->settings->featuredcoursesfuture) {
        $sql .= ' and c.startdate > ' . $now;
    }
    $sql .= ' ORDER BY c.startdate ASC';
    $sql .= ' LIMIT ' . $count;

    $featuredcourses = $DB->get_records_sql($sql);

    // Activate widget.
    $templatecontext['featuredcourseswidget'] = 1;
    // If we get no results from applied filters.
    if (empty($featuredcourses)) {
        $templatecontext['nofeaturedcourses'] = 1;
    }
    $n = 0;
    foreach ($featuredcourses as $featuredcourse) {
        $course = new \core_course_list_element($featuredcourse);
        $templatecontext['featuredcourses'][$n]['id'] = $course->id;
        $templatecontext['featuredcourses'][$n]['fullname'] = $course->fullname;
        if ($theme->settings->featuredcoursesshowcat) {
            // Get category object regarding each course.
            $cat = \core_course_category::get($course->category, IGNORE_MISSING);
            // Show 1st level category if this is not a main category and the setting is on.
            if ($cat->depth > 1 && $theme->settings->featuredcoursesshowcatfirst) {
                $maincat = explode('/', $cat->path);
                // Get first level from the path.
                $coursecategory = \core_course_category::get($maincat[1], IGNORE_MISSING);
                $templatecontext['featuredcourses'][$n]['category'] = $coursecategory->name;
            } else {
                $templatecontext['featuredcourses'][$n]['category'] = $cat->name;
            }
        }
        // If the course is hidden we print a notice.
        if (!$course->visible) {
            $templatecontext['featuredcourses'][$n]['hidden'] = get_string('availablesoon', 'theme_stream');
        }
        $templatecontext['featuredcourses'][$n]['summary'] = format_text($course->summary);
        // Print course tags.
        $tags = \core_tag_tag::get_item_tags('core', 'course', $course->id);
        $templatecontext['featuredcourses'][$n]['tags'] = $OUTPUT->tag_list($tags, '');

        if ($theme->settings->featuredcoursesstartdate) {
            $templatecontext['featuredcourses'][$n]['startdate'] = $course->startdate;
        }
        $templatecontext['featuredcourses'][$n]['img'] = theme_stream_get_course_image($course->id);

        // If course rating plugin is installed and setting is on.
        $plugins = core_plugin_manager::instance()->get_present_plugins('tool');
        if (isset($plugins['courserating']) && $theme->settings->featuredcoursesrating) {
            // Send course rating value to template.
            $handler = core_course\customfield\course_handler::create();
            $fieldsvisible = $handler->export_instance_data_object($course->id);
            $templatecontext['featuredcourses'][$n]['rating'] = $fieldsvisible->tool_courserating;

        }
        // If a course is missing an image get a standard one from the settings or from the default pix folder.
        if (empty($templatecontext['featuredcourses'][$n]['img'])) {
            $imgurl = $theme->setting_file_url('coursecardimage', 'coursecardimage');
            if (!isset($imgurl)) {
                $imgurl = $OUTPUT->image_url('default/course', 'theme');
            }
            $templatecontext['featuredcourses'][$n]['img'] = $imgurl;
        }
        $n++;
    }

    return $templatecontext;
}
