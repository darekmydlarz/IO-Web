<?php
	require('./src/page.inc');
	
	class AddPage extends Page {
		private $inputs = array();
		
		public function addInput($type, $label) {
			$this->inputs[] = array('type' => $type,
			'name' => $this->slugify($label), 'label' => $label);
		}
		
		public function getForm() {
			$result = '<form id="addTask" method="post" action="add_task.php?action=add">';
			foreach($this->inputs as $input) {
				$type = $input['type'];
				$name = $input['name'];
				$label = $input['label'];
				if ($type == 'file') {
					$result .= "<p class='file-wrapper'><input name='$name' type='$type' />";
					$result .= "<span class='button'>$label</span></p>";
				} else {
					$result .= "<p><input name='$name' type='$type' placeholder='$label' title='$placeholder' /></p>";
				}
			}
			$result .= '<input type="submit" value="Wyślij nowe zadanie">';
			$result .= '</form></div>';
		
			return $result;
		}
	}
	
	$addPage = new AddPage('Dodaj nowe zadanie');
	$addPage->addInput('text', 'Nazwa zadania');
	$addPage->addInput('file', 'Parametry ciągników');
	$addPage->addInput('file', 'Parametry naczep');
	$addPage->addInput('file', 'Parametry kierowców');
	$addPage->addInput('file', 'Parametry holonów');
	$addPage->content = $addPage->getForm();

	$addPage->showPage();
?>
