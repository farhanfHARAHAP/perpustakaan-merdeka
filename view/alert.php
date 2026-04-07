<?php // Alert Message            
    if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){ ?>
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $_SESSION['msg'] ?></div>
        </div>
        <?php 
        $_SESSION['msg'] = '';
} ?>  