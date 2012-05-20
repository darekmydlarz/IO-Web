<?php
require('./class.page.php');

class PageImpl extends Page {
	function display() {
		$content = '';
		if(isset($_GET['del']) && trim($_GET['del']) != null) {
			$dir = self::$ready_dir;
			$name = $_GET['del'];
			if(file_exists("$dir/$name")) {
				//exec("rm -rf $dir/$name");
				$content .= "Zadanie <code>$name</code> usunięte pomyślnie!";
			} else {
				$content .= "Nie udało się usunąć <code>$name</code>. Takie zadanie nie istnieje w systemie.";
			}
		} else {
			$dir = self::$ready_dir;
			$output;
			exec("ls -lt $dir", $output);
			
			$list = array();
			foreach($output as $item) {
				$file = explode(" ", $item);
				if($file[0][0] == 'd') {
					$date = file_get_contents($dir.'/'.$file[8].'/info.txt');
					$list[] = array('name' => $file[8], 'date' => $date);
				}
			}
			
			$content .= '<table id="task-table">';
			$content .= '<tr>';
			$content .= '<th>zadanie</td>';
			$content .= '<th>data obliczenia</td>';
			$content .= '<th>akcje</td>';
			$content .= '</tr>';
			foreach($list as $item) {
				$content .= '<tr>';
				$content .= '<td>'.$item['name'].'</td>';
				$content .= '<td>'.$item['date'].'</td>';
				$content .= '<td><a href="#">pokaż graf</a>';
				$content .= '<a href="table.php?task='.$item['name'].'">pokaż tabelę</a>';
				$content .= '<a href="ready.php?del='.$item['name'].'" onClick="return confirmDelete()">usuń</a></td>';
				$content .= '</tr>';
			}
			$content .= '</table>';
		}
		return $content;
	}
}

$container = isset($_GET['del']);

$page = new PageImpl("Gotowe");
$page->showPage($container);
?>
