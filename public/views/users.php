<?php
/** @var array $users */
?>

<h2 class="h3 text-center mb-4">
    Users (use cache)
</h2>

<div class="row">
    <div class="col-6 mx-auto">
        <?php
        if (count($users) > 0):
            ?>
            <ul class="list-group">
                <?php
                foreach ($users as $user):
                    ?>
                    <li class="list-group-item">
                        <?= $user->id . ') ' . $user->name . ' ' . $user->email ?>
                    </li>
                <?php
                endforeach;
                ?>
            </ul>
        <?php
        else:
            ?>
            <p class="text-center">There are no users</p>
        <?php
        endif;
        ?>
    </div>
</div>
