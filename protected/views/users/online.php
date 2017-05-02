<?php

    foreach ($model as $value){  ?>
        <div class="status_user">
            <?php echo 'Username : '. $value->username;
            echo '<br>';
            echo 'Status : '. Status::Comparison($value->status->date);
            echo '<br>';
            echo '<br>';
            echo '<br>';  ?>
        </div>

<?php
    }
?>







