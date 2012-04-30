<?php 

/**
* Simple custom error handler 
* Prints out the message in template.php, not really for exceptions 
* Singelton pattern
*/

class CoreError {
	
	private $data = array();
	private static $instance = null;

	private function __construct () {
	}

	public static function Instance() {
		if(self::$instance == null) {
			self::$instance = new CoreError();
		}
		return self::$instance;
	}

	public function Error($message, $type = "error") {
		$id = $this->Id();
		$this->data[$id]['type'] = $type;
		$this->data[$id]['message'] = $message;
	}

	public function GetErrors() {
		$errorMsg = null;
		foreach ($this->data as $val) {
			$errorMsg .= "<p><output class=".$val['type'].">".$val['type'].": ".$val['message']."</output></p>";
		}

		return $errorMsg;
	}

	private function Id() {
		return md5(rand(time(), true));
	}

}


?>