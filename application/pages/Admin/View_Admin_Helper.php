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

	}

	public function addView() {
		$fields = '';
		if ($this->type == 'article') {
			$article = new Article($this->db);
			$fields = $article->fields;
			$headline = "Lägg till artikel";
		}
		else if( $this->type == 'object') {
			$object = new Object($this->db);
			$fields = $object->fields;
			$headline = "Lägg till objekt";
		}
	
		return $this->SetupForm('insert', null, $headline, '', $fields);
	}

	public function EditorView($message) {
		$fields = null;
		if ($this->type == 'article') {
			$article = new Article($this->db);
			$res = $article->getAllArticles();
			$dropdown = $this->SetupDropDown($res);
			$headline = "Ändra artikel";
			if (isset($this->id)) {
				$fields = $article->fields;
				$res = $article->getArticle($this->id, 'id');
				//var_dump($res);
			}
		}
		else if( $this->type == 'object') {
			$object = new Object($this->db);
			$res = $object->getAllObjects();
			$dropdown = $this->SetupDropDown($res);
			$headline = "Ändra objekt";
			if (isset($this->id)) {
				$fields = $object->fields;
				$res = $object->getObject($this->id);
				//var_dump($res);
			}
		}
	
		return $this->SetupForm('update', $message, $headline, $dropdown, $fields, $res);

	}

	private function SetupDropDown($array) {

		$select = "<select id='input1' name='editId' onchange='form.submit();'>";
		$select .= "<option value='-1'>välj</option>";

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

	private function SetupForm($action, $message = null, $headline = '', $dropdown = '', $fields = null, $res = null) {
		$disabled = isset($res) ? '' : 'disabled';
		$separator = ($this->type=='object') ? "<br>" : '';
		$html = "<h2>{$headline}</h2>";
		
		
		// Dropdown menu
		if (isset($res)) :
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
		$html .= <<< EOD
		<script>$("#message").text("{$message}").show().fadeOut(4000);</script>
EOD;
	}

	// The fields for adding or updating 
	if (isset($fields)) :
	$the_fields = '';

	foreach ($fields as $val) {
		$the_fields .= "<label for=".$val['name']."> ".$val['label'].": </label>";
		if ($val['type']=="textarea") {
			$the_fields .= "<textarea class='editor {$this->type}' name=".$val['name']." id=".$val['name'].">".$res[0][$val['name']]."</textarea><br>";
		}
		else {
			$the_fields .= "<input class={$this->type} type=".$val['type']."  name=".$val['name']." id=".$val['name']." value='".$res[0][$val['name']]."'>{$separator}";
		}
	}
	  ///admin/{$this->action}/{$this->type}/{$this->id}
	$html .= <<< EOD
	<form method="post" action='bajs' class="editor" id=view>
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