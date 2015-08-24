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
            <th>添加</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <h4 class="ui image header">
                    <img class="ui mini rounded image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/address_book.png">
                    <div class="content">
                        Lena
                        <div class="sub header">Human Resources
                        </div>
                    </div>
                </h4></td>
            <td>
                <button class="ui compact icon button green mini toggle">
                    <i class="icon plus"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <h4 class="ui image header">
                    <img class="ui mini rounded image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/address_book.png">
                    <div class="content">
                        Matthew
                        <div class="sub header">Fabric Design
                        </div>
                    </div>
                </h4></td>
            <td>
                <button class="ui compact icon button green mini">
                    <i class="icon plus"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <h4 class="ui image header">
                    <img class="ui mini rounded image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/address_book.png">
                    <div class="content">
                        Lindsay
                        <div class="sub header">Entertainment
                        </div>
                    </div>
                </h4></td>
            <td>
                <button class="ui compact icon button green mini">
                    <i class="icon plus"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <h4 class="ui image header">
                    <img class="ui mini rounded image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/address_book.png">
                    <div class="content">
                        Mark
                        <div class="sub header">Executive
                        </div>
                    </div>
                </h4></td>
            <td>
                <button class="ui compact icon button green mini">
                    <i class="icon plus"></i>
                </button>
            </td>
        </tr>
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