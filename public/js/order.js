$(document).ready(function() {

    var sendData = new Object();
    var contentSelector = ".content-wrapper";
    vex.defaultOptions.className = 'vex-theme-os';

    //Таймер
    var minutes = [];
    var seconds = [];
    var disbled_buttons = [];

    var timer_message = '';

    function countdown(selector)
    {


        setInterval(function(){

            var order_number = get_order_number(selector);
            if(minutes[order_number] >= 0 && seconds[order_number] >= 0)
            {
                //var m = (minutes[order_number] < 10) || (minutes[order_number].substr(0,1) != "0") ? "0"+minutes[order_number] : minutes[order_number];
                //var s = (seconds[order_number] < 10) || (seconds[order_number].substr(0,1) != "0") ? "0"+seconds[order_number] : seconds[order_number];

                var t_text = minutes[order_number] + ":" + seconds[order_number];

                selector.text(t_text);
                seconds[order_number]--;

                //Отправка номера стола и таймера
                conn.send('cook' + "," + 'timer' + "," + order_number + "," + t_text);

                if(seconds[order_number] < 0) {
                    minutes[order_number]--;
                    seconds[order_number] = 59;
                }

            }
            else
            {

                //Отправка уведомления о завершении
                conn.send('cook' + "," + 'final' + "," + order_number);
                remove_order(selector);

            }


        }, 1000);


    }


    var conn = new WebSocket("ws://localhost:8080");
    conn.open = function(e){
        console.info("Connection established");
    };

    conn.onmessage = function(e){
        //vex.dialog.alert(e.data);
        var mes_array = e.data.split(",");
        // 0 - sender id
        if(mes_array[0] == "waiter")
        {
            /*
             0 - sender id
             1 - number
             2 - table
             3 - food
             4 - waiter name
             */

            var row = get_table_row_from_cook(mes_array[1],mes_array[2],mes_array[3],mes_array[4]);
            insert_row_in_table(row);
            start_timer();

        }

        if(mes_array[0] == "cook")
        {
            if(mes_array[1] == "timer") {

                var __min = 0;
                var __sec = 0;
                /*
                 0 - sender id
                 1 - timer
                 2 - number order
                 3 - time
                 */
                var r = $(".order-"+mes_array[2]);
                var timer_t = r.next().next().next().next();
                timer_t.next().children("button").attr('disabled','disabled');
                timer_t.text(mes_array[3]);
            }

            if(mes_array[1] == "final") {
                /*
                 0 - sender id
                 1 - final
                 2 - number order
                 */
                var final_row = $(".order-"+mes_array[2]).next().next().next();
                final_row.attr('class',"order-status success").text("Готово")
            }
        }
    };

    //Генерация строки в таблице
    function get_table_row_from_cook(number,table,food,waiter)
    {
        /*
         <td class="order-table">1</td>
         <td class="order-food">Суп Харче</td>
         <td class="time"><input ty></td>
         <td class="order-waiter">Василий</td>
         <td class="order-status info">Готовится</td>
         */

        var row = "<tr>";
        row += '<td class="order-number">'+ number + '</td>';
        row += '<td class="order-table">'+ table + '</td>';
        row += '<td class="order-food">'+ food + '</td>>';
        row += '<td class="order-time"><input type="time" placeholder="0:00" /><button class="star-timer">Старт</button></td>>';
        row += '<td class="order-waiter">'+ waiter + '</td>';
        row += '<td class="order-status info">Готовится</td>';
        row += "</tr>";

        return row;
    }

    //Вставка строки в таблицу
    function insert_row_in_table(row)
    {
        var table = $('article.content-wrapper table tbody');
        table.prepend(row);
    }

    //Удаление выполненого заказа поваром
    function remove_order(selector)
    {
        selector.parent().parent().remove();
    }

    //Запуск таймера Кухня
    function start_timer()
    {
        $("button.star-timer").on('click',function(){
            var but = $(this);
            var input = but.prev("input");

            if(input.val() != '')
            {
                var t = input.val().split(":");
                //minutes = t[0].replace("0",'',0);
                //seconds = t[1].replace("0",'',0);
                var order_number_start = get_order_number(but);
                minutes[order_number_start] = t[0];
                seconds[order_number_start] = t[1];
                console.log(minutes);
                input.remove();
                but.attr('disabled','disabled');


                //Отправка номера стола и таймера
                var order_number = get_order_number(but);
                //timer_message = 'cook' + "," + 'timer' + "," + order_number + "," + minutes  + "," + seconds;
                conn.send(timer_message);
                //Старт Таймера
                countdown(but);
            }
            else
            {
                vex.dialog.alert("Сначала укажите время");
            }

        });
    }

    //Номер заказа
    function get_order_number(selector)
    {
        return selector.parent().prev().prev().prev().text();
    }


    function ajaxUpdateContent(action,data,contentSelector)
    {
        $.ajax({
            type: "POST",
            url: action,
            data: data,
            dataType : 'html',
            beforeSend: function(){},
            error: function(e) {
                //alert("Error");
            },
            success: function(response){
                var result = $(response).find(contentSelector).html();
                $(contentSelector).html(result);
                //console.log(result);

            }
        });
    }


    //Ajax обработка статуса заказа в общей таблице таблице
/*    $('form').on('submit',function(){
        var form = $(this);
        var action = form.attr('action');
        var data = form.serializeArray();

        sendData.action = action;
        sendData.data = data;
        sendData.selector = contentSelector;
        ajaxUpdateContent(action,data,contentSelector)
        send();
        return false;
    });*/

    //Отправка заказа на кухню
    var sendOrderBbutton = $('.send-order');
    sendOrderBbutton.on('click',function(){
        var but = $(this);
        var message = "waiter" + "," +  but.data('number') + "," +  but.data('table') + "," + but.data('food') + ","  + but.data('waiter');
        but.attr('disabled','disabled');
        conn.send(message);

    });


    //Получение с кухни













    //End code...
});


