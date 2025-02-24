<?php
class Cart extends Controller {
    function Index() {
		$this->page = 'Cart';
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
 	 	$data['page_title'] = "Cart";
		if(isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart'])) {
			$whq = '';
			foreach($_SESSION['cart'] as $val) {
				if(!is_int($val)) {
					exit('Error fetching cart items');
				}
				$whq .= "id = $val or ";
			}
			$whq = trimwords($whq, 'or', 'last');
			$foodclass = new Food;
			$fooddata = $foodclass->select('id, name, short_desc, image, imagealt, amount, discount')->where($whq);
		}
		$locationclass = new Location;
		$locationdata = $locationclass->select('id, name, deliverycharge')->all();
		// show($locationdata);
		$data['fooddata'] = is_array($fooddata) ? $fooddata : [];
		$data['locationdata'] = is_array($locationdata) ? $locationdata : [];
        $this->view("cart",$data);
	}
}