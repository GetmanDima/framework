<?php
/** @var string $token */

if (isset($formErrors)) {
    $passwordErrors = $formErrors['password'] ?? [];
    $confirmPasswordErrors = $formErrors['confirmPassword'] ?? [];
} else {
    $passwordErrors = $confirmPasswordErrors = [];
}
?>

<?php
if (isset($alertMessage)):
    ?>
    <div class="alert alert-<?=$alertMessage['type']?>" role="alert">
        <?=$alertMessage['text']?>
    </div>
<?php
endif
?>

<h2 class="h3 text-center mb-4">
    Reset password
</h2>

<form action="/password/reset" method="POST" class="col-md-8 col-lg-7 col-xl-6 mx-auto">
    <div class="form-group row mb-3">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            <?php
            foreach ($passwordErrors as $errorText):
                ?>
                <div class="form-text text-danger">
                    <?= $errorText ?>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="confirm-password" class="col-sm-2 col-form-label">Confirm password</label>
        <div class="col-sm-10">
            <input name="confirmPassword" type="password" class="form-control" id="confirm-password" placeholder="Confirm password">
            <?php
            foreach ($confirmPasswordErrors as $errorText):
                ?>
                <div class="form-text text-danger">
                    <?= $errorText ?>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>

    <input type="hidden" name="token" value="<?=$token?>">

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Reset</button>
    </div>
</form>
