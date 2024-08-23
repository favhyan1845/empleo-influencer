<?php namespace App\Models;
    use CodeIgniter\Model;
    class CountryModel extends Model{


    protected $table = 'country'; // Nombre de la tabla en la base de datos
    protected $primaryKey  = 'CountryCode';
    protected $allowedFields =['CountryCode','CountryName','Status','AddedDate','UpdatedDate']; // Campos que se pueden insertar

        public function getAllCountries(){
            $db = \Config\Database::connect();
            $builder = $db->table($this->table);
            return $builder->get()->getResultArray();

        }
    }