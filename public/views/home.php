<?php

if (isset($message)):
    ?>
    <div class="alert alert-<?=$message['type']?>" role="alert">
        <?=$message['text']?>
    </div>
<?php
endif;

echo 'Framework home';

//if (isset($user)) {
//    dd($user);
//}