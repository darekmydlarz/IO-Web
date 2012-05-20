<?php

abstract class Page {
	private $meta_title = "Web Dispatch Rider | AGH Kraków 2012";
	private $top_title = "Web Dispatch Rider";
	private $page_title;
	public static $uploads_dir = 'uploads';
	public static $ready_dir = 'ready';
	private $menu = array();
	private $style = array();
	private $script = array();
        private $parseXML = false;
	
	public function __construct($page_title, $commission_table = false) {
		$this->page_title = $page_title;
		
		// css
		$this->addStyle('main');
		
		// js
		$this->addScript('jquery');
		$this->addScript('xmlResults2text');
		$this->addScript('main');
                $this->parseXML = $commission_table;
		
		$this->addMenuElement('Zadania obliczone', 'ready.php', $this->countDirs(self::$ready_dir));
		$this->addMenuElement('W trakcie', 'uploads.php', $this->countDirs(self::$uploads_dir));
		//$this->addMenuElement('Zadania nieudane', '#', 1);
		$this->addMenuElement('Dodaj nowe', 'add_task.php');
	}
	
	public function __destruct() {
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

        echo "<script type='text/javascript' src='./js/jquery.js'></script>\n";
        foreach($this->script as $element)
                echo "<script type='text/javascript' src='./js/$element.js'></script>";
        if($this->parseXML)
                echo '<script type=\'text/javascript\'>jQuery(document).parseXml();</script>';
        echo "</head>";
    }
	
	abstract function display();
	
	private function showContent($container) {
		echo $container ? "<div id='container'>" : '';
		echo $this->display();
		echo $container ?  "</div>" : '';
	}
	
	public function showPage($container) {
		echo "<!DOCTYPE html>\n<html lang='pl'>\n";
		$this->showMeta();
		echo "\n<body>";
		$this->showTop();
		$this->showContent($container);
		echo "\n</body>\n</html>";
	}
	
	function input($name, $label, $options = null) {
		$inputOptions = '';
		foreach($options as $key => $value) {
			$inputOptions .= $key.'="'.$value.'" ';
		}
		
		$input = '<p><label>'.$label.'</label><input id="'.$name.'"
			name="'.$name.'" placeholder="'.$label.'" '.$inputOptions.' /></p>';
		$input .= "\n<p class='message'></p>";
		return "$input\n";
	}
	
	function textarea($name, $label, $value, $options = null) {
		$result = '';
		$areaOptions = '';
		foreach($options as $key => $value)
			$areaOptions .= $key.'="'.$value.'" ';
			
		$result .= '<h2>'.$label.':</h2>';
		$result .= '<textarea name="'.$name.'" class="edit">'.$value.'</textarea>';
		return $result;
	}
	
	function slugify($text){ 
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
	
	function fileUpload($file, $dir, $destination) {
		$fileTmp = $file['tmp_name'];
		$fileSize = $file['size']; 

		if(is_uploaded_file($fileTmp)) { 
			move_uploaded_file($fileTmp, "$dir/$destination"); 
			chmod("$dir/$destination/$fileTmp", 666);
			return true; 
		}
		return false;			
	}
	
	private function countDirs($dir) {
		$handle = opendir($dir);
		$counter = 0;
		while (false !== ($entry = readdir($handle)))
			if ($entry != "." && $entry != ".." && is_dir($dir.'/'.$entry))
				++$counter;
		
		return $counter;
	}
}
?>
