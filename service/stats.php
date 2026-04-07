<?php

include 'connectDB.php';

// Functions

function countMember(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT COUNT(perpus_members.member_id)
        FROM perpus_members
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
        mysqli_stmt_bind_result($stmt, $count);
        $result = array(
            'count'=>0,
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            $result['count'] = $count;
        }
        return $result;
    }
}

function countMemberCategory(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT COUNT(perpus_member_categories.category_id)
        FROM perpus_member_categories
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
        mysqli_stmt_bind_result($stmt, $count);
        $result = array(
            'count'=>0,
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            $result['count'] = $count;
        }
        return $result;
    }
}

function countBook(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT COUNT(perpus_books.book_id)
        FROM perpus_books
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
        mysqli_stmt_bind_result($stmt, $count);
        $result = array(
            'count'=>0,
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            $result['count'] = $count;
        }
        return $result;
    }
}

function countBookCategory(){
    global $conn;
    // Prepare Query
    $query = '
        SELECT COUNT(perpus_book_categories.category_id)
        FROM perpus_book_categories
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
        mysqli_stmt_bind_result($stmt, $count);
        $result = array(
            'count'=>0,
            'response'=>200,
            'msg'=>'Berhasil mengakses data!'
        );
        while(mysqli_stmt_fetch($stmt)){
            $result['count'] = $count;
        }
        return $result;
    }
}

// Services

if(isset($_GET['mode']) && $_GET['mode'] == 'JSON'){

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_GET['action']) && $_GET['action'] == 'giveStat'){
        $members = countMember()['count'];
        $member_categories = countMemberCategory()['count'];
        $books = countBook()['count'];
        $book_categories = countBookCategory()['count'];
        echo json_encode(array(
            'data'=>array(
                'members'=>$members,
                'member_categories'=>$member_categories,
                'books'=>$books,
                'book_categories'=>$book_categories,
            ),
            'response'=>200,
            'msg'=>'Success!'
        ));
        exit;
    }

    echo json_encode(array(
        'response'=>400,
        'msg'=>'Bad Request!'
    )); // BAD REQUEST
    exit;
}