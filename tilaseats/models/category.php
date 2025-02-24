<?php
class Category {
    use Db, Validate;
    private static $table = 'category';
    private $columns = ['id', 'name', 'image', 'imagealt', 'active', 'featured', 'recycle'];

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
                if(is_numeric($filename) && file_exists($imagecopy)) {
                    $data['image'] = str_replace(' ', '_', $data['name']).'_'.mt_rand(1000, 10000).".$fileext";
                    $check = $this->exists(['image'=>$data['image']], 'food');
                    if($check) {
                        $data['image'] = str_replace(' ', '_', $data['name']).'_'."$filename.$fileext";
                    }
                    rename($imagecopy, '../images/'.$data['image']);
                }
            }
        }
        if(isset($fields['imagealt'])) {
            $data['imagealt'] = $this->validate_text($fields['imagealt'], true, 'imagealt');
        }
        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], true, 'active');
        }
        if(isset($fields['featured'])) {
            $data['featured'] = $this->validate_toggle($fields['featured'], true, 'featured');
        }
        if(isset($fields['recycle'])) {
            $data['recycle'] = $this->validate_toggle($fields['recycle'], true, 'recycle');
        }
        if(isset($fields['submit'])) {
            if($fields['submit'] == 'Add Category') {
                if(!isset($fields['image'])) {
                    $this->err['image'] = 'Image cannot be empty';
                }
            }

            if(!isset($this->err['name'])) {
                if($fields['submit'] == 'Add Category') {
                    $check = $this->exists(['name'=>$data['name']]);
                } elseif($fields['submit'] == 'Update Category') {
                    $check = $this->exists(['name'=>$data['name'], 'id'=>$data['id']], 'and not');
                } else {
                    $check = '';
                }
                if($check) {
                    $this->err['name'] = 'This category already exists.';
                }
                //where name=... and category=... and not id=...;
            }
        }
        return [$data, $this->err];
    }
}