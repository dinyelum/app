<?php
class Images {
    use Db, Validate;
    private static $table = 'images';
    private $columns = ['id', 'name', 'image', 'imagealt', 'text', 'section', 'featured'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_itemname($fields['name'], true, 'name');
        }
        if(isset($fields['image'])) {
            $data['image'] = $this->validate_filename($fields['image'], true, 'image');
            if(!isset($this->err['name']) && !isset($this->err['image'])) {
                $imagecopy = $data['image'];
                $filename = pathinfo($data['image'], PATHINFO_FILENAME);
                $fileext = pathinfo($data['image'], PATHINFO_EXTENSION);
                if(is_numeric($filename)) {
                    $data['image'] = strtolower(str_replace(' ', '_', $data['name'])).'_'.mt_rand(1000, 10000).".$fileext";
                    $check = $this->exists(['image'=>$data['image']], 'food');
                    if($check===true) {
                        $data['image'] = strtolower(str_replace(' ', '_', $data['name'])).'_'."$filename.$fileext";
                    }
                    rename($imagecopy, '../images/'.$data['image']);
                }
            }
        }
        if(isset($fields['imagealt'])) {
            $data['imagealt'] = $this->validate_text($fields['imagealt'], true, 'imagealt');
        }
        if(isset($fields['text'])) {
            $data['text'] = $this->validate_text($fields['text'], false, 'text');
        }
        if(isset($fields['section'])) {
            $data['section'] = $this->validate_alphanumeric($fields['section'], true, 'section');
        }
        if(isset($fields['featured'])) {
            $data['featured'] = $this->validate_toggle($fields['featured'], true, 'featured');
        }
        if(isset($fields['submit'])) {
            if($fields['submit'] == 'Add Images') {
                if(!isset($fields['image'])) {
                    $this->err['image'] = 'Image cannot be empty';
                }
            }
            if(!isset($this->err['name'])) {
                if($fields['submit'] == 'Add Images') {
                    $check = $this->exists(['name'=>$data['name']]);
                } elseif($fields['submit'] == 'Update Images') {
                    $check = $this->select()->where('name=:name and not id=:id', ['name'=>$data['name'], 'id'=>$data['id']]);
                } else {
                    $check = '';
                }
                if($check===true || (is_array($check) && count($check))) {
                    $this->err['name'] = $data['name'].' already exists';
                }
            }
        }
        return [$data, $this->err];
    }
}