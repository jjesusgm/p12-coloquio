// JavaScript Document
$(document).ready(function(){
                         
      var consulta;
             
      //hacemos focus
      $("#fUsername").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#fUsername").keyup(function(e){
             //obtenemos el texto introducido en el campo
             consulta = $("#fUsername").val();
                                      
             //hace la búsqueda
             $("#div_resultado").delay(1000).queue(function(n) {      
                                           
                  $("#div_resultado").html('<img src="../imagenes/ajax-loader.gif" />');
                                           
                        $.ajax({
                              type: "POST",
                              url: "../comprobar_usuario.php",
                              data: "b="+consulta,
                              dataType: "html",
                              error: function(){
                                    alert("error petición ajax");
                              },
                              success: function(data){                                                      
                                    $("#div_resultado").html(data);
                                    n();
                              }
                  });
                                           
             });
                                
      });
                          
});