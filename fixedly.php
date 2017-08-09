<?php
/**
    Plugin Name: Fixedly Media Gallery
    Plugin URI: http://www.fixedly.net/
    Description: Create and integrate <strong>easily and quickly</strong> your <strong>video, image, or slideshow gallery</strong> into your WordPress pages/posts. Check out our website for <a href="http://www.fixedly.net/">usage, demos &amp; screencasts</a>.
    Version: 1.2
    Author: Krasen Slavov
    Author URI: http://www.thechoppr.com/
    License: GPL2

    Copyright 2012 Krasen Slavov  (email : hello@fixedly.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/** define some global plugin variables */

global $wpdb;
global $fixedly_db_version;

$fixedly_db_version = "0.2";

define("FIXEDLY_GALLERY_DB_TABLE", $wpdb->prefix . "fixedly_gallery");
define("FIXEDLY_MEDIA_DB_TABLE", $wpdb->prefix . "fixedly_media");
define("FIXEDLY_TEMPLATE_DB_TABLE", $wpdb->prefix . "fixedly_template");

define("FIXEDLY_PLUGIN_VERSION", "1.2");
define("FIXEDLY_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("FIXEDLY_PLUGIN_DIR", plugin_dir_path( __FILE__ ));

/** add stylesheet and javascript files into admin and template headers */

add_action("admin_enqueue_scripts", "load_fixedly_admin_header");
add_action("wp_enqueue_scripts", "load_fixedly_theme_header");

function load_fixedly_theme_header() {

    wp_register_script('jquery.cycle.all-2.99.js', FIXEDLY_PLUGIN_URL . 'scripts/jquery.cycle.all-2.99.js', array("jquery"));
    wp_enqueue_script('jquery.cycle.all-2.99.js');

    wp_register_script('jquery.fancybox.pack.js', FIXEDLY_PLUGIN_URL . 'scripts/fancybox/jquery.fancybox.pack.js', array("jquery"));
    wp_enqueue_script('jquery.fancybox.pack.js');

    wp_register_style('jquery.fancybox.css', FIXEDLY_PLUGIN_URL . 'scripts/fancybox/jquery.fancybox.css');
    wp_enqueue_style('jquery.fancybox.css');
}

function load_fixedly_admin_header() {

    wp_register_script('jquery.cycle.all-2.99.js', FIXEDLY_PLUGIN_URL . 'scripts/jquery.cycle.all-2.99.js', array("jquery"));
    wp_enqueue_script('jquery.cycle.all-2.99.js');

    wp_register_script('jquery.validate-1.9.min.js', FIXEDLY_PLUGIN_URL . 'scripts/jquery.validate-1.9.min.js', array("jquery"));
    wp_enqueue_script('jquery.validate-1.9.min.js');

    wp_register_script('jquery.jeditable-1.7.1.js', FIXEDLY_PLUGIN_URL . 'scripts/jquery.jeditable-1.7.1.js', array("jquery"));
    wp_enqueue_script('jquery.jeditable-1.7.1.js');

    wp_register_script('fixedly.admin.js', FIXEDLY_PLUGIN_URL . 'scripts/fixedly.admin.js', array("jquery"));
    wp_enqueue_script('fixedly.admin.js');

    wp_register_style('style.css', FIXEDLY_PLUGIN_URL . 'style.css');
    wp_enqueue_style('style.css');
}

/** create ajax action to update media title, description, link, template & type */

if ($_GET["do"] == "save_title") {

    if (!empty($_POST["id"]) && !empty($_POST["value"])) {

        $wpdb->update(FIXEDLY_MEDIA_DB_TABLE,
            array('title' => $_POST["value"]),
            array('id' => $_POST["id"]),
            array('%s'),
            array('%d')
        );
    }

    print $_POST["value"];
    exit;
}

if ($_GET["do"] == "save_desc") {

    if (!empty($_POST["id"]) && !empty($_POST["value"])) {

        $wpdb->update(FIXEDLY_MEDIA_DB_TABLE,
            array('description' => $_POST["value"]),
            array('id' => $_POST["id"]),
            array('%s'),
            array('%d')
        );
    }

    print $_POST["value"];
    exit;
}

if ($_GET["do"] == "save_link") {

    if (!empty($_POST["id"]) && !empty($_POST["value"])) {

        $wpdb->update(FIXEDLY_MEDIA_DB_TABLE,
            array('slide_link' => $_POST["value"]),
            array('id' => $_POST["id"]),
            array('%s'),
            array('%d')
        );
    }

    print $_POST["value"];
    exit;
}

if ($_GET["do"] == "load_tmpl") {

    $rows_affected = $wpdb->get_results("SELECT title
        FROM " . FIXEDLY_TEMPLATE_DB_TABLE . "
        GROUP BY title");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        $templates[$rows_affected[$row]->title] = $rows_affected[$row]->title;
    }

    $templates["selected"] = "default";

    print json_encode($templates);
    exit;
}

if ($_GET["do"] == "save_tmpl") {

    if (!empty($_POST["id"]) && !empty($_POST["value"])) {

        $wpdb->update(FIXEDLY_GALLERY_DB_TABLE,
            array('template' => $_POST["value"]),
            array('id' => $_POST["id"]),
            array('%s'),
            array('%d')
        );
    }

    print $_POST["value"];
    exit;
}

if ($_GET["do"] == "save_type") {

        if (!empty($_POST["id"]) && !empty($_POST["value"])) {

        $wpdb->update(FIXEDLY_GALLERY_DB_TABLE,
            array('type' => $_POST["value"]),
            array('id' => $_POST["id"]),
            array('%s'),
            array('%d')
        );
    }

    print $_POST["value"];
    exit;
}

/** during activation create and initialize database tables and insert default data **/

function fixedly_install() {

    global $wpdb;
    global $fixedly_db_version;

    $fixedly_db_version_installed = get_option("fixedly_db_version");

    $media_table_name   = FIXEDLY_MEDIA_DB_TABLE;
    $gallery_table_name = FIXEDLY_GALLERY_DB_TABLE;
    $template_table_name = FIXEDLY_TEMPLATE_DB_TABLE;

    if (!empty($fixedly_db_version_installed) && ($fixedly_db_version_installed != $fixedly_db_version)) {

        update_option("fixedly_db_version", $fixedly_db_version);

        // ver 1.1.1
        $fixedly_sql = "

          ALTER TABLE $media_table_name MODIFY COLUMN title VARCHAR(128) NOT NULL;
          ALTER TABLE $media_table_name MODIFY COLUMN type VARCHAR(64) NOT NULL;

          ALTER TABLE $gallery_table_name MODIFY COLUMN title VARCHAR(128) NOT NULL;
          ALTER TABLE $gallery_table_name MODIFY COLUMN type VARCHAR(64) NOT NULL;

          CREATE TABLE $template_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(128) DEFAULT '' NOT NULL,
            layout VARCHAR(64) DEFAULT '' NOT NULL,
            show_media_title ENUM('show','dont_show'),
            show_media_description ENUM('show','dont_show'),
            show_media_nav ENUM('show','dont_show'),
            nav_prev_text VARCHAR(128) DEFAULT '' NOT NULL,
            nav_next_text VARCHAR(128) DEFAULT '' NOT NULL,
            col_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_left_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_right_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_height VARCHAR(4) DEFAULT '' NOT NULL,
            style_fixedly_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_img VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav_prev VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav_next VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_head VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_text VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_left VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_right VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_left VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_left_select VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_right VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_right_iframe VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul_li VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul_li_img VARCHAR(255) DEFAULT '' NOT NULL,
            script_cycle_fx VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_width VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_height VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_speed VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_random VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_pause VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_delay VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_continuous VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_timeout VARCHAR(16) DEFAULT '' NULL,
            timestamp DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id));";

        $wpdb->query($wpdb->prepare("ALTER TABLE $template_table_name CHANGE COLUMN script_cycle_timeout script_cycle_timeout VARCHAR(16) NULL"));
        $wpdb->query($wpdb->prepare("ALTER TABLE $media_table_name CHANGE COLUMN outbound_link slide_link VARCHAR(255) DEFAULT '' NOT NULL"));
        $wpdb->query($wpdb->prepare("ALTER TABLE $gallery_table_name ADD COLUMN template VARCHAR(64)  DEFAULT '' NOT NULL AFTER type"));
        
        // ver 1.2
        $wpdb->query($wpdb->prepare("ALTER TABLE $template_table_name ADD COLUMN screenshot_thumb_width VARCHAR(4) DEFAULT '' NOT NULL AFTER col_height"));
        $wpdb->query($wpdb->prepare("ALTER TABLE $template_table_name ADD COLUMN screenshot_thumb_height VARCHAR(4) DEFAULT '' NOT NULL AFTER screenshot_thumb_width"));
    }
    else {

      $fixedly_sql = "

        CREATE TABLE $media_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(128) NOT NULL,
            link VARCHAR(255) DEFAULT '' NOT NULL,
            slide_link VARCHAR(255) DEFAULT '' NOT NULL,
            description text NOT NULL,
            screenshot VARCHAR(255) DEFAULT '' NOT NULL,
            type VARCHAR(64) NOT NULL,
            status ENUM('visible','hidden','deleted'),
            timestamp DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            gid int(11) NOT NULL,
            UNIQUE KEY id (id));

        CREATE TABLE $gallery_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(128) DEFAULT '' NOT NULL,
            type VARCHAR(64) DEFAULT '' NOT NULL,
            template VARCHAR(64) DEFAULT '' NOT NULL,
            status ENUM('visible','hidden','deleted'),
            timestamp DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id));

        CREATE TABLE $template_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(128) DEFAULT '' NOT NULL,
            layout VARCHAR(64) DEFAULT '' NOT NULL,
            show_media_title ENUM('show','dont_show'),
            show_media_description ENUM('show','dont_show'),
            show_media_nav ENUM('show','dont_show'),
            nav_prev_text VARCHAR(128) DEFAULT '' NOT NULL,
            nav_next_text VARCHAR(128) DEFAULT '' NOT NULL,
            col_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_left_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_right_width VARCHAR(4) DEFAULT '' NOT NULL,
            col_height VARCHAR(4) DEFAULT '' NOT NULL,
            screenshot_thumb_width VARCHAR(4) DEFAULT '' NOT NULL,
            screenshot_thumb_height VARCHAR(4) DEFAULT '' NOT NULL,
            style_fixedly_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_img VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav_prev VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_nav_next VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_head VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_text VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_left VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_inner_right VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_left VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_left_select VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_right VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_top_right_iframe VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul_li VARCHAR(255) DEFAULT '' NOT NULL,
            style_fixedly_bot_slider_cont_ul_li_img VARCHAR(255) DEFAULT '' NOT NULL,
            script_cycle_fx VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_width VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_height VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_speed VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_random VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_pause VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_delay VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_continuous VARCHAR(16) DEFAULT '' NOT NULL,
            script_cycle_timeout VARCHAR(16) DEFAULT ''NULL,
            timestamp DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id));";

        add_option("fixedly_db_version", $fixedly_db_version);
    }

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($fixedly_sql);

    $check_default_tpl = $wpdb->get_results("SELECT COUNT(*) as cnt
        FROM $template_table_name
            WHERE title = 'default'", ARRAY_A);

    if  ($check_default_tpl[0]["cnt"] == 0) {

        $wpdb->query("INSERT INTO $template_table_name
            SET
            title = 'default',
            layout = 'one-column',
            show_media_title = 'show',
            show_media_description = 'show',
            show_media_nav = 'show',
            nav_prev_text = '< Previous',
            nav_next_text = 'Next >',
            col_width = '580',
            col_left_width = '',
            col_right_width = '',
            col_height = '360',
            style_fixedly_cont = 'position: relative;',
            style_fixedly_inner_cont = '',
            style_fixedly_inner = 'width: 98%;',
            style_fixedly_inner_img = 'border: 5px solid #ccc;',
            style_fixedly_inner_nav = 'clear: both; overflow: hidden; margin-bottom: 10px;',
            style_fixedly_inner_nav_prev = 'float: left;',
            style_fixedly_inner_nav_next = 'float: right;',
            script_cycle_fx = 'fade',
            script_cycle_width = '100%',
            script_cycle_height = 'auto',
            script_cycle_speed = '3000',
            script_cycle_random = 'false',
            script_cycle_pause = 'true',
            script_cycle_delay = '1000',
            script_cycle_continuous = 'true',
            script_cycle_timeout = '0',
            timestamp = NOW();");

        create_template_dir('default', 'one-column');
    }
    
    // ver 1.2
    $check_default_tpl = $wpdb->get_results("SELECT COUNT(*) as cnt
        FROM $template_table_name
            WHERE title = 'default-image-gallery'", ARRAY_A);
            
    if  ($check_default_tpl[0]["cnt"] == 0) {

        $wpdb->query("INSERT INTO $template_table_name
            SET
            title = 'default-image-gallery-template',
            layout = 'two-columns',
            show_media_title = 'show',
            show_media_description = 'show',
            show_media_nav = 'show',
            nav_prev_text = '< Previous',
            nav_next_text = 'Next >',
            col_left_width = '420',
            col_right_width = '140',
            col_height = '360',
            style_fixedly_cont = 'position: relative;',
            style_fixedly_inner_cont = '',
            style_fixedly_inner = 'position: relative; overflow: hidden; clear: both;',
            style_fixedly_inner_img = 'border: 3px solid #ddd;',
            style_fixedly_inner_nav = 'position: absolute; top: 0px; right: 0px; overflow: hidden; clear: both; z-index: 8;',
            style_fixedly_inner_nav_prev = 'float: left;',
            style_fixedly_inner_nav_next = 'float: right;',
            style_fixedly_inner_head = 'font-size: 18px; line-height: 24px; margin: 30px 0px 10px 0px;',
            style_fixedly_inner_text = 'font-size: 14px',
            style_fixedly_inner_left = 'float: left;',
            style_fixedly_inner_right = 'float: right;',
            script_cycle_fx = 'fade',
            script_cycle_width = '100%',
            script_cycle_height = 'auto',
            script_cycle_speed = '3000',
            script_cycle_random = 'false',
            script_cycle_pause = 'true',
            script_cycle_delay = '1000',
            script_cycle_continuous = 'true',
            script_cycle_timeout = '0',
            timestamp = NOW();");

        create_template_dir('default-image-gallery', 'two-columns');
    }
    
    $check_default_tpl = $wpdb->get_results("SELECT COUNT(*) as cnt
        FROM $template_table_name
            WHERE title = 'default-video-gallery-template'", ARRAY_A);

    if  ($check_default_tpl[0]["cnt"] == 0) {

        $wpdb->query("INSERT INTO $template_table_name
            SET
            title = 'default-video-gallery',
            layout = 'two-columns-with-bottom-slider',
            show_media_title = 'show',
            show_media_description = 'show',
            show_media_nav = 'show',
            nav_prev_text = '<',
            nav_next_text = '>',
            col_left_width = '140',
            col_right_width = '420',
            col_height = '360',
            screenshot_thumb_width = '140',
            screenshot_thumb_height = '140',
            style_fixedly_cont = 'position: relative;',
            style_fixedly_inner_nav = 'clear: both; overflow: hidden; margin-bottom: 10px;',
            style_fixedly_inner_nav_prev = 'position: absolute; bottom: 40px; left: 0px; font-size: 42px; z-index: 8;',
            style_fixedly_inner_nav_next = 'position: absolute; bottom: 40px; right: 0px; font-size: 42px; z-index: 9;',
            style_fixedly_inner_head = 'font-size: 18px; line-height: 22px; margin-bottom: 10px;',
            style_fixedly_inner_text = 'font-size: 14px;',
            style_fixedly_top_cont = 'margin-bottom: 20px; overflow: hidden; clear: both;',
            style_fixedly_top_left = 'float: left;',
            style_fixedly_top_left_select = 'margin-bottom: 20px;',
            style_fixedly_top_right = 'float: right;',
            style_fixedly_top_right_iframe = 'border: 10px solid #eee; width: 95%;',
            style_fixedly_bot_cont = 'margin-bottom: 20px;',
            style_fixedly_bot_slider = 'position: relative;',
            style_fixedly_bot_slider_cont = 'width: 100%; margin: 0 auto; overflow: hidden; position: relative;',
            style_fixedly_bot_slider_cont_ul = 'margin: 0; padding: 0; width: 100%; text-align: center;',
            style_fixedly_bot_slider_cont_ul_li = 'display: inline; list-style-type: none; margin-right: 10px; margin-left: 10px;',
            style_fixedly_bot_slider_cont_ul_li_img = 'border: 5px solid #eee; display: inline-block;',
            script_cycle_fx = 'fade',
            script_cycle_width = '100%',
            script_cycle_height = 'auto',
            script_cycle_speed = '3000',
            script_cycle_random = 'false',
            script_cycle_pause = 'true',
            script_cycle_delay = '1000',
            script_cycle_continuous = 'true',
            script_cycle_timeout = '0',
            timestamp = NOW();");

        create_template_dir('default-video-gallery', 'two-columns-with-bottom-slider');
    }
}

register_activation_hook(__FILE__, 'fixedly_install');

function fixedly_update_db_check() {

    global $fixedly_db_version;
    
    $fixedly_db_version_installed = get_option("fixedly_db_version");
    
    if (!empty($fixedly_db_version_installed) && ($fixedly_db_version_installed != $fixedly_db_version)) {
    
        fixedly_install();
    }
}

add_action('plugins_loaded', 'fixedly_update_db_check');

/** add plugin shortcode and init/loading function */

add_shortcode("fixedly-media-gallery", "fixedly_init");

function fixedly_init($args) {

    if (!empty($args["id"])) {

        if ($gallery_default = fixedly_default($args["id"])) {

            (empty($args["template"])) ? $template = $gallery_default->template : $template = $args["template"];
            (empty($args["type"])) ? $type = $gallery_default->type : $type = $args["type"];

            if (function_exists('fixedly_media_gallery')) {

                return fixedly_media_gallery($args["id"], $template, $type);
            }
            else
                return "<p><em>[Fixedly Error #1]: Please enable your Fixedly Media Gallery plugin!</em></p>";
        }
    }
    else
        return "<p><em>[Fixedly Error #2]: You need to specify the 'id' for your gallery!</em></p>";
}

function fixedly_media_gallery($gid, $template, $type) {

    if (is_dir(ABSPATH . 'wp-content/uploads/fixedly_templates/' . $template . '/')) {

        ob_start();
        require_once(ABSPATH . 'wp-content/uploads/fixedly_templates/' . $template . '/template.php');
        $data = ob_get_clean();

        return $data;
    }
    else
        return "<p><em>[Fixedly Error #4]: The template name you entered cannot be found!</em></p>";
}

function fixedly_default($gid) {

    if (!empty($gid)) {

        global $wpdb;

        $rows_affected = $wpdb->get_results("SELECT *
            FROM " . FIXEDLY_GALLERY_DB_TABLE . "
            WHERE status != 'deleted'
                AND id = '" . $gid . "'");

        if (sizeof($rows_affected) > 0)
            return $rows_affected[0];
    }

    return false;
}


/** create wordpress admin panel menu tabs */

add_action("admin_menu", "fixedly_menu");

function fixedly_menu() {

    add_menu_page("Fixedly Media Gallery", "Fixedly", "administrator", "fixedly/fixedly.php", "fixedly_create_gallery");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Add/Manage Galleries", "My Galleries", "administrator", "fixedly/fixedly.php", "fixedly_create_gallery");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Add New Images", "&nbsp;&nbsp; . Add Images", "administrator", "add_images", "fixedly_add_images_gallery");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Add New Videos", "&nbsp;&nbsp; . Add Videos", "administrator", "add_videos", "fixedly_add_videos_gallery");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Add New Slides", "&nbsp;&nbsp; . Add Slides", "administrator", "add_slides", "fixedly_add_slides_gallery");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Create New Templates", "My Templates", "administrator", "create_template", "fixedly_create_template");
    add_submenu_page("fixedly/fixedly.php", "Fixedly Edit Templates", "&nbsp;&nbsp; . Edit Templates", "administrator", "edit_template", "fixedly_edit_template");
}

/** load media upload scripts to the admin header for the Add Images & Add Slides pages */

if (isset($_GET['page']) && ($_GET['page'] == 'add_images' || $_GET['page'] == 'add_slides')) {

    add_action("admin_enqueue_scripts", "load_fixedly_media_upload_header");
}

function load_fixedly_media_upload_header() {

    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-fixedly-upload', WP_PLUGIN_URL . '/fixedly/scripts/fixedly.admin.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('my-fixedly-upload');
    wp_enqueue_style('thickbox');
}

/** below are fuctions to add, edit & manage galleries **/

function fixedly_create_gallery() {

    $success = false;

    $handle_values = explode("|", $_POST["template"]);

    if ($_POST["action"] == "update") {

        if (fixedly_add_gallery($_POST["title"], $_POST["type"], $handle_values[1]))
            $success = "New Gallery addeded successfully!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/create_gallery.php";

    print_by_line();
}

function fixedly_add_gallery($title, $type, $template) {

    global $wpdb;

    $title_santzd = sanitize_text_field($title);
    $type_santzd = sanitize_text_field($type);
    $template_santzd = sanitize_text_field($template);

    if ($wpdb->insert(FIXEDLY_GALLERY_DB_TABLE,
        array(
            "title" => $title_santzd,
            "type" => $type_santzd,
            "template" => $template_santzd,
            "status" => "visible",
            "timestamp" => current_time('mysql')))) {

        return true;
    }

    return false;
}

function select_galleries() {

    global $wpdb;
    $table_name = FIXEDLY_GALLERY_DB_TABLE;
    $table_name_2 = FIXEDLY_MEDIA_DB_TABLE;

    // update gallery status
    if (!empty($_GET["gid"]) && !empty($_GET["gstatus"])) {

        $gid_santzd = sanitize_text_field($_GET["gid"]);
        $status_santzd = sanitize_text_field($_GET["gstatus"]);

        $wpdb->update($table_name, array("status" =>$status_santzd), array('id' => $gid_santzd), array('%s'));
    }

    $rows_affected = $wpdb->get_results("SELECT $table_name.*,
        (SELECT COUNT(*) FROM $table_name_2 WHERE $table_name.id = $table_name_2.gid AND $table_name_2.status = 'visible') AS num_items
            FROM $table_name
            WHERE $table_name.status != 'deleted'
        ");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        print '<tr>
            <td class="acenter">' . $rows_affected[$row]->id . '</td>
            <td class="acenter">' . $rows_affected[$row]->num_items . '</td>
            <td><a href="?page=fixedly/fixedly.php&gid=' . $rows_affected[$row]->id . '&type=' . $rows_affected[$row]->type  . '&gallery=manage">' . $rows_affected[$row]->title . '</a></td>
            <td nowrap class="acenter"><abbr class="fixedly_edit_type" id="' . $rows_affected[$row]->id . '" style="display: inline">' . $rows_affected[$row]->type . '</abbr></td>
            <td nowrap class="acenter"><abbr class="fixedly_edit_tmpl" id="' . $rows_affected[$row]->id . '" style="display: inline">' . $rows_affected[$row]->template . '</abbr></td>
            <td nowrap class="acenter">' . $rows_affected[$row]->status . '</td>
            <td nowrap class="acenter"><a href="?page=fixedly/fixedly.php&gid=' . $rows_affected[$row]->id . '&gstatus=visible">show</a> . <a href="?page=fixedly/fixedly.php&gid=' . $rows_affected[$row]->id . '&gstatus=hidden">hide</a> . <a href="?page=fixedly/fixedly.php&gid=' . $rows_affected[$row]->id . '&gstatus=deleted">remove</a></td>
            <td nowrap class="acenter">' . mysql2date('m/d/Y', $rows_affected[$row]->timestamp) . '</td>
        </tr>';
    }
}

function select_media($gid, $gtype, $cpage = 0) {

    global $wpdb;
    
    $show_entries_per_page = 10;
    $start_from = $cpage * $show_entries_per_page;

    // update media status
    if (!empty($_GET["mid"]) && !empty($_GET["mstatus"])) {

        $mid_santzd = sanitize_text_field($_GET["mid"]);
        $status_santzd = sanitize_text_field($_GET["mstatus"]);

        $wpdb->update(FIXEDLY_MEDIA_DB_TABLE, array("status" =>$status_santzd), array('id' => $mid_santzd), array('%s'));
    }

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_MEDIA_DB_TABLE . "
        WHERE status != 'deleted'
            AND gid = '" . $gid . "' LIMIT $start_from, $show_entries_per_page");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        ($rows_affected[$row]->type == "image" || $rows_affected[$row]->type == "slideshow" ) ? $screenshot_img = $rows_affected[$row]->link : $screenshot_img = $rows_affected[$row]->screenshot;

        print '<tr>
            <td class="acenter"><img src="' . $screenshot_img . '" width="128" height="128" /></td>
            <td><abbr class="fixedly_edit" id="' . $rows_affected[$row]->id . '">' . stripslashes_deep($rows_affected[$row]->title) . '</abbr></td>
            <td><abbr class="fixedly_edit_area" id="' . $rows_affected[$row]->id . '">' . stripslashes_deep($rows_affected[$row]->description) . '</abbr></td>';


        if ($gtype == "slideshow")
            print '<td><abbr class="fixedly_slide_link" id="' . $rows_affected[$row]->id . '">' . $rows_affected[$row]->slide_link . '</abbr></td>';

        print '<td nowrap class="acenter"><a href="' . $rows_affected[$row]->link . '">View Media</a></td>
            <td nowrap class="acenter">' . $rows_affected[$row]->type . '</td>
            <td nowrap class="acenter">' . $rows_affected[$row]->status . '</abbr></td>
            <td nowrap class="acenter"><a href="?page=fixedly/fixedly.php&gid=' . $gid . '&gallery=manage&mid=' . $rows_affected[$row]->id . '&mstatus=visible&cpage=' . $cpage . '">show</a> . <a href="?page=fixedly/fixedly.php&gid=' . $gid . '&gallery=manage&mid=' . $rows_affected[$row]->id . '&mstatus=hidden&cpage=' . $cpage . '">hide</a> . <a href="?page=fixedly/fixedly.php&gid=' . $gid . '&gallery=manage&mid=' . $rows_affected[$row]->id . '&mstatus=deleted&cpage=' . $cpage . '">remove</a></td>
            <td nowrap class="acenter">' . mysql2date('m/d/Y', $rows_affected[$row]->timestamp) . '</td>
            </tr>';
    }
}

function paginate_media($gid, $gtype, $cpage) {

    global $wpdb;

    $show_entries_per_page = 10;
    
    ($cpage == "" || $cpage == 0) ? $cpage = 1 : "";
    
    if (!empty($cpage) && !empty($gid)) {
    
        $rows_affected = $wpdb->get_results("SELECT *
            FROM " . FIXEDLY_MEDIA_DB_TABLE . "
            WHERE status != 'deleted'
                AND gid = '" . $gid . "'");

        $total_entries = sizeof($rows_affected);

        $number_pages = ceil($total_entries / $show_entries_per_page);
    
        $prev_page = $cpage - 1;

        (($cpage + 1) >= $number_pages) ? $next_page = $number_pages - 1 : $next_page = $cpage + 1;
        
        $last_page = $number_pages - 1;
        $first_page = 0;

        print '<a href="?page=fixedly/fixedly.php&gid=' . $gid . '&type=' . $gtype . '&gallery=manage&cpage=' . $first_page . '"><<</a> &nbsp;';
        print '<a href="?page=fixedly/fixedly.php&gid=' . $gid . '&type=' . $gtype . '&gallery=manage&cpage=' . $prev_page . '"><</a> &nbsp;';

        for ($cnt = 0;  $cnt < $number_pages; $cnt++)  {
        
            $show_page_cnt = $cnt + 1;
            print '<a href="?page=fixedly/fixedly.php&gid=' . $gid . '&type=' . $gtype . '&gallery=manage&cpage=' . $cnt . '">' . $show_page_cnt . '</a> &nbsp;';
        }
        
        print'<a href="?page=fixedly/fixedly.php&gid=' . $gid . '&type=' . $gtype . '&gallery=manage&cpage=' . $next_page . '">></a> &nbsp;';
        print'<a href="?page=fixedly/fixedly.php&gid=' . $gid . '&type=' . $gtype . '&gallery=manage&cpage=' . $last_page . '">>></a> &nbsp;';
    }
}

/** below are fuctions to add, edit & manage templates **/

function fixedly_create_template() {

    $success = false;

    if ($_POST["action"] == "update") {

        if (fixedly_save_template($_POST["title"], $_POST["layout"], $_POST))
                $success = "New Template addeded successfully!";
        else
            $success = "There is already template with that Name OR your template Name & Layout are empty!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/save_template.php";

    print_by_line();
}

function fixedly_edit_template() {

    $success = false;

    if ($_POST["action"] == "update") {

        if (fixedly_update_template($_POST["handle"], $_POST))
            $success = "Template updated successfully!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/edit_template.php";

    print_by_line();
}

function fixedly_save_template($title, $layout, $options) {

    global $wpdb;

    $title_santzd = sanitize_title(sanitize_text_field($title));
    $layout_santzd = sanitize_text_field($layout);

    if (!empty($title_santzd) && !empty($layout_santzd)) {

        $check_default_tpl = $wpdb->get_results("SELECT COUNT(*) as cnt
            FROM " . FIXEDLY_TEMPLATE_DB_TABLE . "
            WHERE title = '" . $title_santzd . "'", ARRAY_A);

        if ($check_default_tpl[0]["cnt"] == 0) {

            $show_media_title_santzd = sanitize_text_field($options["show_title"]);
            $show_media_description_santzd = sanitize_text_field($options["show_description"]);
            $show_media_nav_santzd = sanitize_text_field($options["show_nav"]);

            $tpl_nav_prev_text_santzd = sanitize_text_field($options["tpl_nav_prev_text"]);
            $tpl_nav_next_text_santzd = sanitize_text_field($options["tpl_nav_next_text"]);

            $col_width_santzd = sanitize_text_field($options["tpl_col_width"]);
            $col_left_width_santzd = sanitize_text_field($options["tpl_col_left_width"]);
            $col_right_width_santzd = sanitize_text_field($options["tpl_col_right_width"]);
            $col_height_santzd = sanitize_text_field($options["tpl_col_height"]);
            $col_right_width_santzd = sanitize_text_field($options["tpl_col_right_width"]);
            $screenshot_thumb_width_santzd = sanitize_text_field($options["tpl_screenshot_thumb_width"]);
            $screenshot_thumb_height_santzd = sanitize_text_field($options["tpl_screenshot_thumb_height"]);
            
            $style_fixedly_cont_santzd = sanitize_text_field($options["style_fixedly_cont"]);
            $style_fixedly_inner_cont_santzd = sanitize_text_field($options["style_fixedly_inner_cont"]);
            $style_fixedly_inner_santzd = sanitize_text_field($options["style_fixedly_inner"]);
            $style_fixedly_inner_img_santzd = sanitize_text_field($options["style_fixedly_inner_img"]);
            $style_fixedly_inner_nav_santzd = sanitize_text_field($options["style_fixedly_inner_nav"]);
            $style_fixedly_inner_nav_prev_santzd = sanitize_text_field($options["style_fixedly_inner_nav_prev"]);
            $style_fixedly_inner_nav_next_santzd = sanitize_text_field($options["style_fixedly_inner_nav_next"]);
            $style_fixedly_inner_head_santzd = sanitize_text_field($options["style_fixedly_inner_head"]);
            $style_fixedly_inner_text_santzd = sanitize_text_field($options["style_fixedly_inner_text"]);
            $style_fixedly_inner_left_santzd = sanitize_text_field($options["style_fixedly_inner_left"]);
            $style_fixedly_inner_right_santzd = sanitize_text_field($options["style_fixedly_inner_right"]);
            $style_fixedly_top_cont_santzd = sanitize_text_field($options["style_fixedly_top_cont"]);
            $style_fixedly_top_left_santzd = sanitize_text_field($options["style_fixedly_top_left"]);
            $style_fixedly_top_left_select_santzd = sanitize_text_field($options["style_fixedly_top_left_select"]);
            $style_fixedly_top_right_santzd = sanitize_text_field($options["style_fixedly_top_right"]);
            $style_fixedly_top_right_iframe_santzd = sanitize_text_field($options["style_fixedly_top_right_iframe"]);
            $style_fixedly_bot_cont_santzd = sanitize_text_field($options["style_fixedly_bot_cont"]);
            $style_fixedly_bot_slider_santzd = sanitize_text_field($options["style_fixedly_bot_slider"]);
            $style_fixedly_bot_slider_cont_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont"]);
            $style_fixedly_bot_slider_cont_ul_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul"]);
            $style_fixedly_bot_slider_cont_ul_li_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul_li"]);
            $style_fixedly_bot_slider_cont_ul_li_img_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul_li_img"]);

            $script_fx_santzd = sanitize_text_field($options["script_fx"]);
            $script_width_santzd = sanitize_text_field($options["script_width"]);
            $script_height_santzd = sanitize_text_field($options["script_height"]);
            $script_speed_santzd = sanitize_text_field($options["script_speed"]);
            $script_random_santzd = sanitize_text_field($options["script_random"]);
            $script_pause_santzd = sanitize_text_field($options["script_pause"]);
            $script_delay_santzd = sanitize_text_field($options["script_delay"]);
            $script_continuous_santzd = sanitize_text_field($options["script_continuous"]);
            $script_timeout_santzd = sanitize_text_field($options["script_timeout"]);

            if ($wpdb->insert(FIXEDLY_TEMPLATE_DB_TABLE,
              array(
                "title" => $title_santzd,
                "layout" => $layout_santzd,
                "show_media_title" => $show_media_title_santzd,
                "show_media_description" => $show_media_description_santzd,
                "show_media_nav" => $show_media_nav_santzd,
                "nav_prev_text" => $tpl_nav_prev_text_santzd,
                "nav_next_text" => $tpl_nav_next_text_santzd,
                "col_width" => $col_width_santzd,
                "col_left_width" => $col_left_width_santzd,
                "col_right_width" => $col_right_width_santzd,
                "col_height" => $col_height_santzd,
                "screenshot_thumb_width" => $screenshot_thumb_width_santzd,
                "screenshot_thumb_height" => $screenshot_thumb_height_santzd,
                "style_fixedly_cont" => $style_fixedly_cont_santzd,
                "style_fixedly_inner_cont" => $style_fixedly_inner_cont_santzd,
                "style_fixedly_inner" => $style_fixedly_inner_santzd,
                "style_fixedly_inner_img" => $style_fixedly_inner_img_santzd,
                "style_fixedly_inner_nav" => $style_fixedly_inner_nav_santzd,
                "style_fixedly_inner_nav_prev" => $style_fixedly_inner_nav_prev_santzd,
                "style_fixedly_inner_nav_next" => $style_fixedly_inner_nav_next_santzd,
                "style_fixedly_inner_head" => $style_fixedly_inner_head_santzd,
                "style_fixedly_inner_text" => $style_fixedly_inner_text_santzd,
                "style_fixedly_inner_left" => $style_fixedly_inner_left_santzd,
                "style_fixedly_inner_right" => $style_fixedly_inner_right_santzd,
                "style_fixedly_top_cont" => $style_fixedly_top_cont_santzd,
                "style_fixedly_top_left" => $style_fixedly_top_left_santzd,
                "style_fixedly_top_left_select" => $style_fixedly_top_left_select_santzd,
                "style_fixedly_top_right" => $style_fixedly_top_right_santzd,
                "style_fixedly_top_right_iframe" => $style_fixedly_top_right_iframe_santzd,
                "style_fixedly_bot_cont" => $style_fixedly_bot_cont_santzd,
                "style_fixedly_bot_slider" => $style_fixedly_bot_slider_santzd,
                "style_fixedly_bot_slider_cont" => $style_fixedly_bot_slider_cont_santzd,
                "style_fixedly_bot_slider_cont_ul" => $style_fixedly_bot_slider_cont_ul_santzd,
                "style_fixedly_bot_slider_cont_ul_li" => $style_fixedly_bot_slider_cont_ul_li_santzd,
                "style_fixedly_bot_slider_cont_ul_li_img" => $style_fixedly_bot_slider_cont_ul_li_img_santzd,
                "script_cycle_fx" => $script_fx_santzd,
                "script_cycle_width" => $script_width_santzd,
                "script_cycle_height" => $script_height_santzd,
                "script_cycle_speed" => $script_speed_santzd,
                "script_cycle_random" => $script_random_santzd,
                "script_cycle_pause" => $script_pause_santzd,
                "script_cycle_delay" => $script_delay_santzd,
                "script_cycle_continuous" => $script_continuous_santzd,
                "script_cycle_timeout" => $script_timeout_santzd,
                "timestamp" => current_time('mysql')))) {

                create_template_dir($title_santzd, $layout_santzd);

                return true;
            }
        }
    }

    return false;
}

function fixedly_update_template($handle, $options) {

    global $wpdb;

    $handle_values = explode("|", $handle);

    $layout_santzd = sanitize_text_field($handle_values[0]);
    $title_santzd = sanitize_title(sanitize_text_field($handle_values[1]));

    if (!empty($title_santzd) && !empty($layout_santzd)) {

        $check_default_tpl = $wpdb->get_results("SELECT COUNT(*) as cnt
            FROM " . FIXEDLY_TEMPLATE_DB_TABLE . "
                WHERE title = '" . $title_santzd . "'", ARRAY_A);

        if ($check_default_tpl[0]["cnt"] == 1) {

            $show_media_title_santzd = sanitize_text_field($options["show_title"]);
            $show_media_description_santzd = sanitize_text_field($options["show_description"]);
            $show_media_nav_santzd = sanitize_text_field($options["show_nav"]);

            $tpl_nav_prev_text_santzd = sanitize_text_field($options["tpl_nav_prev_text"]);
            $tpl_nav_next_text_santzd = sanitize_text_field($options["tpl_nav_next_text"]);

            $col_width_santzd = sanitize_text_field($options["tpl_col_width"]);
            $col_left_width_santzd = sanitize_text_field($options["tpl_col_left_width"]);
            $col_right_width_santzd = sanitize_text_field($options["tpl_col_right_width"]);
            $col_height_santzd = sanitize_text_field($options["tpl_col_height"]);
            $screenshot_thumb_width_santzd = sanitize_text_field($options["tpl_screenshot_thumb_width"]);
            $screenshot_thumb_height_santzd = sanitize_text_field($options["tpl_screenshot_thumb_height"]);

            $style_fixedly_cont_santzd = sanitize_text_field($options["style_fixedly_cont"]);
            $style_fixedly_inner_cont_santzd = sanitize_text_field($options["style_fixedly_inner_cont"]);
            $style_fixedly_inner_santzd = sanitize_text_field($options["style_fixedly_inner"]);
            $style_fixedly_inner_img_santzd = sanitize_text_field($options["style_fixedly_inner_img"]);
            $style_fixedly_inner_nav_santzd = sanitize_text_field($options["style_fixedly_inner_nav"]);
            $style_fixedly_inner_nav_prev_santzd = sanitize_text_field($options["style_fixedly_inner_nav_prev"]);
            $style_fixedly_inner_nav_next_santzd = sanitize_text_field($options["style_fixedly_inner_nav_next"]);
            $style_fixedly_inner_head_santzd = sanitize_text_field($options["style_fixedly_inner_head"]);
            $style_fixedly_inner_text_santzd = sanitize_text_field($options["style_fixedly_inner_text"]);
            $style_fixedly_inner_left_santzd = sanitize_text_field($options["style_fixedly_inner_left"]);
            $style_fixedly_inner_right_santzd = sanitize_text_field($options["style_fixedly_inner_right"]);
            $style_fixedly_top_cont_santzd = sanitize_text_field($options["style_fixedly_top_cont"]);
            $style_fixedly_top_left_santzd = sanitize_text_field($options["style_fixedly_top_left"]);
            $style_fixedly_top_left_select_santzd = sanitize_text_field($options["style_fixedly_top_left_select"]);
            $style_fixedly_top_right_santzd = sanitize_text_field($options["style_fixedly_top_right"]);
            $style_fixedly_top_right_iframe_santzd = sanitize_text_field($options["style_fixedly_top_right_iframe"]);
            $style_fixedly_bot_cont_santzd = sanitize_text_field($options["style_fixedly_bot_cont"]);
            $style_fixedly_bot_slider_santzd = sanitize_text_field($options["style_fixedly_bot_slider"]);
            $style_fixedly_bot_slider_cont_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont"]);
            $style_fixedly_bot_slider_cont_ul_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul"]);
            $style_fixedly_bot_slider_cont_ul_li_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul_li"]);
            $style_fixedly_bot_slider_cont_ul_li_img_santzd = sanitize_text_field($options["style_fixedly_bot_slider_cont_ul_li_img"]);

            $script_fx_santzd = sanitize_text_field($options["script_fx"]);
            $script_width_santzd = sanitize_text_field($options["script_width"]);
            $script_height_santzd = sanitize_text_field($options["script_height"]);
            $script_speed_santzd = sanitize_text_field($options["script_speed"]);
            $script_random_santzd = sanitize_text_field($options["script_random"]);
            $script_pause_santzd = sanitize_text_field($options["script_pause"]);
            $script_delay_santzd = sanitize_text_field($options["script_delay"]);
            $script_continuous_santzd = sanitize_text_field($options["script_continuous"]);
            $script_timeout_santzd = sanitize_text_field($options["script_timeout"]);

            if ($wpdb->update(FIXEDLY_TEMPLATE_DB_TABLE,
              array(
                "title" => $title_santzd,
                "layout" => $layout_santzd,
                "show_media_title" => $show_media_title_santzd,
                "show_media_description" => $show_media_description_santzd,
                "show_media_nav" => $show_media_nav_santzd,
                "nav_prev_text" => $tpl_nav_prev_text_santzd,
                "nav_next_text" => $tpl_nav_next_text_santzd,
                "col_width" => $col_width_santzd,
                "col_left_width" => $col_left_width_santzd,
                "col_right_width" => $col_right_width_santzd,
                "col_height" => $col_height_santzd,
                "screenshot_thumb_width" => $screenshot_thumb_width_santzd,
                "screenshot_thumb_height" => $screenshot_thumb_height_santzd,
                "style_fixedly_cont" => $style_fixedly_cont_santzd,
                "style_fixedly_inner_cont" => $style_fixedly_inner_cont_santzd,
                "style_fixedly_inner" => $style_fixedly_inner_santzd,
                "style_fixedly_inner_img" => $style_fixedly_inner_img_santzd,
                "style_fixedly_inner_nav" => $style_fixedly_inner_nav_santzd,
                "style_fixedly_inner_nav_prev" => $style_fixedly_inner_nav_prev_santzd,
                "style_fixedly_inner_nav_next" => $style_fixedly_inner_nav_next_santzd,
                "style_fixedly_inner_head" => $style_fixedly_inner_head_santzd,
                "style_fixedly_inner_text" => $style_fixedly_inner_text_santzd,
                "style_fixedly_inner_left" => $style_fixedly_inner_left_santzd,
                "style_fixedly_inner_right" => $style_fixedly_inner_right_santzd,
                "style_fixedly_top_cont" => $style_fixedly_top_cont_santzd,
                "style_fixedly_top_left" => $style_fixedly_top_left_santzd,
                "style_fixedly_top_left_select" => $style_fixedly_top_left_select_santzd,
                "style_fixedly_top_right" => $style_fixedly_top_right_santzd,
                "style_fixedly_top_right_iframe" => $style_fixedly_top_right_iframe_santzd,
                "style_fixedly_bot_cont" => $style_fixedly_bot_cont_santzd,
                "style_fixedly_bot_slider" => $style_fixedly_bot_slider_santzd,
                "style_fixedly_bot_slider_cont" => $style_fixedly_bot_slider_cont_santzd,
                "style_fixedly_bot_slider_cont_ul" => $style_fixedly_bot_slider_cont_ul_santzd,
                "style_fixedly_bot_slider_cont_ul_li" => $style_fixedly_bot_slider_cont_ul_li_santzd,
                "style_fixedly_bot_slider_cont_ul_li_img" => $style_fixedly_bot_slider_cont_ul_li_img_santzd,
                "script_cycle_fx" => $script_fx_santzd,
                "script_cycle_width" => $script_width_santzd,
                "script_cycle_height" => $script_height_santzd,
                "script_cycle_speed" => $script_speed_santzd,
                "script_cycle_random" => $script_random_santzd,
                "script_cycle_pause" => $script_pause_santzd,
                "script_cycle_delay" => $script_delay_santzd,
                "script_cycle_continuous" => $script_continuous_santzd,
                "script_cycle_timeout" => $script_timeout_santzd,
                "timestamp" => current_time('mysql')), array('title' => $title_santzd))) {

                update_template_dir($title_santzd, $layout_santzd);

                return true;
            }
        }
    }

    return false;
}

function select_templates($handle = "") {

    global $wpdb;

    $rows_affected = $wpdb->get_results("SELECT title, layout
        FROM " . FIXEDLY_TEMPLATE_DB_TABLE . " GROUP BY title");

    $handle_values = explode("|", $handle);

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        if ($rows_affected[$row]->title == $handle_values[1])
            print '<option selected value="' . $rows_affected[$row]->layout . '|' . $rows_affected[$row]->title . '">'. $rows_affected[$row]->title . '</option>';
        else
            print '<option value="' . $rows_affected[$row]->layout . '|' . $rows_affected[$row]->title . '">'. $rows_affected[$row]->title . '</option>';
    }
}

function select_template_options($handle) {

    global $wpdb;

    $handle_values = explode("|", $handle);

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_TEMPLATE_DB_TABLE . " WHERE title = '" . $handle_values[1] . "'");

    return $rows_affected;
}

function create_template_dir($template_dir_name, $template_layout) {

    $template_wpcontent_dir  = ABSPATH . "wp-content/";
    $template_upload_dir = ABSPATH . "wp-content/uploads/";
    $template_root_dir = ABSPATH . "wp-content/uploads/fixedly_templates/";

    if (!is_dir($template_upload_dir)) {

        chmod($template_wpcontent_dir, 0777);
        mkdir($template_upload_dir, 0, true);
        chmod($template_wpcontent_dir, 0755);
    }

    if (!is_dir($template_root_dir)) {

        chmod($template_upload_dir, 0777);
        mkdir($template_root_dir, 0, true);
        chmod($template_upload_dir, 0755);
    }

    $template_dir = $template_root_dir . "/" . $template_dir_name;
    $template_dir_image = $template_dir . "/images";

    $php_contents = create_php_template($template_dir_name, $template_layout);

    if ($php_contents != false) {

        chmod($template_root_dir, 0777);

        if (mkdir($template_dir, 0, true)) {

            chmod($template_dir, 0777);

            mkdir($template_dir_image, 0, true);

            chmod($template_dir_image, 0777);

            $php_handle = fopen($template_dir . "/template.php", "w");
            fwrite($php_handle, $php_contents);
            fclose($php_handle);

            chmod($template_root_dir, 0755);
            chmod($template_dir, 0755);
            chmod($template_dir_image, 0755);

            return true;
        }
    }

    return false;
}

function update_template_dir($template_dir_name, $template_layout) {

    $template_root_dir = ABSPATH . "wp-content/uploads/fixedly_templates/";
    $template_dir = $template_root_dir . $template_dir_name;
    $template_dir_image = $template_dir . "/images";

    $php_contents = create_php_template($template_dir_name, $template_layout);

    if ($php_contents != false) {

        if (file_exists($template_dir . "/template.php"))
            unlink($template_dir . "/template.php");

        $php_handle = fopen($template_dir . "/template.php", "w");
        fwrite($php_handle, $php_contents);
        fclose($php_handle);

        return true;
    }

    return false;
}

function create_php_template($template_dir_name, $template_layout) {

    global $wpdb;

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_TEMPLATE_DB_TABLE . "
            WHERE title = '" . $template_dir_name . "'");

    $rows_count = sizeof($rows_affected);

    if ($rows_count == 1) {

        if ($template_layout == "one-column")
            include_once(ABSPATH . 'wp-content/plugins/fixedly/layouts/one_column_layout.php');

        if ($template_layout == "two-columns")
            include_once(ABSPATH . 'wp-content/plugins/fixedly/layouts/two_columns_layout.php');

        if ($template_layout == "two-columns-with-bottom-slider")
            include_once(ABSPATH . 'wp-content/plugins/fixedly/layouts/two_columns_with_bottom_slider_layout.php');

        return $php_contents;
    }

    return false;
}

/** below are fuctions to add, edit & manage image fallery **/

function fixedly_add_images_gallery() {

    $success = false;

    if ($_POST["action"] == "update") {

        if (fixedly_add_images($_POST["title"], $_POST["upload_image"], $_POST["description"], $_POST["gid"]))
            $success = "New Image(s) addeded successfully!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/add_new_images.php";

    print_by_line();
}

function fixedly_add_images($title, $link, $description, $gid) {

    global $wpdb;

    $gid_santzd = sanitize_text_field($gid);

    for ($row = 0; $row < sizeof($title); $row++) {

        if (!empty($title[$row]) && !empty($link[$row]) && !empty($description[$row])) {

            $title_santzd = sanitize_text_field($title[$row]);
            $description_santzd = sanitize_text_field($description[$row]);
            $link_santzd = sanitize_text_field($link[$row]);

            $wpdb->insert(FIXEDLY_MEDIA_DB_TABLE,
                array(
                    "title" => $title_santzd,
                    "link" => $link_santzd,
                    "description" => $description_santzd,
                    "type" => 'image',
                    "status" => 'visible',
                    "timestamp" => current_time('mysql'),
                    "gid" => $gid_santzd));
        }
    }

    return true;
}

function select_image_galleries() {

    global $wpdb;

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_GALLERY_DB_TABLE . "
        WHERE status = 'visible'
            AND type = 'image'");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        print '<option value="' . $rows_affected[$row]->id . '">'. $rows_affected[$row]->title . '</option>';;
    }
}

/** below are fuctions to add, edit & manage video gallery **/

function fixedly_add_videos_gallery() {

    $success = false;

    if ($_POST["action"] == "update") {

        if (fixedly_add_videos($_POST["title"], $_POST["link"], $_POST["description"], $_POST["type"], $_POST["gid"]))
            $success = "New Video(s) addeded successfully!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/add_new_videos.php";

    print_by_line();
}

function fixedly_add_videos($title, $link, $description, $type, $gid) {

    global $wpdb;

    $gid_santzd = sanitize_text_field($gid);

    for ($row = 0; $row < sizeof($title); $row++) {

        if (!empty($title[$row]) && !empty($link[$row]) && !empty($description[$row])) {

            $title_santzd = sanitize_text_field($title[$row]);
            $description_santzd = sanitize_text_field($description[$row]);
            $link_santzd = sanitize_text_field($link[$row]);
            $type_santzd = $type[$row];

            // Vimeo
            if ($type_santzd == "vimeo") {

                $hash = @unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $link_santzd . ".php"));
                $screenshot_santzd = $hash[0]["thumbnail_medium"];
                $link_santzd = "http://player.vimeo.com/video/" . $link_santzd;
            }

            // Youtube
            if ($type_santzd == "youtube") {

                $screenshot_santzd = "http://img.youtube.com/vi/" . $link_santzd . "/0.jpg";
                $link_santzd = "http://www.youtube.com/embed/" . $link_santzd;
            }

            // Dailymotion
            if ($type_santzd == "dailymotion") {

                $screenshot_santzd = "http://www.dailymotion.com/thumbnail/video/" . $link_santzd;
                $link_santzd = "http://www.dailymotion.com/embed/video/" . $link_santzd;
            }

            $wpdb->insert(FIXEDLY_MEDIA_DB_TABLE,
                array(
                    "title" => $title_santzd,
                    "link" => $link_santzd,
                    "description" => $description_santzd,
                    "screenshot" => $screenshot_santzd,
                    "type" => $type_santzd,
                    "status" => 'visible',
                    "timestamp" => current_time('mysql'),
                    "gid" => $gid_santzd));
        }
    }

    return true;
}

function select_video_galleries() {

    global $wpdb;

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_GALLERY_DB_TABLE . "
        WHERE status = 'visible'
            AND type = 'video'");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        print '<option value="' . $rows_affected[$row]->id . '">'. $rows_affected[$row]->title . '</option>';;
    }
}

/** below are fuctions to add, edit & manage slideshow **/

function fixedly_add_slides_gallery() {

    $success = false;

    if ($_POST["action"] == "update") {

        if ( fixedly_add_slides($_POST["title"], $_POST["upload_image"], $_POST["slide_link"], $_POST["description"], $_POST["gid"]))
            $success = "New Slideshow Slide addeded successfully!";
    }

    require_once FIXEDLY_PLUGIN_DIR . "includes/add_new_slides.php";

    print_by_line();
}

function fixedly_add_slides($title, $link, $slide_link, $description, $gid) {

    global $wpdb;

    $gid_santzd = sanitize_text_field($gid);

    for ($row = 0; $row < sizeof($title); $row++) {

        if (!empty($title[$row]) && !empty($link[$row]) && !empty($slide_link[$row]) && !empty($description[$row])) {

            $title_santzd = sanitize_text_field($title[$row]);
            $description_santzd = sanitize_text_field($description[$row]);
            $link_santzd = sanitize_text_field($link[$row]);
            $slide_link_santzd = sanitize_text_field($slide_link[$row]);

            $wpdb->insert(FIXEDLY_MEDIA_DB_TABLE,
                array(
                    "title" => $title_santzd,
                    "link" => $link_santzd,
                    "slide_link" => $slide_link_santzd,
                    "description" => $description_santzd,
                    "type" => 'slideshow',
                    "status" => 'visible',
                    "timestamp" => current_time('mysql'),
                    "gid" => $gid_santzd));
        }
    }

    return true;
}

function select_slideshow_galleries() {

    global $wpdb;

    $rows_affected = $wpdb->get_results("SELECT *
        FROM " . FIXEDLY_GALLERY_DB_TABLE . "
        WHERE status = 'visible'
            AND type = 'slideshow'");

    for ($row = 0; $row < sizeof($rows_affected); $row++) {

        print '<option value="' . $rows_affected[$row]->id . '">'. $rows_affected[$row]->title . '</option>';;
    }
}

/** other functions */

function print_by_line() {

    print '<p class="fixedly-by-line"><em>Fixedly Media Gallery ' . FIXEDLY_PLUGIN_VERSION . '</em> is coded by <a href="http://www.thechoppr.com">Krasen Slavov</a>.</p>';
}

?>
