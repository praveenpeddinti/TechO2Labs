<?php

Class InstantEmpStorage
{
     public function storedata($eachfile, $saveFileName, $session_user) 
                {        
        $response = array();
        $allFiles_Data = array();        
        $allFilesdata = StorageModel:: model()->storeFile($eachfile, $saveFileName, $session_user ); 
        if (isset($allFilesdata) && count($allFilesdata) > 0) 
                    {
            $response = $allFiles_Data;
                    }
                    
                   // print_r($response); die;
        return $response;
               }                 
}


