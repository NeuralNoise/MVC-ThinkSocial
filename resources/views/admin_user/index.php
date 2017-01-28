<?php
include ROOT . '/resources/views/layouts/auth/header.php';
?>
    <div class="container">
        </br>
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/admin">Adminpanel</a></li>
                <li class="active">User management</li>
            </ol>
        </div>
        <h1 class="text-center">
        </h1>
        <div class="text-right"><b>All users:</b> <i class="badge"><?php echo count($users); ?></i></div>
        <br/>
        <div class="messages">
            <?php if (count($users)) { ?>
                <?php foreach ($users as $user) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                           <span>
                         <a href="/admin/user/update/<?php echo $user->id ?>"><?= $user->firstName . ' ' .  $user->lastName ?></a>
                        </span>
                                <span class="pull-right label label-info">
                           <?php echo $user->birthday; ?>
                        </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                          <img src="/avatars/<?=isset($user->avatarFileName)? $user->avatarFileName:'default.jpeg'?>" style="height:120px;width:100px">
                             <hr/>
                            <div class="pull-right">
                                <a class="btn btn-info" href="/admin/user/update/<?= $user->id ?>">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a class="btn btn-danger" href="/admin/user/delete/<?= $user->id ?>">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="text-center">
                    <?php //$tasks->render() ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
include ROOT . '/resources/views/layouts/auth/footer.php';
?>