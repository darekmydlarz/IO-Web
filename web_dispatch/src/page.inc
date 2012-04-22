<?php
class Page {
	private $meta_title = "Web Dispatch Rider | AGH Kraków 2012";
	private $top_title = "Web Dispatch Rider";
	private $page_title;
	private $menu = array();
	private $style = array();
	private $script = array();
	public $content;
	
	public function __construct($page_title) {
		$this->page_title = $page_title;
		
		$this->addStyle('main');
		$this->addScript('main');		
		
		$this->addMenuElement('Zadania obliczone', '#', 10);
		$this->addMenuElement('W trakcie', '#', 3);
		$this->addMenuElement('Zadania nieudane', '#', 1);
		$this->addMenuElement('Dodaj nowe', 'add_task.php');
	}
	
	private function addMenuElement($name, $href, $number = null) {
		$this->menu[] = array('name' => $name, 'href' => $href, 'number' => $number);
	}
	
	private function addStyle($href) {
		$this->style[] = $href;
	}
	
	private function addScript($href) {
		$this->script[] = $href;
	}
	
	private function showMenu() {
		if(!empty($this->menu)) {
			echo "\n<div id='menu'><a href='index.php'><h1>$this->top_title</h1></a>\n";
			echo "<ul>";
			foreach($this->menu as $element) {
				$name = $element['name'];
				$href = $element['href'];
				$number = $element['number'];
				$span = empty($number) ? '' : "<span class='number'>$number</span>";
				echo "\n<li><a href='$href'>$name$span</a></li>";
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
		foreach($this->style as $element)
			echo "<link rel='stylesheet' type='text/css' href='./css/$element.css' />";
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>";
		foreach($this->script as $element)
			echo "<script type='text/javascript' src='./js/$element.js'></script>";

				
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
	
	public function slugify($text){ 
		$in	=	array ('Ą','ą','Ć','ć','Ę','ę','Ł','ł','Ń','ń','Ó','ó','Ś','ś','Ź','ź','Ż','ż');
		$out=	array ('a','a','c','c','e','e','l','l','n','n','o','o','s','s','z','z','z','z');
		$text = trim($text);
		$text = utf8_encode($text);
		foreach ($in as $index => $letter)
			$text = str_replace(utf8_encode($letter), $out[$index], $text);
		
		$text = strtolower($text);
		$text = preg_replace('/[^a-zA-Z0-9-]/', '-', $text);
		$text = preg_replace('/-+/', '-', $text);
		return $text;
	}
}
?>
