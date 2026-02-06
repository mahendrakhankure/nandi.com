<?php
class Manage_S3bucket extends CI_Controller {


public function addVideos(){
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('patti', 'patti', 'required');
    if (empty($_FILES['file']['name'])){
        $this->form_validation->set_rules('file', 'file', 'required');
    }
    if ($_POST && $this->form_validation->run() != FALSE)  { 
        $img = $this->upload();
        // echo '<pre>';
        // print_r($img);
        // die();
        if ($gameid > 0 && ($this->form_validation->run() != FALSE || $this->form_validation->run() =='' || $img) ) {
            $addnewGame = array(
                'patti' => $_POST['patti'] , 
                'dealer' => $img
            );
            AddUpdateTable('dealerVideos','id',$gameid,$addnewGame);
        }else{
            $addnewGame = array(
                'patti' => $_POST['patti'] , 
                'dealer' => $img
            );
            $gameid = AddUpdateTable('dealerVideos','','',$addnewGame);		
        }
        redirect('0571b3cbce86ae08dc5ba2b744302e53');
    }else{ 
        if($gameid > 0){
            $data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
        }
        $this->load->view('admin/add_new_videos',$data); 
    } 
}

public function videoList(){
    if($this->input->post()){
        $postData = $this->input->post();
		$ManageVideos_Model = $this->load->model('ManageVideos_Model');
	    $data = $this->ManageVideos_Model->videoList($postData);
        echo json_encode($data);
    }else{
        $this->load->view('admin/videosList');
    }
}

public function deleteVideo(){
    $this->load->model('Common_model');
    $this->load->helper('s3_helper');
    $data = $this->Common_model->getData('dealerVideos',' WHERE id="'.$_POST['id'].'"','','','','one','','');
    // echo '<pre>';
    // print_r($data);
    // die();
    $d = delete_from_s3($data['dealer']);
    if($d){
        deleteRecord('dealerVideos','id',$_POST['id']);
        die(json_encode(['status'=>200,'massage'=>'Record deleted successfully.']));
    }
    die(json_encode(['status'=>400,'massage'=>'Somthing went wrong.']));
}

public function changeStatus(){
    $addnewGame = array(
        'status' => $_POST['status'],
    );
    $add = AddUpdateTable('dealerVideos','id',$_POST['id'],$addnewGame);
    if($add){
        die(json_encode(['status'=>200,'massage'=>'status updated']));
    }else{
        die(json_encode(['status'=>400,'massage'=>'Somthing went wrong']));
    }
}
public function upload() {
    // Load the S3 helper (if using helper)
    $this->load->helper('s3_helper');
    // Assuming file is being uploaded via an HTML form
    if (isset($_FILES['file']['tmp_name'])) {
        $filePath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        $newFileName = transactionID(16,16). time() . '.' . $fileExt;
        // Upload the file to S3
        $result = upload_to_s3($filePath, $newFileName);
        if ($result) {
            return $result;
        } else {
            return "File upload failed.";
        }
    }
}

public function getFileUrl() {
    // Load the S3 helper (if using helper)
    $this->load->helper('s3_helper');

    $key = 'example.jpg';  // S3 key of the file
    $fileUrl = get_s3_file_url($key);

    if ($fileUrl) {
        echo "File URL: " . $fileUrl;
    } else {
        echo "Error retrieving file URL.";
    }
}
}
