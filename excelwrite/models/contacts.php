<?php
class Contacts {
    use Db, Validate;
    private static $table = 'contacts';
    private $columns = ['id', 'channel', 'icon', 'value', 'link', 'note', 'active'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id'], 'id');
        }
        
        if(isset($fields['channel'])) {
            // $data['channel'] = $this->validate_name($fields['channel'], true, 'channel');
            if($this->submitmode=='insertunique') {
                $data['channel'] = $this->validate_unique_text('validate_text', [$fields['channel'], true, 'channel'], 'channel');
            } elseif($this->submitmode=='updateunique') {
                if(isset($data['id']) && !isset($this->err['id'])) {
                    $data['channel'] = $this->validate_unique_text('validate_text', [$fields['channel'], true, 'channel'], 'channel', $data['id']);
                }
            } else {}
        }

        foreach ($fields as $key => $val) {
            if($key=='icon' || $key=='note') {
                $data[$key] = $this->validate_text($fields[$key], true, $key);
            }
        }
        
        if(isset($fields['value'])) {
            if(isset($fields['channel']) && strtolower($fields['channel'])=='email') {
                $data['value'] = $this->validate_email($fields['value'], true, true, 'value');
            } elseif(strtolower($fields['channel'])=='phone' || strtolower($fields['channel'])=='whatsapp') {
                $data['value'] = $this->validate_phone($fields['value'], true, true, 'value');
            } else {
                $data['value'] = $this->validate_text($fields['value'], true, 'value');
            }
        }

        if(isset($fields['link'])) {
            $data['link'] = $this->validate_link($fields['link'], false, 'link', FILTER_FLAG_PATH_REQUIRED);
        }

        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], true, 'active');
        }
        return [$data, $this->err];
    }
}