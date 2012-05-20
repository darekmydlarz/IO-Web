<?php
require('./class.page.php');

class AddTaskPage extends Page {
	function display() {
		$content = '';
		
		if(isset($_POST['task']) && trim($_POST['task']) != '') {
			$task = $_POST['task'];
			$i = 0;
			$task_dir = $this->slugify($task).$i;			
			
			// looking for a free directory name
			while(file_exists(self::$uploads_dir.'/'.$task_dir))
				$task_dir = substr($task_dir, 0, -1).$i++;
			
			// creating a dir
			$dir = self::$uploads_dir.'/'.$task_dir;
			mkdir($dir, 0777, true) or die ('Nie można utworzyć katalogu');
			
			// uploading files:			
			foreach($_FILES as $key => $value) {
				$extension = $key == 'configuration' ? 'xml' : 'properties';
				$this->fileUpload($value, $dir, $key.'.'.$extension);
			}
			
			// information file
			$info_fh = fopen("$dir/info.txt", 'w') or die("can't open file");
			fwrite($info_fh, date('Y-m-d H:i:s'));
			fclose($ourFileHandle);
			
			
			$content .= 'Zadanie: <code>'.$task.'</code> utworzono pomyślnie';
		} else {
			$content .= '<form id="addTask" method="post" action="add_task.php" enctype="multipart/form-data">';
			$content .= $this->input('task', 'Nazwa zadania', array(
				'type' => 'text'
			));
			$content .= $this->input('trucks', 'Parametry ciągników', array(
				'type' => 'file'
			));
			$content .= $this->input('trailers', 'Parametry naczep', array(
				'type' => 'file'
			));
			$content .= $this->input('drivers', 'Parametry kierowców', array(
				'type' => 'file'
			));
			$content .= $this->input('holons', 'Parametry holonów', array(
				'type' => 'file'
			));
			$content .= $this->input('configuration', 'Konfiguracja', array(
				'type' => 'file'
			));
			$content .= '<input type="submit" value="Wyślij nowe zadanie">';
			$content .= '</form>';
			
		}
		
		return $content;
	}
}

	$page = new AddTaskPage('Dodaj nowe zadanie');
	$page->showPage(true);
?>
