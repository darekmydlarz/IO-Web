<?php
	header('Access-Control-Allow-Origin: http://localhost');
?>
<?php
require('./class.page.php');

class PageImpl extends Page {
	
	function __construct($page_title, $commission_table = false) {
		parent::__construct($page_title, $commission_table);
		$this->addScript('graph');
	}
	
	function display() {
		$dir = Page::$ready_dir;
		$content = '';
		if(isset($_GET['task']) && trim($_GET['task']) != '' && file_exists($dir.'/'.$_GET['task'].'/map.js')) {
			if(!file_exists($dir.'/'.$_GET['task'].'/lc101.xls.xml'))
				$content .= '<p>Dla tego zadania nie ma jeszcze wyników (brak pliku: <code>lc101.xls.xml</code>)</p>';
			$content .= '<canvas id="myCanvas" width="1600" height="800"></canvas>';
			$content .= '<script language="javascript">
					start("./'.$dir.'/'.$_GET['task'] .'");
			</script>';
		} else {
			$content .= 'Takie zadanie nie istnieje lub jest niepoprawne!';
		}
		return $content;
	}
}

function getTitle() {
	$dir = Page::$ready_dir;
	if(isset($_GET['task']) && trim($_GET['task']) != '' && file_exists($dir.'/'.$_GET['task'].'/map.js'))
		return 'Pokaż graf <code>'.$_GET['task'].'</code>';
	return "Błąd!";
}

$page = new PageImpl(getTitle());
$page->showPage(true);
?>
