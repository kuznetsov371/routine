<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {
		include '/usr/share/nginx/apps/routine/model/config/patterns.php';// Підключення файлу із патернами
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e'); // /form/submitAmbassador
		$path = explode('/', $url);// path[1]=form path[2]=submitAmbassador
		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php'; // /usr/share/nginx/apps/routine/model/config/methods/form.php
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];
					foreach ($details['params'] as $param) {
						$var = $this->getVar($param['name'], $param['source']);
							if(!isset($var) && $param['required'])//Перевірка: якщо змінна var не встановлена,але обов'язкова
								throw new \Exception('REQUEST_INCOMPLETE',1);// Викидається виключення із відповідним кодом помилки
							else
								if(!isset($var) && !$param['required']){//Перевірка: якщо змінна var не встановлена і не обов'язкова
									if(isset($param['default'] ))//Перевірка: чи існує значення за замовчуванням
										$request[$param['name']] = $param['default'];// Встановлення значення за замовчуванням 
									else
										throw new \Exception('INTERNAL_ERROR',6);// Викидається виключення із відповідним кодом помилки
								}
								else{
									if(isset($param['pattern'])){//Перевірка:чи існує патерн
										if(preg_match($patterns[$param['pattern']]['regex'],$var)){//Перевірка:чи відповідає змінна патерну
											if(isset($patterns[$param['pattern']]['callback']))//Перевірка:чи є функція callback
												$var = preg_replace_callback($patterns[$param['pattern']]['regex'],$patterns[$param['pattern']]['callback'],$var);//Запис відкорегованої змінної
											$request[$param['name']] = $var;//Встановлення змінної
										}
										else
											throw new \Exception('REQUEST_INCORRECT',2);// Викидається виключення із відповідним кодом помилки
									}
									else
										$request[$param['name']] = $var;//Встановлення змінної
								}
					}
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];	
						$result = $method($request);
					}
				}

			}
		}

		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$front = $this -> getVar('FRONT','e');
		foreach ( [$front] as $allowed )
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}