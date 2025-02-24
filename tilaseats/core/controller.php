<?php
//mother controller

Class Controller
{
	public $page;
	public $metabots;
	public $keywords;
	public $description;
	public $og = [];
	public $style;
	public $displayheadermenu = 'default'; //default, profile, false

	protected function view($view,$data = [])
	{
		$generalclass = new General;
		//$data['footersocials'] = $generalclass->get_by_active('contacts', ['channel', 'icon', 'value', 'link'], [1]);
		include "../app/tilaseats/incs/header.php";
		if(file_exists("../app/tilaseats/views/". $view .".php"))
 		{
 			include "../app/tilaseats/views/". $view .".php";
 		}else{
 		    $errorlevel = 'view';
 			include "../app/tilaseats/views/404.php";
 		    trigger_error("View page, $view not found for: ".HOME.URI, E_USER_ERROR);
 		}
		include "../app/tilaseats/incs/footer.php"; // all pages have the same header and footer.
	}

	public function check_logged_in($loginpage='account/login', $table='user') {
        if(!isset($_SESSION[$table]['logged_in']) || $_SESSION[$table]['logged_in']!==true) {
            header("location: ".HOME."/$loginpage");
            exit();
        }
        return true;
    }

    // protected function loadModel($model)
	// {
	// 	if(file_exists("../app/models/". $model .".php"))
 	// 	{
 	// 		include "../app/models/". $model .".php";
 	// 		return $model = new $model();
 	// 	}

 	// 	return false;
	// }


}