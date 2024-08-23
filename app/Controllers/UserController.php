<?php
namespace App\Controllers;
use App\Models\ActionCategoryModel;
use App\Models\UserModel;
use App\Models\CampaignModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\SocialModel;
class UserController extends BaseController
{
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// registrar Marca
	public function company_register()
	{
		$datos['categorias'] = $this->categoryMo();
        $datos['type'] = 2;
        $datos['setCat'] = 0;
		return 	view('layouts/header').

				view('layouts/nav').
				view('registrar', $datos).
				view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// registrar influencer
	public function influencer_register()
	{
		$datos['categorias'] = $this->categoryMo();
        $datos['type'] = 3;
        $datos['setCat'] = 0;
		return 	view('layouts/header').

				view('layouts/nav').
				view('registrar', $datos).
				view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// registro influencer o marca
	public function registration()
	{

		$ip = $this->request->getIPAddress();
		$email = $this->request->getPost('email');
		$password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
		$FName = $this->request->getPost('FName');
		$LName = $this->request->getPost('LName');
		$gender = $this->request->getPost('gender');
		$birthday = $this->request->getPost('birthday');
		$type = $this->request->getPost('type');
		$setCatModelo = new ActionCategoryModel();
		$cat = array();
		$subCat = array();

		if($gender == '' || $gender == 'Otro'|| $gender == 'No definido'){
			$gender = 'o';
		}else if($gender == 'Masculino'){
			$gender = 'm';
		}else if($gender == 'Femenino'){
			$gender = 'f';
		}

		$data = [
			"UserName" => NULL,
			"Ip" => $ip,
			"Email" => $email,
			"Password" => $password,
			"FName" => $FName,
			"LName" => $LName,
			"Gender" => $gender,
			"Type" => $type,
			"Status" => 0,
			'Birthday' => $birthday,
			"JoinDate" => date("Y-m-d H:i:s")

		];

		$usuarioModelo = new UserModel();
		$datosUsuario = $usuarioModelo->getUser(['Email' => $email]);

		if(count($datosUsuario) > 0){
            $msg = 'No se pudo registrar ya que el usuario con ese email ya existe, intenta de nuevo.';
            $alertClass = 'alert-danger';
			return redirect()->to(base_url('/'))->with('msg',$msg)->with('alertClass',$alertClass);
		}

		$idInsert = $usuarioModelo->insertUser([$data]);

		if(!empty($_POST['inlineCheckbox'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckbox'] as $selected){
				array_push($cat, $selected);
			}
		}
		if(!empty($_POST['inlineCheckboxSub'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxSub'] as $selectedSub){
				array_push($subCat, $selectedSub);
			}
		}

		$dataCat =[
			'cat_json' => $cat,
			'sub_json' => $subCat,
			'id_type'  => $idInsert
		];
		// recorda validacion
		// $setCatModelo->insertCat([$dataCat], 0);

            $msg = 'Usuario registrado exitosamente.';
            $alertClass = 'alert-success';
			$this->send_Email($data);
			return redirect()->to(base_url('/'))->with('msg',$msg)->with('alertClass',$alertClass);
	}

	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// enviar email
	protected function send_Email($data){

		$email = \Config\Services::email();

		$email->setFrom('no-replay@xharla.com', 'Xharla influencer');
		$email->setTo($data['Email']);

		$email->setSubject('Activar cuenta');
		$email->setMessage('este es el email de activacion de la cuenta, ingresa al siguiente link <a href="http://localhost/xharla/empleo-influencers/activar">Activar</a>');

		if(!$email->send()){
			echo "no se ha podido enviar el correo";
		}
		if(!$email->send()){
			echo "no se ha podido enviar el correo";
		}
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// creacion de vista de la experiencia en el perfil del usuario
	public function create_view_exp_profile(){

		$this->validateAuth();
		$datosCategoria = $this->categoryMo();
		$experiences = false;
		$btn = $this->btn_generator('Guardar');

		return 	view('layouts/header').

				view('layouts/nav').
				view('exp/lista-exp-user',['type' => 0,'form' => base_url('/insert_exp_user'),'categorias' => $datosCategoria, 'setCat' => false,'experiences' => $experiences, 'btn' => $btn]).
				view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// editar vista la experiencia en el perfil del usuario
	public function edit_view_exp_profile($id_exp){

		$this->validateAuth();
		$datosCategoria = $this->categoryMo();
		$experience = new CampaignModel();

		$experiences = $experience->getByIdExperience(session('Id'), $id_exp, 1);
		$dataSetCat = new ActionCategoryModel();
		$btn = $this->btn_generator("Guardar");
		$arr = [];

		foreach($experiences as $exp){
			$datasSetCategory = $dataSetCat->categorySetMoCampaing($exp);
			if(!empty($datasSetCategory)){
				array_push($arr,json_decode($datasSetCategory[0]['cat_json'],true));
			}
		}

		$dataSet = array_unique(array_merge(...$arr));

		return 	view('layouts/header').
				view('layouts/nav').
				view('exp/lista-exp-user',['type' => 1,'form' => base_url('/edit_exp_user'),'categorias' => $datosCategoria, 'setCat' => $dataSet,'experiences' => $experiences, 'btn' => $btn]).
				view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// vista del perfil del usuario
	public function profileUser(){

		$this->validateAuth();
		$usuarioModelo = new userModel();
		$datosUsuario = $usuarioModelo->getUser(['UserId' => session('Id')]);
		$datosUsuario[0]['edad'] = empty($datosUsuario[0]['Birthday']) ? calcularEdad("1960-01-01") : calcularEdad($datosUsuario[0]['Birthday']);
		$paisModelo = new countryModel();
		$datosPais = $paisModelo->getAllCountries();
		$ciudadModelo = new cityModel();
		$datosciudad = $ciudadModelo->getAllCities();
		$datosCategoria = $this->categoryMo();
		$datosSetCat = $this->categorySetMo();
		$datosSocial = new SocialModel();
		$dataSocial = $datosSocial->getIdUser();
		$experience = new CampaignModel();

		if(session('type') == 2){
			$title_exp = "Mis campañas activas";
			$experiences = $experience->getIdExperienceCampaign(session('Id'), 2);
		}else{
			$title_exp = "Algunas campañas que he realizado";
			$experiences = $experience->getIdExperience(session('Id'), 1);
		}


		if(empty($dataSocial)){

            $msg = 'No has registrado ninguna red social.';
            $alertClass = 'alert-danger';
			$btn = $this->btn_generator('Actualizar');
			$btn_add = $this->btn_generator_a("Añadir experiencia", base_url('/crear-experiencia'));
			$dataSocial = false;
			if(!$experiences){
				$experiences = false;
			}

			if(!$datosUsuario[0]['UserName']){
				$datosUsuario[0]['UserName'] = false;
			}
			if(!$datosSetCat){
				$datosSetCategoria = false;
			}else{
				$datosSetCategoria = json_decode($datosSetCat[0]['cat_json'],true);
			}


			return 	view('layouts/header').
				view('layouts/nav').
					view('user/editar-perfil', ['usuario' => $datosUsuario, 'countries' => $datosPais, 'cities' => $datosciudad, 'social' => $dataSocial, 'categorias' => $datosCategoria, 'setCat' => $datosSetCategoria, 'experiences' => $experiences, 'msg' => $msg, 'alertClass' => $alertClass, 'btn' => $btn, 'btn_add' => $btn_add, 'titleExp' => $title_exp]).
					view('layouts/footer');
		}

	$sumaFollow =[
			$dataSocial[0]['fbFollow'],
			$dataSocial[0]['inFollow'],
			$dataSocial[0]['ytFollow'],
			$dataSocial[0]['ttFollow'],
			$dataSocial[0]['insFollow'],
			$dataSocial[0]['xFollow'],
	];

	$sumaEr =[
			$dataSocial[0]['fbER'],
			$dataSocial[0]['inER'],
			$dataSocial[0]['ytER'],
			$dataSocial[0]['ttER'],
			$dataSocial[0]['insER'],
			$dataSocial[0]['xER'],
	];

	$sumaFollow = array_sum($sumaFollow);
	$sumaER = array_sum($sumaEr);

	if($datosSetCat){
		$dataSet = json_decode($datosSetCat[0]['cat_json'],true);
	}else{
		$dataSet = false;
	}
	return 	view('layouts/header').
			view('layouts/nav').
			view('user/perfil', ['usuario' => $datosUsuario, 'social' => $dataSocial, 'countries' => $datosPais, 'cities' => $datosciudad, 'categorias' => $datosCategoria, 'setCat' => $dataSet, 'experiences' => $experiences, 'totalFollow' => $sumaFollow, 'totalER' => $sumaER, 'titleExp' => $title_exp]).
			view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// vista del editar perfil del usuario
	public function edit_profile()
	{
		$this->validateAuth();
		$usuarioModelo = new userModel();
		$datosUsuario = $usuarioModelo->getUser(['UserId' => session('Id')]);
		$paisModelo = new countryModel();
		$datosPais = $paisModelo->getAllCountries();
		$ciudadModelo = new cityModel();
		$datosciudad = $ciudadModelo->getAllCities();
		$datosCategoria = $this->categoryMo();
		$datosSetCat = $this->categorySetMo();
		$datosSocial = new SocialModel();
		$dataSocial = $datosSocial->getIdUser();
		$experience = new CampaignModel();
		$experiences = $experience->getIdExperience(session('Id'), 1);
		$btn = $this->btn_generator('Actualizar');
		$btn_add = $this->btn_generator_a("Añadir experiencia", base_url('/crear-experiencia'));

		if(isset($datosSetCat) && count($datosSetCat) > 0){
			$setCat = json_decode($datosSetCat[0]['cat_json'], true);
		}else{
			$setCat = false;
		}

		if(empty($experiences)){
			$experiences = false;
		}

		if(empty($datosSetCat)){
			$datosSetCat = false;
		}
		
		$msg = '';
		$alertClass = 'alert-default';
			return 	view('layouts/header').
					view('layouts/nav').
					view('user/editar-perfil', ['usuario' => $datosUsuario, 'social' => $dataSocial, 'countries' => $datosPais, 'cities' => $datosciudad, 'categorias' => $datosCategoria, 'setCat' => $setCat, 'experiences' => $experiences, 'msg' => $msg, 'alertClass' => $alertClass, 'btn' => $btn, 'btn_add' => $btn_add]).
					view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// Actualizar el perfil del usuario
	public function updateUser(){
		$this->validateAuth();
		$usuarioModelo = new UserModel();
		$catModelo = new ActionCategoryModel();
		$datosSocial = new SocialModel();
		$username = $this->request->getPost('username');
		$fname = $this->request->getPost('fname');
		$lname = $this->request->getPost('lname');
		$email = $this->request->getPost('email');
		$birthday = $this->request->getPost('birthday');

		$cat = array();
		$subCat = array();


		if ($this->request->getFile('imagename')->isValid()) {
            // Obtener la imagen del campo file
            $imagen = $this->request->getFile('imagename');

            // Mover la imagen a tu directorio de almacenamiento
            $imagen->move(ROOTPATH . 'public/uploads/img/logo/user-' .session('Id'), $imagen->getName());

            // Obtener la ruta de la imagen guardada
            $rutaImagen = 'uploads/img/logo/user-' .session('Id').'/'. $imagen->getName();
        } else {
			$datosUsuario = $usuarioModelo->getUser(['UserId' => session('Id')]);

			if( !empty($datosUsuario[0]['ImageName']) ){
				$rutaImagen = $datosUsuario[0]['ImageName'];
			}else{
				$rutaImagen = false;
			}
        }

		$gender = $this->request->getPost('gender');
		$countryName = $this->request->getPost('countryName');
		$cityName = $this->request->getPost('cityName');
		$address = $this->request->getPost('address');
		$postalCode = $this->request->getPost('postalCode');
		$bio = $this->request->getPost('bio');

		$data =[
			'username' => $username,
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'ImageName' => $rutaImagen,
			'gender' => $gender,
			'countryName' => $countryName,
			'cityName' => $cityName,
			'address' => $address,
			'postalCode' => $postalCode,
			'Biography' => $bio,
			'Birthday' => $birthday,
			'UpdatedDate' => date("Y-m-d H:i:s")
		];
		$usuarioModelo->updateUser([$data]);

		if(!empty($_POST['inlineCheckbox'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckbox'] as $selected){
				array_push($cat, $selected);
			}
		}
		if(!empty($_POST['inlineCheckboxSub'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxSub'] as $selectedSub){
				array_push($subCat, $selectedSub);
			}
		}
		$dataCat =[
			'cat_json' => $cat,
			'sub_json' => $subCat
		];

		$catModelo->updateCat([$dataCat], 0);

		$facebook = $this->request->getPost('facebook');
		$linkedin = $this->request->getPost('linkedin');
		$youtube = $this->request->getPost('youtube');
		$tiktok = $this->request->getPost('tiktok');
		$instagram = $this->request->getPost('instagram');
		$twitter = $this->request->getPost('twitter');
		$fbER = $this->request->getPost('fbER');
		$inER = $this->request->getPost('inER');
		$ytER = $this->request->getPost('ytER');
		$ttER = $this->request->getPost('ttER');
		$insER = $this->request->getPost('insER');
		$xER = $this->request->getPost('xER');
		$fbFollow = $this->request->getPost('fbFollow');
		$inFollow = $this->request->getPost('inFollow');
		$ytFollow = $this->request->getPost('ytFollow');
		$ttFollow = $this->request->getPost('ttFollow');
		$insFollow = $this->request->getPost('insFollow');
		$xFollow = $this->request->getPost('xFollow');

		$dataSocial =[
			'id_user' 	=> session('Id'),
			'facebook' 	=> $facebook,
			'linkedin'	=> $linkedin,
			'youtube' 	=> $youtube,
			'tiktok' 	=> $tiktok,
			'instagram' => $instagram,
			'twitter' 	=> $twitter,
			'fbER' 		=> $fbER,
			'inER' 		=> $inER,
			'ytER' 		=> $ytER,
			'ttER' 		=> $ttER,
			'insER' 	=> $insER,
			'xER' 		=> $xER,
			'xFollow'	=> $xFollow,
			'fbFollow'	=> $fbFollow,
			'inFollow'	=> $inFollow,
			'ytFollow'	=> $ytFollow,
			'ttFollow'	=> $ttFollow,
			'insFollow'	=> $insFollow,
			'xFollow'	=> $xFollow,
		];
		$datosSocial->updateSocialUser($dataSocial);
		return redirect()->to(base_url('/perfil'));
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// Insertar la experiencia del usuario
	public function insert_exp_user(){
		$this->validateAuth();
		$campaignModelo = new CampaignModel();

		$IdCompany = session('Id');
		$CName = $this->request->getPost('campana_name');
		$DateFinish = $this->request->getPost('date_campana');
		$CDescription = $this->request->getPost('campana');
		$catModelo = new ActionCategoryModel();

		$cat = array();
		$subCat = array();
		$data =[
			'id_influencer' => $IdCompany,
			'name_camp' => $CName,
			'Description' => $CDescription,
			'date_create' => $DateFinish,
			'date_finish' => NULL,
			'active' => '1'
		];

		$insert = $campaignModelo->insertCampaign([$data], 1);


		if(!empty($_POST['inlineCheckbox'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckbox'] as $selected){
				array_push($cat, $selected);
			}
		}
		if(!empty($_POST['inlineCheckboxSub'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxSub'] as $selectedSub){
				array_push($subCat, $selectedSub);
			}
		}
		$dataCat =[
			'id_type' => $insert,
			'cat_json' => $cat,
			'sub_json' => $subCat
		];
		$catModelo->updateCat([$dataCat], 3);


		if($insert){
			$msg = 'Campaña creada exitosamente.';
			$alertClass = 'alert-success';
			return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
		}else{
			$msg = 'La campaña no fue creada';
			$alertClass = 'alert-danger';
			return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
		}
	}

	//-
	//--------------------------------------------------------------------
	// editar la experiencia del usuario
	public function edit_exp_user(){
		$this->validateAuth();
		$campaignModelo = new CampaignModel();


		$IdCompany = session('Id');
		$id_exp = $this->base64Decode($this->request->getPost('id_exp'));
		$CName = $this->request->getPost('campana_name');
		$DateFinish = $this->request->getPost('date_campana');
		$CDescription = $this->request->getPost('campana');
		$catModelo = new ActionCategoryModel();

		$cat = array();
		$subCat = array();
		$data =[
			'id' => $id_exp,
			'id_influencer' => $IdCompany,
			'name_camp' => $CName,
			'Description' => $CDescription,
			'date_create' => $DateFinish,
			'date_finish' => NULL,
			'active' => '1'
		];

		$update = $campaignModelo->updateCampainExp([$data], 1);

		if(!empty($_POST['inlineCheckbox'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckbox'] as $selected){
				array_push($cat, $selected);
			}
		}
		if(!empty($_POST['inlineCheckboxSub'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxSub'] as $selectedSub){
				array_push($subCat, $selectedSub);
			}
		}
		$dataCat =[
			'id_type' => $id_exp,
			'cat_json' => $cat,
			'sub_json' => $subCat
		];

		$updateCat = $catModelo->updateCat([$dataCat], 3);

		if($updateCat > 0){
			$msg = 'Campaña creada exitosamente.';
			$alertClass = 'alert-success';
			return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
		}else{
			$msg = 'La campaña no fue creada';
			$alertClass = 'alert-danger';
			return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
		}
	}
	public function delete_exp_profile($id_exp){

		$campaignModelo = new CampaignModel();
		$deleteCampaign = $campaignModelo->deleteCampaign($id_exp,1);
		$catModelo = new ActionCategoryModel();
		$deleteCampaignExp = $catModelo->deleteCampaignExp($id_exp,1);

		if($deleteCampaign == 1 || $deleteCampaignExp == 1 ){

		$msg = '';
		$alertClass = 'alert-default';

		$msg = 'La campaña fue eliminada';
		$alertClass = 'alert-success';
		return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
	}else{

		$msg = 'La campaña no fue creada';
		$alertClass = 'alert-danger';
		return redirect()->to(base_url('/editar-perfil'))->with('msg',$msg)->with('alertClass',$alertClass);
	}
}
}