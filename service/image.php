<?php

include 'connectDB.php';

// Functions

function uploadImage($image, $filename){
    //echo $image['type']; exit;
    // Check if upload error
    if($image['error'] !== UPLOAD_ERR_OK){
        return array(
            'response'=>500,
            'msg'=>'Terjadi error ketika mengupload file!'
        ); // Internal Server Error
    }
    // Check if format not supported
    $allowedFormat = array("image/jpeg", "image/png");
    if(!in_array($image['type'], $allowedFormat)){
        return array(
            'response'=>500,
            'msg'=>'Format bukan gambar! Pastikan format .jpg atau .png!'
        ); // Internal Server Error
    }
    // Prepare filename
    $ext_list = array(
        "image/jpeg"=>'.jpg',
        "image/png"=>'.png',
    );
    $extension = $ext_list[$image['type']];    
    $path = './img/'; // Edit this if you want to change image location!
    $newFilename = $path.$filename.$extension;
    // Attempt to save
    if (move_uploaded_file($image['tmp_name'], '../view/img/'.$filename.$extension) === false) {
        return array(
            'response'=>500,
            'msg'=>'Terjadi error ketika mengupload file!'
        ); // Internal Server Error
    }
    // Success
    $result = array(
        'data'=>$newFilename, // Returns filename
        'response'=>200,
        'msg'=>'Berhasil mengupload gambar di '.$newFilename.'!'
    );
    return $result;
}

function selectImageAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_image.image_id, perpus_image.image_name FROM perpus_image
        ORDER BY perpus_image.image_id DESC;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Querying
        try{
            mysqli_stmt_execute($stmt);            
        }catch(mysqli_sql_exception $e){
            return array(
                'response'=>500,
                'msg'=>'Terjadi error ketika mengakses database!'
            ); // Internal Server Error
        }
        // Fetch result
        mysqli_stmt_store_result($stmt);        
        if(mysqli_stmt_num_rows($stmt) < 1){
            return array(
                'response'=>204,
                'msg'=>'Data kosong!'
            ); // Internal Server Error
        }
        // Bind result
        mysqli_stmt_bind_result($stmt, $id, $name);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'name'=>$name,                
            ));
        }
        return $result;
    }
}

function insertImage($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_image VALUES (?, ?);
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'is', 
            $data[0], // id
            $data[1], // name            
        );
        // Querying
        try{
            mysqli_stmt_execute($stmt);            
        }catch(mysqli_sql_exception $e){
            return array(
                'response'=>500,
                'msg'=>'Terjadi error ketika mengakses database!'
            ); // Internal Server Error
        }        
        // Success      
        $result = array(            
            'response'=>200,
            'msg'=>'Berhasil menambahkan data!'
        );        
        return $result;
    }
}

// Services

if(isset($_GET['mode']) && $_GET['mode'] == 'JSON'){ // GET JSON

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_GET['action']) && $_GET['action'] == 'selectImageAll'){
        echo json_encode(selectImageAll());
        exit;
    }

}    

if(isset($_POST['mode']) && $_POST['mode'] == 'PHP'){ // POST PHP

    if(isset($_POST['action']) && $_POST['action'] == 'insertImage'){
        $form = array('id', 'name');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            // Save image in .img
            $attemptSave = uploadImage($_FILES['image'], $data[1]);
            if($attemptSave['response'] != 200){
                session_start();
                $_SESSION['msg'] = $attemptSave['msg'];;
                header('Location: /../view/upload-image.php');
                exit;
            }
            $data[1] = $attemptSave['data'];
            // Save filepath in DB            
            $result = insertImage($data);
            session_start();
            $_SESSION['msg'] = $attemptSave['msg'];
            header('Location: /../view/show-images.php');
            exit;
        }        
    }    

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-images.php');
    exit;

}
