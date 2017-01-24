(function () {
    var TRUE = 1;
    var FALSE = 0;
    var GROUP_CREATION_HANDLER = "/groups/add";
    var GROUP_SUBSCRIBE_HANDLER = "/groups/subscribe/";
    var GROUP_UNSUBSCRIBE_HANDLER = '/groups/unsubscribe/';
    var MY_GROUPS_SEARCH = '/groups/mysearch';
    var GROUPS_SEARCH = '/groups/search';
    var GROUP_CREATION_TIMER = 60000;
    var UNSUBSCRIBE_BUTTON_CLASS = 'w3-red';
    var SUBSCRIBE_BUTTON_CLASS = 'w3-indigo';
    var CREATION_STAMP = TRUE;
    var offsetY = 0;
    var offsetX = 0;
    var hidden = 'sg-hidden';
    var POST_MAX_SIZE = 5000000;
    var groupId = /id([0-9]+)$/;
    var APPROPRIATE_IMEGE_TYPES = {'image/gif' : 1, 'image/jpeg' : 2, 'image/png' : 3};
    var panel = {},
        newsSubmit = {},
        dropBox = {},
        postNewsPanel = {},
        groupCreationForm = {},
        avatarUploader = {},
        myGroupSearch = {},
        innerSearch = {},
        searchBox = {};


    var checkNode = function (node) {
        if (!node) {
            return false;
        } else {
            return node;
        }
    };

    var eventSubscriber = function (node, event, func) {
        if (!node) {
            return false;
        }
            node.addEventListener(event, func);
    };

    var preventAditionRequest = function () {
        if (!CREATION_STAMP) {
            return false;
        }
        CREATION_STAMP = FALSE;
        setTimeout(function () {
            CREATION_STAMP = TRUE;
        }, GROUP_CREATION_TIMER);
    };

    var actionGroupUnSubscribe = function (event) {
        event.preventDefault();
        var that = this;
        if (groupId.test(this.href)){
            var id = groupId.exec(this.href)[0];
            var request = new XMLHttpRequest();
            request.open('POST', this.href, true);
            request.send();
            request.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 204) {
                        that.classList.remove(UNSUBSCRIBE_BUTTON_CLASS);
                        that.classList.add(SUBSCRIBE_BUTTON_CLASS);
                        that.href = GROUP_SUBSCRIBE_HANDLER + id;
                        that.innerHTML = "Subscribe";
                        that.removeEventListener('click', actionGroupUnSubscribe);
                        that.addEventListener('click', actionGroupSubscribe);
                    }
                }
            }
        } else {
            return false;
        }
    };

    var actionGroupSubscribe = function (event) {
        event.preventDefault();
        var that = this;
        if (groupId.test(this.href)){
            var id = groupId.exec(this.href)[0];
            var request = new XMLHttpRequest();
            request.open('POST', this.href, true);
            request.send();
            request.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 204) {
                        that.classList.remove(SUBSCRIBE_BUTTON_CLASS);
                        that.classList.add(UNSUBSCRIBE_BUTTON_CLASS);
                        that.href = GROUP_UNSUBSCRIBE_HANDLER + id;
                        that.innerHTML = "Unsubscribe";
                        that.removeEventListener('click', actionGroupSubscribe);
                        that.addEventListener('click', actionGroupUnSubscribe);
                    }
                }
            }
        } else {
            return false;
        }
    };

    var actionGroupCreate = function (event) {
        event.preventDefault();
        preventAditionRequest();
        var form = this;
        var messageBoxSuccess = document.createElement('div');
        messageBoxSuccess.classList.add('create-group-msg-box-success');
        var messageBoxError = document.createElement('div');
        messageBoxError.classList.add('create-group-msg-box-error');
        var response = "";

        var groupName = this.getElementsByClassName('group-create-input')[0].value;
        var groupDescription = this.getElementsByClassName('create-group__describe')[0].value;
        var message = 'group-name=' + groupName + "&description=" + groupDescription;


        var request = new XMLHttpRequest();
        request.open('POST', GROUP_CREATION_HANDLER, true);
        request.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
        request.send(message);
        request.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 201) {
                    messageBoxSuccess.innerHTML = request.getResponseHeader("X-COMMENT-RESPONSE");
                    form.insertBefore(messageBoxSuccess, form.firstChild);
                    setTimeout(function () {
                        location.href = request.getResponseHeader("Location");
                    }, 1000);
                }
            }
        }
    };

    var showParange = function(event){
        event.preventDefault();
        offsetY = window.pageYOffset;
        var parange = document.getElementById('parange');
        parange.style['display'] = "block";
        document.body.classList.add('bodyflow');
        var groupName = document.getElementsByName('group-name');
        groupName[0].focus();
    };

    var closeParange = function() {
        document.body.classList.remove('bodyflow');
        document.getElementById('parange').style['display'] = null;
        window.scroll(offsetX, offsetY);
    };

    var showNewsAdder = function () {
        newsSubmit.classList.remove(hidden);
    };

    var hideNewsAdder = function (event) {
        if(!panel) {
            return false;
        }
        var node = event.target;
        var input = document.getElementsByClassName('post-news-input')[0];
        var documentChecker = function (node) {
          if (node == panel) {
            return false;
          } else if (node != document) {
              documentChecker(node.parentNode);
          } else {
              if (input.value == '') {
                newsSubmit.classList.add(hidden);
              }
          }
        };
        documentChecker(node);
    };

    var dropBoxOver = function (event) {
        event.preventDefault();
        dropBox.classList.add('hover');
    };

    var dropBoxLeave = function () {
        dropBox.classList.remove('hover');
    };

    var dropBoxError = function (box, message) {
        var firstStage = box.innerHTML;
        var errorBox = document.createElement("DIV");
        errorBox.classList.add('drop-box-upload-error');
        errorBox.innerHTML = "Sorry, but this file hasn't been uploaded.";
        var errorMsg = document.createElement("DIV");
        errorMsg.classList.add('drop-box-upload-error-msg');
        errorMsg.innerHTML = message;
        box.innerHTML = "";
        box.appendChild(errorBox);
        box.appendChild(errorMsg);
        box.classList.add('error');
        setTimeout(function () {
            box.innerHTML = firstStage;
            box.classList.remove('error');
        }, 5000);
    };

    var dropBoxFileUpload = function(box, file)
    {
        var firstState = box.innerHTML;
        var fileInput = document.getElementsByClassName('avatar-upload-file')[0];
        if (file.type in APPROPRIATE_IMEGE_TYPES) {
            if(parseInt(file.size) > POST_MAX_SIZE) {
                dropBoxError(box, "Inappropriate file size. <br> Max Size Available 5M");
            } else {
                var formData = new FormData();
                formData.append("avatar", file);
                var request = new XMLHttpRequest();
                request.open('POST', location.href, true);
                request.setRequestHeader('X_PAGE_ACTION', "avatar_upload");
                var progressTitle = document.createElement('DIV');
                progressTitle.classList.add("drop-box-upload-msg");
                progressTitle.innerText = 'Uploading file in progress:';
                var progressBar = document.createElement('DIV');
                progressBar.classList.add('progress-status-bar');
                var progressMsg = document.createElement('SPAN');
                progressMsg.classList.add("progress-msg");
                var progressPercent = document.createElement('SPAN');
                progressPercent.classList.add("progress-percentage");
                progressBar.appendChild(progressMsg);
                progressBar.appendChild(progressPercent);

                request.upload.onloadstart = function () {
                    box.innerHTML = "";
                      box.appendChild(progressTitle);
                      box.appendChild(progressBar);
                      box.removeEventListener('drop' , dropBoxUpload);
                };

                request.upload.onprogress = function (event) {
                    var percent = parseInt(parseInt(event.loaded) / parseInt(event.total) * 100);
                    progressMsg.innerHTML = percent + " / 100";
                    progressPercent.style.width = percent + "%";
                };

                request.upload.onerror = function () {
                    box.innerHTML = firstState;
                    dropBoxError(box, "Error while uploading");
                };

                request.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        box.addEventListener('drop' , dropBoxUpload);
                        var parent = box.parentNode;
                        box.innerHTML = firstState;
                        if (this.status == 201) {
                            var img = document.createElement("IMG");
                            img.src = request.getResponseHeader('Location');
                            img.style.width = '100%';
                            img.style['min-height'] = '190px';
                            img.classList.add('group-avatar-page-image');
                            parent.insertBefore(img, box);
                            parent.removeChild(box);
                            parent.removeChild(fileInput);
                        } else if (this.status == 403) {
                            dropBoxError(box, request.getResponseHeader('X-COMMENT-RESPONSE'));
                        } else if (this.status == 406) {
                            dropBoxError(box, request.getResponseHeader('X-COMMENT-RESPONSE'));
                        } else if (this.status == 503) {
                            dropBoxError(box, request.getResponseHeader('X-COMMENT-RESPONSE'));
                        } else {
                            dropBoxError(box, "Error while uploading");
                        }
                    }
                };
                request.send(formData);
            }
        } else {
            dropBoxError(box, "Inappropriate file format <br> Available: jpeg,png,gif,svg");
        }
    };

    var dropBoxUpload = function (event) {
        event.preventDefault();
        dropBox.classList.remove('hover');
        var file = event.dataTransfer.files[0];
        dropBoxFileUpload(this, file);
    };

    var dropBoxFormUpload = function (event) {
        event.preventDefault();
        var file = this.files[0];
        dropBoxFileUpload(dropBox, file);
    };

    var refresh = function () {
        if ( this.value == "") {
            var box = document.getElementById('my-search-wrapper');
            box.innerHTML = innerSearch;
        }
    };

    var myGroups = function (event) {
        var box = document.getElementById('my-search-wrapper');
        var search = this.value + event.key;
        var request = new XMLHttpRequest();
        request.open('POST', MY_GROUPS_SEARCH, true);
        request.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
        request.send('search='+search);
        request.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    box.innerHTML = "";
                    var json = JSON.parse(request.responseText);
                    for (var i in json['owner']) {
                        var card = document.createElement('section');
                        card.classList.add('group-card');
                        card.classList.add('mine');
                        var img = document.createElement('img');
                        img.src = "/avatars/" + json['owner'][i]['photo'];
                        img.classList.add('group-card__avatar');
                        img.style.width = "100px";
                        img.style.height = "100px";
                        var desc = document.createElement('div');
                        desc.classList.add('group-desc');
                        var groupName = document.createElement('a');
                        groupName.href = "/groups/page/id" + i;
                        groupName.classList.add('group-card__group-name');
                        groupName.appendChild(document.createTextNode(json['owner'][i]['name']));
                        var groupDesc = document.createElement('div');
                        groupDesc.classList.add('group-card__desc');
                        groupDesc.appendChild(document.createTextNode(json['owner'][i]['desc']));
                        desc.appendChild(groupName);
                        desc.appendChild(groupDesc);
                        var a = document.createElement('a');
                        a.href = "/groups/page/id" + i;
                        a.innerText = "To Page";
                        a.classList.add('group-card__subs');
                        a.classList.add('w3-btn');
                        a.classList.add('w3-ripple');
                        a.classList.add('w3-teal');
                        card.appendChild(img);
                        card.appendChild(desc);
                        card.appendChild(a);
                        box.appendChild(card);
                    }

                    for (var i in json['subscriber']) {
                        var card = document.createElement('section');
                        card.classList.add('group-card');
                        var img = document.createElement('img');
                        img.src = "/avatars/" + json['subscriber'][i]['photo'];
                        img.classList.add('group-card__avatar');
                        img.style.width = "100px";
                        img.style.height = "100px";
                        var desc = document.createElement('div');
                        desc.classList.add('group-desc');
                        var groupName = document.createElement('a');
                        groupName.href = "/groups/page/id" + i;
                        groupName.classList.add('group-card__group-name');
                        groupName.appendChild(document.createTextNode(json['subscriber'][i]['name']));
                        var groupDesc = document.createElement('div');
                        groupDesc.classList.add('group-card__desc');
                        groupDesc.appendChild(document.createTextNode(json['subscriber'][i]['desc']));
                        desc.appendChild(groupName);
                        desc.appendChild(groupDesc);
                        var a = document.createElement('a');
                        a.href = "/groups/unsubscribe/id" + i;
                        a.innerText = "Unsubscribe";
                        a.classList.add('group-card__subs');
                        a.classList.add('w3-btn');
                        a.classList.add('w3-ripple');
                        a.classList.add('w3-red');
                        eventSubscriber(a, 'click', actionGroupUnSubscribe);
                        card.appendChild(img);
                        card.appendChild(desc);
                        card.appendChild(a);
                        box.appendChild(card);
                    }
                }
            }
        }
    };

    var Groups = function (event) {
        var box = document.getElementById('my-search-wrapper');
        var search = this.value + event.key;
        var request = new XMLHttpRequest();
        request.open('POST', GROUPS_SEARCH, true);
        request.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
        request.send('search='+search);
        request.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    box.innerHTML = "";
                    var json = JSON.parse(request.responseText);
                    for (var i in json['new']) {
                        var card = document.createElement('section');
                        card.classList.add('group-card');
                        var img = document.createElement('img');
                        img.src = "/avatars/" + json['new'][i]['photo'];
                        img.classList.add('group-card__avatar');
                        img.style.width = "100px";
                        img.style.height = "100px";
                        var desc = document.createElement('div');
                        desc.classList.add('group-desc');
                        var groupName = document.createElement('a');
                        groupName.href = "/groups/page/id" + i;
                        groupName.classList.add('group-card__group-name');
                        groupName.appendChild(document.createTextNode(json['new'][i]['name']));
                        var groupDesc = document.createElement('div');
                        groupDesc.classList.add('group-card__desc');
                        groupDesc.appendChild(document.createTextNode(json['new'][i]['desc']));
                        desc.appendChild(groupName);
                        desc.appendChild(groupDesc);
                        var a = document.createElement('a');
                        a.href = "/groups/subscribe/id" + i;
                        a.innerText = "Subscribe";
                        a.classList.add('group-card__subs');
                        a.classList.add('w3-btn');
                        a.classList.add('w3-ripple');
                        a.classList.add('w3-indigo');
                        eventSubscriber(a, 'click', actionGroupSubscribe);
                        card.appendChild(img);
                        card.appendChild(desc);
                        card.appendChild(a);
                        box.appendChild(card);
                    }
                }
            }
        }
    };


    var init = function () {
        panel = checkNode(document.getElementsByClassName('post-news-panel')[0]);
        newsSubmit = checkNode(document.getElementsByClassName('post-news-submit')[0]);
        dropBox = checkNode(document.getElementsByClassName('avatar-drop-box')[0]);
        postNewsPanel = checkNode(document.getElementsByClassName('post-news-panel')[0]);
        groupCreationForm = checkNode(document.getElementsByClassName('form-bag')[0]);
        avatarUploader = checkNode(document.getElementsByClassName('avatar-upload-file')[0]);
        myGroupSearch = checkNode(document.getElementsByClassName('my-group-search')[0]);
        GroupSearch = checkNode(document.getElementsByClassName('group-search')[0]);
        searchBox = checkNode(document.getElementById('my-search-wrapper'));

        var groupBtns = document.getElementsByClassName('group-card__subs');
        for (var i = 0; i < groupBtns.length ; i++) {
            if (groupBtns[i].classList.contains(UNSUBSCRIBE_BUTTON_CLASS)) {
                eventSubscriber(groupBtns[i], 'click', actionGroupUnSubscribe);
            } else if (groupBtns[i].classList.contains(SUBSCRIBE_BUTTON_CLASS)) {
                eventSubscriber((groupBtns[i]), 'click', actionGroupSubscribe);
            }
        }
        if (searchBox) {
            innerSearch = searchBox.innerHTML;
        }
        eventSubscriber(document.getElementById('create-group-btn'), 'click', showParange);
        eventSubscriber(document.getElementById('create-group-close'), 'click', closeParange);
        eventSubscriber(postNewsPanel, 'click', showNewsAdder);
        eventSubscriber(document, 'click', hideNewsAdder);
        eventSubscriber(dropBox, 'dragover', dropBoxOver);
        eventSubscriber(dropBox, 'dragleave', dropBoxLeave);
        eventSubscriber(dropBox, 'drop', dropBoxUpload);
        eventSubscriber(groupCreationForm, 'submit', actionGroupCreate);
        eventSubscriber(avatarUploader, 'change', dropBoxFormUpload);
        eventSubscriber(myGroupSearch, 'keypress', myGroups);
        eventSubscriber(myGroupSearch, 'blur', refresh);
        eventSubscriber(GroupSearch, 'blur', refresh);
        eventSubscriber(GroupSearch, 'keypress', Groups);
    };

    var onWindowLoad = function () {
        window.addEventListener('load', init);
    };

    onWindowLoad();
})();
