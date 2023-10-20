<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/vendor/autoload.php');
    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $dropboxKey = "plvsmmoa4pia5ma";
        $dropboxSecret = "moszz8mf5j47wku";
        $dropboxToken = "sl.BSBVk5yP3uNG2TLUh39NZm5DIKk19qffgt8Wk32CvCtxF-kAR4aAPqB0EvzI2cTsahINZCGbOW_NgmnuDEJdyURrCqC0iGd3FLtchTPm2ekFdssJXaRWEMXyGITO37gJS_2e24U";
        $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
        $dropbox = new Dropbox($app);
        if(!empty($_FILES)){
            $path = $_FILES['file']['name'];
            $nombre = pathinfo($path, PATHINFO_FILENAME);
            $tempfile = $_FILES['file']['tmp_name'];
            $ext = explode(".",$_FILES['file']['name']);
            $ext = end($ext);
            $nombreDropbox = "/".$nombre.".".$ext;

            try{
                $file = $dropbox->simpleUpload($tempfile,'/'.$_REQUEST["cursos"].$nombreDropbox,['autorename' => true]);
                if($file){
                    echo "<p> Se ha subido el material de clase satisfactoriamente </p>";
                }
            }
            catch(\Exception $e){
                throw $e;
                exit;
            }
        }
    }
?>  