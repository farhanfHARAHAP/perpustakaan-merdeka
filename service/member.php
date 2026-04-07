<?php

include 'connectDB.php';

// Functions

function selectMemberAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_members.member_id, perpus_members.member_name, perpus_members.member_category, perpus_member_categories.category_name, perpus_members.member_address, perpus_members.member_image
        FROM perpus_members
        LEFT JOIN perpus_member_categories
        ON perpus_members.member_category = perpus_member_categories.category_id
        ORDER BY perpus_members.member_id DESC
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
        mysqli_stmt_bind_result($stmt, $id, $name, $category_id, $category, $address, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'name'=>$name,                
                'category_id'=>$category_id,
                'category'=>$category,
                'address'=>$address,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function selectMemberByID($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_members.member_id, perpus_members.member_name, perpus_members.member_category, perpus_member_categories.category_name, perpus_members.member_address, perpus_members.member_image
        FROM perpus_members
        LEFT JOIN perpus_member_categories
        ON perpus_members.member_category = perpus_member_categories.category_id        
        WHERE perpus_members.member_id = ?
        ORDER BY perpus_members.member_id DESC
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'i', 
            $data[0] // id
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
        // Fetch result
        mysqli_stmt_store_result($stmt);        
        if(mysqli_stmt_num_rows($stmt) < 1){
            return array(
                'response'=>204,
                'msg'=>'Data kosong!'
            ); // Internal Server Error
        }
        // Bind result
        mysqli_stmt_bind_result($stmt, $id, $name, $category_id, $category, $address, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'name'=>$name,                
                'category_id'=>$category_id,
                'category'=>$category,
                'address'=>$address,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function selectMemberByName($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_members.member_id, perpus_members.member_name, perpus_members.member_category, perpus_member_categories.category_name, perpus_members.member_address, perpus_members.member_image
        FROM perpus_members
        LEFT JOIN perpus_member_categories
        ON perpus_members.member_category = perpus_member_categories.category_id        
        WHERE perpus_members.member_name LIKE ?
        ORDER BY perpus_members.member_id DESC
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        $name = '%'.$data[0].'%'; // search name query
        mysqli_stmt_bind_param($stmt, 's', 
            $name
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
        // Fetch result
        mysqli_stmt_store_result($stmt);        
        if(mysqli_stmt_num_rows($stmt) < 1){
            return array(
                'response'=>204,
                'msg'=>'Data kosong!'
            ); // Internal Server Error
        }
        // Bind result
        mysqli_stmt_bind_result($stmt, $id, $name, $category_id, $category, $address, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'name'=>$name,                
                'category_id'=>$category_id,
                'category'=>$category,
                'address'=>$address,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function insertMember($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_members VALUES (?, ?, ?, ?, ?);
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'isiss', 
            $data[0], // id
            $data[1], // name
            $data[2], // category
            $data[3], // address
            $data[4], // image                
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

function updateMember($data){
    global $conn;
    // Prepare Query
    $query = '
        UPDATE perpus_members SET
        perpus_members.member_name = ?,
        perpus_members.member_category = ?,
        perpus_members.member_address = ?,
        perpus_members.member_image = ?
        WHERE perpus_members.member_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'sissi',             
            $data[1], // name
            $data[2], // category
            $data[3], // address
            $data[4], // image      
            $data[0], // id          
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

function deleteMember($data){
    global $conn;
    // Prepare Query
    $query = '
        DELETE FROM perpus_members WHERE member_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'i', 
            $data[0], // id            
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
            'msg'=>'Berhasil menghapus data!'
        );        
        return $result;
    }
}

// Services

if(isset($_GET['mode']) && $_GET['mode'] == 'JSON'){ // GET JSON

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_GET['action']) && $_GET['action'] == 'selectMemberAll'){
        echo json_encode(selectMemberAll());
        exit;
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectMemberByID'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectMemberByID($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectMemberByName'){
        $key = array('name');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectMemberByName($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'deleteMember'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);            
            if(selectMemberByID($data)['response'] == 204){
                echo json_encode(array(
                    'response'=>204,
                    'msg'=>'Data tidak ditemukan!'
                ));
                exit;
            }            
            echo json_encode(deleteMember($data));
            exit;
        }        
    }

    echo json_encode(array(
        'response'=>400,
        'msg'=>'Bad Request!'
    )); // BAD REQUEST
    exit;
}

if(isset($_POST['mode']) && $_POST['mode'] == 'JSON'){ // POST JSON

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_POST['action']) && $_POST['action'] == 'insertMember'){
        $form = array('id', 'name', 'category', 'address', 'image');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            echo json_encode(insertMember($data));
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateMember'){
        $form = array('id', 'name', 'category', 'address', 'image');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);
            deleteMember($data);
            echo json_encode(insertMember($data));
            exit;
        }        
    }

    echo json_encode(array(
        'response'=>400,
        'msg'=>'Bad Request!'
    )); // BAD REQUEST
    exit;

}

if(isset($_POST['mode']) && $_POST['mode'] == 'PHP'){ // POST PHP

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_POST['action']) && $_POST['action'] == 'insertMember'){
        $form = array('id', 'name', 'category', 'address', 'image');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            $result = insertMember($data);
            session_start();
            $_SESSION['msg'] = $result['msg'];
            header('Location: /../view/show-members.php');
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateMember'){
        $form = array('id', 'name', 'category', 'address', 'image');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);
            deleteMember($data);
            insertMember($data);
            session_start();
            $_SESSION['msg'] = 'Berhasil mengupdate data!';
            header('Location: /../view/show-members.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-members.php');
    exit;

}

if(isset($_GET['mode']) && $_GET['mode'] == 'PHP'){ // POST PHP

    if(isset($_GET['action']) && $_GET['action'] == 'deleteMember'){
        $key = array('id');
        if(isNotBadGETRequest($key)){            
            $data = getGETRequest($key);
            deleteMember($data);            
            session_start();
            $_SESSION['msg'] = 'Berhasil menghapus data!';
            header('Location: /../view/show-members.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-members.php');
    exit;

}

