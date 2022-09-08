$('#removeCache').click(function() {
    $.post(
        "../utilite/deleteFile.php", {
            myActionName: "Очистка кеша"
        }
    );

});
$("#formButton").on("click", function() {
    $.post(
        "del.php", {
            myActionName: "Очищаем"
        }
    );
    var link = $("#link").val();
    alert(link);
    $.ajax({
        url: 'parser.php',
        type: 'POST',
        cache: false,
        data: {
            'link': link
        },
        dataType: "html",

        success: function(data) {
            if (!data) {
                alert("Были ошибки,сообщение не отправлено!");
            } else

                alert("Данные переданы для обработки!");
        }
    });
});