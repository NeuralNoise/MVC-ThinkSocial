$(function() {
    $('#userBirthday').datepicker({
        changeMonth : true ,
        changeYear : true,
        yearRange : '-120:+0',
        maxDate : 0,
        dateFormat : 'yy-mm-dd'
    });
    $('#editProfile').click(function(){
        if ($(this).val() != 'Submit') {
            $(this).val('Submit');
            $('#resetProfile').show();
            var title = $('title').text();
            $('title').text(title.replace('Profile', 'Edit profile'));
            $('.inputProfile').prop('disabled', false);
            $('form.userProfile').attr('action', '/profile/update/');
            return false;
        }
    });
    $('#resetProfile').click(function(){
        var title = $('title').text();
        $('title').text(title.replace('Edit profile', 'Profile'));
        $('#editProfile').val('Edit profile');
        $(this).hide();
        $('.inputProfile').prop('disabled', true);
        $('form.userProfile').attr('action', '/profile/edit/');
    });
    $('#addPhone').click(function(){
        if ($(this).val() != 'OK') {
            $(this).val('OK');
            $('#resetPhone').show();
            var title = $('title').text();
            $('title').text(title.replace('Profile', 'Adding phone'));
            $('#inputPhone').prop('required', true);
            $('.input').css('visibility', 'visible');
            $('form.userPhones').attr('action', '/profile/insert/');
            return false;
        }
    });
    $('#resetPhone').click(function(){
        var title = $('title').text();
        $('title').text(title.replace('Adding phone', 'Profile'));
        $('#addPhone').val('Add phone');
        $(this).hide();
        $('#inputPhone').prop('required', false);
        $('.input').css('visibility', 'hidden');
        $('form.userPhones').attr('action', '/profile/input/');
    });
    $('#resetAvatar').click(function(){
        $('.userAvatar').hide();
    });
    $('#changeAvatar').click(function(){
        $('.userAvatar').show();
    });
});
