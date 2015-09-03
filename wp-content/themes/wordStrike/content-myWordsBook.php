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
                        <img class="ui mini rounded image" src="<?php echo $book['img_url']; ?>">
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
</body>
</html>

<script>
    semantic = {};
    // ready event
    semantic.ready = function () {
        // selector cache
        var $toggle = $('.ui.toggle.button'),
              $a = $('a');

        handler = {
            nonce : "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            activate: function(){
                var uid = $(this).attr('uid'),
                    books_id = $(this).attr('books_id');
                if ($(this).hasClass('red')) {
                    $.post(
                        handler.url,
                        {_ajax_nonce:  handler.nonce, action: 'del_my_words_book', uid: uid, books_id: books_id},
                        function(result){
                            console.log(result);
                        }
                    );
                } else {
                    $.post(
                        handler.url,
                        {_ajax_nonce:  handler.nonce, action: 'add_my_words_book', uid: uid, books_id: books_id}
                    );
                }
//                console.log($(this).hasClass('red'));
            },
            addSession: function(){
                $.post(
                    handler.url,
                    {_ajax_nonce:  handler.nonce, action: 'add_session'},
                    function(result){
                        console.log(result);
                    }
                );
            }
        };
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
    // attach ready event
    $(document).ready(semantic.ready);
</script>