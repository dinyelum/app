<?php
class Download {
    public function index() {
        // $path = match ($_GET['ref']) {
        //     'assignment' => UPLOAD_ROOT.'/assignments/'.$_GET['filename'],
        //     'finishedwork' => UPLOAD_ROOT.'/assignments/'.$_GET['filename'],
        // };
        $path = UPLOAD_ROOT.'/assignments/'.$_GET['filename'];
        if(file_exists($path)) {
            download($path);
        } else {
            exit('This file no longer exists or has been moved.');
        }
    }

    // public function id($id) {
    //     if(is_int($id)) {
    //         $getfile = $adminclass->table('adminfileupdates')->select('filename')->where('id=:id', ['id'=>$id]);
    //         if(count($getfile)) {
    //             $update = $adminclass->table('adminfileupdates')->update(['downloaded'=>1])->where('id=:id', ['id'=>$id]);
    //             if(!$update) {
    //                 error_log("The admin file with id $id wasn't updated.");
    //             }
    //             download('/home/betaahfg/core/betagamers/adminfiles/'.$getfile[0]['filename']);
    //         } else {
    //             exit('This file no longer exists or has been moved.');
    //         }
    //     }
    // }
}