<?php
if (isset($errors)) {
    $emailErrors = $errors['email'] ?? [];
    $nameErrors = $errors['name'] ?? [];
    $passwordErrors = $errors['password'] ?? [];
    $confirmPasswordErrors = $errors['confirmPassword'] ?? [];
} else {
    $emailErrors = $nameErrors = $passwordErrors = $confirmPasswordErrors = [];
}
?>

<h2 class="h3 text-center mb-4">
    Sign Up
</h2>

<form action="/register" method="POST" class="col-md-8 col-lg-7 col-xl-6 mx-auto">
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
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input name="name" type="text" class="form-control" id="name" placeholder="Name">
            <?php
            foreach ($nameErrors as $errorText):
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

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </div>
</form>