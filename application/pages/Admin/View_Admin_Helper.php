<?php 

class View_Admin_Helper {

	private $id;
	private $model;

	public function __construct($model, $id = null) {
		$this->id = $id;
		$this->model = $model;
		$this->db = Database::Instance();
		$this->request = new Request();
		$this->request->parse();
	}

	public function notice($message) {
		ViewHelper::Instance()->jsDocumentReadyFunction("$('#message').text('{$message}').show().fadeOut(4000);");
	}

	public function addView() {
		$fields = '';

		if ( isset($this->model) ){
			$model = new $this->model($this->db);
			$fields = $model->fields;

			ViewHelper::Instance()->jsDocumentReadyFunction("$('#view').validate();");

			switch ($this->model) :

			case 'Article':
				$headline = "Lägg till artikel";
				break;
			
			case 'Object':
				$headline = "Lägg till objekt";
				break;

			endswitch;

			return $this->SetupForm('insert', $headline, $fields);
		}
		else return "Modellen saknas.";
	}

	public function editView() {
		$fields = null;
		$item = null;

		if (isset($this->model)) {
			$model = new $this->model($this->db);
			$dropdown = $model->getAll();
		
			if (isset($this->id)) {
					$fields = $model->fields;
					$item = $model->getById($this->id);
			}
			switch ($this->model) {

			case 'Article':
				$headline = "Ändra artikel";
				break;

			case 'Object':
				$headline = "Ändra objekt";
				break;
			}
	
			return $this->setupForm('update', $headline, $fields, $dropdown, $item);
		}
		else return "Modellen saknas.";
	}

	

	private function setupForm($action, $headline = '', $fields = null, $dropdown = null, $item = null) {

		$disabled = isset($dropdown) ? '' : 'disabled';
		$html = "<h2>{$headline}</h2>";
		$html .= "\n\t<div class='editor-message notice' id='message'></div><br><br>\n";

		// Dropdown menu
		if (isset($dropdown)) {
			
			$dropdown = $this->setupDropDown($dropdown);
			$html .= "\n\t<form method='post' action='{$this->request->baseUrl}admin/edit/{$this->model}'>\n\t<input type=hidden name='show' value='true'>\n\t";
		  	$html .= "\n\t<div class='editor-dropdown'>\n\t{$dropdown}\n\t</div>";
	  	
	  		$html .= "\n\t</form><br>";
		}

		// The fields for adding or updating 
		if (isset($fields) && $this->id!="-1") {

		$the_fields = $this->setupFields($fields, $item);

		$html .= "\n\t<form method='post' action='action' class='editor' id=view>
		<fieldset>
		<p class='editor' style='font-size: 0.7em; display: block;'>Håll musen över ett fält för att se tillåtna taggar.</p>
		<input type=hidden name=id value={$this->id}>
		<input type=hidden name=type value={$this->model}>{$the_fields}

		<button type=submit id=save name='save' value='true' class='editor' data-url='{$this->request->baseUrl}admin/{$action}/{$this->model}'>Spara</button>
		<button type=reset id=reset class='editor'>Ångra</button>
		<button type=submit id=delete name='delete' value='true' class='editor' data-url='{$this->request->baseUrl}admin/delete/{$this->model}' {$disabled}>Ta bort</button>

		</fieldset>
		</form>
		<div id='dialog-confirm' class='ui-dialog' title='Ta bort?'>
		<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>Artikeln kommer att tas bort, är du säker?</p>
		</div>";

		ViewHelper::Instance()->jsDocumentReadyFunction("$( 'button' ).button({});");

		}


	return $html;

	}

	private function setupFields($array, $item) {
		$html = '';
		$separator = ($this->model=='Object') ? "<br>" : '';

		// Add the properties for tooltip
		ViewHelper::Instance()->jsDocumentReadyFunction("var shared = { position: { my: 'bottom left', at: 'top right' }, style: { classes: 'ui-tooltip-rounded ui-tooltip-green' } }");

		foreach ($array as $val) {
			$html .= "\n\t<label for=".$val['name']."> ".$val['label'].": </label>";
			if ($val['type']=="textarea") {
				$html .= "\n\t<textarea class='editor {$this->model}' title='Tillåtna taggar: ".htmlentities($val['tags'])."' name=".$val['name']." id=".$val['name'].">".$item[0][$val['name']]."</textarea><br>";
			}
			else {
				$html .= "\n\t<input class=".$val['validate']." type=".$val['type']."  name=".$val['name']." id=".$val['name']." value='".$item[0][$val['name']]."'>{$separator}";
			}

			// Get some nice tooltips
			ViewHelper::Instance()->jsDocumentReadyFunction("$('#".$val['name']."').qtip( $.extend({}, shared, { content: 'Tillåtna taggar: ".htmlentities($val['tags'])." '}));");

		}
		// Date picker for field
		ViewHelper::Instance()->jsDocumentReadyFunction("$( '#pubdate' ).datepicker( { dateFormat: 'yy-mm-dd' } );");

		return $html;
	}

	private function setupDropDown($array) {

		$select = "<select id='input1' name='id' onchange='form.submit();'>";
		$select .= "<option value='-1'>välj</option>";

		foreach($array as $val)  {
		  $selected = '';
		  if ( isset($this->id) && $this->id==$val['id'] ) {
			$selected = "selected";
		  }
		  $select .= "\n\t<option value='{$val['id']}' {$selected}>" .$val['title'] . "</option>";
		}
		$select .= "</select>";

		return $select;
	}

}

?>