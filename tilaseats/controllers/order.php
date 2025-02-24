<?php
class Order extends Controller {
    function __construct() {

    }
    function index($adminmode=false) {
		$this->page = 'order';
		$this->metabots = 'noindex, nofollow';
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
        date_default_timezone_set('Africa/Lagos');
        $orderclass = new Orders;
        $genclass = new General;

        $foodids = [];
        $foodwh = $order_summary = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(count($_POST) <= 1) {
                exit("Something isn't right with the contents of your order.");
            }
            if(!isset($_POST['location']) || trim($_POST['location'])=='') {
                exit("Select Location.");
            }
            // $foodqty = [];
            $foodidqty = $_POST;
            foreach ($_POST as $key => $val) {
                // $val = filter_var($val, FILTER_VALIDATE_INT);
                // var_dump($val);
                if(is_int($key) && filter_var($val, FILTER_VALIDATE_INT) != false) {
                    $foodids[] = $key;
                    // $foodqty[] = $val;
                    $foodwh .= 'id_or_';
                    $order_summary .= $key.'_'.$val.',';
                } elseif($key == 'location') {
                    $locationdata = $genclass->get_by_name('location', ['id', 'name', 'homedelivery', 'deliverycharge'], [$val]);
                    // show($locationdata);
                    // var_dump($val);
                } else {
                    exit('Problem with data received from Cart');
                }
            }

            $foodwh = 'get_by_'.trimwords($foodwh, '_or_', 'last');
            $fooddata = $genclass->$foodwh('food', ['id', 'name', 'short_desc', 'amount', 'discount'], $foodids);
            $amount = 0;
            foreach ($fooddata as $key => $val) {
                $id = $val['id'];
                $amount += ($val['discount'] ?? $val['amount'])*$foodidqty[$id];
            }
            //echo $amount;
            $order_summary = rtrim($order_summary, ',');
            if(isset($_SESSION['order']['name']) && $_SESSION['order']['name'] != '' &&
            isset($_SESSION['order']['items_summary']) && $_SESSION['order']['items_summary'] == $order_summary
            ) {
                $orderdata = $orderclass->select()->where('name=:name',['name'=>$_SESSION['order']['name']]);
                if(is_array($orderdata) && count($orderdata)) {
                    // echo 'yes';
                } else {
                    // echo 'unset session';
                    unset($_SESSION['order']);
                    //refresh
                    //or try elseif(!isset($_SESSION['order']['name']) || $_SESSION['order']['name'] == '')
                }
            } else {
                $order['name'] = strtoupper(bin2hex(random_bytes(5)));
                $ordercheck = $orderclass->exists(['name'=>$order['name']]);
                if($ordercheck===true) {
                    $order['name'].time();
                }
                $order['items_summary'] = $order_summary;
                $order['status'] = 'Not Started';
                $order['amount'] = $amount;
                $order['extracharges'] = $locationdata[0]['deliverycharge'];
                $order['totalamount'] = $order['amount'] + $order['extracharges'];
                $order['locationid'] = $locationdata[0]['id'];
                $order['clientid'] = $_SESSION['user']['id'];
                $orderdata = $orderclass->insert($order, true);
                if(is_array($orderdata) && count($orderdata)) {
                    $order['regdate'] = date('l, jS F, Y h:i:s A');
                    $_SESSION['order']['name'] = $order['name'];
                    $_SESSION['order']['items_summary'] = $order_summary;
                } else {
                    exit('Error creating order. Please referesh this page or try again later.');
                }
                $data['order'] = $order;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $orderid = filter_input(INPUT_GET, 'orderid', FILTER_VALIDATE_INT);
            if(!is_int($orderid)) {
                exit('Problem with Order id');
            }
            if($adminmode) {
                $orderdata = $orderclass->select('*', 'o')->join('inner join', 'address', 'o.addressid=a.id', 'a')->where('o.id=:id', ['id'=>$orderid]);
                show($orderdata);
            } else {
                $orderdata = $orderclass->select()->where('id=:id and clientid=:clientid', ['id'=>$orderid, 'clientid'=>$_SESSION['user']['id']]);
            }
            if(is_array($orderdata) && count($orderdata)) {
                $itemsarr = explode(',',$orderdata[0]['items_summary']);
                foreach ($itemsarr as $val) {
                    $idandqty = explode('_', $val);
                    $foodids[] = $idandqty[0];
                    $foodidqty[$idandqty[0]] = $idandqty[1];
                    $foodwh .= 'id_or_';
                }
                $locationdata = $genclass->get_by_id('location', ['id', 'name', 'homedelivery', 'deliverycharge'], [$orderdata[0]['locationid']]);
            } else {
                exit('Order Id doesn\'t exist.');
            }
            $data['order'] = $orderdata[0];
            $foodwh = 'get_by_'.trimwords($foodwh, '_or_', 'last');
            $fooddata = $genclass->$foodwh('food', ['id', 'name', 'short_desc', 'amount', 'discount'], $foodids);
        } else {}
        // show($foodidqty);
        //$display = $orderdata[0];
        $acctsdata = $genclass->get_all_name('acctdetails', ['acctname', 'acctnumber', 'bank']);
        $addressdata = $genclass->get_by_clientid_and_locationid('address', ['id','address'], [$_SESSION['user']['id'], $locationdata[0]['id']]);
        foreach ($fooddata as $key => $val) {
            $id = $val['id'];
            $fooddata[$key]['qty'] = $foodidqty[$id];
        }
        //show($acctsdata);
        
		$data['acctsdata'] = is_array($acctsdata) ? $acctsdata : [];
        $data['locationdata'] = is_array($locationdata) ? $locationdata[0] : [];
        $data['addressdata'] = is_array($addressdata) ? $addressdata[0] : [];
        $data['fooddata'] = is_array($fooddata) ? $fooddata : [];
        $data['adminmode'] = $adminmode;
		$this->view("order",$data);
	}
}