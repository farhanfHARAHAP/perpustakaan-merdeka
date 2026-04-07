<?php

include 'connectDB.php';

// Functions

function selectReturnAll(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT perpus_members.member_name, perpus_books.book_code, perpus_ledger_returns.return_date
        FROM perpus_ledger_returns
        LEFT JOIN perpus_members ON perpus_ledger_returns.member_id = perpus_members.member_id
        LEFT JOIN perpus_books ON perpus_ledger_returns.book_id = perpus_books.book_id
        ORDER BY perpus_ledger_returns.return_date DESC;        
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
        mysqli_stmt_bind_result($stmt, $member, $book, $date);
        $result = array(
            'data'=>array(),
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            array_push($result['data'],array(                            
                'member'=>$member,                
                'book'=>$book,                
                'date'=>$date,                                    
            ));
        }
        return $result;
    }
}

function insertReturn($data){
    global $conn;
    // Prepare Query
    $query = '
        INSERT INTO perpus_ledger_returns VALUES (?, ?, ?, ?);
    ';    
    $query2 = '
        UPDATE perpus_books SET book_lended = 0 WHERE perpus_books.book_id = ?;
    ';
    $query3 = '
        UPDATE perpus_ledger_lends SET lend_returned = 1 WHERE perpus_ledger_lends.lend_id = ?;
    ';
    if($stmt = mysqli_prepare($conn, $query)){
        // Bind Param
        mysqli_stmt_bind_param($stmt, 'iiis', 
            $data[0], // id
            $data[1], // member
            $data[2], // book
            $data[3], // date            
        );   
        // Bind Param 2 UPDATE perpus_books.book_return
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, 'i',             
            $data[2], // book (update returned status)
        );    
        // Bind Param 3 UPDATE perpus_books.book_return
        $stmt3 = mysqli_prepare($conn, $query3);
        mysqli_stmt_bind_param($stmt3, 'i',             
            $data[4], // lend_id (update returned status)
        );                        
        // Querying
        try{
            mysqli_stmt_execute($stmt);            
            mysqli_stmt_execute($stmt2);       
            mysqli_stmt_execute($stmt3);
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

    if(isset($_GET['action']) && $_GET['action'] == 'selectReturnAll'){
        echo json_encode(selectReturnAll());
        exit;
    }

    echo json_encode(array(
        'response'=>400,
        'msg'=>'Bad Request!'
    )); // BAD REQUEST
    exit;
}

if(isset($_POST['mode']) && $_POST['mode'] == 'PHP'){ // POST PHP

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_POST['action']) && $_POST['action'] == 'insertReturn'){
        $form = array('id', 'member', 'book', 'date', 'lend_id');
        if(isNotBadPOSTRequest($form)){
            $data = getPOSTRequest($form);
            $result = insertReturn($data);
            session_start();
            $_SESSION['msg'] = $result['msg'];
            header('Location: /../view/show-returns.php');
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

