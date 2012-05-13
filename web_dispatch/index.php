<?php
require('./class.page.php');

class MainPage extends Page {
	function display() {
		$content = '<p>Web Dispatch Rider to aplikacja internetowa pozwalająca na wygodne korzystanie
		z zainstalowanego na serwerze oprogramowania do zajmowania się problemem transportowym.
		Prosty w obsłudze i czytelny interfejs ma zapewnić użytkownikowi maksymalną satysfakcję
		z używania tego produktu. Dołożyliśmy wszelkich starań, aby aplikacja ta spełniała
		oczekiwania odbiorców.</p>
		<p><strong>Zapraszamy do korzystania</strong></p>';
		return $content;
	}
}

$page = new MainPage("Strona główna");
$page->showPage(true);
?>
