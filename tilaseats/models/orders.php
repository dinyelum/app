<?php
class Orders {
    use Db, Validate;
    private static $table = 'orders';
    private $columns = ['id', 'name', 'items_summary', 'amount', 'extracharges', 'totalamount', 'locationid', 'addressid', 'riderid', 'status', 'clientid', 'instructions', 'paymentproof'];
    public $status = [
        'Not Started', 
        'Awaiting Approval', 
        'Order Approved', 
        'On the Way', 
        'Order Completed'
    ];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if($key=='id' || $key=='locationid' || $key=='addressid' || $key=='riderid' || $key=='clientid') {
                $data[$key] = $this->validate_id($fields[$key], $key);
            }
        }
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_alphanumeric($fields['name'], true, 'name');
        }
        if(isset($fields['items_summary'])) {
            $data['items_summary'] = $this->validate_text($fields['items_summary'], true, 'items_summary');
        }
        if(isset($fields['amount'])) {
            $data['amount'] = $this->validate_number($fields['amount'], true, 'amount');
        }
        //totalamount
        if(isset($fields['extracharges'])) {
            $data['extracharges'] = $this->validate_number($fields['extracharges'], true, 'extracharges');
        }
        if(isset($fields['status'])) {
            if(!in_array($fields['status'], $this->status)) {
                $this->err['status'] = 'Invalid Order Status';
            }
            $data['status'] = $this->validate_text($fields['status'], true, 'status');
        }
// paymentproof
        if(isset($fields['instructions'])) {
            $data['instructions'] = $this->validate_text($fields['instructions'], true, 'instructions');
        }
        if(isset($fields['paymentproof'])) {
            $model = ['filetype'=>'image', 'size'=>2000000];
            $model['url'] = ROOT.'/tilaseats/images/'.$fields['paymentproof']['name'];
            $this->validate_file($fields['paymentproof'], $model, 'paymentproof');
            $data['paymentproof'] = $fields['paymentproof']['name'];
        }
        // show ([$data, $this->err]);
        return [$data, $this->err];
    }
}