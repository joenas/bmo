<?php 

class Controller_Source extends CoreController {
	
	public function __contruct() {
	 	;
	}

	public function Route($request) {

	}


	public function GetData() {

		$this->data['title'] = "Visa källkod";
		$this->data['pageId'] = "source";
		$this->data['pageStyle'] = <<< EOD

div.primary { width:20%; float: right; padding: 0; overflow: auto;}

div.secondary {  
	width: 70%;
	min-width: 50em;
	margin-left: auto;
	margin-right: 4em;
	margin-bottom: 2em;
	float: right;
	padding: 0;
}

h3#file {
	margin-bottom: 0px;
}

div.secondary.sourceimg {
	text-align: center;
}
div.secondary img {
	border: 1px solid gray;
	padding: 1em;
}

EOD;

		return $this->data;
	}
}

?>