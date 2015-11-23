semantic = {};

semantic.object = {
    handler: function (nonce, url, wordsId) {

        this.nonce = nonce;
        this.url = url;
        this.add = function () {
            var level = $(this).attr('level');
            $.post(
                this.url,
                {_ajax_nonce: this.nonce, action: 'add_my_recite', words_id: wordsId, level: level},
                function (result) {
                    if (result == 1) {
                        location.reload();
                    }
                }
            );
        };
        this.upgrade = function () {
            var type = $(this).attr('type');
            $.post(
                this.url,
                {_ajax_nonce: this.nonce, action: 'upgrade_my_recite', words_id: wordsId, type: type},
                function (result) {
                    if (result == 1) {
                        location.reload();
                    }
                }
            );
        };
        this.show = function () {
            $('#show').hide();
            $('#show2').show();
        };
        this.keyDownEvent = function (event) {
            if (event.keyCode == 38) {
                $('audio')[0].play();
            } else if (event.keyCode == 37) {
                $('.bottom-button .button.left').click();
            } else if (event.keyCode == 39) {
                $('.bottom-button .button.right').click();
            } else if (event.keyCode == 40) {
                this.show();
            }
        }
    }
};

// ready event
semantic.ready = function (handler, todayCount) {
    if (todayCount == 20) {
        alert('今天已经背了20个单词!');
    }
    var $add = $('.add'),
        $upgrade = $('.upgrade'),
        $show = $('#show');

    $add.on('click', handler.add);
    $upgrade.on('click', handler.upgrade);
    $show.on('click', handler.show);
    $('#play').click(function () {
        $('audio')[0].play();
    });

    var width = $('.ui.text.container').width();
    $('.bottom-button').width(width);
    $('.bottom-button .button').width(width / 2 - 50);
};