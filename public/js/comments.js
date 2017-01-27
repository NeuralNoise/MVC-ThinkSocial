(function ($) {
    $(document).ready(function () {

        var article = $('article');

        article.on('click', '.btn-comment', function (){
            var idNews = $(this).attr("data-id");
            $('.unique-form-'+idNews).slideDown();
        });

        $(document).click(function(event){
            if ($(event.target).closest(".post").length ) {
                return;
            }

            $('.write-comment').slideUp();
        });

        $(document).click(function(event){
            if ($(event.target).closest(".post").length ) {
                return;
            }

            var comments = document.getElementsByClassName('comments');
            for(var i=0; i<comments.length; i++) {
                if (comments[i].innerHTML != "") {
                    comments[i].innerHTML = "";
                }
            }

        });

        article.on('click', '.btn-add-comment', function (){
            var dataFormComment = $('#write-comments-form[form-id="'+$(this).attr("data-id")+'"]' ).serializeArray();
            var dataMsg = '';
            $.each(dataFormComment,function(){
                dataMsg = this.value;
            });


            var idNews = $(this).attr("data-id");

            $.ajax({
                type: 'POST',
                url: 'comments/add-comments',
                data: {dataForm: dataMsg, id: idNews},
                datatype: 'JSON',
                success: function (result) {
                    location.reload();
                },
                error: function() {
                    alert('Something went wrong. Sorry :\'(');
                }
            });

            return false;
        });

        $(document).on('click', '.btn-show', function () {
            var idNews = $(this).attr("data-id");
            var box = this.parentNode.nextSibling.innerHTML;

            if (box == "") {
                $.ajax({
                    type: 'POST',
                    url: 'comments/get-comments',
                    data: {'id': JSON.stringify($(this).attr("data-id"))},
                    success: function (result) {
                        var data = JSON.parse(result);
                        console.log(data);
                        var comments = data.comments;
                        var user = data.user;

                        comments.forEach(function (item, i, comments) {
                            $('article div[comment-id="' + idNews+'"]').append(getCommentTemplate(item, user));
                        });

                    },
                    error: function (data) {
                        alert('Something went wrong. Sorry :\'(');
                    }
                });
            }
        });

        article.on('click', '.comment-delete', function () {
            $.ajax({
                type: 'POST',
                url: 'comments/delete-comments',
                data: {'id':JSON.stringify($(this).attr("data-id"))},
                success: function (result) {
                    location.reload();
                },
                error: function () {
                    alert('Something went wrong. Sorry :\'(');
                }
            });
        });

        function getCommentTemplate(data, user) {
            return    '<div class="row">'
                    + '<div class="user-avatar"><img src="avatars/'+user.avatarFileName+'"></div>'
                    + '<div class="comment-info">'
                    + '<div class="row">'
                    + '<div class="username">'+user.firstName+' '+user.lastName+'</div>'
                    + '<div class="comment-time">'+data.created_at+'</div>'
                    + '<div class="comment-delete"  data-id="'+data.id+'"> <i class="fa fa-times" aria-hidden="true"></i></div>'
                    + '<div class="text-comment">'+data.text+'</div></div></div>';
        }
    });
})(jQuery);
