$(function(){
   $(document).on("click", "#submit_save_video_del", submit_save_del_video);
   $(document).on("click", "#submit_search_video", submit_search_video);
   
  
});

//отправка запроса на поиск видео
function submit_search_video(){
    var link_name=$("#linkUser").val();
    $("#info_message").html("Ожидайте идёт поиск данных, а так же их валидация - Это может занять несколько минут");
    $.ajax({
      url: "/main/link-usere",
      type: "POST",
      data: ({ linkUser : link_name, type : type}),
      dataType : "html"
      //success : result
    });
}

//получение данных их формы на удаление, подготовка для отправки через Ajax запрос
function submit_save_del_video(){
    var max;
    max=$(".result").length;
    var data_array = new Array(max);
    var numcheckbox=0;
    for(var i=0; i<max; i++){
        name_temp="input[name='delete["+i+"]']";
        if($(name_temp).prop("checked")){  // проверяем был ли проставлен чекбокс
            name_temp="input[name='id_url["+i+"]']";
            data_array[numcheckbox]=$(name_temp).val();
            numcheckbox++;
        }
    }
    if(numcheckbox){
        $("#result_del").empty();
        write_link_php(data_array, "del"); // вызов Ajax для отправки данных в php
    }
    else{
        $("#error_del").html("Нет подтверждения на удаление ни одного пользователя");
    }
}

// вызов Ajax для отправки данных в php на удаление данных
function write_link_php(data_array, type){
    //console.log(data_array[0]);
    $.ajax({
      url: "/main/delete",
      type: "POST",
      data: ({ array_js : data_array, type : type}),
      dataType : "html",
      success : result
    });
};

//вывод результатов
function result(data){
   $("#result_del").html(data);
   $("#block_del").empty();
}
