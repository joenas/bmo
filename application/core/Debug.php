<?php 

/**
* Simple custom debug handler 
* Prints out the message in template.php, not really for exceptions 
* Singelton pattern
*/

class Debug {
	
	public $data = null;
	private static $instance = null;

	private function __construct () {
	}

	public static function Instance() {
		if(self::$instance == null) {
			self::$instance = new Debug();
		}
		return self::$instance;
	}

	public function message($message, $line = '', $file = '') {
		$id = $this->Id();
		$this->data[$id]['message'] = $message;
		$this->data[$id]['line'] = $line;
		$this->data[$id]['file'] = $file;
	}

	public function output() {
		//var_dump($this->data);
		if (isset($this->data)) {
			$html = "<div class='debug'>";
			foreach ($this->data as $val) {
				$html .= "<p>".$val['message']."<code> in <strong>".$val['file']."</strong> on line ".$val['line']."</code></p>";
			}
			$html .= "</div>";
			return $html;
		}
	}

	private function Id() {
		return md5(rand(time(), true));
	}

}


?>