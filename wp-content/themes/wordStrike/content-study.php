<?php
/**
 * Template Name:study
 */
?>

<html>
<?php get_header(); ?>
<body>
<?php $word = randOneWord(); ?>
<?php if (null == $word) : ?>
    <div class="margin100px">
        <h1 class="ui center aligned header">该生词本已背完</h1>
    </div>
<?php else : ?>
<div class="margin100px">
    <h1 class="ui center aligned header"><?php echo $word['word_name']; ?></h1>
    <h4 class="ui center aligned header"><span id="play"><?php echo $word['phonetic']; ?></span></h4>
    <audio src=
    <?php if (empty($word['voice'])) : ?>
        "http://dict.youdao.com/dictvoice?audio=<?php echo $word['word_name']; ?>&type=2"
    <?php else : ?>
        <?php echo $word['voice']; ?>
    <?php endif; ?>
    >对不起,您的浏览器已经跟不上时代,请下载最新的现代浏览器</audio>
</div>
<div class="ui text container">
    <div class="ui segments">
        <?php $meas = json_decode($word['means'], true);
        foreach ($meas as $key => $one) : ?>
        <div class="ui segment"><span class="ui red header"><?php echo $key; ?>. </span><?php echo $one; ?></div>
        <?php endforeach; ?>
    </div>
    <div class="ui two bottom attached buttons">
        <div class="ui button red add" level="0">熟词</div>
        <div class="ui button green add" level="1">加入生词本</div>
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

        $('#play').click(function(){
            $('audio')[0].play();
        }).mouseover(function(){
            $('audio')[0].play();
        })
    };
    $(document).ready(semantic.ready);
</script>
</html>
