// JavaScript Document
function show_hide_fields_on_edit(){
	fIdUniversidad = $("select#fIdUniversidad").val();
    if(fIdUniversidad == 60){
		$("#fUnivOtra").show();
	}else{
		$("#fUnivOtra").hide();  
		$("input#fUnivOtra").val('');
	}

	fIdGradoAcad = $("select#fIdGradoAcad").val();
    if(fIdGradoAcad == 4){
		$("#fGradoAcadOtro").show();
	}else{
		$("#fGradoAcadOtro").hide();  
		$("input#fGradoAcadOtro").val('');
	}
}

function hide_show_otra_universidad(){
	fIdUniversidad = $("select#fIdUniversidad").val();
	
    if(fIdUniversidad == 60){
		$("#fUnivOtra").show();
	}else{
		$("#fUnivOtra").hide();  
		$("input#fUnivOtra").val('');
	}
}

function hide_show_otro_grado_academico(){
	fIdGradoAcad = $("select#fIdGradoAcad").val();
	
    if(fIdGradoAcad == 4){
		$("#fGradoAcadOtro").show();
	}else{
		$("#fGradoAcadOtro").hide();  
		$("input#fGradoAcadOtro").val('');
	}
}

