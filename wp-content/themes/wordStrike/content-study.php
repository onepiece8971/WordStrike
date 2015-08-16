<?php
/**
 * Template Name:study
 */
?>

<html>
<?php get_header(); ?>

<body>
<?php $words = getUserWordsBook() ?>
<h1>Study</h1>
<h2><?php  ?></h2>
<p>
    <?php
    var_dump($words) ;
    ?>
</p>

<script>
    $(function () {
        var nonce = "<?php echo wp_create_nonce( 'WordStrike' ) ?>";
        var url = "<?php echo admin_url('admin-ajax.php'); ?>";
        $('#button').click(function () {
            $.post(
                url,
                {_ajax_nonce:  nonce, action: 'add_transfer'},
                function(result){
                    alert(result);
                }
            )
        });
    })
</script>
</html>
