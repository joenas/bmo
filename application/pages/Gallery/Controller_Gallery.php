<?php 

class Controller_Gallery extends CoreController {

	public function __contruct() { 
		
	}

	public function getData() {
		$this->data['pageId'] = "gallery";
		$this->data['title'] = "Galleri";
		//$this->data['pageStyle'] = 'div.primary { width: 60%; margin: 0 auto; }';
		return $this->data;
	}

	public function index() {
		$this->db = Database::Instance();

		$object = new Object($this->db);
		$array = $object->getAll();

		$html = "";
		foreach ($array as $val) {
			$html .= "\n\n\t<a class=gallery href={$this->baseUrl}".str_replace('/bmo/', '/bmo/550/', $val['image'])." title='".$val['title']."'>";
			$html .= "\n\t<img class='thumbnail' title='".$val['title']."' src=".str_replace('/bmo/', '/bmo/250/', $val['image'])."></a>";
		}

		$this->data['html'] = $html;

		ViewHelper::Instance()->jsDocumentReadyFunction("var shared = { position: { my: 'bottom left', at: 'top right' }, style: { classes: 'ui-tooltip-rounded ui-tooltip-red' } }");
		ViewHelper::Instance()->jsDocumentReadyFunction("$('.thumbnail').qtip( $.extend({}, shared, { content: this.alt }));");
		ViewHelper::Instance()->jsDocumentReadyFunction("jQuery('a.gallery').colorbox({rel:'gallery', transition:'fade', width:'55%', height:'65%'});");

	}
	
}

?>