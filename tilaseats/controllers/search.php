<?php
class Search extends Controller {
    function index() {
		$this->page = 'search';
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
		
        if(!isset($_GET['term']) || trim($_GET['term'])=='') {
            exit('Invalid search parameters.');
        }
        $search = $_GET['term'];
        $offset = 0;
        $perpage = 10;
        $foodclass = new Food;
        $fooddata = $foodclass->select(
            "id, name, short_desc, description, amount, discount, image, imagealt, category, count(*) over() as totalcount"
            )->where(
                "(name like :name or short_desc like :short_desc or description like :description or category like :category) and active=1 and recycle=0 limit $perpage", 
                ['name'=>"%$search%", 'short_desc'=>"%$search%", 'description'=>"%$search%", 'category'=>"%$search%"]);
        // show($fooddata);
        if(is_array($fooddata) && count($fooddata)) {
            $totalpages = ceil($fooddata[0]['totalcount']/$perpage);
        }

        $data['totalpages'] = $totalpages;
        $data['perpage'] = $perpage;
        $data['search'] = $search;
		$data['fooddata'] = is_array($fooddata) ? $fooddata : [];
		$this->view("search",$data);
	}
}