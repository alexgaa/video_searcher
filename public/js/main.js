$(function(){
   $(document).on("click","#submit_search_video",info_message);

  
});

function info_message() {
    $("#info_message").html("Ожидайте идёт поиск данных, а так же их валидация - Это может занять несколько минут");
}
