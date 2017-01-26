<?php
include ROOT . '/resources/views/layouts/auth/header.php';
?>

    <div class="container">

        </br>
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/admin">Adminpanel</a></li>
                <li><a href="/admin/task">User management</a></li>
                <li class="active">Edit the user</li>
            </ol>
        </div>

        <h1 class="text-center">
        </h1>
        <form method="POST" id="id-form_messages" action="/admin/user/update/<?php echo $user->id ?>">
            <div class="form-group">
                <label for="name">Name: *</label>
                <input class="form-control" placeholder="Name" name="name" type="text" id="name" value="<?php
                echo $user->firstName;
                ?>">
                <?php if (isset($errors['firstName'])) { ?>
                    <span class="help-block">
                                        <strong><?php echo $errors['firstName']; ?></strong>
                                    </span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input class="form-control" placeholder="E-mail" name="email" type="email" id="email" value="<?= $user->email;?> ">
                <?php if (isset($errors['email'])) { ?>
                    <span class="help-block">
                                        <strong><?php echo $errors['email']; ?></strong>
                                    </span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="password">Password: *</label>
                <input class="form-control" placeholder="Пароль" name="password" type="text"  id="password" value="<?= $user->password[0]->password; ?>">
                <?php if (isset($errors['password'])) { ?>
                    <span class="help-block">
                                        <strong><?php echo $errors['password']; ?></strong>
                                    </span>
                <?php } ?>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Change">
            </div>
        </form>
    </div>
<?php
include ROOT . '/resources/views/layouts/auth/footer.php';
?>