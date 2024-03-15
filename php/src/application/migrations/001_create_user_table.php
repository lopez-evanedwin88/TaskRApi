<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_User_Table extends CI_Migration
{
    private $table='user';

    public function up()
    {
        $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE,
                        ),
                        'first_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'last_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'unique' => true,
                        ),
                        'staff_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '5',
                        ),
                        'password' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'gender' => array(
                                'type' => 'ENUM("Male", "Female")',
                                'null' => TRUE,
                        ),
                        'roles' => array(
                                'type' => 'ENUM("Admin", "Staff", "Client")',
                                'null' => TRUE
                        ),
                ));
        $this->dbforge->add_key('id',true);
        $this->dbforge->create_table($this->table);

        # Seeding user table
        $data = array(
                array(
                        'id' => 1,
                        'staff_id' => '001',
                        'first_name' => 'Salvidor',
                        'last_name' => 'Zorzenoni',
                        'password' => 'test123',
                        'email' => 'szorzenoni0@etsy.com',
                        'gender' => 'Male',
                        'roles' => 'Admin',
                ),
                array(
                        'id' => 2,
                        'staff_id' => '002',
                        'first_name' => 'Verna',
                        'last_name' => 'Marciek',
                        'password' => 'test123',
                        'email' => 'vmarciek1@independent.co.uk',
                        'gender' => 'Female',
                        'roles' => 'Admin',
                ),
                array(
                        'id' => 3,
                        'staff_id' => '003',
                        'first_name' => 'Belinda',
                        'last_name' => 'Ablott',
                        'password' => 'test123',
                        'email' => 'bablott2@nifty.com',
                        'gender' => 'Female',
                        'roles' => 'Client',
                ),
                array(
                        'id' => 4,
                        'staff_id' => '004',
                        'first_name' => 'Rudd',
                        'last_name' => 'Powlett',
                        'password' => 'test123',
                        'email' => 'rpowlett3@abc.net.au',
                        'gender' => 'Male',
                        'roles' => 'Client',
                ),
                array(
                        'id' => 5,
                        'staff_id' => '005',
                        'first_name' => 'Gwenneth',
                        'last_name' => 'Rainbird',
                        'password' => 'test123',
                        'email' => 'grainbird4@google.com.br',
                        'gender' => 'Female',
                        'roles' => 'Client',
                ),
                array(
                        'id' => 6,
                        'staff_id' => '006',
                        'first_name' => 'Clarine',
                        'last_name' => 'Whistance',
                        'password' => 'test123',
                        'email' => 'cwhistance5@blog.com',
                        'gender' => 'Female',
                        'roles' => 'Staff',
                ),
                array(
                        'id' => 7,
                        'staff_id' => '007',
                        'first_name' => 'Hakim',
                        'last_name' => 'Rogans',
                        'password' => 'test123',
                        'email' => 'hrogans6@illinois.edu',
                        'gender' => 'Male',
                        'roles' => 'Staff',
                ),
                array(
                        'id' => 8,
                        'staff_id' => '008',
                        'first_name' => 'Colman',
                        'last_name' => 'Longstreet',
                        'password' => 'test123',
                        'email' => 'clongstreet7@slideshare.com',
                        'gender' => 'Male',
                        'roles' => 'Staff',
                ),
                array(
                        'id' => 9,
                        'staff_id' => '009',
                        'first_name' => 'Padraig',
                        'last_name' => 'Utting',
                        'password' => 'test123',
                        'email' => 'putting8@phoca.cz',
                        'gender' => 'Male',
                        'roles' => 'Staff',
                ),
                array(
                        'id' => 10,
                        'staff_id' => '010',
                        'first_name' => 'Arny',
                        'last_name' => 'Huggon',
                        'password' => 'test123',
                        'email' => 'ahuggon9@samsung.com',
                        'gender' => 'Male',
                        'roles' => 'Staff',
                )
        );
        $this->db->insert_batch($this->table, $data);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table);
    }
}