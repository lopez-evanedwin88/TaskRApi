<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Task_Table extends CI_Migration
{
    private $table='task';

    public function up()
    {
        $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE,
                        ),
                        'client_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '5',
                            'null' => FALSE,
                        ),
                        'title' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '50',
                            'null' => FALSE,
                        ),
                        'description' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 255,
                            'null' => TRUE,
                        ),
                        'start_date' => array(
                            'type' => 'DATETIME',
                            'null'=> TRUE,
                        ),
                        'due_date' => array(
                            'type' => 'DATETIME',
                            'null'=> TRUE,
                        ),
                        'status' => array(
                                'type' => 'ENUM("Pending", "In-progress", "Done")',
                                'null'=> TRUE,
                        ),
                        'assignee_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '5',
                            'null'=> TRUE,
                        ),
                        'created_date datetime default current_timestamp',
                        'updated_date datetime default current_timestamp on update current_timestamp', 
                ));
        $this->dbforge->add_key('id',true);
        $this->dbforge->create_table($this->table);

        # Seeding task table
        $data = array(
            array(
                    'id' => 1,
                    'client_id' => '005',
                    'start_date' => date("Y-m-d H:i:s"),
                    'due_date' => date("Y-m-d H:i:s"),
                    'title' => 'Development Task',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit., ',
                    'Status' => 'Pending',
                    'assignee_id' => '',
            ),
            array(
                'id' => 2,
                'client_id' => '005',
                'start_date' => date("Y-m-d H:i:s"),
                'due_date' => date("Y-m-d H:i:s"),
                'title' => 'Task 1',
                'description' => '',
                'Status' => 'Pending',
                'assignee_id' => '006',
            ),
            array(
                'id' => 3,
                'client_id' => '005',
                'start_date' => date("Y-m-d H:i:s"),
                'due_date' => date("Y-m-d H:i:s"),
                'title' => 'Task 2',
                'description' => 'quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
                'Status' => 'Pending',
                'assignee_id' => '007',
            ),
            array(
                'id' => 4,
                'client_id' => '005',
                'start_date' => date("Y-m-d H:i:s"),
                'due_date' => date("Y-m-d H:i:s"),
                'title' => 'Task 3',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit., ',
                'Status' => 'Pending',
                'assignee_id' => '',
            ),
        );
        $this->db->insert_batch($this->table, $data);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table);
    }
}