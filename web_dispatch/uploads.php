<?php
require('./class.page.php');

class PageImpl extends Page {
	function display() {
		$content = '';		
		if(isset($_POST['task']) && trim($_POST['task']) != null) {
			$task = $_POST['task'];
			$dir = self::$uploads_dir.'/'.$task;
			// trucks
			$file = fopen("$dir/trucks.properties", 'w+') or die('Nie moge otworzyć pliku');
			if(trim($_POST['trucks']) != '')
				fwrite($file, $_POST['trucks']);
			fclose($file);
			// trailers
			$file = fopen("$dir/trailers.properties", 'w+') or die('Nie moge otworzyć pliku');
			if(trim($_POST['trailers']) != '')
				fwrite($file, $_POST['trailers']);
			fclose($file);
			// drivers
			$file = fopen("$dir/drivers.properties", 'w+') or die('Nie moge otworzyć pliku');
			if(trim($_POST['drivers']) != '')
				fwrite($file, $_POST['drivers']);
			fclose($file);
			// holons
			$file = fopen("$dir/holons.properties", 'w+') or die('Nie moge otworzyć pliku');
			if(trim($_POST['holons']) != '')
				fwrite($file, $_POST['holons']);
			fclose($file);
			// configuration
			$file = fopen("$dir/configuration.xml", 'w+') or die('Nie moge otworzyć pliku');
			if(trim($_POST['configuration']) != '')
				fwrite($file, $_POST['configuration']);
			fclose($file);
			
			$content .= 'Edycja zakończona pomyślnie';
			
		} else if(isset($_GET['del']) && trim($_GET['del']) != null) {
			$dir = self::$uploads_dir;
			$name = $_GET['del'];
			if(file_exists("$dir/$name")) {
				exec("rm -rf $dir/$name");
				$content .= "Zadanie <code>$name</code> usunięte pomyślnie!";
			} else {
				$content .= "Nie udało się usunąć <code>$name</code>. Takie zadanie nie istnieje w systemie.";
			}
		} else if(isset($_GET['edit']) && trim($_GET['edit']) != null) {
			$task = $_GET['edit'];
			$content .= '<form id="edit" method="post" action="uploads.php" enctype="multipart/form-data">';
			$content .= $this->input('task', null, array(
				'type' => 'hidden', 'value' => $task
			));
			$fileContent = file_get_contents(self::$uploads_dir.'/'.$task.'/trucks.properties');
			$content .= $this->textarea('trucks', 'Ciągniki', $fileContent);
			$fileContent = file_get_contents(self::$uploads_dir.'/'.$task.'/trailers.properties');
			$content .= $this->textarea('trailers', 'Naczepy', $fileContent);
			$fileContent = file_get_contents(self::$uploads_dir.'/'.$task.'/drivers.properties');
			$content .= $this->textarea('drivers', 'Kierowcy', $fileContent);
			$fileContent = file_get_contents(self::$uploads_dir.'/'.$task.'/holons.properties');
			$content .= $this->textarea('holons', 'Holony', $fileContent);
			$fileContent = file_get_contents(self::$uploads_dir.'/'.$task.'/configuration.xml');
			$content .= $this->textarea('configuration', 'Konfiguracja', $fileContent);
			$content .= '<input type="submit" value="Edycja"></form>';
		} else {
			$dir = self::$uploads_dir;
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
			$content .= '<th>data wysłania</td>';
			$content .= '<th>akcje</td>';
			$content .= '</tr>';
			foreach($list as $item) {
				$content .= '<tr>';
				$content .= '<td>'.$item['name'].'</td>';
				$content .= '<td>'.$item['date'].'</td>';
				$content .= '<td><a href="uploads.php?edit='.$item['name'].'">edytuj</a>
					<a href="uploads.php?del='.$item['name'].'" onClick="return confirmDelete()">usuń</a></td>';
				$content .= '</tr>';
			}
			$content .= '</table>';
		}
			
		return $content;
	}
}

function title() {
	if(isset($_GET['edit']) && trim($_GET['edit']) != null)
		return 'Edycja <code>'.$_GET['edit'].'</code>';
	return "W trakcie";
}

$container = isset($_GET['edit']) || isset($_GET['del']) || isset($_POST['task']);

$page = new PageImpl(title());
$page->showPage($container);
?>
