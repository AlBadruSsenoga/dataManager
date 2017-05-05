<?php
/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 3:41 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Table_project extends CI_Migration
{
    public function up()
    {
        // Drop table 'project' if it exists
        $this->dbforge->drop_table('project', TRUE);

        // Table structure for table 'project'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'description' => array(
                'type' => "TEXT"
            ),
            'created_at' => array(
                'type' => "DATETIME",
                'null' => FALSE
            ),
            'owner' => array(
                'type' => "INT",
                'constraint' => '11',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('project');
    }

    public function down()
    {
        $this->dbforge->drop_table('project', TRUE);
    }

}