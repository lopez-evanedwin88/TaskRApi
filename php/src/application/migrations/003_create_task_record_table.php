<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Task_Record_Table extends CI_Migration
{
    private $table='task_record';

    public function up()
    {
        $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE,
                        ),
                        'task_id' => array(
                                'type' => 'INT',
                                'unsigned' => TRUE,
                        ),
                        'message' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => TRUE
                        ),
                        'image_url' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => TRUE
                        ),
                ));
        $this->dbforge->add_key('id',true);
        $this->dbforge->create_table($this->table);

        # Seeding user table
        $data = array(
                array(
                        'id' => 1,
                        'task_id' => 1,
                        'message' => 'Nearly done',
                        'image_url' => '78633642_2575512575897642_4055321345087504384_n.jpg',
                ),
                array(
                        'id' => 2,
                        'task_id' => 1,
                        'message' => 'Starting to work in this',
                        'image_url' => '78633642_2575512575897642_4055321345087504384_n.jpg',
                ),
                array(
                        'id' => 3,
                        'task_id' => 1,
                        'message' => 'I have troubled in this',
                        'image_url' => '78633642_2575512575897642_4055321345087504384_n.jpg',
                ),
                array(
                        'id' => 4,
                        'task_id' => 2,
                        'message' => 'Is this okay?',
                        'image_url' => '78633642_2575512575897642_4055321345087504384_n.jpg',
                )
        );
        $this->db->insert_batch($this->table, $data);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table);
    }
}