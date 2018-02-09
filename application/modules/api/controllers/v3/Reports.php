<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 08/02/2018
 * Time: 09:06
 */

class Reports extends REST_Controller
{
    private $table_name;
    private $instance_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model', 'User_model', 'Xform_model', 'Feedback_model'));
    }

    //forms
    function forms_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required parameter are missing'), 202);
        }

        //get user details from database
        $user = $this->User_model->find_by_username($this->get('username'));

        //show status header if user not available in database
        if (count($user) == 0) {
            $this->response(array('status' => 'failed', 'message' => 'User not exist'), 202);
        }

        $user_groups = $this->User_model->get_user_groups_by_id($user->id);
        $user_perms = array(0 => "P" . $user->id . "P");
        $i = 1;
        foreach ($user_groups as $ug) {
            $user_perms[$i] = "G" . $ug->id . "G";
            $i++;
        }

        $forms = $this->Xform_model->get_form_list_by_perms($user_perms);

        if ($forms) {
            $form = array();

            foreach ($forms as $v) {
                //form data
                $this->model->set_table($v->form_id);
                $form_data = $this->model->get_all();

                foreach ($form_data as $value) {
                    $this->model->set_table('feedback');
                    $feedback = $this->model->count_by(array('form_id' => $v->form_id));

                    $label = '';
                    if (array_key_exists('meta_instanceName', $value))
                        $label = $value->meta_instanceName;
                    else
                        $label = $v->title;

                    $form[] = array(
                        'id' => $v->id,
                        'form_id' => $v->form_id,
                        'instance_id' => $value->meta_instanceID,
                        'instance_name' => $label,
                        'title' => $v->title,
                        'created_at' => $v->date_created,
                        'jr_form_id' => $v->jr_form_id,
                        'feedback' => $feedback
                    );
                }
            }
            $this->response(array("status" => "success", "forms" => $form), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'No campaign found'), 202);
        }
    }


    //form details
    function form_details_get()
    {
        if (!$this->get('table_name') || !$this->get('instance_id')) {
            $this->response(array('status' => 'failed', 'message' => 'Invalid table name or instance Id'), 202);
        }

        //get variables
        $this->table_name = $this->get('table_name');
        $this->instance_id = $this->get('instance_id');

        // get definition file name
        $this->model->set_table('xforms');
        $form_details = $this->model->get_by('form_id', $this->table_name);

        //set file defn
        $this->Xformreader_model->set_defn_file($this->config->item("form_definition_upload_dir") . $form_details->filename);
        $this->Xformreader_model->load_xml_definition();
        $form_definition = $this->Xformreader_model->get_defn();

        //get form data
        $form_data = $this->get_form_data($form_definition, $this->get_field_name_map($this->table_name));

        if ($form_data)
            $this->response(array("status" => "success", "form_details" => $form_data), 200);
        else
            $this->response(array("status" => "failed", "message" => "No details found"), 202);
    }


    //get form data
    function get_form_data($structure, $map)
    {
        //get feedback form details
        $this->model->set_table($this->table_name);
        $data = $this->model->get_by('meta_instanceID', $this->instance_id);

        if (!$data) return false;
        $holder = array();
        //print_r($map);
        //print_r($structure);

        $ext_dirs = array(
            'jpg' => "images",
            'jpeg' => "images",
            'png' => "images",
            '3gpp' => 'audio',
            'amr' => 'audio',
            '3gp' => 'video',
            'mp4' => 'video');

        $c = 1;
        $id = $data->id;

        foreach ($structure as $val) {
            $tmp = array();
            $field_name = $val['field_name'];
            $type = $val['type'];

            //TODO : change way to get label
            if (array_key_exists($field_name, $map)) {
                if (!empty($map[$field_name]['field_label'])) {
                    $label = $map[$field_name]['field_label'];
                } else {
                    if (!array_key_exists('label', $val))
                        $label = $field_name;
                    else
                        $label = $val['label'];
                }
            }

            if (array_key_exists($field_name, $map)) {
                $field_name = $map[$field_name]['col_name'];
            }
            $l = $data->$field_name;


            if ($type == 'select1') {
                //print_r($val);
                //$l = $val['option'][$l];
            }

            if ($type == 'binary') {
                // check file extension
                $value = explode('.', $l);
                $file_extension = end($value);
                if (array_key_exists($file_extension, $ext_dirs)) {
                    $l = site_url('assets/forms/data') . '/' . $ext_dirs[$file_extension] . '/' . $l;
                }
            }

            if ($type == 'select') {
                $tmp1 = explode(" ", $l);
                $arr = array();
                foreach ($tmp1 as $item) {
                    $item = trim($item);
                    array_push($arr, $val['option'][$item]);
                }
                $l = implode(",", $arr);
            }

            if (substr($label, 0, 5) == 'meta_') continue;
            $tmp['id'] = $id . $c++;
            $tmp['label'] = str_replace('_', ' ', $label);
            $tmp['type'] = $type;
            $tmp['value'] = $l;
            array_push($holder, $tmp);
        }
        return $holder;
    }

    //get field name map
    function get_field_name_map($table_name)
    {
        $tmp = $this->Xform_model->get_fieldname_map($table_name, '0');
        $map = array();
        foreach ($tmp as $part) {
            $key = $part['field_name'];
            $map[$key] = $part;
        }
        return $map;
    }
}