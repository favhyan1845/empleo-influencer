<?php namespace App\Models;
    use CodeIgniter\Model;
    class CampaignModel extends Model{


    protected $table = 'campaigns'; // Nombre de la tabla en la base de datos
    protected $tableInfluencer = 'user_exp'; // experiencia de usuario
    protected $primaryKey = 'id';
    protected $allowedFields =['id','id_company','name_camp','Description','date_create','date_finish','active']; // Campos que se pueden insertar

    public function getAll(){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->table);
        $campaigns->orderBy('id', 'DESC');
        $campaigns->where('active', '1');
        return $campaigns->get()->getResultArray();
    }
    public function getId($id){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->table);
        $campaigns->where('id', $id);
        return $campaigns->get()->getResultArray();
    }
    public function getByWord($word){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->table);
        $campaigns->like('name_camp', $word, 'both');
        return $campaigns->get()->getResultArray();
    }
    public function getIdExperience($id, $type){
            $builder = $this->typeTable($type);
            $builder->where('id_influencer', $id);
            $builder->orderBy('date_create', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function getIdExperienceCampaign($id, $type){
            $builder = $this->typeTable($type);
            $builder->where('id_company', $id);
            $builder->orderBy('date_create', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function getByIdExperience($id, $id_exp, $type){
            $builder = $this->typeTable($type);
            $builder->where('id', $id_exp);
            $builder->where('id_influencer', $id);
        return $builder->get()->getResultArray();
    }
    public function insertCampaign($data, $type){
            $builder = $this->typeTable($type);
            $campain = $builder->insert($data[0]);
            return $campain->connID->insert_id;

        }

        public function updateCampain($data, $type){
            $builder = $this->typeTable($type);
            // Reemplaza 'usuario' por el nombre de tu tabla
            $builder->where('Id', session('Id'));
            $builder->update($data[0]);

            if ($this->db->affectedRows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        public function updateCampainExp($data, $type){
            $builder = $this->typeTable($type);
            // Reemplaza 'usuario' por el nombre de tu tabla
            $builder->where('id', $data[0]['id']);
            $builder->where('id_influencer', session('Id'));
            $builder->update($data[0]);

            if ($this->db->affectedRows() > 0) {
                return $data[0]['id'];
            } else {
                return false;
            }
        }
    public function deleteCampaign($data, $type){
        $builder = $this->typeTable($type);
        $builder->where('id', $data);
        $builder->delete();
        return true;
    }
    public function typeTable($type){
        $db = \Config\Database::connect();
        if($type == 1){
            return $db->table($this->tableInfluencer);
        }else{
            return $db->table($this->table);
        }
    }
}