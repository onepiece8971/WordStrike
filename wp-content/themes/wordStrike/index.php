<html>
<?php get_header(); ?>

<body>
<h1>WordStrike</h1>

<form id="" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form">
    <?php wp_nonce_field('add_transfer', 'WordStrike'); ?>
    <input name="action" value="add_transfer" type="hidden"/>
    <input type="submit" value="提交"/>
    <input id="button" type="button" value="按钮"/>
</form>
</body>

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