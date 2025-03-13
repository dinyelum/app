<?php
class Bookies {
    use db, validate;
    protected static $table = 'bookies';
    protected $columns = ['id', 'bookie', 'description_en', 'description_fr', 'description_es', 'description_pt', 'description_de', 'reflink', 'promocode', 'dashboard', 'active', 'homepage', 'bcolor', 'tcolor', 'countries'];
    
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
            $data['description_en'] = $this->validate_text($fields['description_en'], false, 'description_en');
        }

        if(isset($fields['description_fr'])) {
            $data['description_fr'] = $this->validate_text($fields['description_fr'], false, 'description_fr');
        }

        if(isset($fields['description_es'])) {
            $data['description_es'] = $this->validate_text($fields['description_es'], false, 'description_es');
        }

        if(isset($fields['description_pt'])) {
            $data['description_pt'] = $this->validate_text($fields['description_pt'], false, 'description_pt');
        }

        if(isset($fields['description_de'])) {
            $data['description_de'] = $this->validate_text($fields['description_de'], false, 'description_de');
        }

        if(isset($fields['reflink'])) {
            $data['reflink'] = $this->validate_link($fields['reflink'], fieldname:'reflink');
        }

        if(isset($fields['promocode'])) {
            $data['promocode'] = $this->validate_alphanumeric($fields['promocode'], false, 'promocode');
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

        if(isset($fields['bcolor'])) {
            $data['bcolor'] = $this->validate_alphanumeric($fields['bcolor'], false, 'bcolor');
        }

        if(isset($fields['tcolor'])) {
            $data['tcolor'] = $this->validate_alphanumeric($fields['tcolor'], false, 'tcolor');
        }

        if(isset($fields['countries'])) {
            $countryarr = explode(', ', $fields['countries']);
            foreach($countryarr as $val) {
                $countries[] = $this->validate_country($val, false, fieldname:'countries');
            }
            if(isset($this->err['countries']) && count($countryarr)) $this->err['countries'] = $this->resp_invalid_selections('countries');
            $data['countries'] = implode(', ', $countries);
        }

        return [$data, $this->err];
    }
}