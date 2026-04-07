<?php

include 'connectDB.php';

// Functions

function selectBookAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_books.book_id, perpus_books.book_code, perpus_books.book_name, perpus_books.book_author, perpus_books.book_release, perpus_books.book_category, perpus_book_categories.category_name, perpus_books.book_image
        FROM perpus_books
        LEFT JOIN perpus_book_categories
        ON perpus_book_categories.category_id = perpus_books.book_category
        ORDER BY perpus_books.book_id DESC
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
        mysqli_stmt_bind_result($stmt, $id, $code, $name, $author, $release, $category_id, $category, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,
                'code'=>$code,
                'name'=>$name,
                'author'=>$author,
                'release'=>$release,
                'category_id'=>$category_id,
                'category'=>$category,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function selectBookLend(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_books.book_id, perpus_books.book_code, perpus_books.book_name, perpus_book_categories.category_name, perpus_books.book_image, perpus_books.book_lended
        FROM perpus_books
        LEFT JOIN perpus_book_categories
        ON perpus_book_categories.category_id = perpus_books.book_category
        ORDER BY perpus_books.book_id DESC
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
        mysqli_stmt_bind_result($stmt, $id, $code, $name, $category, $image, $lended);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,
                'code'=>$code,
                'name'=>$name,                
                'category'=>$category,
                'image'=>$image,
                'lended'=>$lended,
            ));
        }
        return $result;
    }
}

function selectBookByID($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_books.book_id, perpus_books.book_code, perpus_books.book_name, perpus_books.book_author, perpus_books.book_release, perpus_books.book_category, perpus_book_categories.category_name, perpus_books.book_image
        FROM perpus_books
        LEFT JOIN perpus_book_categories
        ON perpus_book_categories.category_id = perpus_books.book_category
        WHERE perpus_books.book_id = ?
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
        mysqli_stmt_bind_result($stmt, $id, $code, $name, $author, $release, $category_id, $category, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,
                'code'=>$code,
                'name'=>$name,
                'author'=>$author,
                'release'=>$release,
                'category_id'=>$category_id,
                'category'=>$category,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function selectBookByName($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_books.book_id, perpus_books.book_code, perpus_books.book_name, perpus_books.book_author, perpus_books.book_release, perpus_books.book_category, perpus_book_categories.category_name, perpus_books.book_image
        FROM perpus_books
        LEFT JOIN perpus_book_categories
        ON perpus_book_categories.category_id = perpus_books.book_category
        WHERE perpus_books.book_name LIKE ?;
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
        mysqli_stmt_bind_result($stmt, $id, $code, $name, $author, $release, $category_id, $category, $image);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,
                'code'=>$code,
                'name'=>$name,
                'author'=>$author,
                'release'=>$release,
                'category_id'=>$category_id,
                'category'=>$category,
                'image'=>$image,
            ));
        }
        return $result;
    }
}

function insertBook($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_books VALUES (?, ?, ?, ?, ?, ?, ?, 0);
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'issssis', 
            $data[0], // id
            $data[1], // code
            $data[2], // name
            $data[3], // author
            $data[4], // release
            $data[5], // category
            $data[6], // image            
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

function updateBook($data){
    global $conn;
    // Prepare Query
    $query = '
        UPDATE perpus_books SET        
        perpus_books.book_code = ?,
        perpus_books.book_name = ?,
        perpus_books.book_author = ?,
        perpus_books.book_release = ?,
        perpus_books.book_category = ?,
        perpus_books.book_image = ?
        WHERE perpus_books.book_id = ?;        
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'ssssisi',             
            $data[1], // code
            $data[2], // name
            $data[3], // author
            $data[4], // release
            $data[5], // category
            $data[6], // image  
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

function deleteBook($data){
    global $conn;
    // Prepare Query
    $query = '
        DELETE FROM perpus_books WHERE book_id = ?;
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

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookAll'){
        echo json_encode(selectBookAll());
        exit;
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookLend'){
        echo json_encode(selectBookLend());
        exit;
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookByID'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectBookByID($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectBookByName'){
        $key = array('name');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectBookByName($data));
            exit;
        }        
    }

    if(isset($_GET['action']) && $_GET['action'] == 'deleteBook'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);            
            if(selectBookByID($data)['response'] == 204){
                echo json_encode(array(
                    'response'=>204,
                    'msg'=>'Data tidak ditemukan!'
                ));
                exit;
            }            
            echo json_encode(deleteBook($data));
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

    if(isset($_POST['action']) && $_POST['action'] == 'insertBook'){
        $form = array('id', 'code', 'name', 'author', 'release', 'category', 'image');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            echo json_encode(insertBook($data));
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateBook'){
        $form = array('id', 'code', 'name', 'author', 'release', 'category', 'image');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);            
            echo json_encode(updateBook($data));
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

    if(isset($_POST['action']) && $_POST['action'] == 'insertBook'){
        $form = array('id', 'code', 'name', 'author', 'release', 'category', 'image');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            $result = insertBook($data);
            session_start();
            $_SESSION['msg'] = $result['msg'];
            header('Location: /../view/show-books.php');
            exit;
        }        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'updateBook'){
        $form = array('id', 'code', 'name', 'author', 'release', 'category', 'image');
        if(isNotBadPOSTRequest($form)){            
            $data = getPOSTRequest($form);
            updateBook($data);
            session_start();
            $_SESSION['msg'] = 'Berhasil mengupdate data!';
            header('Location: /../view/show-books.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-books.php');
    exit;

}

if(isset($_GET['mode']) && $_GET['mode'] == 'PHP'){ // POST PHP

    if(isset($_GET['action']) && $_GET['action'] == 'deleteBook'){
        $key = array('id');
        if(isNotBadGETRequest($key)){            
            $data = getGETRequest($key);
            deleteBook($data);            
            session_start();
            $_SESSION['msg'] = 'Berhasil menghapus data!';
            header('Location: /../view/show-books.php');
            exit;            
        }        
    }

    $respond = array(
        'response'=>400,
        'msg'=>'Bad Request!'
    ); // BAD REQUEST    
    session_start();
    $_SESSION['msg'] = $respond['msg'];
    header('Location: /../view/add-books.php');
    exit;

}
