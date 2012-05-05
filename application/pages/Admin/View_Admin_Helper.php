<?php 

class View_Admin_Helper {

	private $id;
	private $type;

	public function __construct($type, $id = "-1", $baseUrl = '/') {
		$this->id = $id;
		$this->type = $type;
		$this->baseUrl = $baseUrl;
		$this->db = Database::Instance();

	}

	public function SetupView() {

		$fields = '';


		if ($this->type == 'article') {
			$article = new Article($this->db);
			$res = $article->getAllArticles();
			$dropdown = $this->SetupDropDown($res);
			if (isset($this->id)) {
							$fields = array( 
												'category' => array('name' => 'category', 'type' => 'text'),
												'title' 		=> array('name' => 'title', 'type' =>'text'),
												'author'		=> array('name' => 'author','type' =>'text'),
												'pubdate'	=> array('name' => 'pubdate','type' =>'text'),
												'content'	=> array('name' => 'content', 'type' =>'textarea')												
												);

				$res = $article->getArticle($this->id);
				//var_dump($res);
			}
		}
		else if( $this->type == 'object') {
			$object = new Object($this->db);
			$res = $object->getAllObjects();
			$dropdown = $this->SetupDropDown($res);
			if (isset($this->id)) {
						$fields = array(	'title' 		=> 'text',
												'category'	=> 'text',
												'text'			=> 'textarea',
											 	'image'			=> 'text',
											 	'owner'			=> 'text'
											);
	
				$res = $object->getObject($this->id);
				//var_dump($res);
			}
		}
	
		return $this->SetupForm($dropdown, $fields, $res);

	}

	private function SetupDropDown($array) {

		$select = "<select id='input1' name='editId' onchange='form.submit();'>";
		$select .= "<option value='-1'>välj</option>";
		//var_dump($array);
		foreach($array as $val) 
		{
		  $selected = '';
		  if ( isset($this->id) && $this->id==$val['id'] ) 
		  {
			$selected = "selected";
		  }
		  $select .= "<option value='{$val['id']}' {$selected}>" .$val['title'] . "</option>";
		}
		$select .= "</select>";

		return $select;

	}

	private function SetupForm($dropdown, $fields = 0, $res = 0) {


		$html = <<< EOD
<form method="post" action='/admin/edit/{$this->type}' class="editor">
	  <fieldset>
	  <legend>{$this->type}:</legend>

	  <div class="editor-upper-container">
	    <div class="editor-show"><!-- Div for drop down menu -->
			
			{$dropdown}
			<input type=hidden name="show" value="true">
		    
			</div>

		</div>
EOD;

	if (isset($this->id)) {
	$the_fields = '';

	foreach ($fields as $val) {
		if ($val['type']=="textarea") {
			$the_fields .= "<textarea class=editor name=".$val['name'].">".$res[0][$val['name']]."</textarea>";
		}
		else {
			$the_fields .= "<input type=".$val['type']." class=editor name=".$val['name']." value='".$res[0][$val['name']]."'>";
		}
	}
	  
	$html .= <<< EOD
	  <div class="editor-lower-container">
	  	<div class="editor-lower-menu">
		  	<p class="editor" style="font-size: 0.7em; display: block;">Tillåtna taggar: <em>&lt;b&gt;&lt;i&gt;&lt;p&gt;&lt;img&gt;</em></p>
			</div>

			<div class="editor-display-container">		
	      {$the_fields}
	      	   	  <button type=submit name="update" value="true" class="editor">Spara</button>
		  	<button type=reset class="editor">Ångra</button>
		  	<button type=submit name="delete" value="true" class="editor">Ta bort</button>

	    </div>
	  </div>
	  
	  </fieldset>
	</form>
EOD;

	}

	return $html;
	}
}

?>