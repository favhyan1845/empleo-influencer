<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMaster extends Migration
{
	public function up()
    {
        $this->forge->addField([
            'UserId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'UserName' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
				'null' => true,
            ],
            'Password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
				'null' => false,
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
				'null' => true,
            ],
            'FName' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
				'null' => true,
            ],
            'LName' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
				'null' => true,
            ],
            'ImageName' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
				'null' => true,
            ],
            'Biography' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Gender' => [
				'type' => 'ENUM("m","f")',
				'default' => 'm',
				'null' => false,
				'comment' => 'm=male, f=female'
            ],
            'CountryCode' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
				'null' => true,
            ],
            'CityName' => [
                'type' => 'INT',
                'constraint' => '11',
				'null' => true,
            ],
            'PostalCode' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
				'null' => true,
            ],
            'Address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
				'null' => true,
            ],
            'Ip' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
				'null' => true,
            ],
            'JoinDate' => [
				'type' => 'varchar',
				'constraint' => 250,
				'null' => false,
				'on update' => 'NOW()'
            ],
            'UpdatedDate' => [
				'type' => 'varchar',
				'constraint' => 250,
				'null' => true,
            ],
            'Type' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'comment' => '1=>admin, 2=>moderador, 3=>empresa, 4=>influencer'
            ],
            'Status' => [
				'type' => 'INT',
				'default' => 1,
				'null' => true,
				'comment' => '0=>inactive, 1=>active, 2=>block, 3=>delete, 11=>inactive by admin'
            ],
        ]);
        $this->forge->addKey('UserId', true);
		$this->forge->createTable('user_master');
    }

    public function down()
    {
        $this->forge->dropTable('user_master');
    }
}
