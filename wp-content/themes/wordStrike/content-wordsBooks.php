<?php
/**
 * Template Name:wordsBooks
 */
?>
<html>
<?php get_header(); ?>
<body>
<div class="masthead">
    <h1 class="ui center aligned header inverted middlebig"><span class="library">WordStrike</span></h1>
</div>
<div class="ui container">
    <table class="ui celled table">
        <thead>
        <tr>
            <th>生词本</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $books = getWordsBooks();
        $current_user = wp_get_current_user();
        $uid = $current_user->ID;
        ?>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td>
                    <h4 class="ui image header">
                        <img class="ui mini rounded image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/address_book.png">
                        <div class="content"><?php echo $book['name'] ?></div>
                    </h4>
                </td>
                <td>
                    <?php $isMyWordsBook = isMyWordsBook($uid, $book['uid']) ?>
                    <button class="ui compact icon button green mini toggle <?php if ($isMyWordsBook) echo 'red' ?>">
                        <i class="icon <?php if ($isMyWordsBook) {echo 'minus';} else {echo 'plus';} ?>"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<script>
    semantic = {};
    // ready event
    semantic.ready = function () {
        // selector cache
        var $toggle = $('.ui.toggle.button');
        $toggle.state({
            text: {
                inactive: '<i class="icon plus"></i>',
                active: '<i class="icon minus"></i>'
            },
            className: {
                active: 'red'
            }
        });
    };
    // attach ready event
    $(document).ready(semantic.ready);
</script>