<?php
require('./class.page.php');

class PageImpl extends Page {
	function display() {
		$content = '';
		$dir = self::$ready_dir;
		if(isset($_GET['task']) && trim($_GET['task']) != '' && file_exists($dir.'/'.$_GET['task'].'/info.txt')) {
			$task = $_POST['task'];
			$resultsXMLFilePath = $dir.'/'.$_GET['task'].'/results.xml';
		} else {
			$content .= 'Coś poszło nie tak. Spróbuj ponownie!';
			
		}
		
		return $content;
	}
}

function resultsFile() {
	$dir = Page::$ready_dir;
	$resultsXMLFilePath = $dir.'/'.$_GET['task'].'/results.xml';
	if(isset($_GET['task']) && trim($_GET['task']) != '' && file_exists($resultsXMLFilePath))
		return $resultsXMLFilePath;
	return null;
}

function getTitle() {
	$dir = Page::$ready_dir;
	if(isset($_GET['task']) && trim($_GET['task']) != '' && file_exists($dir.'/'.$_GET['task'].'/info.txt'))
		return 'Pokaż tabelę <code>'.$_GET['task'].'</code>';
	return "Błąd!";
}

$page = new PageImpl(getTitle(), resultsFile());
$page->showPage(true);
?>
