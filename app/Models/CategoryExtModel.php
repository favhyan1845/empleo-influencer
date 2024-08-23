<?php namespace App\Models;
    use CodeIgniter\Model;
    class CategoryExtModel extends Model{


    protected $table = 'cat_camp'; // Nombre de la tabla en la base de datos
    protected $primaryKey  = 'id';
    protected $allowedFields =['id', 'titulo' ,'descripcion']; // Campos que se pueden insertar

        public function getAll(){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table);
            return $builder->get()->getResultArray();
        }
        public function getAllSubcategory($id){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table2);
            $builder->where('id_categoria', $id);
            return $builder->get()->getResultArray();

        }
        public function getByWord($word){
            $db = \Config\Database::connect();
            $campaigns = $db->table($this->table);
            $campaigns->like('titulo', $word, 'both');
            return $campaigns->get()->getResultArray();
        }
    }