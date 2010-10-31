(function($){
    $('a.ajax').click(function(){
        $('#result').append('<p class="loading">ちょっと待っててね。結構時間かかるかもしれないから先にシャワーでも浴びてて下さい。</p>');
        $.get(this.href,{}, function(res){
            res = eval('('+res+')');
            if(typeof res.error !== 'undefined'){
                location.href = '/connect';
            }else{
                $('#result').append('<p>趣味合うよねランキング</p><ol></ol>');
                var i = 0;
                while(i < res.result.length && i < 5){
                    $('#result ol').append('<li><a href="'+res.result[i].link+'" class="blank">'+res.result[i].name+'</a></li>');
                    i++;
                }
                $('a.blank').click(function(){
                    window.open(this.href, 'child');
                    return false;
                });
                $('p.loading').remove();
                $('#get').remove();
            }
        });
        return false;
    });
})(jQuery);
