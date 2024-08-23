<?php namespace App\Models;
    use CodeIgniter\Model;
    class SocialModel extends Model{


    protected $table = 'user_social'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id';
    protected $allowedFields =['id','id_user','facebook','fbER','fbFollow','linkedin','inER', 'inFollow','youtube','ytER', 'ytFollow','tiktok', 'ttER', 'ttFollow', 'instagram', 'insER', 'insFollow', 'twitter', 'xER', 'xFollow']; // Campos que se pueden insertar

    public function getAll(){
        $db = \Config\Database::connect();
        $social = $db->table($this->table);
        return $social->get()->getResultArray();
    }
    public function getIdUser(){
        $db = \Config\Database::connect();
        $social = $db->table($this->table);
        $social->where('id_user', session('Id'));
        return $social->get()->getResultArray();
    }
        public function insertSocialUser($data){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table);
            $social = $builder->insert($data[0]);
            return $social->resultID;

        }

    public function updateSocialUser($data){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id_user', session('Id'));
        $builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            $this->insertSocialUser([$data]);
        }
        return true;
    }
}