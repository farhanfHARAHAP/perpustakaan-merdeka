<?php

include 'connectDB.php';

// Functions

function selectBookCategoryAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_book_categories.category_id, perpus_book_categories.category_name
        FROM perpus_book_categories
        ORDER BY perpus_book_categories.category_id DESC
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

function selectBookCategoryByID($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_book_categories.category_id, perpus_book_categories.category_name
        FROM perpus_book_categories        
        WHERE perpus_book_categories.category_id = ?
        ORDER BY perpus_book_categories.category_id DESC
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

function selectBookCategoryByName($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_book_categories.category_id, perpus_book_categories.category_name
        FROM perpus_book_categories        
        WHERE perpus_book_categories.category_name LIKE ?
        ORDER BY perpus_book_categories.category_id DESC;
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

function insertBookCategory($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_book_categories VALUES (?, ?);
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

function updateBookCategory($data){
    global $conn;
    // Prepare Query
    $query = '
        UPDATE perpus_book_categories
        SET perpus_book_categories.category_name = ?
        WHERE perpus_book_categories.category_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'si',             
            $data[1], // name    
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

function deleteBookCategory($data){
    global $conn;
    // Prepare Query
    $query = '
        DELETE FROM perpus_book_categories WHERE category_id = ?;
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

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookCategoryAll'){
        echo json_encode(selectBookCategoryAll());
        exit;
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookCategoryByID'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectBookCategoryByID($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookCategoryByName'){
        $key = array('name');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectBookCategoryByName($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'deleteBookCategory'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);            
            if(selectBookCategoryByID($data)['response'] == 204){
                echo json_encode(array(
                    'response'=>204,
                    'msg'=>'Data tidak ditemukan!'
                ));
                exit;
            }            
            echo json_encode(deleteBookCategory($data));
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

    if(isset($_POST['action']) && $_POST['action'] == 'insertBookCategory'){
        $form = array('id', 'name');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            echo json_encode(insertBookCategory($data));
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateBookCategory'){
        $form = array('id', 'name');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);            
            echo json_encode(updateBookCategory($data));
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

    if(isset($_POST['action']) && $_POST['action'] == 'insertBookCategory'){
        $form = array('id', 'name');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);
            $result = insertBookCategory($data);
            session_start();
            $_SESSION['msg'] = $result['msg'];
            header('Location: /../view/show-book-categories.php');
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateBookCategory'){
        $form = array('id', 'name');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);
            updateBookCategory($data);
            session_start();
            $_SESSION['msg'] = 'Berhasil mengupdate data!';
            header('Location: /../view/show-book-categories.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-book-categories.php');
    exit;

}

if(isset($_GET['mode']) && $_GET['mode'] == 'PHP'){ // POST PHP

    if(isset($_GET['action']) && $_GET['action'] == 'deleteBookCategory'){
        $key = array('id');
        if(isNotBadGETRequest($key)){            
            $data = getGETRequest($key);
            deleteBookCategory($data);            
            session_start();
            $_SESSION['msg'] = 'Berhasil menghapus data!';
            header('Location: /../view/show-book-categories.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-book-categories.php');
    exit;

}