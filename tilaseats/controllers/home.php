<?php

Class Home extends Controller 
{
	function index() {
		$this->page = 'homepage';
		$this->metabots = 'index, follow';
		$this->keywords = '';
		$this->description = '';
		$this->og = [
			'url'=>'',
			'title'=>'',
			'description'=>'',
			'image'=>'',
			'imagetype'=>'image/png'
		];
 	 	$data['page_title'] = "";
		  if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}
		// show($_SESSION);
		// session_destroy();
		$genclass = new General;
		$foodclass = new Food;
		$fooddata = $foodclass->select(
			"id, name, short_desc, description, amount, discount, image, imagealt, category,
			(select count(rating) from reviews where reviews.foodid=f.id) as ratingcount, 
			(select round(AVG(rating),2) from reviews where reviews.foodid=f.id) as ratingaverage, salescount", 'f'
		)->where('active=1 and featured=1 and recycle=0 order by salescount desc');
		$catdata = $genclass->get_by_active_and_featured_and_recycle('category', '*', [1,1,0]);
		//sum ratings where foodid
		$slide_images = $genclass->get_by_section_and_featured('images', ['name', 'image', 'imagealt', 'text'], ['events', 1]);
		
		$data['fooddata'] = is_array($fooddata) ? $fooddata : [];
		$data['catdata'] = is_array($catdata) ? $catdata : [];
		$data['slide_images'] = is_array($slide_images) ? $slide_images : [];
		$this->view("home",$data);
	}
}
