<html>
<?php get_header(); ?>
<body>
<h1 class="ui center aligned header">添加生词本</h1>
<div class="ui text container">
    <form class="ui form">
        <div class="two fields">
            <div class="field">
                <label>单词本名字</label>
                <input name="name"  placeholder="单词本名字" type="text">
            </div>
        </div>
        <div class="field">
            <label>描述</label>
            <input name="content" placeholder="描述" type="text">
        </div>
        <div class="field">
            <label>封面url</label>
            <input name="img_url" placeholder="封面url" type="text">
        </div>
        <button id="addWordsBook" class="ui button primary admin" type="button">Save</button>
    </form>
</div>
<h1 class="ui center aligned header">上传生词本</h1>
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
        //获取将表单内容并转为json对象
        $.fn.serializeObject = function()
        {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        var $add = $('.add'),
              $addWordsBook = $('#addWordsBook'),
              $progress = $('.progress'),
              $ei = $('#ei');
        handler = {
            nonce : "<?php echo wp_create_nonce( 'WordStrike' ) ?>",
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            add: function(){
                var i = $ei.val();
                $.post(
                    handler.url,
                    {_ajax_nonce:  handler.nonce, action: 'import_words_book', i: i},
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
            },
            addWordsBook: function(){
                var form = $("form").serializeObject();
                $.post(
                    handler.url,
                    {_ajax_nonce:  handler.nonce, action: 'add_words_book',
                        name: form.name, content: form.content, img_url: form.img_url},
                    function(result){
                        if (result) {
                            alert('添加成功!');
                        } else {
                            alert('添加失败!');
                        }
//                        console.log(result);
                    }
                );
            }
        };
        $add.on('click', function(){
            $progress.addClass('active');
            $add.addClass('disabled');
        });
        $add.on('click', handler.add);
        $addWordsBook.on('click', handler.addWordsBook);
    };
    $(document).ready(semantic.ready);
</script>
</body>
</html>