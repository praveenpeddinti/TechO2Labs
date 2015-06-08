<?php
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()){
            return false;
        }

        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 31457280;
    private $file;



    function __construct(array $allowedExtensions = array(), $sizeLimit = 31457280){


        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();
        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
       
        error_log("===$postSize==this sizelimit=$this->sizeLimit====");
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            error_log("file sizeeeeeeeeeeeeeeeeeeeeeeeeeeeeee".$size);
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE, $images=null) {
        if (!is_writable($uploadDirectory)) {
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file) {
            return array('error' => 'File is too large, max file upload size is 10M.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large, max file upload size is 10M.');
        }
        $pathinfo = pathinfo($this->file->getName());
        $filename = trim($pathinfo['filename']);
        $filename = str_replace(',', '_', $filename);
        $filename = str_replace(' ', '', $filename);
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];
        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        }
        $date = strtotime("now");
        $savedfilename = $filename . '_' . $date;
        $filename = trim($filename);
//        if(!$replaceOldFile){
//            /// don't overwrite previous files that were uploaded
//           
//            while (file_exists($uploadDirectory . $filename )) {
//              //  return array('error' => 'File already uploaded, it should be one of ');
//                //$filename .= rand(10, 99);
//            }
//        }
//        $tempFolder = "temp/";
        $dirArr = explode("/",$uploadDirectory);
        $tempFolder = $dirArr[sizeof($dirArr)-2]."/";
        $tExt = "";
        $mfilename = "";
        $mtempFileName = "";
        $tsavedfilename = "";
        if (file_exists($uploadDirectory . $filename . '.' . $ext)) {            
            $tempFileName = $filename . "_" . $date;
            //return;            
               
            if ($this->file->save($uploadDirectory . $tempFileName . '.' . $ext)) {
                
                 if(strtolower($ext) == "tif" || strtolower($ext) == "tiff"){       
                      $tExt = "jpg";
                    $filename = $this->imageConvertion($tempFolder,$filename);
                     $tempFolder = $tempFolder.$filename.".jpg";
                     $mfilename = $filename.".jpg";
                     $mtempFileName = $filename . "_" . $date.".jpg";
                     $tsavedfilename = $mtempFileName;                    

                }
                
                if (sha1_file($uploadDirectory . $tempFileName . '.' . $ext) == sha1_file($uploadDirectory . $filename . '.' . $ext)) {
                    unlink($uploadDirectory . $tempFileName . '.' . $ext);                    
                    return array('success' => true, 'filename' => $filename . '.' . $ext, 'extension' => $ext, 'savedfilename' => $savedfilename . '.' . $ext, 'imagetime' => $date,'tempFolder' => $tempFolder,'mfilename'=>$mfilename, 'tsavedfilename' => $tsavedfilename);
                } else {
                    if ($images != "undefined" && $images != null) {
                        $imageArray = explode(",", $images);
                        foreach ($imageArray as $image) {
                            if (file_exists($uploadDirectory . $image)) {
                                if (sha1_file($uploadDirectory . $tempFileName . '.' . $ext) == sha1_file($uploadDirectory . $image)) {
                                    unlink($uploadDirectory . $tempFileName . '.' . $ext);
                                    return array('success' => true, 'filename' => "", 'extension' => $ext, 'savedfilename' => $savedfilename . '.' . $ext, 'imagetime' => $date,'tempFolder' => $tempFolder,'mfilename'=>$mfilename, 'tsavedfilename' => $tsavedfilename);
                                }
                            }
                        }
                        return array('success' => true, 'filename' => $tempFileName . '.' . $ext, 'extension' => $ext, 'savedfilename' => $savedfilename . '.' . $ext, 'imagetime' => $date,'tempFolder' => $tempFolder,'mfilename'=>$mtempFileName, 'tsavedfilename' => $tsavedfilename);
                    }
                    return array('success' => true, 'filename' => $tempFileName . '.' . $ext, 'extension' => $ext, 'savedfilename' => $savedfilename . '.' . $ext, 'imagetime' => $date,'tempFolder' => $tempFolder,'mfilename'=>$mtempFileName, 'tsavedfilename' => $tsavedfilename);
                }
            } else {
                return array('error' => 'Could not save uploaded file.' .
                    'The upload was cancelled, or server error encountered');
            }
        } else {
            if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {
                
                 if(strtolower($ext) == "tif" || strtolower($ext) == "tiff"){
                     //$ext = "jpg";
                     $filename = $this->imageConvertion($tempFolder,$filename);
                     $tempFolder = $tempFolder.$filename.".jpg";
                     $mfilename = $filename.".jpg";      
                     $tsavedfilename = $filename . "_" . $date.".jpg";                    
                }
                return array('success' => true, 'filename' => $filename . '.' . $ext, 'extension' => $ext, 'savedfilename' => $savedfilename . '.' . $ext, 'imagetime' => $date,'tempFolder' => $tempFolder,'mfilename'=>$mfilename, 'tsavedfilename' => $tsavedfilename);
            } else {
                return array('error' => 'Could not save uploaded file.' .
                    'The upload was cancelled, or server error encountered');
            }
        }
    }
    
    public function imageConvertion($tfolder,$tfilename){
        try{
            $path = Yii::getPathOfAlias('webroot')."/$tfolder".$this->file->getName();      
            $fileName1 = $tfilename.".jpg";
            $folder = Yii::getPathOfAlias('webroot')."/".$tfolder;
            $outputF = $folder.$fileName1;                        
            $uploadfile = $path; // inuput file path
            exec("ffmpeg -i $uploadfile $outputF");
            return $tfilename;
        } catch (Exception $ex) {

        }
    }
}