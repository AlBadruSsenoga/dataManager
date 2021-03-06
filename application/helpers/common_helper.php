<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 2/1/2016
 * Time: 9:46 AM
 */


/**
 * Check if user can access Module
 * access_module function
 *
 * @param  int module_id Input int
 * @return boolean TRUE or FALSE
 */

if (!function_exists("perm_module")) {

    function perm_module($controller)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');
        $user_group = $CI->ion_auth_model->get_users_groups($user_id)->row();

        //get perm_module details
        $module = $CI->db->get_where('perms_module', array('controller' => $controller))->row();

        if (count($module) > 0) {
            //get access level
            $check = $CI->db->get_where('perms_group',
                array('group_id' => $user_group->id, 'module_id' => $module->id, 'allow' => 1))->num_rows();

            //check if query exceed 0
            if ($check > 0) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

/**
 *  Check if user has roles
 * has_role function
 *
 * @param  int    module_id    Input int
 * @param  String role_link    Input string
 * @return boolean TRUE or FALSE
 */

if (!function_exists("perms_role")) {

    function perms_role($controller, $perm_slug)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');
        $user_group = $CI->ion_auth_model->get_users_groups($user_id)->row();

        //get perm_module details
        $module = $CI->db->get_where('perms_module', array('controller' => $controller))->row();

        if (count($module) > 0) {
            //get access level
            $check = $CI->db->get_where('perms_group',
                array('group_id' => $user_group->id, 'module_id' => $module->id, 'perm_slug' => $perm_slug, 'allow' => 1))->num_rows();

            if ($check > 0) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

if (!function_exists("display_message")) {
    function display_message($message, $message_type = "success")
    {

        if ($message_type == "success") {
            return '<div class="alert alert-success">' . $message . '</div>';
        }

        if ($message_type == "info") {
            return '<div class="alert alert-info">' . $message . '</div>';
        }

        if ($message_type == "warning") {
            return '<div class="alert alert-warning">' . $message . '</div>';
        }

        if ($message_type == "danger") {
            return '<div class="alert alert-danger">' . $message . '</div>';
        }
    }
}

//display first name and last name
if (!function_exists('display_full_name')) {
    function display_full_name()
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');
        $User = $CI->User_model->find_by_id($user_id);
        echo ucfirst($User->first_name) . ' ' . ucfirst($User->last_name);
    }
}

//time ago
if (!function_exists('time_ago')) {
    function time_ago($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}


if (!function_exists('array_utf8_encode')) {
    /**
     * Encode array to utf8 recursively
     * @param $dat
     * @return array|string
     */
    function array_utf8_encode($dat)
    {
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = array_utf8_encode($d);
        return $ret;
    }
}

if (!function_exists("get_flashdata")) {
    function get_flashdata()
    {
        $CI = &get_instance();
        return (($CI->session->flashdata("message") != "")) ? $CI->session->flashdata("message") : "";
    }
}

if (!function_exists("set_flashdata")) {
    function set_flashdata($flash_message)
    {
        $CI = &get_instance();
        $CI->session->set_flashdata("message", $flash_message);
    }
}

if (!function_exists("get_current_user_id")) {
    function get_current_user_id()
    {
        $CI = &get_instance();
        return $CI->session->userdata("user_id");
    }
}