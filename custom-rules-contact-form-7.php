<?php
/*
Plugin Name:       Custom Rules for Contact Form 7
Plugin URI:        http://guaven.com
Description:       Prevent wrong and misplaced messages and refer senders to the right place. Create smart custom rules for Contact Form 7 which decreases amount of wrong requests and helps senders immeditially get the needed info if it is possible.
Version:           1.0.0
Author:            Guaven Labs
Author URI:        http://guaven.com
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function crcf7_first_custom_rule()
{
    if (is_single() or is_page()) {
        global $post;
        if (has_shortcode($post->post_content, 'contact-form-7')) {
            $cf7_id = shortcode_parse_atts($post->post_content);
            $rules  = get_posts("post_type=crcf7_p&post_status=private&posts_per_page=100");
            foreach ($rules as $key => $crcf7_relateds_post) {
                $crcf7_relateds_meta = get_metadata('post', $crcf7_relateds_post->ID);
                if ($crcf7_relateds_meta['crcf7_relateds'][0] == $cf7_id["id"] or $crcf7_relateds_meta['crcf7_relateds'][0] == '*') {
                    break;
                }
            }
            require_once plugin_dir_path(__FILE__) . 'front-view.php';
        }
    }
}
add_action('wp_footer', 'crcf7_first_custom_rule');


add_action('admin_menu', 'crcf7_admin_menu');
function crcf7_admin_menu()
{
    add_submenu_page('wpcf7', 'Custom Warning Rules', 'Custom Warning Rules', 'manage_options', __FILE__, 'crcf7_admin_settings');
}


function crcf7_admin_settings()
{
    if (isset($_GET["remove_rule"]) and wp_verify_nonce($_GET['_wpnonce'], 'trash-rule-' . $_GET["remove_rule"])) {
        $dpid = (int) $_GET["remove_rule"];
        wp_delete_post($dpid, true);
    }
    
    if (isset($_GET["addnew"])) {
        $gpid = (int) $_GET["addnew"];
    } else
        $gpid = '';
    
    if (!empty($_POST)) {
        if (isset($_POST["crcf7_title"]) and isset($_POST["crcf7_itself"]) and isset($_POST["crcf7_message"]) and isset($_POST['_wpnonce']) and wp_verify_nonce($_POST['_wpnonce'], 'add_rule_cf')) {
            $args = array(
                'crcf7_title' => sanitize_text_field($_POST["crcf7_title"]),
                'crcf7_message' => wp_kses_data($_POST["crcf7_message"]),
                'crcf7_type' => isset($_POST["crcf7_type"]) ? 1 : '',
                'crcf7_buttontext' => sanitize_text_field($_POST["crcf7_buttontext"]),
                'crcf7_relateds' => sanitize_text_field($_POST["crcf7_relateds"]),
                'crcf7_itself' => sanitize_text_field($_POST["crcf7_itself"])
            );
            
            if (!empty($_POST["pid"]) and $_POST["pid"] > 0)
                $args['id'] = (int)$_POST["pid"];
            crcf7_insert($args);
            
        } else
            'Error: Missing fields';
    }
    
    $rules = get_posts("post_type=crcf7_p&post_status=private&posts_per_page=100");
    require_once plugin_dir_path(__FILE__) . 'admin-view.php';
}

function crcf7_hiddenpost()
{
    $args = array(
        'public' => false,
        'label' => 'Contact Form 7 Rules'
    );
    register_post_type('crcf7_p', $args);
    if (get_option('crcf7_first_install_c') == '') {
        update_option('crcf7_first_install_c', 1);
        $args = array(
            'crcf7_title' => 'Sample rule: Technical questions',
            'crcf7_message' => 'This form is for the questions about billing. It seems you have technical question. Please write technical questions to <a href="#">tecnical support team.</a>',
            'crcf7_type' => 1,
            'crcf7_buttontext' => 'No, i will write here',
            'crcf7_relateds' => '*',
            'crcf7_itself' => 'server,computer,restart'
        );
        crcf7_insert($args);
    }
}
add_action('init', 'crcf7_hiddenpost');


function crcf7_insert($args)
{
    $pid      = !empty($args['id']) ? $args['id'] : 0;
    $ins_args = array(
        'post_type' => 'crcf7_p',
        'post_title' => $args['crcf7_title'],
        'post_content' => $args['crcf7_message'],
        'post_status' => 'private',
        'ID' => $pid
    );
    if (!empty($args['id']))
        $ins_args['ID'] = $args['id'];
    
    $nid = wp_insert_post($ins_args);
    update_post_meta($nid, 'crcf7_type', $args['crcf7_type']);
    update_post_meta($nid, 'crcf7_buttontext', $args['crcf7_buttontext']);
    update_post_meta($nid, 'crcf7_itself', $args['crcf7_itself']);
    update_post_meta($nid, 'crcf7_relateds', $args['crcf7_relateds']);
}


function crcf7_value($str, $id)
{
    if ($id == 0)
        return;
    $pid = get_post($id);
    if ($str == 'crcf7_title')
        return $pid->post_title;
    elseif ($str == 'crcf7_message')
        return $pid->post_content;
    return esc_attr(get_post_meta($id, $str, true));
}