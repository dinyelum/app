<?php
class Food {
    use Db, Validate;
    private static $table = 'food';
    private $columns = ['id', 'name', 'short_desc', 'description', 'amount', 'discount', 'image', 'imagealt', 'active', 'featured', 'category', 'recycle'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_itemname($fields['name'], true, 'name');
        }
        if(isset($fields['short_desc'])) {
            $data['short_desc'] = $this->validate_text($fields['short_desc'], true, 'short_desc');
        }
        if(isset($fields['description'])) {
            $data['description'] = $this->validate_text($fields['description'], true, 'description');
        }
        if(isset($fields['amount'])) {
            $data['amount'] = $this->validate_number($fields['amount'], true, 'amount');
        }
        if(isset($fields['discount'])) {
            if($fields['discount'] == 0) {
                $data['discount'] = null;
            } else {
                $data['discount'] = $this->validate_number($fields['discount'], true, 'discount');
            }
        }
        if(isset($fields['image'])) {
            $data['image'] = $this->validate_filename($fields['image'], true, 'image');
            if(!isset($this->err['name']) && !isset($this->err['image'])) {
                $imagecopy = $data['image'];
                $filename = pathinfo($data['image'], PATHINFO_FILENAME);
                $fileext = pathinfo($data['image'], PATHINFO_EXTENSION);
                if(is_numeric($filename)) {
                    $data['image'] = str_replace(' ', '_', $data['name']).'_'.mt_rand(1000, 10000).".$fileext";
                    $check = $this->exists(['image'=>$data['image']], 'food');
                    if($check===true) {
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
        if(isset($fields['category'])) {
            $data['category'] = $this->validate_itemname($fields['category'], true, 'category');
        }
        if(isset($fields['submit'])) {
            if($fields['submit'] == 'Add Food') {
                if(!isset($fields['image'])) {
                    $this->err['image'] = 'Image cannot be empty';
                }
            }

            if(!isset($this->err['name']) && !isset($this->err['category'])) {
                //where name=... and category=... and not id=...;
                if($fields['submit'] == 'Add Food') {
                    $check = $this->exists(['name'=>$data['name'], 'category'=>$data['category']], 'and');
                } elseif($fields['submit'] == 'Update Food') {
                    $check = $this->select()->where('name=:name and category=:category and not id=:id', ['name'=>$data['name'], 'category'=>$data['category'], 'id'=>$data['id']]);
                } else {
                    $check = '';
                }
                if($check===true || (is_array($check) && count($check))) {
                    $this->err['name'] = $data['name'].' already exists in '.$data['category'].' category';
                }
            }

            if(!$this->err) {
                $check = $this->exists(['name'=>$data['category']], '','category');
                // var_dump($check);
                if(!$check) {
                    $genclass = new General;
                    $newcat = $genclass->create(['name'=>$data['category']], 'category');
                    if(!$newcat) {
                        $this->err['category'] = 'Error creating new category. Please try again later.';
                    }
                } 
            }
        }
        // show ([$data, $this->err]);
        return [$data, $this->err];
    }
}