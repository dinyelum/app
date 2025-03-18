<?php
class Adminfiles {
    /*
    alter table adminfileupdates drop notes, change downloaded downloaded varchar(10), ADD UNIQUE(`filename`),
    change regdate modified datetime on update CURRENT_TIMESTAMP default CURRENT_TIMESTAMP,
    DROP downloaded,
    rename table adminfileupdates to adminfiles;
    create table downloads (
        id int(6) unsigned PRIMARY key AUTO_INCREMENT,
        agentid int(6) not null,
        adminfilesid int(6) not null,
        downloaddate datetime default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
    );
    */
    use Db, Validate;
    public static $table = 'adminfiles';
    private $columns = ['id', 'name', 'modified'];
    public $filegroup = [
        'screenshots'=>'Screenshots', 'adminfiles'=>'Admin Files', 'topteams'=>'Top Teams'
    ];
    public $workfilefolders = [
        'chats'=>'Chats', 'admin'=>'Admin', 'root'=>'Root'
    ];

    public function validate(array $fields) {
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['date'])) {
            $data['date'] = $this->validate_date($fields['date']);
        }

        if(isset($fields['lang'])) {
            $data['lang'] = $this->validate_in_array($fields['lang'], LANGUAGES, fieldname:'lang');
        }

        if(isset($fields['folder'])){
            $data['folder'] = $this->validate_in_array($fields['folder'], $this->workfilefolders, fieldname:'folder');
        }

        if(isset($fields['filegroup'])) {
            $data['filegroup'] = $this->validate_in_array($fields['filegroup'], $this->filegroup, fieldname:'filegroup');
        }

        if(isset($fields['fileToUpload'])) {
            if(isset($fields['fileToUpload']['name']) && $countfiles=count($fields['fileToUpload']['name'])) {
                if(isset($data['filegroup'])) {
                    if($data['filegroup']=='screenshots') {
                        $dir = UPLOAD_SCREENSHOTS_ROOT.'/'.($data['lang']=='en' ? 'public_html' : $data['lang'].'.betagamers.net').'/recs/'.$data['date'].'/';
                        /*if(isset($data['lang']) && !isset($this->err['lang'])) {
                            $dir = UPLOAD_SCREENSHOTS_ROOT.'/'.($data['lang']=='en' ? 'public_html' : $data['lang'].'.betagamers.net').'/recs/'.$data['date'].'/';
                        } else {
                            $this->err['lang'] = $this->err['lang'] ?? 'Please select language';
                        }*/
                    } elseif($data['filegroup']=='topteams') {
                        $dir = UPLOAD_TEAMS_ROOT.'/';
                        if($countfiles>1) $this->err['genErr'] = 'You can only upload 1 file at a time in this section';
                        $this->mix_file_formats(['html', 'compressed']);
                    } elseif($data['filegroup']=='adminfiles') {
                        $dir = UPLOAD_ADMIN_ROOT.'/'.($data['folder']=='root' ? '' : $data['folder']).'/';
                    }
                    // if(!file_exists($dir)) mkdir("$dir");
                }
                $blueprint = match ($data['filegroup']) {
                    'screenshots' => ['size'=>2000000, 'filetype'=>'image'],
                    'adminfiles' => ['size'=>5000000, 'filetype'=>'document', 'overwrite'=>true],
                    'topteams' => ['size'=>5000000, 'filetype'=>'mixed', 'overwrite'=>true],
                    default => []
                };
                
                if(!$this->err) {
                    if(!file_exists($dir)) mkdir("$dir");
                    for($i=0; $i<$countfiles; $i++) {
                        foreach($fields['fileToUpload'] as $key=>$val) {
                            $file[$key] = $val[$i];
                        }
                        $filename = purify(strtolower($file['name']));
                        $blueprint['url'] = $dir.$filename;
                        $upload = $this->validate_file($file, $blueprint, fieldname:'fileToUpload');
                        if(isset($this->err['fileToUpload'])) {
                            $err['fileToUpload'][$filename] = "$filename: ".$this->err['fileToUpload'];
                        }
                        // $this->err['fileToUpload'] = '';
                        $this->err['fileToUpload'] = null;
                        if($upload) {
                            $data['fileToUpload'][] = $filename;
                        } else {
                            $this->err['imgerr'][] = "$filename was not uploaded.";
                        }
                    }
                    $this->err['fileToUpload'] = $err['fileToUpload'] ?? null;
                }
            }
            // $fields['fileToUpload'] = validate_file($file, $blueprint, $required, $fieldname);
        }
        // $blueprint[size, filetype, url];

        return [$data, $this->err];
    }
}