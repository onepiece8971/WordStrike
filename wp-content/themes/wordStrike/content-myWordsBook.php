<?php
/**
 * Template Name:myWordsBook
 */
?>
<html>
<?php get_header(); ?>
<body>
<div class="masthead">
    <h1 class="ui center aligned header inverted middlebig"><span class="library">WordStrike</span></h1>
    <div class="ui container text" style="margin-top: 10%">
        <table class="ui celled table three column center aligned">
            <tr>
                <td>生词 <?php echo getNewWordsCount(); ?></td>
                <td class="positive">熟词 <?php echo getNewWordsCount(false); ?></td>
                <td class="negative">未学 <?php echo getUnstudiedCount(); ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="ui container text">
    <?php
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;
    $books = getMyWordsBooks($uid);
    ?>
    <?php if (false !== $books) : ?>
    <table class="ui celled table">
        <thead>
        <tr>
            <th>我的生词本</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td>
                    <h4 class="ui image header">
                        <img class="ui mini rounded image" src="
                        <?php if (empty($book['img_url'])) : ?>
                        <?php echo esc_url(get_template_directory_uri()); ?>/images/address_book.png
                        <?php else :
                            echo $book['img_url'];
                        endif; ?>
                        ">
                        <div class="content">
                            <a href="<?php echo site_url()."/study/?b=".$book['id'] ?>"><?php echo $book['name'] ?></a>
                            <div class="sub header"><?php echo $book['content']; ?></div>
                        </div>
                    </h4>
                </td>
                <td>
                    <?php $isMyWordsBook = isMyWordsBook($uid, $book['id']) ?>
                    <button class="ui compact icon button green mini toggle <?php if (!$isMyWordsBook) echo 'red' ?>" uid="<?php echo $uid; ?>" books_id="<?php echo $book['id']; ?>">
                        <i class="icon <?php if ($isMyWordsBook) {echo 'plus';} else {echo 'minus';} ?>"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else : ?>
        <h1 class="ui center aligned header">您还没有添加生词本</h1>
    <?php endif; ?>
</div>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/content/MyWordsBook.js"></script>
<script>
    var nonce   = "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
        url     = "<?php echo admin_url('admin-ajax.php'); ?>",
        handler = new semantic.object.handler(nonce, url);
    // attach ready event
    $(document).ready(semantic.ready(handler));
</script>
</body>
</html>