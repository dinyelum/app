<?php

Class Account extends Controller {
	public $sessionparams = 'id, firstname, lastname, email, phone, emailactive, phoneactive, writer';
	function index() {
	    $data['page_title'] = "Error";
	    $this->view("404",$data);
	}
	
	function login() {
		$redirecturl = $_SESSION['redirecturl'] ?? '../account/profile';
		if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true) {
			header("location: $redirecturl");
			exit;
		}
		$this->page = 'login';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = false;
 	 	$data['page_title'] = "Login";
 	 	
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$generalclass = new General;
			$data['formdata'] = $generalclass->login($_POST, 'user', $this->sessionparams);
			if($data['formdata']===true) {
				if(isset($_SESSION['user']['emailactive']) && $_SESSION['user']['emailactive'] == 1) {
					header("location: $redirecturl");
					exit;
				} else {
					$data['formdata'] = [];
					$data['formdata'][0] = ['email'=>$_SESSION['user']['email']];
					$data['formdata'][1]['emailactive'] = "Kindly check your inbox / spam folder to activate your account. Didn't receive any activation link? <span id=resend class=clickable onclick='resendMail()' style='text-decoration: underline'>Resend</span>.";
					//resend email
					unset($_SESSION['user']['logged_in']);
				}
			}
		}

		$this->view("account/login",$data);
	}

	function signup() {
		$this->page = 'signup';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = false;
 	 	$data['page_title'] = "Sign Up";
 	 	
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$hash = $_POST['hash'] = sha1(mt_rand(1000, 10000));
			$generalclass = new General;
			if(isset($_POST['writer']) && $_POST['writer'] == 1) {
				$userclass = new User;
				$data['formdata'] = $userclass->validate($_POST);
				if(!isset($data['formdata'][1]) || !count($data['formdata'][1])) {
					$trarr = [
						'user'=>[
							'insert'=>[$data['formdata'][0], $this->sessionparams], 
							'setvariable'=>[['lastinsid'=>'LAST_INSERT_ID()']]
						], 
						'writer'=>[
							'custom_query'=>['insert into writer (userid) values (@lastinsid)', 'insert'], 
							]
						];
					
					$value = $userclass->transaction($trarr);
					$value = array_merge([], ...$value);

					if(is_array($value) && count($value)) {
						foreach ($value[0] as $key => $val) {
							$_SESSION['user'][$key] = $val;
						}
						$data['formdata'] = true;
						$email = $_SESSION['user']['email'];
        				$firstname = $_SESSION['user']['firstname'];
        				$phone = $_SESSION['user']['phone'];
        				$message['subject'] = 'New Writer Registration';
        				$message['body'] = 
"<p>Hello Admin,<br>
This is to notify you about a new writer that just registered on your website.</p>
<p>
Name: $firstname<br>
Email Address: $email<br>
Phone Number: $phone<br>
</p>

<p>You can contact him / her or view more details via the admin dashboard:<br>
https://excelwrite.com/admin</p>

<p>Best Regards.</p>";
                        $message['alt'] = "Hello Admin, this is to notify you about a new writer that just registered on your website. Name: $firstname Email Address: $email Phone Number: $phone You can contact him / her or view more details via the admin dashboard: https://excelwrite.com/admin
                        Best Regards.";
        				$from = [
        				    'email'=>ENV['EMAIL_NOREPLY'],
        				    'password'=>ENV['EMAIL_NOREPLY_PASS']
        				    ];
        				$receiver['email'] = ENV['ADMIN_EMAIL_1'];
        				$receiver['bcc'] = [ENV['ADMIN_EMAIL_2']];
        				$generalclass->sendmail($receiver, $message, $from);
        				$receiver = [];
					} elseif($value===null) {
						$data['formdata'][1]['gen'] = 'An error occurred. Please try again later or contact us if the error persists.';
					} else {}
				}
			} else {
				$data['formdata'] = $generalclass->create($_POST, 'user', $this->sessionparams);
			}
			
			if($data['formdata']===true) {
				$data['formdata'] = [];
				$data['formdata'][1]['success'] = 'Registration Successful. Kindly check your mail '.$_SESSION['user']['email'].' for the activation link';
				$email = $receiver['email'] = $_SESSION['user']['email'];
				$firstname = $_SESSION['user']['firstname'];
				$message['subject'] = 'ExcelWrite Account Verification';
				$message['body'] = 
"<p>Hello $firstname,<br>
Thank you for signing up!</p>

<p>Please click the link below to activate your account:<br>
https://excelwrite.com/account/verify?email=$email&hash=$hash</p>

<p>Best Regards.</p>";
                $message['alt'] = "Hello $firstname, Thank you for signing up! Please click the link below to activate your account: https://excelwrite.com/account/verify?email=$email&hash=$hash 
                Best Regards.";
				$from = [
				    'email'=>ENV['EMAIL_NOREPLY'],
				    'password'=>ENV['EMAIL_NOREPLY_PASS']
				    ];
				$generalclass->sendmail($receiver, $message, $from);
			}
		}

		$this->view("account/signup",$data);
	}

	function forgot() {
		$this->page = 'forgot';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = false;
 	 	$data['page_title'] = "Forgot Password";
 	 	
		if($_SERVER['REQUEST_METHOD']=='POST') {
		    $data['formdata'] = [];
			$generalclass = new General;
			$data['formdata'] = $generalclass->get_by_email('user', ['firstname', 'email', 'hash'], [$_POST['email']]);
			if(is_array($data['formdata'][0]) && count($data['formdata'][0]) && (!isset($data['formdata'][1]) || !count($data['formdata'][1]))) {
				$email = $receiver['email'] = $data['formdata'][0]['email'];
				$firstname = $data['formdata'][0]['firstname'];
				$hash = $data['formdata'][0]['hash'];
				$message['subject'] = 'ExcelWrite Password Reset';
				$message['body'] = 
"<p>Hello $firstname,<br>
Thank you for signing up!</p>

<p>Please click the link below to reset your password: <br>
https://excelwrite.com/account/reset?email=$email&hash=$hash</p>

<p>Best Regards.</p>";
                $message['alt'] = "Hello $firstname, Thank you for signing up! Please click the link below to activate your account: https://excelwrite.com/account/verify?email=$email&hash=$hash 
                Best Regards.";
				$from = [
				    'email'=>ENV['EMAIL_NOREPLY'],
				    'password'=>ENV['EMAIL_NOREPLY_PASS']
				    ];
				$sendmail = $generalclass->sendmail($receiver, $message, $from);
				if($sendmail) {
				    $data['formdata'][1]['success'] = "Successful!. Kindly check your mail $email for the password reset link";
				} else {
				    $data['formdata'][1]['gen'] = "Email wasn't sent successfully. Please try again later.";
				}
			} else {
			    $data['formdata'][1]['gen'] = $data['formdata'][1]['gen'] ?? $data['formdata'][1]['gen'] ?? "An unknown error occurred.";
			}
		}

		$this->view("account/forgot",$data);
	}

	function verify() {
		$this->page = 'forgot';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = false;
 	 	$data['page_title'] = "Forgot Password";
 	 	
		if(
		    isset($_GET['email']) && trim($_GET['email']) != '' && 
		    isset($_GET['hash']) && trim($_GET['hash']) != '') {
		        
			$generalclass = new General;
			$data['formdata'] = $generalclass->get_by_email_and_hash_and_emailactive('user', ['firstname', 'email'], [$_GET['email'], $_GET['hash'], 0]);
			if(isset($data['formdata'][0]) && count($data['formdata'][0]) && (!isset($data['formdata'][1]) || !count($data['formdata'][1]))) {
			    $update = $generalclass->update_by_email('user', ['emailactive'=>1, 'hash'=>sha1(mt_rand(1000, 10000))], [$_GET['email']]);
			    if($update === true) {
			        header('location: '.HOME.'/account/login');
			    } else {
			        echo 'Looks like something went wrong.';
			    }
			    exit;
			} else {
			    echo 'Account has already been activated or the URL is invalid.';
			    exit;
			}
		}
	}

	function reset() {
		$this->page = 'reset';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = false;
 	 	$data['page_title'] = "Password Reset";
 	 	
		if($_SERVER['REQUEST_METHOD']=='POST') {
		    $_POST['hash'] = sha1(mt_rand(1000, 10000));
		    $_POST['emailactive'] = 1;
			$userclass = new User;
			$data['formdata'] = $userclass->validate($_POST);
			//show($data['formdata']);exit;
			if(!isset($data['formdata'][1]) || !count($data['formdata'][1])) {
			    $email = $_SESSION['user']['email'];
			    $update = $userclass->update($data['formdata'][0])->where("email='$email'");
			    
			    if($update === true) {
    			    unset($_SESSION['user']['emailhash']);
    				header('location: '.HOME.'/account/login');
    				exit;
    			} else {
    			    $data['formdata'][1]['gen'] = 'Looks like something went wrong.';
    			}
			} else {
			    $data['formdata'][1]['gen'] = $data['formdata'][1]['password'] ?? $data['formdata'][1]['confirmpassword'] ?? $data['formdata'][1]['gen'] ?? '';
			}
			//$update = $generalclass->update_by_email('user', ['password'=>$_POST['password'], 'hash'=>$_POST['hash']], [$_POST['email']]);
		} else {
		    if(
		    isset($_GET['email']) && trim($_GET['email']) != '' && 
		    isset($_GET['hash']) && trim($_GET['hash']) != '') {
		        $generalclass = new General;
    			$data['formdata'] = $generalclass->get_by_email_and_hash('user', ['email'], [$_GET['email'], $_GET['hash']]);
    			if(isset($data['formdata'][0]) && count($data['formdata'][0]) && (!isset($data['formdata'][1]) || !count($data['formdata'][1]))) {
    			    
    			    $_SESSION['user']['emailhash'] = 1;
    			    $_SESSION['user']['email'] = $data['formdata'][0]['email'];
    			    
    			} else {
    			    $_SESSION['user']['emailhash'] = 0;
    			}
		    }
		}

		$this->view("account/reset",$data);
	}

	function profile() {
	    $this->check_logged_in();
		$this->page = 'profile';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$data = $_SESSION['user'] ?? [];
		$this->displayheadermenu = 'profile';
 	 	$data['page_title'] = "My Profile";
		
		if($_SESSION['user']['writer'] == 1) {
			$data['writer'] = [];
			$writerclass = new Writer;
			$getsubjects = $writerclass->select(
				'subject1, (select subject from subjects where id=subject1) as name1, 
				subject2, (select subject from subjects where id=subject2) as name2, 
				subject3, (select subject from subjects where id=subject3) as name3, 
				subject4, (select subject from subjects where id=subject4) as name4, 
				subject5, (select subject from subjects where id=subject5) as name5'
			)->where('userid='.$_SESSION['user']['id']);

			if(is_array($getsubjects) && count($getsubjects)) {
				$groupdata = array_chunk($getsubjects[0], 2);
				$data['writer']['subjects'] = array_column($groupdata, 0);
			} else {
				$data['writer']['subjects'] = [];
			}
			// show($data['writer']['subjects']);

			$subjectsclass = new Subjects;
			$getallsubjects = $subjectsclass->select('id, subject')->where('active=1 order by subject');
			$data['writer']['allsubjects'] = is_array($getallsubjects) ? $getallsubjects : [];
			$data['writer']['allsubjectscount'] = count($data['writer']['allsubjects']);
		}

		if($_SERVER['REQUEST_METHOD']=='POST') {
			
			if(isset($_POST['email'])) {
				unset($_POST);
			}
			if(isset($_SESSION['user']['writer']) && $_SESSION['user']['writer']==1) {
				$subjects = ['subject1', 'subject2', 'subject3', 'subject4', 'subject5'];
				foreach($subjects as $val) {
					if(!isset($_POST[$val])) {
						$_POST[$val] = 0;
					}
				}
				$userclass = new User;
				$writerclass = new Writer;
				$userdata = $userclass->validate($_POST);
				$writerdata = $writerclass->validate($_POST);
				$data['formdata'][0] = array_merge($userdata[0], $writerdata[0]);
				if(!isset($userdata[1]) && !isset($writerdata[1])) {
					$trarr = [
						'user'=>[
							'update'=>[$userdata[0]], 
							'where'=>['id='.$_SESSION['user']['id']]
						], 
						'writer'=>[
							'update'=>[$writerdata[0]], 
							'where'=>['userid='.$_SESSION['user']['id']]
							]
						];
					
					$value = $userclass->transaction($trarr);

					if(is_array($value)) {
						// && / if count($value)
						$data['formdata'] = true;
					} elseif($value===null) {
						$data['formdata'][1]['gen'] = 'An error occurred. Please try again later or contact us if the error persists.';
					} else {}
				} else {
					$data['formdata'][1] = array_merge($userdata[1] ?? [], $writerdata[1] ?? []);
				}
			} else {
				$generalclass = new General;
				$data['formdata'] = $generalclass->update_by_id('user', $_POST, [$_SESSION['user']['id']]);
			}
			
			if($data['formdata']===true) {
				$data['formdata'] = [];
				$data['formdata'][1]['success'] = 'Update Successful.';
				$_SESSION['user']['firstname'] = $_POST['firstname'];
				$_SESSION['user']['lastname'] = $_POST['lastname'];
				$_SESSION['user']['phone'] = $_POST['phone'];
				$_SESSION['user']['fullname'] = $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];
			}
		}
		$this->view("account/profile",$data);
	}
		
	

	function orders() {
	    $this->check_logged_in();
		$this->page = 'orders';
		$this->keywords = '';
		$this->description = '';
		$this->og = [];
		$this->style = '';
		$this->displayheadermenu = 'profile';
 	 	$data['page_title'] = "My Orders";
		$orderclass = new Orders;
		$limitperpage = 5;
		// SELECT name, subject, status, expdate, count(*) over() as ordercount, (select count(*) from orders where status != 'completed' and  status != 'cancelled') as opencount, (select count(*) from orders where status = 'completed' or  status = 'cancelled') as completedcount FROM `orders` WHERE clientemail='chyjohn777@gmail.com'
		$data['order_details'] = $orderclass->select(
			"id, name, subject, substatus, status, DATE_FORMAT(expdate, '%a, %D %M, %Y') as expdate, count(*) over() as ordercount, (select count(*) from orders where status = 'open') as opencount, (select count(*) from orders where status = 'finished') as completedcount"
			)->where("clientemail='".$_SESSION['user']['email']."' order by regdate desc limit $limitperpage");
		$data['filtered_order_details'] = $orderclass->custom_query(
			"WITH added_row_number AS (
				SELECT
				id, name, subject, substatus, status, DATE_FORMAT(expdate, '%a, %D %M, %Y') as expdate, clientemail,
				  ROW_NUMBER() OVER(PARTITION BY status order by regdate desc) AS row_number
				FROM orders
			  )
			  SELECT
				*
			  FROM added_row_number
			  WHERE row_number <= $limitperpage AND clientemail='".$_SESSION['user']['email']."';", 'select');
		/*
		SELECT *
		FROM (
		 SELECT
			 *,
			 ROW_NUMBER() OVER (PARTITION BY user_id 
			 ORDER BY start_date ASC) AS row_number
		 FROM your_table
		) t
		WHERE t.row_number = 1
		*/
			// show($data['filtered_order_details']);
		if(is_array($data['order_details']) && count($data['order_details'])) {
			$data['limitperpage'] = $limitperpage;
			$data['allpagecount'] = ceil($data['order_details'][0]['ordercount'] / $limitperpage);
			$data['openpagecount'] = ceil($data['order_details'][0]['opencount'] / $limitperpage);
			$data['completedpagecount'] = ceil($data['order_details'][0]['completedcount'] / $limitperpage);
		}

		if(isset($_SESSION['user']['writer']) && $_SESSION['user']['writer']==1) {
			$data['writer']['order_details'] = $orderclass->select(
				"id, name, subject, substatus, status, DATE_FORMAT(expdate, '%a, %D %M, %Y') as expdate, count(*) over() as ordercount, (select count(*) from orders where status = 'open' and writerid=(select id from writer where userid=1)) as opencount, (select count(*) from orders where status = 'finished' and writerid=(select id from writer where userid=1)) as completedcount"
				)->where("writerid=(select id from writer where userid=".$_SESSION['user']['id'].") order by regdate desc limit $limitperpage");
			$data['writer']['filtered_order_details'] = $orderclass->custom_query(
				"WITH added_row_number AS (
					SELECT
					id, name, subject, substatus, status, DATE_FORMAT(expdate, '%a, %D %M, %Y') as expdate, writerid,
					  ROW_NUMBER() OVER(PARTITION BY status order by regdate desc) AS row_number
					FROM orders
				  )
				  SELECT
					*
				  FROM added_row_number
				  WHERE row_number <= $limitperpage AND writerid=(select id from writer where userid=".$_SESSION['user']['id'].")", 'select');

			if(is_array($data['writer']['order_details']) && count($data['writer']['order_details'])) {
				$data['writer']['limitperpage'] = $limitperpage;
				$data['writer']['allpagecount'] = ceil($data['writer']['order_details'][0]['ordercount'] / $limitperpage);
				$data['writer']['openpagecount'] = ceil($data['writer']['order_details'][0]['opencount'] / $limitperpage);
				$data['writer']['completedpagecount'] = ceil($data['writer']['order_details'][0]['completedcount'] / $limitperpage);
			}
		}
		// show($data['writer']);
		$this->view("account/orders",$data);
	}

	function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['redirecturl']);
		header("location: ".HOME);
		exit;
	}
}