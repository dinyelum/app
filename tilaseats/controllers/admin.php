<?php

Class Admin extends Controller 
{
    public $adminmode;
    private $generalclass;
    private $sections = ['orders', 'subjects', 'contacts', 'writer'];
    public $mode = ['writing', 'rewriting', 'editing'];
    public $substatus = ['Not Started', 'Awaiting Payment', 'In the works', 'Canceled', 'Completed'];
    public $allsubjects = [];

    function fetch_all_subjects() {
        $subjectclass = new Subjects;
        $subjects = $subjectclass->select('id, subject')->where('active=1');
        $this->allsubjects = is_array($subjects) ? $subjects : [];
    }

    function __construct() {
        $_SESSION['redirecturl'] = $_SERVER['REQUEST_URI'];
        $this->keywords = 'NOINDEX, NOFOLLOW';
    }

    function checkadmin() {
        $this->check_logged_in();
        $this->generalclass = new General;
        $admindata = $this->generalclass->get_by_userid_and_active('admins', ['userid', 'level'], [$_SESSION['user']['id'], 1]);
            
        if(count($admindata)) {
            $this->adminmode = true;
        }
        
        if($this->adminmode !== true) {
            header("location: ".HOME."/account/profile");
            exit;
        }
    }

	function index() {
        $this->checkadmin();
		$this->page = '';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = 'admin';
 	 	$data['page_title'] = "Admin";
		$getcount = $this->generalclass->custom_sql(
            'select count(*) as users, 
            (select count(*) from orders) as orders, 
            (select count(*) from subjects) as subjects, 
            (select count(*) from contacts) as contacts, 
            (select count(*) from writer) as writer from `user`', 'select');
		
		$data['counts'] = is_array($getcount) ? $getcount : [];
		$this->view("admin/home",$data);
	}

    function display() {
        $this->checkadmin();
		$this->page = '';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = 'admin';
 	 	$data['page_title'] = "Admin";

        if(!isset($_GET['section']) || !in_array($_GET['section'], $this->sections)) {
            exit('Invalid Parameters');
        }
        $cols = match ($_GET['section']) {
            'orders' => "id, name, mode, status, concat(currency, ' ', amount) as amount, subject, pages, DATE_FORMAT(expdate, '%a, %D %M, %Y') as expdate, clientname, writerid",
            'subjects' => "id, subject, active",
            'contacts' => "id, channel, icon, value, link, note, active",
            'writer' => "id, 
            CONCAT((select firstname from user where id=userid), ' ', (select firstname from user where id=userid)) as name, 
            (select email from user where id=userid) as email,
            (select phone from user where id=userid) as phone,
            (select subject from subjects where id=subject1) as subject1,
            (select subject from subjects where id=subject2) as subject2,
            (select subject from subjects where id=subject3) as subject3,
            (select subject from subjects where id=subject4) as subject4,
            (select subject from subjects where id=subject5) as subject5, active",
            default => '*',
        };
        $orderby = match ($_GET['section']) {
            'orders' => "order by status desc, expdate",
            'subjects' => "order by active desc, subject",
            'contacts' => "order by active desc, channel",
            'writer' => 'order by active desc, name, subject1, subject2, subject3, subject4, subject5',
            default => '',
        };
        $class = new $_GET['section'];
        $fetchdata = $class->select($cols)->all($orderby);
        $data['displaydata'] = is_array($fetchdata) ? $fetchdata : [];
		$this->view("admin/display",$data);
	}

    function process() {
        $this->checkadmin();
		$this->page = '';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = 'admin';
 	 	$data['page_title'] = "Admin";
        $actions = ['add', 'update'];
        $id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : '';
        if(
            !isset($_GET['section']) ||
            !in_array($_GET['section'], $this->sections) ||
            !isset($_GET['action']) ||
            !in_array($_GET['action'], $actions) ||
            (isset($_GET['id']) && !is_int($id))
            ) {
            exit('Invalid Parameters');
        }

        $action = $_GET['action'];
        $section = $_GET['section'];
        
        if($_GET['action'] != 'add') {
            if($section=='orders') {
                $ordersclass = new Orders;
                $fetchdata = $ordersclass->
                select('orders.*, w.id, u.firstname as writerfirstname, u.lastname as writerlastname, u.email as writeremail, u.phone as writerphone')->
                join('left join', 'writer', 'orders.writerid=w.id', 'w')->
                join('left join', 'user', 'w.userid=u.id', 'u')->
                where("orders.id=$id");
            } elseif($section=='writer') {
                $this->fetch_all_subjects();
                $writerclass = new Writer;
                $fetchdata = $writerclass->
                select('w.*, s1.subject as subject1, s2.subject as subject2, s3.subject as subject3, s4.subject as subject4, s5.subject as subject5, u.firstname as writerfirstname, u.lastname as writerlastname, u.email as writeremail, u.phone as writerphone', 'w')->
                join('left join', 'user', 'w.userid=u.id', 'u')->
                join('left join', 'subjects', 'w.subject1=s1.id', 's1')->
                join('left join', 'subjects', 'w.subject2=s2.id', 's2')->
                join('left join', 'subjects', 'w.subject3=s3.id', 's3')->
                join('left join', 'subjects', 'w.subject4=s4.id', 's4')->
                join('left join', 'subjects', 'w.subject5=s5.id', 's5')->
                where("w.id=$id");
            } else {
                $genclass = new General;
                $fetchdata = $genclass->get_by_id($section, '*', [$id]);
            }
        }
        
        if($_SERVER['REQUEST_METHOD']=='POST') {
            // show($_FILES);
            $sectionclass = new $section;
            $postdata = $sectionclass->validate(array_merge($_FILES, $_POST));
            // show($postdata);
            if(!isset($postdata[1]) || !count($postdata[1])) {
                switch ($action) {
                    case 'add':
                        $dbop = $sectionclass->insert($postdata[0]);
                        $verb = 'added';
                        break;
                    case 'update':
                        $dbop = $sectionclass->update($postdata[0])->where('id=:id', ['id'=>$id]);
                        $verb = 'updated';
                    default:
                    break;
                }
            } else {
                // $response = $response[0];
                // $data[1] = $response[1];
            }
        }

        if(isset($postdata) && isset($fetchdata)) {
            $formdata = [array_merge($fetchdata[0], $postdata[0]), $postdata[1]];
        } else {
            $formdata = $postdata ?? $fetchdata ?? [];
        }
        // show($formdata);

        if($section == 'orders') {
            $sectionclass = $sectionclass ?? new $section;
            $this->mode = $sectionclass->mode;
            $this->substatus = $sectionclass->substatus;
            $this->writers = $sectionclass->writers($formdata[0]['subject']) ?? [];
        }

		$data['formdata'] = isset($formdata) && is_array($formdata) ? $formdata : [];
        if(count($data['formdata'])) {
            $data['formdata'][0]['success'] = (isset($dbop) && $dbop===true) ? "$section $verb successfully" : null;
        }
        $data['misc'] = ['id'=>$id, 'action'=>$action, 'section'=>$section];

		$this->view("admin/process",$data);
	}
}