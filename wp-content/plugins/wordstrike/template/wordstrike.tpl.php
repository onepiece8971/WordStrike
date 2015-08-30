<html>
<?php get_header(); ?>
<body>
<div class="ui text container">
    <div data-percent="0" class="ui progress">
        <div style="transition-duration: 300ms; width: 0%;" class="bar">
            <div class="progress">0%</div>
        </div>
        <div class="label">Uploading Files</div>
    </div>
    <div class="ignored">
        <div class="ui icon buttons">
            <div class="decrement ui basic red button"><i class="minus icon"></i></div>
            <div class="add ui basic green button"><i class="plus icon"></i></div>
        </div>
    </div>
    <input id="ei" type="hidden" value="0" />
</div>
<script>
    semantic = {};
    // ready event
    semantic.ready = function () {
        var $add = $('.add'),
              $progress = $('.progress'),
            $ei = $('#ei');
        handler = {
            nonce : "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            add: function() {
                var i = $ei.val();
                $.post(
                    handler.url,
                    {_ajax_nonce:  handler.nonce, action: 'add_words_book', i: i},
                    function(result){
                        $ei.val(result);
                        console.log(result);
                        if (result != 0) {
                            if ($progress.hasClass('success')) {
                                $progress.progress('reset');
                            }
                            $progress.progress('increment', 10);
                            handler.add();
                        } else {
                            if ($progress.hasClass('success')) {
                                $ei.val(0);
                            } else {
                                $progress.addClass('warning');
                            }
                        }
//                        console.log(result);
                    }
                );
            }
        };
        $add.on('click', handler.add);
    };
    $(document).ready(semantic.ready);
</script>
</body>
</html>