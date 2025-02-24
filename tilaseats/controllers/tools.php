<?php
class Tools extends Controller {
    function counter() {
        $this->page = 'wordcounter';
		$this->metabots = 'index, follow';
		$this->keywords = 'word counter, word count, character count, sentence count';
		$this->description = 'Accurate online word counter tool. Automatically count words, characters and senctences and make your essay writing and other writing tasks easier.';
		$this->og = [];
		$this->style = '';
 	 	$data['page_title'] = "Word Counter";
		$this->view("tools/counter",$data);
    }

    function converter() {
        $this->page = 'wordcounter';
		$this->metabots = 'index, follow';
		$this->keywords = '';
		$this->description = 'Advanced letter case conversion tool that would help you remove double spacing too. Convert texts between lower case, upper case, sentence case and capitalized case conveniently without bothering yourself about starting afresh to type.';
		$this->og = [];
		$this->style = '';
 	 	$data['page_title'] = "Letter Case Converter";
		$this->view("tools/converter",$data);
    }
}