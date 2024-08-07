<?php
class Orders {
    use Db, Validate;
    private static $table = 'orders';
    private $columns = ['id', 'name', 'mode', 'status', 'currency', 'amount', 'subject', 'type', 'file', 'pages', 'expdate', 'clientname', 'clientemail', 'clientphone', 'writerid', 'review', 'rating'];
    public $mode = ['writing', 'rewriting', 'editing'];
    public $substatus = [
        'Not Started', 
        'Awaiting Approval', 
        'Order Approved', 
        'On the Way', 
        'Cancelled',
        'Order Completed'
    ];
    public $status = ['Open', 'Finished'];
    public $writers = [];

    public function writers($subject='') {
        $subjectsclass = new Subjects;
        $validate = $subjectsclass->validate(['subject'=>$subject]);
        if(!isset($validate[1])) {
            $subjectid = $subjectsclass->select('id, subject')->where('subject=:subject',['subject'=>$subject]);
            if(is_array($subjectid) && count($subjectid)) {
                $writerclass = new Writer;
                return $writerdata = $writerclass->
                select('writer.*, u.firstname, u.lastname, u.email as writeremail, u.phone as writerphone')->
                join('inner join', 'user', 'writer.userid=u.id', 'u')->
                where(
                    "(subject1 = ".$subjectid[0]['id']."  || subject2 = ".$subjectid[0]['id']."  || subject3 = ".$subjectid[0]['id']."  || subject4 = ".$subjectid[0]['id']."  || subject5 = ".$subjectid[0]['id'].") and active=1 ");
            }
        }
    }

    public function validate(array $fields) {
        $data = [];
        $this->get_submitmode($fields['submit'] ?? '');
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if($key=='id' || $key=='pages') {
                $data[$key] = $this->validate_id($val, $key);
            }
        }
        if(isset($fields['writerid'])) {
            $data['writerid'] = $this->validate_id($fields['writerid'], 'writerid', false);
        }
        if(isset($fields['name'])) {
            if($this->submitmode=='insertunique') {
                $data['name'] = $this->validate_alphanumeric($fields['name'], true, 'name', true);
            } elseif($this->submitmode=='updateunique') {
                if(isset($data['id']) && !isset($this->err['id'])) {
                    $data['name'] = $this->validate_unique_text('validate_alphanumeric', [$fields['name'], true, 'name'], 'name', $data['id']);
                }
            } else {
                $this->err['gen'] = 'Error with submit mode.';
            }
        }
        if(isset($fields['mode'])) {
            if(!in_array($fields['mode'], $this->mode)) {
                $this->err['mode'] = 'Invalid Mode Selected';
            }
            $data['mode'] = $this->validate_text($fields['mode'], true, 'mode');
        }
        if(isset($fields['substatus'])) {
            if(!in_array($fields['substatus'], $this->substatus)) {
                $this->err['substatus'] = 'Invalid Order Status';
            }
            $data['substatus'] = $this->validate_text($fields['substatus'], true, 'substatus');
        }
        if(isset($fields['status'])) {
            if(!in_array($fields['status'], $this->status)) {
                $this->err['status'] = 'Invalid Order Status';
            }
            $data['status'] = $this->validate_text($fields['status'], true, 'status');
        }
        if(isset($fields['additionalnote'])) {
            $data['additionalnote'] = $this->validate_text($fields['additionalnote'], false, 'additionalnote');
        }
        if(isset($fields['currency'])) {
            $data['currency'] = $this->validate_text($fields['currency'], true, 'currency', 1, 3);
        }
        if(isset($fields['amount'])) {
            $data['amount'] = $this->validate_number($fields['amount'], true, 'amount');
        }
        if(isset($fields['subject'])) {
            $data['subject'] = $this->validate_text($fields['subject'], true, 'subject');
        }
        if(isset($fields['type'])) {
            $data['type'] = $this->validate_text($fields['type'], false, 'type');
        }
        if(isset($fields['clientname'])) {
            $data['clientname'] = $this->validate_text($fields['clientname'], true, 'clientname');
        }
        if(isset($fields['clientemail'])) {
            $data['clientemail'] = $this->validate_email($fields['clientemail'], true, false, 'clientemail');
        }
        if(isset($fields['clientphone'])) {
            $data['clientphone'] = $this->validate_phone($fields['clientphone'], true, true, 'clientphone');
        }
        if(isset($fields['expdate'])) {
            $data['expdate'] = $this->validate_date($fields['expdate'], true, 'expdate');
        }
        if(isset($fields['file'])) {
            $rename = $data['name'].'_client_'.date('d_m_y', strtotime('today')).'_'.$fields['file']['name'];
            $this->mix_file_formats(['image', 'document']);
            $model = ['filetype'=>'mixed', 'size'=>50000000];
            $model['url'] = UPLOAD_ROOT.'/assignments/'.$rename;
            $this->validate_file($fields['file'], $model, true, 'file');
            $data['file'] = $rename;
        }
        if(isset($fields['finishedwork'])) {
            $rename = $data['name'].'_finished_'.date('d_m_y', strtotime('today')).'_'.$fields['finishedwork']['name'];
            $this->mix_file_formats(['image', 'document']);
            $model = ['filetype'=>'mixed', 'size'=>50000000];
            $model['url'] = UPLOAD_ROOT.'/assignments/'.$rename;
            $this->validate_file($fields['finishedwork'], $model, false,'finishedwork');
            if($fields['finishedwork']['name']) {
                $data['finishedwork'] = $rename;
            }
        }
        if(isset($fields['rating'])) {
            $data['rating'] = $this->validate_number($fields['rating'], true, 'rating');
        }
        if(isset($fields['review'])) {
            $data['review'] = $this->validate_text($fields['review'], false, 'review');
        }
         //show ([$data, $this->err]);
        return [$data, $this->err];
    }
}