<?php namespace App\Models;
    use CodeIgniter\Model;
    class CategoryModel extends Model{


    protected $table = 'categoria'; // Nombre de la tabla en la base de datos
    protected $table2 = 'subcategoria';
    protected $primaryKey  = 'id';
    protected $allowedFields =['id','descripcion']; // Campos que se pueden insertar

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
    }