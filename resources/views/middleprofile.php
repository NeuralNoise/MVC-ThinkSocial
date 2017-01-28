<!-- Middle Column -->
<div class="w3-col m7">

    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <!--              <h6 class="w3-opacity">Social Media template by w3.css</h6>
                                  <p class="w3-border w3-padding" contenteditable="true"> New post</p>  -->
                    <button type="button" class="w3-btn w3-theme" id="changeAvatar"><i class="fa"></i>Change avatar</button>
                    <form name="userAvatar" class="userAvatar" action="/profile/upload/" method="post" enctype="multipart/form-data" hidden>
                        <input type="file" id="fileName" name="fileName" class="fileName">
                        <input type="submit" class="avatar profile" id="submitAvatar" value="OK">
                        <input type="reset" class="avatar profile" id="resetAvatar" value="Reset">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>

    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/profile.css" rel="stylesheet">
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/profile.js"></script>

    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <form name="userProfile" class="userProfile" action="/profile/<?=$submitAction?>/" method="post">
                        <h4 class="w3-center">My Profile</h4>
                        <p><label for="userEmail">e-mail</label><input type="email" name="email" id="userEmail" value="<?=$user->email?>" disabled></p>
                        <p><label for="userFirstName">First name</label><input type="text" class="inputProfile" name="firstName" id="userFirstName" value="<?=$user->firstName?>" pattern="[A-ZА-ЯЁ][a-zа-яё]+" title="Your first name" <?=$allowEdit?> required maxlength="25"></p>
                        <p><label for="userMiddleName">Middle name</label><input type="text" class="inputProfile" name="middleName" id="userMiddleName" value="<?=$user->middleName?>" pattern="[A-ZА-ЯЁ][a-zа-яё]+" title="Your middle name" <?=$allowEdit?> required maxlength="25"></p>
                        <p><label for="userLastName">Last name</label><input type="text" class="inputProfile" name="lastName" id="userLastName" value="<?=$user->lastName?>" pattern="[A-ZА-ЯЁ][a-zа-яё]+" title="Your last name" <?=$allowEdit?> required maxlength="25"></p>
                        <p><label for="userBirthday">Birthday</label><input type="date" class="inputProfile" name="birthday" id="userBirthday" value="<?=$user->birthday?>" title="Your birthday" <?=$allowEdit?> required></p>
                        <p><label for="userSex">Gender</label> <input type="radio" class="inputProfile" name="sex" id="userSex" value="female" <?=(($user->sex=='female')? "checked ":"")?><?=$allowEdit?>> Female
                            <input type="radio" class="inputProfile" name="sex" id="userSex" value="male" <?=(($user->sex=='male')? "checked ":"")?><?=$allowEdit?>> Male</p>
                        <input type="submit" class="submit profile" id="editProfile" value="<?=$submitValue?>">
                        <input type="reset" class="profile" id="resetProfile" value="Reset" hidden>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <form name="userPhones" class="userPhones" action="/profile/<?=$submitPhoneAction?>/" method="post">
                        <h4 class="w3-center">My Phones</h4>
                        <?php foreach ($userPhones as $userPhone): ?>
                        <p><label for="userPhone">Phone</label><input type="text" name="phone" id="userPhone" value="<?=$userPhone->phone?>" disabled>
                            <input type="hidden" name="phoneID" value="<?=$userPhone->id?>">
                            <button type="submit" formaction="/profile/delete/">Delete</button>
                            <?php endforeach; ?>
                        <p><label for="inputPhone" class="<?=$submitPhoneAction?>">Input number</label><input type="text" id="inputPhone" name="newPhone" class="<?=$submitPhoneAction?>" title="Your phone number (only digits)" pattern="[0-9]+" maxlength="15"></p>
                        <input type="submit" class="submit profile" id="addPhone" value="<?=$submitPhoneValue?>">
                        <input type="reset" class="profile" id="resetPhone" value="Reset" hidden>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- End Middle Column -->
</div>