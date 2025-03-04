<?php
//router
Class App 
{
	private $controller = "home"; //change to error controller so if someone type bg.net/abc and abc controller doesn't exist, it redirects to 404 page instead of home page
	private $method = "index";
	private $params = [];
	private $linkstructure = [
		
	];

	public function __construct()
	{
		if(str_ends_with(URI, '/index') || str_ends_with(URI, '/index.php'))  {
			// show($_GET['url']);
			// exit;
			header('location: '.htmlspecialchars(substr(URI, 0, strrpos(URI, '/index'))));
			exit;
		}

		if(str_ends_with(URI, '/') && URI!='/betagamers/public_html/' && URI!=='/')  {
			// echo 'wrong error: '.URI;
			// show($_GET['url']);
			// exit;
			header('location: '.htmlspecialchars(rtrim(URI, '/')));
			exit;
		}

		$url = $this->splitURL();
		// show($url);
		if(count($url)>2 && $url[0]!='tennis') {
			//prevents http://localhost/betagamers/public_html/account/forgot/abcdgh?jstvg=1234 from also serving account/forgot as duplicate content
			header('location: '.htmlspecialchars(HOME.'/'.$url[0].'/'.$url[1]));
			exit;
		}
		//if url[0]==tennis, get controller and method and attach to it.
		// if(isset($url))

 		if((file_exists(ROOT."/app/betagamers/controllers/". strtolower($url[0]) .".php")) && (LANG=='en' || $url[0]=='home'))
 		{
			//LANG=='en'
 			$controllername = strtolower($url[0]);
 			unset($url[0]);
 		} else {
			if(LANG=='en') {
				error_page();
			}
			$allaliases = controller_translations('all');
			$aliases = array_column($allaliases, LANG, 'en');
			// show($aliases);
			$key = array_search($url[0], $aliases);
			if($key) {
				$controllername = strtolower($key);
				unset($url[0]);
			} else {
				error_page();
			}
			//exit ('this controller '.$url[0].' does not exist');
		}
		
		
 		require ROOT."/app/betagamers/controllers/$controllername.php";
 		$this->controller = new $controllername;

 		if(isset($url[1]))
 		{
			$methodname = $url[1];
			if(LANG!='en') {
				$allmethods = directory_listing($controllername);
				$methodname = array_search($url[1], array_column($allmethods, LANG, 'en'));
			}
			if(!method_exists($this->controller, $methodname)) {
				error_page();
 			}
			// else {
			// 	//error_log method does not exist in controller, change controller to error (with method index as the 404 page)
			// 	//echo $url[1];
			// 	echo $url[1].' is not a controller and even as a method, does not exist in '.get_class($this->controller).' controller.';
			// 	$errorlevel = 'controller';
			// 	include "../app/betagamers/views/404.php";
			// 	exit;
			// 	//echo 'A very funny error just occurred. Please contact admin.';
			// 	// for index pages use abcd/ instead of abcd/efgh
			// }
 		}
		$this->method = $methodname ?? $this->method;
		// show($this->controller); echo $this->method; exit;

 		//run the class and method
 		$this->params = array_values($url);
		// echo $controllername.$methodname;exit;
 		call_user_func_array([$this->controller,$this->method], $this->params);
	}

	private function splitURL()
	{
		//if url has .php redirect to non .php equivalent, here or on htaccess
		$url = isset($_GET['url']) ? $_GET['url'] : "home";
		return explode("/", filter_var(trim($url,"/"),FILTER_SANITIZE_URL));
	}
}