<?php
if (isset($formErrors)) {
    $emailErrors = $formErrors['email'] ?? [];
    $passwordErrors = $formErrors['password'] ?? [];
} else {
    $emailErrors = $passwordErrors = [];
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
    Login
</h2>

<form action="/login" method="POST" class="col-md-8 col-lg-7 col-xl-6 mx-auto">
    <div class="form-group row mb-3">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
            <?php
            foreach ($emailErrors as $errorText):
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

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="/password/reset" class="link-primary">Forgot password?</a>
    </div>
</form>