<?php namespace App\Models;
    use CodeIgniter\Model;
    class CityModel extends Model{


    protected $table = 'city'; // Nombre de la tabla en la base de datos
    protected $primaryKey  = 'CityId';
    protected $allowedFields =['CityId','CityName','Date','Status']; // Campos que se pueden insertar

    public function getAllCities(){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->get()->getResultArray();

    }
    }