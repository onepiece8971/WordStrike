<html>
<?php get_header(); ?>
<body>
<div class="ui text container">
    <div data-percent="0" class="ui progress">
        <div style="transition-duration: 300ms; width: 0%;" class="bar">
            <div class="progress">0%</div>
        </div>
        <div class="label">上传生词本</div>
    </div>
    <button class="ui compact icon button green toggle add">
        <i class="icon plus"></i>
    </button>
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
                        var result = JSON.parse(result);
                        $ei.val(result.i);
                        console.log(result);
                        if (result.flag == 1) {
                            if ($progress.hasClass('success')) {
                                $progress.progress('reset');
                            }
                            $progress.progress('increment', result.percent);
                            handler.add();
                        } else if (result.flag == 2) {
                            $progress.progress('increment', result.percent);
                            $ei.val(0);
                            $add.removeClass('disabled');
                        } else {
                            $progress.addClass('warning');
                            $add.removeClass('disabled');
                        }
                    }
                );
            }
        };
        $add.on('click', function(){
            $progress.addClass('active');
            $add.addClass('disabled');
        });
        $add.on('click', handler.add);
    };
    $(document).ready(semantic.ready);
</script>
</body>
</html>