<?php
/**
 * Template Name:review
 */
?>

<html>
<?php get_header(); ?>
<body>
<?php $word = getOneReviewWord(); ?>
<?php if (null == $word) : ?>
    <div class="margin100px">
        <h1 class="ui center aligned header">您已完成现阶段复习</h1>
    </div>
<?php else : ?>
    <div class="margin100px">
        <h1 class="ui center aligned header"><?php echo $word['word_name']; ?></h1>
        <h4 class="ui center aligned header"><?php echo $word['phonetic']; ?></h4>
    </div>
    <div class="ui text container">
        <div class="ui segments">
            <?php $meas = json_decode($word['means'], true);
            foreach ($meas as $key => $one) : ?>
                <div class="ui segment"><span class="ui red header"><?php echo $key; ?>. </span><?php echo $one; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="ui two bottom attached buttons">
            <div class="ui button red add">忘记</div>
            <div class="ui button green add">记得</div>
        </div>
    </div>
<?php endif; ?>
</body>

<script>
    semantic = {};
    // ready event
    semantic.ready = function () {
        var $add = $('.add'),
            words_id = "<?php echo $word['id'] ?>";
        handler = {
            nonce : "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            add: function() {
                var level = $(this).attr('level');
                $.post(
                    handler.url,
                    {_ajax_nonce:  handler.nonce, action: 'add_my_recite', words_id: words_id, level: level},
                    function(result){
                        if (result == 1) {
                            location.reload();
                        }
                    }
                );
//                console.log(level);
            }
        };
        $add.on('click', handler.add);
    };
    $(document).ready(semantic.ready);
</script>
</html>
