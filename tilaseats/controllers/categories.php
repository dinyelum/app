<?php
class Categories extends Controller {
	public $foodclass;
	public $catclass;

	function __construct() {
		$this->foodclass = new Food;
		$this->catclass = new Category;
	}

    function show() {
		$this->page = 'categories';
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
 	 	$data['page_title'] = "Categories";
		
		$id = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);
		if(is_int($id)) {
			$fooddata = $this->foodclass->select()->where("active=1 and recycle=0 and category=(select name from category where id=$id)");
			if(!is_array($fooddata) || !count($fooddata)) {
				exit('There are no contents in this category yet');
			}
		} else {
			exit('Invalid Category');
		}
		$data['fooddata'] = is_array($fooddata) ? $fooddata : [];
		$this->view("categories/show",$data);
	}

	function index() {
		$this->page = 'categories';
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
 	 	$data['page_title'] = "Categories";
		$cats = $this->foodclass->select("distinct category")->where('active=1 and recycle=0');
		$allcats = array_column($cats, 'category');
		foreach ($allcats as $ind=>$val) {
			if($ind===0) {
				$catwh = 'and (';
			}
			$catwh .= "category='$val' or ";
			if($ind===(count($allcats)-1)) {
				$catwh = trimwords($catwh, ' or ', 'last').')';
			}
		}
		$catwh = $catwh ?? '';
		$foodcolumns = "id, name, short_desc, description, amount, discount, image, imagealt, category";
		$fooddata = $this->foodclass->select($foodcolumns)->where("active=1 and featured=1 and recycle=0 $catwh order by category,name asc");
		if(!is_array($fooddata) || !count($fooddata)) {
			exit('Error fetching contents in category');
		}
		foreach($fooddata as $ind=>$val) {
			$newfooddata[$val['category']][] = $val;
		}
		$data['fooddata'] = is_array($newfooddata) ? $newfooddata : [];
		$this->view("categories/home",$data);
	}
}