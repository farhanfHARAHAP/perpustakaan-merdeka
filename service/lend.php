<?php

include 'connectDB.php';

// Functions

function selectLendAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_ledger_lends.lend_id, perpus_members.member_name, perpus_books.book_code, perpus_ledger_lends.lend_date, perpus_ledger_lends.lend_return, perpus_ledger_lends.lend_returned, perpus_ledger_lends.book_id
        FROM perpus_ledger_lends
        LEFT JOIN perpus_members ON perpus_ledger_lends.member_id = perpus_members.member_id
        LEFT JOIN perpus_books ON perpus_ledger_lends.book_id = perpus_books.book_id
        ORDER BY perpus_ledger_lends.lend_date DESC
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
        mysqli_stmt_bind_result($stmt, $id, $member, $book, $date, $will_return, $returned, $book_id);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'member'=>$member,                
                'book'=>$book,                
                'date'=>$date,                
                'will_return'=>$will_return,                
                'returned'=>$returned,                
                'book_id'=>$book_id,       
            ));
        }
        return $result;
    }
}

function selectLendByID($data){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_ledger_lends.lend_id, perpus_ledger_lends.member_id, perpus_ledger_lends.book_id, perpus_ledger_lends.lend_date, perpus_members.member_name, perpus_books.book_name, perpus_ledger_lends.lend_return
        FROM perpus_ledger_lends   
        LEFT JOIN perpus_members ON perpus_ledger_lends.member_id = perpus_members.member_id
        LEFT JOIN perpus_books ON perpus_ledger_lends.book_id = perpus_books.book_id
        WHERE lend_id = ?            
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
        // Fetch result
        mysqli_stmt_store_result($stmt);        
        if(mysqli_stmt_num_rows($stmt) < 1){
            return array(
                'response'=>204,
                'msg'=>'Data kosong!'
            ); // Internal Server Error
        }
        // Bind result
        mysqli_stmt_bind_result($stmt, $id, $member_id, $book_id, $date, $member, $book, $will_return);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(
                'id'=>$id,                
                'member'=>$member,                
                'book'=>$book,                                   
                'date'=>$date,   
                'member_id'=>$member_id,                
                'book_id'=>$book_id,   
                'will_return'=>$will_return,   
            ));
        }
        return $result;
    }
}

function insertLend($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_ledger_lends VALUES (?, ?, ?, ?, ?, ?);              
    ';    
    $query2 = '
        UPDATE perpus_books SET book_lended = 1 WHERE perpus_books.book_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'iiissi', 
            $data[0], // id
            $data[1], // member
            $data[2], // book
            $data[3], // date
            $data[4], // return                
            $data[5], // returned            
        );   
        // Bind Param 2 UPDATE perpus_books.book_lend
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, 'i',             
            $data[2], // book (update lended status)
        );                          
        // Querying
        try{
            mysqli_stmt_execute($stmt);            
            mysqli_stmt_execute($stmt2);       
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

function deleteLend($data){
    global $conn;
    // Prepare Query
    $query = '
        DELETE FROM perpus_ledger_lends WHERE lend_id= ?;
    ';
    $query2 = '
        UPDATE perpus_books SET book_lended = 0 WHERE perpus_books.book_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'i', 
            $data[0], // id            
        );
        // Bind Param 2 UPDATE perpus_books.book_lend
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, 'i',             
            $data[1], // book (update lended status)
        );   
        // Querying
        try{
            mysqli_stmt_execute($stmt);            
            mysqli_stmt_execute($stmt2);  
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

    if(isset($_GET['action']) && $_GET['action'] == 'selectLendAll'){
        echo json_encode(selectLendAll());
        exit;
    }

    if(isset($_GET['action']) && $_GET['action'] == 'selectLendByID'){
        $key = array('id');
        if(isNotBadGETRequest($key)){
            $data = getGETRequest($key);
            echo json_encode(selectLendByID($data));
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

    if(isset($_POST['action']) && $_POST['action'] == 'insertLend'){
        $form = array('id', 'member', 'book', 'date', 'return', 'returned');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            $result = insertLend($data);
            session_start();
            $_SESSION['msg'] = $result['msg'];
            header('Location: /../view/show-lends.php');
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

if(isset($_GET['mode']) && $_GET['mode'] == 'PHP'){ // GET PHP

    if(isset($_GET['action']) && $_GET['action'] == 'deleteLend'){
        $key = array('id', 'book');
        if(isNotBadGETRequest($key)){            
            $data = getGETRequest($key);
            deleteLend($data);            
            session_start();
            $_SESSION['msg'] = 'Berhasil menghapus data!';
            header('Location: /../view/show-lends.php');
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

