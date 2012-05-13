<?php
require('./class.page.php');

class PageImpl extends Page {
	function display() {
		$content = '';
		$dir = $this->ready_dir;
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
		foreach($taskList as $item) {
			$content .= '<tr>';
			$content .= '<td>'.$item['name'].'</td>';
			$content .= '<td>'.$item['date'].'</td>';
			$content .= '<td>usuń</td>';
			$content .= '</tr>';
		}
		$content .= '</table>';
		
		return $content;
	}
}

$page = new PageImpl("Gotowe");
$page->showPage(false);
?>
