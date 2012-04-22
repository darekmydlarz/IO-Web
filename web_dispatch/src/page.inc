<?php
class Page {
	private $meta_title = "Web Dispatch Rider | AGH Kraków 2012";
	private $top_title = "Web Dispatch Rider";
	private $page_title;
	private $menu = array();
	private $style = array();
	public $content;
	
	public function __construct($page_title) {
		$this->page_title = $page_title;
		
		$this->addStyle('main.css');
		
		$this->addMenuElement('Zadania obliczne', '#');
		$this->addMenuElement('W trakcie', '#');
		$this->addMenuElement('Zadania nieudane', '#');
		$this->addMenuElement('Dodaj nowe', '#');
	}
	
	private function addMenuElement($name, $href) {
		$this->menu[$name] = $href;
	}
	
	private function addStyle($href) {
		$this->style[] = $href;
	}
	
	private function showMenu() {
		if(!empty($this->menu)) {
			echo "\n<div id='menu'><h1>$this->top_title</h1>\n";
			echo "<ul>";
			foreach($this->menu as $key => $value) {
				echo "\n<li><a href='$value'>$key</a></li>";
			}
			echo "\n</ul>";			
			echo "\n</div>";
		}
	}
	
	private function showTop() {
		echo "\n<div id='top'>";
		$this->showMenu();
		echo "<h2>$this->page_title</h2>";
		echo "\n</div>";		
	}
	
	private function showMeta() {
		echo "<head>\n";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />\n";
		echo "<title>$this->meta_title</title>\n";
		foreach($this->style as $element) {
			echo "<link rel='stylesheet' type='text/css' href='./css/$element' />";
		}		
		echo "</head>";
	}
	
	private function showContet() {
		echo "<div id='container'>";
		echo $this->content;
		echo "</div>";
	}
	
	public function showPage() {
		echo "<!DOCTYPE html>\n<html lang='pl'>\n";
		$this->showMeta();
		echo "\n<body>";
		$this->showTop();
		$this->showContet();
		echo "\n</body>\n</html>";
	}
}
?>
