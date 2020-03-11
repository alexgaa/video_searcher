$(function(){
   $(document).on("click", "#submit_clear_search_users", click_clear_search_users);
   $(document).on("click", "#submit_save_user", click_save_user);
   $(document).on("click", "#submit_save_pass", click_save_pass);
   $(document).on("click", "#submit_save_del", click_save_del);
});

// отправка ajax запроса с на обновление данных в БД, входящие данные массив данных, имя таблицы, тип обработчика
function sendNameFile(nameFile){
  $.ajax({
    url: "/main/file-unload",
    type: "POST",
    data: ({result_file : nameFile}),
    dataType : "html"
    //success : funcSuccessRead
  });
};

//отправка файла
function fileSend(){
      sendNameFile(all);
}

//очистка результатов поиска
function click_clear_search_users(){
    $("#tabl2").remove();
    $("#p_result").remove();
    $("#error_del").remove();
};

//функциф инициализации двумерного массива
function array2x2(column,line){
  var prog = new Array(column);
  for (var i = 0; i < prog.length; i++) {
    prog[i] = new Array(line);
  }
  return prog;
};

//обработка результат после добавления 
function funcSuccessRead(data){
    click_clear_search_users();
    $("#error_save_user").html(data);
}

// отправка ajax запроса с на обновление данных в БД, входящие данные массив данных, имя таблицы, тип обработчика
function write_php(data_array, name_table_wr,type){
  $.ajax({
    url: "/users/savedb",
    type: "POST",
    data: ({array_js : data_array, name_table : name_table_wr, type : type}),
    dataType : "html",
    success : funcSuccessRead
  });
};

//получение данных их формы и подготовка для отправки через Ajax запрос
function click_save_user(){
    var max;
    max=$(".result").length;
    var data_array = array2x2(max,15);
    for(var i=0; i<max; i++){
        name_temp="input[name='id["+i+"]']";
        data_array[i][0]=$(name_temp).val();
        name_temp="input[name='username["+i+"]']";
        data_array[i][1]=$(name_temp).val();
        if(data_array[i][1]===''){
            $(name_temp).attr("placeholder","Введите значение");
            $(name_temp).css("border","3px solid red");
            $("#error_save_user").html("<b>Ошибка сохранения, поле не может быть пустым!</b>");
            break;
        }
        name_temp="input[name='fullname["+i+"]']";
        data_array[i][2]=$(name_temp).val();    
        if(data_array[i][2]===''){
            $(name_temp).attr("placeholder","Введите значение");
            $(name_temp).css("border","3px solid red");
            $("#error_save_user").html("<b>Ошибка сохранения, поле не может быть пустым!</b>");
            break;
        }
        name_temp="select[name='typeuser["+i+"]']";
        data_array[i][3]=$(name_temp).val();
        name_temp="input[name='tl["+i+"]']";
        data_array[i][4]=$(name_temp).val();    
        if(data_array[i][4]===''){
            $(name_temp).attr("placeholder","Введите значение");
            $(name_temp).css("border","3px solid red");
            $("#error_save_user").html("<b>Ошибка сохранения, поле не может быть пустым!</b>");
            break;
        }
        name_temp="select[name='block["+i+"]']";
        data_array[i][5]=$(name_temp).val();
        name_temp="select[name='type["+i+"]']";
        data_array[i][6]=$(name_temp).val();
        name_temp="select[name='admin["+i+"]']";
        data_array[i][7]=$(name_temp).val();
        name_temp="select[name='inven["+i+"]']";
        data_array[i][8]=$(name_temp).val();
        name_temp="select[name='check["+i+"]']";
        data_array[i][9]=$(name_temp).val();
        name_temp="select[name='vendor["+i+"]']";
        data_array[i][10]=$(name_temp).val();
        name_temp="select[name='tl_imp["+i+"]']";
        data_array[i][11]=$(name_temp).val();
        name_temp="select[name='imp["+i+"]']";
        data_array[i][12]=$(name_temp).val();
        name_temp="select[name='mand["+i+"]']";
        data_array[i][13]=$(name_temp).val();
        name_temp="select[name='all["+i+"]']";
        data_array[i][14]=$(name_temp).val();
    }
    write_php(data_array, "User", "edit_user"); // вызов Ajax для отправки данных в php
}   

//получение данных их формы на смену пароля, подготовка для отправки через Ajax запрос
function click_save_pass(){
    var max;
    max=$(".result").length;
    var data_array = array2x2(max,15);
    var numcheckbox=0;
    for(var i=0; i<max; i++){
        name_temp="input[name='delete["+i+"]']";
        if($(name_temp).prop("checked")){  // проверяем был ли проставлен чекбокс
            name_temp="input[name='id["+i+"]']";
            data_array[numcheckbox][0]=$(name_temp).val();
            name_temp="input[name='pass["+i+"]']";
            data_array[numcheckbox][1]=$(name_temp).val();
            if(data_array[numcheckbox][1]===''){  // проверка на пустоту в поле пароля
                $(name_temp).attr("placeholder","Введите значение");
                $(name_temp).css("border","3px solid red");
                $("#error_save_user").html("<b>Ошибка сохранения, поле не может быть пустым!</b>");
                break;
            }                     
            numcheckbox++;
        }
    }
    if(numcheckbox){
        write_php(data_array, "User", "edit_pass"); // вызов Ajax для отправки данных в php
        $("#error_del").remove();
    }
    else{
        $("#error_del").html("Не выбраны пользователи для выдачи пароля");
    }
}

//получение данных их формы на удаление, подготовка для отправки через Ajax запрос
function click_save_del(){
    var max;
    max=$(".result").length;
    var data_array = array2x2(max,15);
    //console.log(max);
    var numcheckbox=0;
    for(var i=0; i<max; i++){
        name_temp="input[name='delete["+i+"]']";
        if($(name_temp).prop("checked")){  // проверяем был ли проставлен чекбокс
            name_temp="input[name='id["+i+"]']";
            data_array[numcheckbox][0]=$(name_temp).val();
            numcheckbox++;
        }
    }
    if(numcheckbox){
        write_php(data_array, "User", "edit_del"); // вызов Ajax для отправки данных в php
        $("#error_del").remove();
    }
    else{
        $("#error_del").html("Нет подтверждения на удаление ни одного пользователя");
    }
}