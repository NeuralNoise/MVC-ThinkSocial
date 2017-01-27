    <!-- Page Container -->
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
        <!-- The Grid -->
        <div class="w3-row">
            <!-- Left Column -->
            <div class="w3-col m3">
                <!-- New Dialog -->


                <div class="w3-card-2 w3-round w3-white">
                    <div class="w3-container">
                        <div class="w3-center">

                            <button class="btn btn-primary btn-block btn-dialog" type="button" data-toggle="modal" data-target="#myModal">New dialog</button>
                            <div id="myModal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Creating dialog</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input id="dialog-name" type="text" placeholder="Enter your dialog name" class="form-control input-lg">

                                            <select data-placeholder="Choose receivers" class="chosen-select chosen-container-multi" multiple>
                                                <?php if (isset($friends)) : ?>
                                                    <?php foreach ($friends as $friend) : ?>
                                                        <option value="<?= $friend->id ?>">
                                                            <?= $friend->firstName . ' '. $friend->lastName ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif;?>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="create-dialog" class="btn btn-default" type="button">Создать</button>
                                            <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <!-- Accordion -->
                <div class="w3-card-2 w3-round">
                    <div class="w3-accordion w3-white">
                        <!-- Dialogs -->
                        <div class="w3-container r-dialog">
                            <button onclick="myFunction('Dialogs')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-envelope fa-fw w3-margin-right"></i>Recent dialogs</button>
                            <div id="Dialogs" class="w3-accordion-content w3-container w3-show">

                                <!-- member list -->

                                <ul class="dialog-list">
                                    <?php if (isset($dialogs)) : ?>
                                    <?php foreach ($dialogs as $dialog) : ?>
                                    <li dialog-id="<?= $dialog->id?>">
                                        <a href="#" class="clearfix">
                                            <div class="friend-name">
                                                <strong><?= $dialog->name ?></strong>
                                            </div>
                                            <div class="last-message text-muted">
                                                <?php if ($messages[$dialog->id]) : ?>
                                                <?= end($messages[$dialog->id])->text ?>

                                            </div>
                                            <small class="time text-muted"><?= end($messages[$dialog->id])->time ?></small>
                                            <?php else : ?>
                                            <i>Новых сообщений нет...</i>
                            </div>


                            <?php endif;?>
                            <?php foreach ($dialogRecipients[$dialog->id] as $dialogRecipient) : ?>
                                <?php if ($dialogRecipient->userId == $loggedUser->id) : ?>
                                    <?php if ($dialogRecipient->unreadCounter != 0) : ?>
                                        <small class="chat-alert label label-danger">
                                            <?= $dialogRecipient->unreadCounter ?>
                                        </small>
                                    <?php else : ?>
                                        <small class="chat-alert label label-danger"></small>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php endforeach; ?>
                            </a>
                            </li>
                            <?php endforeach; ?>
                            <?php endif;?>

                            <!--
                            <button class="btn btn-primary btn-block btn-old" >Show Older</button> -->

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Interests -->
            <div class="w3-card-2 w3-round w3-white w3-hide-small">
                <div class="w3-container">
                    <p>Interests</p>
                    <p>
                        <span class="w3-tag w3-small w3-theme-d5">News</span>
                        <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                        <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                        <span class="w3-tag w3-small w3-theme-d2">Games</span>
                        <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                        <span class="w3-tag w3-small w3-theme">Games</span>
                        <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                        <span class="w3-tag w3-small w3-theme-l2">Food</span>
                        <span class="w3-tag w3-small w3-theme-l3">Design</span>
                        <span class="w3-tag w3-small w3-theme-l4">Art</span>
                        <span class="w3-tag w3-small w3-theme-l5">Photos</span>
                    </p>
                </div>
            </div>
            <br>

            <!-- Alert Box -->
            <div class="w3-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-hover-text-grey w3-closebtn">
          <i class="fa fa-remove"></i>
        </span>
                <p><strong>Hey!</strong></p>
                <p>People are looking at your profile. Find out who.</p>
            </div>

            <!-- End Left Column -->
        </div>

        <!-- Middle Column -->
        <div class="w3-col m7">

            <div class="w3-row-padding">
                <div class="w3-col m12">
                    <div class="w3-card-2 w3-round w3-white">
                        <div class="w3-container w3-padding">
                            <!-- Messages -->
                            <div class="w3-row">

                                <div class="chat-area">
                                    <?php if (isset($dialogs)) : ?>
                                        <?php foreach ($dialogs as $dialog) : ?>
                                            <ul class="chat" chat-id="<?= $dialog->id ?>">
                                                <?php foreach ($messages[$dialog->id] as $message) : ?>
                                                    <?php foreach ($users[$dialog->id] as $user) : ?>
                                                        <?php if ($user->id == $message->senderId) : ?>
                                                            <?php if ($user->id == $loggedUser->id) : ?>
                                                                <li class="right clearfix">
                                                                <span class="chat-img pull-right">
                                                            <?php else: ?>
                                                                <li class="left clearfix">
                                                                <span class="chat-img pull-left">
                                                            <?php endif;?>
                                                            <img src="/avatars/default.jpeg" alt="User Avatar">
                                                            </span>
                                                            <div class="chat-body clearfix">
                                                                <div class="header">
                                                                    <strong class="primary-font"><?= $user->firstName . ' '. $user->middleName . ' '. $user->lastName ?></strong>
                                                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?= $message->time ?></small>
                                                                </div>
                                                                <?php if ($user->id == $loggedUser->id) : ?>
                                                                <p class="chat-message dark">
                                                                    <?php else: ?>
                                                                <p class="chat-message">
                                                                    <?php endif;?>
                                                                    <?= $message->text ?>
                                                                </p>
                                                            </div>
                                                            </li>
                                                        <?php endif;?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                    <?php endif;?>

                                    <ul class="chat">
                                    </ul>
                                </div><!--chat-area-->

                                <div class="message-write">
                                    <div class="write-panel">
                                        <div class="row">
                                            <div class="col-xs-9">
                                                <textarea id="msg" placeholder="Enter your message..."class="form-control chat-input"></textarea>
                                            </div>
                                            <div class="col-xs-3">
                                                <button id="send-msg" class="btn btn-primary btn-block" type="submit">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Messages --> </div>
                    </div>
                </div>
            </div>

            <!-- End Middle Column -->
        </div>

        <script src="/js/chosen.js"></script>
        <script src="/js/dialog.js"></script>
        <script>
            // Accordion
            function myFunction(id) {
                var x = document.getElementById(id);
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                    x.previousElementSibling.className += " w3-theme-d1";
                } else {
                    x.className = x.className.replace("w3-show", "");
                    x.previousElementSibling.className =
                        x.previousElementSibling.className.replace(" w3-theme-d1", "");
                }
            }

            // Used to toggle the menu on smaller screens when clicking on the menu button
            function openNav() {
                var x = document.getElementById("navDemo");
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }
        </script>
