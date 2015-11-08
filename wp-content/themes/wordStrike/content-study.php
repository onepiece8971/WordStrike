<?php
/**
 * Template Name:study
 */
?>

<html>
<?php get_header(); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$begin = $_SESSION['study_time'];
$review = getOneReviewWord($begin);
?>
<body>
<?php if (null == $review) : ?>
    <?php $word = randOneWord(); ?>
    <?php if (null == $word) : ?>
        <div class="margin100px">
            <h1 class="ui center aligned header">该生词本已背完</h1>
        </div>
    <?php else : ?>
        <span class="ui right floated header"><?php $todayCount = getTodayReciteWordCount(); echo $todayCount; ?>/20</span>
        <div class="margin100px">
            <h1 class="ui center aligned header"><?php echo $word['word_name']; ?></h1>
            <h4 class="ui center aligned header">
            <span id="play">
                <?php if (empty($word['phonetic'])) : ?>
                    <i class="play icon"></i>
                <?php else :
                    echo $word['phonetic'];
                endif;
                ?>
            </span>
            </h4>
            <audio src=
                   <?php if (empty($word['voice'])) : ?>
                   "http://dict.youdao.com/dictvoice?audio=<?php echo $word['word_name']; ?>&type=2"
                <?php else : ?>
                    <?php echo $word['voice']; ?>
                <?php endif; ?>
                >对不起,您的浏览器已经跟不上时代,请下载最新的现代浏览器
            </audio>
        </div>
        <div class="ui text container">
            <div class="ui segments">
                <?php $meas = json_decode($word['means'], true);
                foreach ($meas as $key => $one) : ?>
                    <div class="ui segment"><span class="ui red header"><?php echo $key; ?>. </span><?php echo $one; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div  class="bottom-button">
                <div class="ui button red add left" level="9">熟词</div>
                <div class="ui button green add right" level="1">加入生词本</div>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <?php $word =  $review; ?>
    <div class="margin100px">
        <h1 class="ui center aligned header"><?php echo $word['word_name']; ?></h1>
        <h4 class="ui center aligned header">
            <span id="play">
                <?php if (empty($word['phonetic'])) : ?>
                    <i class="play icon"></i>
                <?php else :
                    echo $word['phonetic'];
                endif;
                ?>
            </span>
        </h4>
        <audio src=
               <?php if (empty($word['voice'])) : ?>
               "http://dict.youdao.com/dictvoice?audio=<?php echo $word['word_name']; ?>&type=2"
            <?php else : ?>
                <?php echo $word['voice']; ?>
            <?php endif; ?>
            >对不起,您的浏览器已经跟不上时代,请下载最新的现代浏览器
        </audio>
    </div>
    <div class="ui text container">
        <div id="show" class="ui segments" style="height: 30%;"></div>
        <div id="show2" class="ui segments" hidden="hidden">
            <?php $meas = json_decode($word['means'], true);
            foreach ($meas as $key => $one) : ?>
                <div class="ui segment"><span class="ui red header"><?php echo $key; ?>. </span><?php echo $one; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div  class="bottom-button">
            <div class="ui button green upgrade left" type="upgrade">记得</div>
            <div class="ui button red upgrade right" type="forget">忘记</div>
        </div>
    </div>
<?php endif; ?>
</body>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/content/Study.js"></script>
<script>
    var wordsId = "<?php echo $word['id'] ?>",
        nonce   = "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
        url     = "<?php echo admin_url('admin-ajax.php'); ?>",
        todayCount = "<?php echo $todayCount ?>",
        handler = semantic.object.handler(nonce, url, wordsId);
    // attach ready event
    $(document).ready(semantic.ready(handler, todayCount)).keydown(handler.keyDownEvent);
</script>
</html>
