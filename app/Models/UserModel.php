<?php namespace App\Models;
    use CodeIgniter\Model;
    class UserModel extends Model{


    protected $table = 'user_master'; // Nombre de la tabla en la base de datos
    protected $primaryKey       = 'UserId';
    protected $allowedFields =['UserId','UserName','Password','Email','FName','LName','ImageName','Biography','Gender','CountryCode','CityName','PostalCode','Address','Ip','JoinDate','UpdatedDate','Birthdate','Type','Status']; // Campos que se pueden insertar
        public function getUser($data){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table);
            $builder->where($data);
            return $builder->get()->getResultArray();
        }
        public function insertUser($data){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table);
            $user = $builder->insert($data[0]);
            return $user->connID->insert_id;

        }


    public function updateUser($data){

        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        // Reemplaza 'usuario' por el nombre de tu tabla
        $builder->where('UserId', session('Id'));
        $builder->update($data[0]);
        if ($this->db->affectedRows() > 0) {
            return "Usuario actualizado correctamente.";
        } else {
            return "No se encontró ningún usuario con el email proporcionado.";
        }
    }
}