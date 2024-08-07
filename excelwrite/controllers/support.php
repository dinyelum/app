<?php

Class Support extends Controller 
{
	function Index() {
		$this->page = 'contactus';
		$this->metabots = 'index, follow';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
 	 	$data['page_title'] = "Contact Us";
		$generalclass = new General;
		$getcontacts = $generalclass->get_by_active('contacts', ['channel', 'icon', 'value', 'link', 'note'], [1]);
		$data['contacts'] = is_array($getcontacts) ? $getcontacts : [];
		$this->view("support/contactus",$data);
	}
	
	function terms() {
		$this->page = 'terms';
		$this->metabots = 'index, follow';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
 	 	$data['page_title'] = "Terms of Use";
		$this->view("support/terms",$data);
	}
	
	function notes() {
	    $this->page = 'notes';
		$this->metabots = 'noindex, nofollow';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
 	 	$data['page_title'] = "Website Notes";
		$this->view("/notes",$data);
	}

}