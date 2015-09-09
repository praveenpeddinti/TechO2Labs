<?php
class UploadRulesModal extends CFormModel{
    public $image;
    public $rating;
    public function rules () {
        return array (
            array('image[],rating', 'required',
                  'message'=>'Please upload a file .'),
            array ('image[]', 'file', 'types' => 'gif, jpg, png, doc, docx, pdf', 'safe' => false),
        );
    }
    public function attributeLabels(){
        return array(
            'image'=>'Upload files',
        );
    }
}
?>