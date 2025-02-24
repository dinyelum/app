<?php
class Bookies {
    use db, validate;
    protected static $table = 'bookies';
    protected $columns = ['id', 'bookie', 'description_en', 'description_fr', 'description_es', 'description_pt', 'description_de', 'reflink', 'promocode', 'dashboard', 'active', 'homepage', 'countries'];
    //betwinneraffiliates.com https://melbetaffiliates.com
    /*
    create table bookies (
        id int(6) unsigned primary key auto_increment,
        bookie varchar(10) not null, 
        description_en varchar(100) not null, 
        description_fr varchar(100) not null, 
        description_es varchar(100) not null, 
        description_pt varchar(100) not null, 
        description_de varchar(100) not null, 
        reflink varchar(150) not null, 
        dashboard varchar(150) not null, 
        promocode varchar(10) not null default 'BETAGAMERS',
        active tinyint(1) default 0,
        homepage tinyint(1) default 0,
        countries varchar(100) not null default 'ALL',
        regdate datetime default CURRENT_TIMESTAMP
    )
    */

    
    public function get_allbookies() {
        return $this->select('bookie, countries')->all();
    }

    public function validate(array $fields) {
        $data = [];
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['bookie'])) {
            if(in_array($fields['bookie'], $this->insertunique)) {
                $data['bookie'] = $this->validate_unique_text('validate_alphanumeric', [$fields['bookie']], 'bookie');
            } else {
                $data['bookie'] = $this->validate_alphanumeric($fields['bookie'], fieldname:'bookie');
            }
        }

        if(isset($fields['description_en'])) {
            $data['description_en'] = $this->validate_text($fields['description_en'], fieldname:'description_en');
        }

        if(isset($fields['description_fr'])) {
            $data['description_fr'] = $this->validate_text($fields['description_fr'], fieldname:'description_fr');
        }

        if(isset($fields['description_es'])) {
            $data['description_es'] = $this->validate_text($fields['description_es'], fieldname:'description_es');
        }

        if(isset($fields['description_pt'])) {
            $data['description_pt'] = $this->validate_text($fields['description_pt'], fieldname:'description_pt');
        }

        if(isset($fields['description_de'])) {
            $data['description_de'] = $this->validate_text($fields['description_de'], fieldname:'description_de');
        }

        if(isset($fields['reflink'])) {
            $data['reflink'] = $this->validate_link($fields['reflink'], fieldname:'reflink');
        }

        if(isset($fields['promocode'])) {
            $data['promocode'] = $this->validate_alphanumeric($fields['promocode'], fieldname:'promocode');
        }

        if(isset($fields['dashboard'])) {
            $data['dashboard'] = $this->validate_link($fields['dashboard'], fieldname:'dashboard');
        }

        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], 'active');
        }

        if(isset($fields['homepage'])) {
            $data['homepage'] = $this->validate_toggle($fields['homepage'], 'homepage');
        }

        if(isset($fields['countries'])) {
            $data['countries'] = $this->validate_itemname($fields['countries'], fieldname:'countries');
        }

        return [$data, $this->err];
    }
}