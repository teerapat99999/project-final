<?php if(isset($_SESSION['alert'])){ ?>
<label>
    <div class="alert alert-danger">
        <?php 
        echo $_SESSION['alert']; 
        unset($_SESSION['alert']);
        ?>
    </div>
</label>
<?php } ?>