<?php

Class Home extends Controller 
{
	function index() {
		$this->page = 'homepage';
		$this->metabots = 'index, follow';
		$this->keywords = 'assignment help, writing help, homework help, online assignment help, best assignment service, assignment making service, finance assignment help, university assignment online, project writing assistance, essay assignment, expert assignment service, buy online assignment';
		$this->description = 'An assignment writing website that guarantees top grades. Get quality help online for your assignments, projects, thesis, term papers etc from our expert assignment writers across various professions and at affordable prices.';
		$this->og = [
			'url'=>'',
			'title'=>'The Best Assignment Writing Service',
			'description'=>'Get top-notch assistance for your assignments from our team of professionals.',
			'image'=>'https://excelwrite.com/assets/images/logo-socials.png',
			'imagetype'=>'image/png'
		];
		$this->style = '';
		$this->displayheadermenu = 'home';
 	 	$data['page_title'] = "The Best Assignment Writing Service";
		$generalclass = new General;
		$ordersclass = new Orders;
		$getsubjects = $generalclass->get_by_active('subjects', ['subject'], [1], 'order by subject');
		$getreviews = $ordersclass->custom_query(
			"select id, subject, type, pages, review, rating, date, deadline from (
			select id, subject, type, pages, review, rating, DATE_FORMAT(expdate, '%D %M, %Y') as date, @days := HOUR(TIMEDIFF(expdate, regdate)) DIV 24, (
			CASE
			when @days<1 THEN CONCAT(@days, ' hours')
			WHEN @days=1 THEN CONCAT(@days, ' day') ELSE 
			CONCAT(@days, ' days') END) as deadline FROM `orders`  where rating >= 3 and review != '' order by expdate desc limit 9) as subset;");
		$data['subjects'] = is_array($getsubjects) ? array_chunk(array_column($getsubjects, 'subject'), ceil(count($getsubjects)/4)) : ['subject'=>''];
		$allreviews = is_array($getreviews) ? $getreviews : [];
		$data['reviews'] = array_chunk($allreviews, 3);
		$this->view("home",$data);
	}
}
/*
ceil(count($getsubjects)/4) is
an attempt at making sure list items have the same number of rows on all screen sizes without 
having to echo the list items multiple times for differnt screen sizes. There's 
already CSS grid auto auto dividing the list items in two and two foreach making sure batch A starts at A 
and batch B starts somewhere in the middle.
For a later increased number of list items(20 list items currently gives me 5555 on big screens and 1010 on small screens), you can adjust the number 4, to any other numer till it suits what you want.
The mobile view meanwhile will always have two columns of equal / almost equal length.
*/
