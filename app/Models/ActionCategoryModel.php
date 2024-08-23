<?php namespace App\Models;
    use CodeIgniter\Model;
    class ActionCategoryModel extends Model{


    protected $table = 'action_cat'; // Nombre de la tabla en la base de datos
    protected $tableInfluencer = 'user_action_cat'; //tabla de categoria para experiencia de usuarios registrados
    protected $tableCampaign = 'camp_action_cat'; //tabla de categoria para campañas
    protected $primaryKey = 'id';
    protected $allowedFields =['id','id_type','cat_json','sub_json','catExt_json']; // Campos que se pueden insertar


    public function getId($data){
        $user = $this->db->table($this->table);
        $user->where($data);
        return $user->get()->getResultArray();
    }
    public function getIdCat($data){
        $user = $this->db->table($this->table);
        $user->where($data);
        return $user->get()->getResultArray();
    }
    public function getIdCatInfluencer($data, $type){
        $user = $this->db->table($this->tableInfluencer);
        $user->where('id_type', $data['id_type']);
        return $user->get()->getResultArray();
    }

    public function insertCat($data, $type){

        $db = \Config\Database::connect();

        $builder = $this->typeTable($type);

        $user = $builder->insert($data[0]);
        return $user->connID->insert_id;
    }
    protected function stringToInt($string) {
        if(intval($string) == 0){
            return session('Id');
        }else{
            return intval($string);
        }
    }

    public function updateCat($cat, $type){

        if( $type == 2){
            $dataCat =[
                'id_type'  => json_encode($cat[0]['id_type']),
                'cat_json' => json_encode($cat[0]['cat_json']),
                'sub_json' => json_encode($cat[0]['sub_json']),
                'catExt_json' => json_encode($cat[0]['catExt_json'])
            ];
        }else if( $type == 3){
            $catType = trim($cat[0]['id_type'],'"');
            $dataCat =[
                'id_type'  => $catType,
                'cat_json' => json_encode($cat[0]['cat_json']),
                'sub_json' => json_encode($cat[0]['sub_json'])
            ];
        }else{
            $dataCat =[
                'id_type' => session('Id'),
                'cat_json' => json_encode($cat[0]['cat_json']),
                'sub_json' => json_encode($cat[0]['sub_json'])
            ];
        }
        $db = \Config\Database::connect();

        $builder = $this->typeTable($type);

        // Reemplaza 'usuario' por el nombre de tu tabla
        $builder->where('id_type', $dataCat['id_type']);
        $builder->update($dataCat);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            $this->insertCat([$dataCat], $type);
            return true;
        }
    }
    public function getById($id){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->tableCampaign);
        $campaigns->like('catExt_json', $id[0]['id'], 'both');
        return $campaigns->get()->getResultArray();
    }
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// obtener el id de la categoria por campaña
	public function categorySetMoCampaing($data){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->tableInfluencer);
        $campaigns->like('id_type', $data['id'], 'both');
        return $campaigns->get()->getResultArray();
	}

    public function deleteCampaignExp($data, $type){
        $builder = $this->typeTable($type);
        $builder->where('id_type', $data);
        $builder->delete();
        return true;
    }
    public function typeTable($type){
        $db = \Config\Database::connect();
        if($type == 1 || $type == 3){
            return $db->table($this->tableInfluencer);
        }else if($type == 2){
            return $db->table($this->tableCampaign);
        }else{
            return $db->table($this->table);
        }
    }

}