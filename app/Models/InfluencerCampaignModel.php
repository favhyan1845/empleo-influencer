<?php namespace App\Models;
    use CodeIgniter\Model;
    class InfluencerCampaignModel extends Model{

    protected $table = 'campaign_influencer'; // experiencia de usuario
    protected $primaryKey = 'id';
    protected $allowedFields =['id', 'id_user_influencer', 'id_campaign', 'active']; // Campos que se pueden insertar
    public function applyId($data){
        $db = \Config\Database::connect();
        $campaign = $db->table($this->table);
        $campaing = $campaign->insert($data);
        return $campaing->connID->insert_id;
    }
    public function influCamp($data){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->table);
        $campaigns->where('id_user_influencer', $data['session']);
        $campaigns->where('active', '1');
        $campaigns->orderBy('id', 'DESC');
        $arr = [];

        foreach($campaigns->get()->getResultArray() as $influCamp){
            foreach($data['campaigns'] as $camp ){
                if($influCamp['id_campaign'] === $camp['id']){
                    array_push($arr, $camp);
                }
            }
        }
        return $arr;
    }
    public function influCampApplied(){
        $db = \Config\Database::connect();
        $campaigns = $db->table($this->table);
        $campaigns->where('active', '1');
        $campaigns->orderBy('id', 'DESC');
        return 'trabajando en el modelo';
    }
}