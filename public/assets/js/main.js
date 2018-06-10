$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

var message_output = document.querySelector('.messages');
var machine_write = document.getElementById('machine-write');
var sound = document.getElementById('click');

function scrollDown() {
    message_output.scrollTop = message_output.scrollHeight;

}

var machine;

function write(input) {
    var text = input;
    var i = 0;
    machine_write.innerHTML = '';
    if(text != 'undefined' )
    machine = setInterval(function() {

        machine_write.innerHTML += text[i];
        i++;
        if(text.length <= i){
            clearInterval(machine);
        }
    }, 70); 
}
    
// if(message_output.offsetHeight <= message_output.scrollHeight){
// 	message_output.style.overflow = "scroll";
// }
// scrollDown();

$("#chat-input").keyup(function(event){
   if(event.keyCode === 13){
        clearInterval(machine);
        var message = $('#chat-input').val();
        var id = $('#chat-input').attr('data-id');

        $('.messages').append('<p class="me">'+message+'</p>');
        $('#chat-input').val('');
        scrollDown();

         $.ajax({
            type: "post",
            url: '/message/'+id,
            data: {id:id,message:message},
            success:function(data)
            {   
                if(data[0] == 'ERROR' || data[0] == 'simple')
                {
                    $('.messages').append('<p class="bot">'+data[1]+'</p>');
                    scrollDown();
                }else if( data[0] == 'hard')
                {
                    if(data[1]['years'].length === 0)
                    {
                        $('.messages').append('<p class="bot">'+data[1].text+'</p>');
                        scrollDown();
                    }else
                    {
                        $('.messages').append('<p class="bot">'+data[1].text+'</p>');
                        scrollDown();

                        $.each(data[1].years, function(data,val){
                            $('.messages').append('<p class="bot">'+val+'</p>');
                        });

                        scrollDown();
                    }
                }else{
                    write(data[1].text);
                }
            }
        });

    }
});

