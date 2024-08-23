<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Usuario extends Seeder
{
	public function run()
    {
		$usuario = "admin";
		$password = password_hash("123", PASSWORD_DEFAULT);
		$type = 1;

        $data = [
            'UserName' => $usuario,
            'Password'    => $password,
			'Type' => $type
        ];

        // Using Query Builder
        $this->db->table('user_master')->insert($data);
    }
}
