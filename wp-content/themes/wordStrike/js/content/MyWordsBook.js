semantic = {};

semantic.object = {
    handler : function (nonce, url) {
        var $this = this;

        $this.nonce = nonce;
        $this.url   = url;

        $this.activate = function () {
            var uid = $(this).attr('uid'),
                books_id = $(this).attr('books_id');
            if ($(this).hasClass('red')) {
                $.post(
                    $this.url,
                    {_ajax_nonce:  $this.nonce, action: 'del_my_words_book', uid: uid, books_id: books_id},
                    function(result){
                        console.log(result);
                    }
                );
            } else {
                $.post(
                    $this.url,
                    {_ajax_nonce:  $this.nonce, action: 'add_my_words_book', uid: uid, books_id: books_id}
                );
            }
        };
        $this.addSession = function () {
            $.post(
                $this.url,
                {_ajax_nonce: $this.nonce, action: 'add_session'},
                function (result) {
                    console.log(result);
                }
            );
        };

        return $this;

    }
};
// ready event
semantic.ready = function (nonce, url) {
    // selector cache
    var $toggle = $('.ui.toggle.button'),
        $a      = $('a'),
        handler = semantic.object.handler(nonce, url);

    $toggle.on('click', handler.activate);
    $toggle.state({
        text: {
            inactive: '<i class="icon plus"></i>',
            active: '<i class="icon minus"></i>'
        },
        className: {
            active: 'red'
        }
    });
    $a.on('click', handler.addSession);
};