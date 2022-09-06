$('#myActionButton').click(function(){
    $.post(
        "del.php", 
        { myActionName: "Выполнить" } 
    );
});
$("#formButton").on("click",function(){
var link=$("#link").val();
alert(link);
$.ajax({
url:'parser.php',
type:'POST',
cache:false,
data:{'link':link},
dataType:"html",

success:function(data){
  if(!data){
    alert("Были ошибки,сообщение не отправлено!");}
    else 
   
    alert("сообщение отправлено!");
}
});
});