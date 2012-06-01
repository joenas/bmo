<?php

class ViewHelper {

	private static $instance;
	private $baseUrl;
	private $javascript = array();

	public static function Instance() {
		if(self::$instance == null) {
			self::$instance = new ViewHelper();
		}
		return self::$instance;
	}

	private function __construct() {
		$request = new Request();
		$request->Parse();
		$this->baseUrl = $request->baseUrl;
		$this->db = Database::Instance();
	}

	public function Link($link, $type = 'href', $abaseUrl = null) {

		// If provided with new baseUrl, use that. Otherwise check for root and alter or use regular			
		$baseUrl = ( isset($abaseUrl) ) ? $abaseUrl : $this->baseUrl;
				print $type . "='{$baseUrl}{$link}'";
	
	}

	public function RandomImage() {

		$aPath = ($this->baseUrl=='/') ? 'img/550/' : $this->baseUrl.'img/250/';	
		$list = $this->ReadDirectory($aPath);
		$image = $list[rand(0, count($list)-1)];
		return "<div class='randimage'><img width=220 src='/{$aPath}{$image}' alt=''></div>";

	}

	public function ReadDirectory($aPath) {
		$list = Array();
		if(is_dir($aPath)) {
			if ($dh = opendir($aPath)) {
				while (($file = readdir($dh)) !== false) {
					if(is_file("$aPath/$file") && $file != '.htaccess') {
						$list[$file] = "$file";
					}
				}
				closedir($dh);
			}
		}
		sort($list, SORT_STRING);
		return $list;
	}

	public function getCurrentUrl() {
		$url = "http";
		$url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
		$url .= "://";
		$serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
 	   (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
		$url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
		return $url;
	}

	public function jsDocumentReadyFunction ($function) {
		$this->javascript[] = "{$function}\n";
	}	

	public function getJsFunctions() {
		//var_dump(empty($this->javascript));
		if (!empty($this->javascript)) {
			$html = "<script>\$(document).ready(function(){ ";
			foreach ($this->javascript as $val ) {
				$html .= $val;
			}
			$html .= " });</script>";
			return $html;
		}
		else return false;
	}

	public function searchField() {
		$this->jsDocumentReadyFunction("$.widget( 'custom.catcomplete', $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var self = this,
				currentCategory = '';
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( '<li class=ui-autocomplete-category>' + item.category + '</li>' );
					currentCategory = item.category;
				}
				self._renderItem( ul, item );
			});
		}
	});");

		$articles = new Article($this->db);
		$objects = new Object($this->db);

		$articlesArray = $articles->getAllByIndex('category', 'article');
		$objectsArray = $objects->getAll();

		$data = "$(function() { var data = [ ";
		foreach ($articlesArray as $val ) {
			$data .= "\n{ label: '" . $val['title'] . "', category: 'Artiklar', href: '/articles/show/". $val['permalink']."' },";
		}
		foreach ($objectsArray as $val ) {
			$data .= "\n{ label: '" . $val['title'] . "', category: 'Objekt', href: '/objects/show/". $val['permalink']. "' },";
		}


		$data .= "];";
		$data .= "
			$( '#search' ).catcomplete({ 
				delay: 0, 
				source: data,
				select: function( event, ui ) {
					window.location = ui.item.href;

				return false;
				}

			});
		});";
		$this->jsDocumentReadyFunction($data);

		echo <<< EOD
		<form action='{$this->baseUrl}search' method=post>
		<label for='search'>Sök: </label><input id='search' name=search />
		</form>
EOD;
	}


}
