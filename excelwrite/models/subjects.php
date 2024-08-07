<?php
class Subjects {
    use Db, Validate;
    private static $table = 'subjects';
    private $columns = ['id', 'subject', 'active'];

    public function validate(array $fields) {
        $data = [];
        $this->get_submitmode($fields['submit'] ?? '');
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id'], 'id');
        }
        if(isset($fields['subject'])) {
            // $data['subject'] = $this->validate_text($fields['subject'], true, 'subject');
            if($this->submitmode=='insertunique') {
                $data['subject'] = $this->validate_unique_text('validate_text', [$fields['subject'], true, 'subject'], 'subject');
            } elseif($this->submitmode=='updateunique') {
                if(isset($data['id']) && !isset($this->err['id'])) {
                    $data['subject'] = $this->validate_unique_text('validate_text', [$fields['subject'], true, 'subject'], 'subject', $data['id']);
                }
            } else {
                //$data['subject'] = $this->validate_text($fields['subject'], true, 'subject');
            }
        }
        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], true, 'active');
        }
        return [$data, $this->err];
    }
}