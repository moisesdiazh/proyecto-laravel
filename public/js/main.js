var url = 'http://proyecto-laravel.com.devel';
window.addEventListener("load", function(){


    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');


    //boton de like 
    function like(){
    $('.btn-like').unbind('click').click(function(){
        console.log('like');
        $(this).addClass('btn-dislike').removeClass('btn-like');
        $(this).attr('src', url+'/img/heartsazul.png');

        $.ajax({

            url: url+'/like/'+$(this).data('id'),
            type: 'GET', 
            success: function(response){

                if(response.like){

                    console.log('Like!');
                }else{

                    console.log('Error!')
                }
            }
        });

        dislike();
    });
}
like();

    //boton de dislike
    function dislike(){
    $('.btn-dislike').unbind('click').click(function(){
        console.log('dislike');
        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/img/heartsgris.png');

        $.ajax({

            url: url+'/dislike/'+$(this).data('id'),
            type: 'GET', 
            success: function(response){

                if(response.like){

                    console.log('Dislike!');
                }else{

                    console.log('Error!')
                }
            }
        });

        like();
    });
}
dislike();

//buscador
$('#buscador').submit(function(e){

    $(this).attr('action',url+'/gente/'+$('#buscador #search').val());
});

});