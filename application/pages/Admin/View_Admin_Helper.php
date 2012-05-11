<?php 

class View_Admin_Helper {

	private $id;
	private $type;

	public function __construct($action, $type, $id = "-1", $baseUrl = '/') {
		$this->action = $action;
		$this->id = $id;
		$this->type = $type;
		$this->baseUrl = $baseUrl;
		$this->db = Database::Instance();
		$this->helper = ViewHelper::Instance();
	}

	public function addView() {
		$fields = '';
		switch ($this->type) :

		case 'article':
			$article = new Article($this->db);
			$fields = $article->fields;
			$headline = "Lägg till artikel";
			break;
		
		case 'object':
			$object = new Object($this->db);
			$fields = $object->fields;
			$headline = "Lägg till objekt";
			break;

		endswitch;

		return $this->SetupForm('insert', $headline, $fields);
	}

	public function editView($message = null) {
		$fields = null;
		$item = null;
		switch ($this->type) {

		case 'article':
			$headline = "Ändra artikel";
			
			$article = new Article($this->db);
			$dropdown = $article->getAllArticles();
			if (isset($this->id)) {
				$fields = $article->fields;
				$item = $article->getArticle($this->id, 'id');
			}
			break;

		case 'object':
			$object = new Object($this->db);
			$dropdown = $object->getAllObjects();
			$headline = "Ändra objekt";
			if (isset($this->id)) {
				$fields = $object->fields;
				$item = $object->getObject($this->id);
			}
			break;
		}
	
		return $this->setupForm('update', $headline, $fields, $dropdown, $message, $item);
	}

	private function setupDropDown($array) {

		$select = "<select id='input1' name='id' onchange='form.submit();'>";
		$select .= "<option value='-1'>välj</option>";

		foreach($array as $val)  {
		  $selected = '';
		  if ( isset($this->id) && $this->id==$val['id'] ) {
			$selected = "selected";
		  }
		  $select .= "<option value='{$val['id']}' {$selected}>" .$val['title'] . "</option>";
		}
		$select .= "</select>";

		return $select;
	}

	private function setupForm($action, $headline = '', $fields = null, $dropdown = null, $message = null, $item = null) {

		$disabled = isset($dropdown) ? '' : 'disabled';
		$separator = ($this->type=='object') ? "<br>" : '';
		$html = "<h2>{$headline}</h2>";
		//var_dump($res);
		
		// Dropdown menu
		if (isset($dropdown)) :
			$dropdown = $this->setupDropDown($dropdown);
		$html .= <<< EOD
<form method="post" action='/admin/edit/{$this->type}' class="editor">
	  <fieldset>
	  <legend>Välj:</legend>

	  <div class="editor-upper-container">
	    <div class="editor-show"><!-- Div for drop down menu -->
			
			{$dropdown}
			<input type=hidden name="show" value="true">
		    
			</div>
			<div class="editor-message notice" id="message"></div>
		</div>
	  </fieldset>
</form>

EOD;

	endif;

	if (isset($message)) {
		$script = "\$('#message').text('{$message}').show().fadeOut(4000);";
		$html .= $this->helper->jsDocumentReadyFunction("\$('#message').text('{$message}').show().fadeOut(4000);");
	}


	// The fields for adding or updating 
	if (isset($fields)) :
	$the_fields = '';

	foreach ($fields as $val) {
		$the_fields .= "<label for=".$val['name']."> ".$val['label'].": </label>";
		if ($val['type']=="textarea") {
			$the_fields .= "<textarea class='editor {$this->type}' name=".$val['name']." id=".$val['name'].">".$item[0][$val['name']]."</textarea><br>";
		}
		else {
			//$the_fields = Form::input(array('type' => $val['type'], 'name' => )
			$the_fields .= "<input class={$this->type} type=".$val['type']."  name=".$val['name']." id=".$val['name']." value='".$item[0][$val['name']]."'>{$separator}";
		}
	}

	$html .= <<< EOD
	<form method="post" action='' class="editor" id=view>
	<fieldset>
	  <div class="editor-lower-container">
	  	<div class="editor-lower-menu">
		  	<p class="editor" style="font-size: 0.7em; display: block;">Tillåtna taggar: <em>&lt;b&gt;&lt;i&gt;&lt;p&gt;&lt;img&gt;</em></p>
			</div>

			<div class="editor-display-container">
			<input type=hidden name=id value={$this->id}>
			<input type=hidden name=type value={$this->type}>
	      {$the_fields}
	     	<button type=submit id=save name="save" value="true" class="editor" data-url="/admin/{$action}/{$this->type}">Spara</button>
		  	<button type=reset class="editor">Ångra</button>
		  	<button type=submit id=delete name="delete" value="true" class="editor" data-url="/admin/delete/{$this->type}" {$disabled}>Ta bort</button>

	    </div>
	  </div>
	 </fieldset>
	</form>
	  
EOD;

	endif;

	return $html;
	}
}

?>