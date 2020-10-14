// JavaScript Document
function muestraMenuMain(menu_group, link_pre){
	//Menu para el grupo de Administradores
	var administrador_menu = 			["Inicio","Administrador","Soporte","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var administrador_menu_links =		["index.php","admin/index.php","soporte/index.php","convocatoria/index.php","inscripcion/index.php","lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	var administrador_submenu = 		[[],["Archivos","Grados académicos","Niveles de acceso","Universidades","Usuarios"],["Lista de usuarios","Mensajes de contacto","Noticias","Ver archivos"],[],["Validar pagos"],["Validar ponencias","Validar presentaciones"],[],[],[]];
	var administrador_submenu_links =	[[],["admin/admin_archivos.php","admin/lst_grad_acad.php","admin/lst_niv_acc.php","admin/lst_univ.php","admin/lst_usr.php"],["soporte/lista_usuarios.php","soporte/contacto.php","soporte/lst_noticias.php","soporte/ver_archivos.php"],[],["inscripcion/val_pagos.php"],["lineamientos/val_ponencias.php","lineamientos/val_presentaciones.php"],[],[],[]];
	//Menu para el grupo de Soporte
	var soporte_menu = 			["Inicio","Soporte","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var soporte_menu_links =	["index.php","soporte/index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	var soporte_submenu = 		[[],["Lista de usuarios","Mensajes de contacto","Noticias","Ver archivos"],[],["Validar pagos","Constancias"],["Validar ponencias","Validar presentaciones"],[],[],[]];
	var soporte_submenu_links =	[[],["soporte/lista_usuarios.php","soporte/contacto.php","soporte/lst_noticias.php","soporte/ver_archivos.php"],[],["inscripcion/val_pagos.php","inscripcion/constancias.php"],["lineamientos/val_ponencias.php","lineamientos/val_presentaciones.php"],[],[],[]];
	//Menu para el grupo de Ponentes
	var ponente_menu = 			["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var ponente_menu_links =	["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	var ponente_submenu = 		[[],[],["Comprobante de pago","Cartas de aceptación","Constancias"],["Comite evaluador","Formato para ponencia","Presentación para ponencia"],[],[],[]];
	var ponente_submenu_links =	[[],[],["inscripcion/sube_comp_pago.php","inscripcion/cartas_aceptacion.php","inscripcion/constancias.php"],["lineamientos/comite_evaluador.php","lineamientos/form_ponencia.php","lineamientos/pres_ponencia.php"],[],[],[]];
	//Menu para el grupo de Asistentes
	var asistente_menu = 			["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var asistente_menu_links =		["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	var asistente_submenu = 		[[],[],["Comprobante de pago","Constancias"],[],[],[],[]];
	var asistente_submenu_links =	[[],[],["inscripcion/sube_comp_pago.php","inscripcion/constancias.php"],[],[],[],[]];
	//Menu por default
	var default_menu = 			["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var default_menu_links =	["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	var default_submenu = 		[[],[],["Asistente","Ponente"],[],[],[],[]];
	var default_submenu_links =	[[],[],["inscripcion/ins_asistente.php","inscripcion/ins_ponente.php"],[],[],[],[]];

	//Variable para armar el string del menu
	var menu_string = "";
	
	menu_string = menu_string + "<ul>";
	switch(menu_group){
		case "Administrador":
			for (var i = 0; i < administrador_menu.length; i++) {
				if(administrador_submenu[i].length > 0){
					menu_string = menu_string + "<li class='dropdown'>";
					menu_string = menu_string + "<a href='" + link_pre + administrador_menu_links[i] + "' class='dropbtn'>" + administrador_menu[i] + "</a>"
					menu_string = menu_string + "<div class='dropdown-content'>"
					for(var j = 0; j < administrador_submenu[i].length; j++){
						menu_string = menu_string + "<a href='" + link_pre + administrador_submenu_links[i][j] + "'>" + administrador_submenu[i][j] + "</a>"
					}
					menu_string = menu_string + "</div>"
					menu_string = menu_string + "</li>";
				}else{
					menu_string = menu_string + "<li><a href='" + link_pre + administrador_menu_links[i] + "'>" + administrador_menu[i] + "</a></li>";
				}
			}
			break;
		case "Soporte":
			for (var i = 0; i < soporte_menu.length; i++) {
				if(soporte_submenu[i].length > 0){
					menu_string = menu_string + "<li class='dropdown'>";
					menu_string = menu_string + "<a href='" + link_pre + soporte_menu_links[i] + "' class='dropbtn'>" + soporte_menu[i] + "</a>"
					menu_string = menu_string + "<div class='dropdown-content'>"
					for(var j = 0; j < soporte_submenu[i].length; j++){
						menu_string = menu_string + "<a href='" + link_pre + soporte_submenu_links[i][j] + "'>" + soporte_submenu[i][j] + "</a>"
					}
					menu_string = menu_string + "</div>"
					menu_string = menu_string + "</li>";
				}else{
					menu_string = menu_string + "<li><a href='" + link_pre + soporte_menu_links[i] + "'>" + soporte_menu[i] + "</a></li>";
				}
			}
			break;
		case "Ponente":
			for (var i = 0; i < ponente_menu.length; i++) {
				if(ponente_submenu[i].length > 0){
					menu_string = menu_string + "<li class='dropdown'>";
					menu_string = menu_string + "<a href='" + link_pre + ponente_menu_links[i] + "' class='dropbtn'>" + ponente_menu[i] + "</a>"
					menu_string = menu_string + "<div class='dropdown-content'>"
					for(var j = 0; j < ponente_submenu[i].length; j++){
						menu_string = menu_string + "<a href='" + link_pre + ponente_submenu_links[i][j] + "'>" + ponente_submenu[i][j] + "</a>"
					}
					menu_string = menu_string + "</div>"
					menu_string = menu_string + "</li>";
				}else{
					menu_string = menu_string + "<li><a href='" + link_pre + ponente_menu_links[i] + "'>" + ponente_menu[i] + "</a></li>";
				}
			}
			break;
		case "Asistente":
			for (var i = 0; i < asistente_menu.length; i++) {
				if(asistente_submenu[i].length > 0){
					menu_string = menu_string + "<li class='dropdown'>";
					menu_string = menu_string + "<a href='" + link_pre + asistente_menu_links[i] + "' class='dropbtn'>" + asistente_menu[i] + "</a>"
					menu_string = menu_string + "<div class='dropdown-content'>"
					for(var j = 0; j < asistente_submenu[i].length; j++){
						menu_string = menu_string + "<a href='" + link_pre + asistente_submenu_links[i][j] + "'>" + asistente_submenu[i][j] + "</a>"
					}
					menu_string = menu_string + "</div>"
					menu_string = menu_string + "</li>";
				}else{
					menu_string = menu_string + "<li><a href='" + link_pre + asistente_menu_links[i] + "'>" + asistente_menu[i] + "</a></li>";
				}
			}
			break;
		default:
			for (var i = 0; i < default_menu.length; i++) {
				if(default_submenu[i].length > 0){
					menu_string = menu_string + "<li class='dropdown'>";
					menu_string = menu_string + "<a href='" + link_pre + default_menu_links[i] + "' class='dropbtn'>" + default_menu[i] + "</a>"
					menu_string = menu_string + "<div class='dropdown-content'>"
					for(var j = 0; j < default_submenu[i].length; j++){
						menu_string = menu_string + "<a href='" + link_pre + default_submenu_links[i][j] + "'>" + default_submenu[i][j] + "</a>"
					}
					menu_string = menu_string + "</div>"
					menu_string = menu_string + "</li>";
				}else{
					menu_string = menu_string + "<li><a href='" + link_pre + default_menu_links[i] + "'>" + default_menu[i] + "</a></li>";
				}
			}
	}
	menu_string = menu_string + "</ul>";
	document.write(menu_string);
}

function muestraMenuFooter(menu_group, link_pre){
	//Menu para el grupo de Administradores
	var administrador_menu = 		["Inicio","Administrador","Soporte","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var administrador_menu_links =	["index.php","admin/index.php","soporte/index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	//Menu para el grupo de Soporte
	var soporte_menu = 			["Inicio","Soporte","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var soporte_menu_links =	["index.php","soporte/index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	//Menu para el grupo de Ponentes
	var ponente_menu = 			["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var ponente_menu_links =	["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	//Menu para el grupo de Asistentes
	var asistente_menu = 		["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var asistente_menu_links =	["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];
	//Menu por default
	var default_menu = 			["Inicio","Convocatoria","Inscripción","Lineamientos","Programa","Contacto","Hospedaje"];
	var default_menu_links =	["index.php","convocatoria/index.php","inscripcion/index.php", "lineamientos/index.php","programa/index.php","contacto/index.php","hospedaje/index.php"];

	//Variable para armar el string del menu
	var menu_string = "";
	
	menu_string = menu_string + "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"
    menu_string = menu_string + "<tr>"
    menu_string = menu_string + "<td colspan='2' align='left'><p class='Marron Grande'>Men&uacute;</p></td>"
    menu_string = menu_string + "</tr>"
	switch(menu_group){
		case "Administrador":
			for (var i = 0; i < administrador_menu.length; i++) {
				menu_string = menu_string + "<tr>";
				menu_string = menu_string + "<td width='25'><img src='" + link_pre + "imagenes/footer_bullet.png' alt='HBullet " + i + "' name='HBullet" + i + "' width='25' height='18' id='HBullet" + i + "'></td>";
				menu_string = menu_string + "<td><a href='" + link_pre + administrador_menu_links[i] + "'>" + administrador_menu[i] + "</a></td>";
				menu_string = menu_string + "</tr>";
			}
			break;
		case "Soporte":
			for (var i = 0; i < soporte_menu.length; i++) {
				menu_string = menu_string + "<tr>";
				menu_string = menu_string + "<td width='25'><img src='" + link_pre + "imagenes/footer_bullet.png' alt='HBullet " + i + "' name='HBullet" + i + "' width='25' height='18' id='HBullet" + i + "'></td>";
				menu_string = menu_string + "<td><a href='" + link_pre + soporte_menu_links[i] + "'>" + soporte_menu[i] + "</a></td>";
				menu_string = menu_string + "</tr>";
			}
			break;
		case "Ponente":
			for (var i = 0; i < ponente_menu.length; i++) {
				menu_string = menu_string + "<tr>";
				menu_string = menu_string + "<td width='25'><img src='" + link_pre + "imagenes/footer_bullet.png' alt='HBullet " + i + "' name='HBullet" + i + "' width='25' height='18' id='HBullet" + i + "'></td>";
				menu_string = menu_string + "<td><a href='" + link_pre + ponente_menu_links[i] + "'>" + ponente_menu[i] + "</a></td>";
				menu_string = menu_string + "</tr>";
			}
			break;
		case "Asistente":
			for (var i = 0; i < asistente_menu.length; i++) {
				menu_string = menu_string + "<tr>";
				menu_string = menu_string + "<td width='25'><img src='" + link_pre + "imagenes/footer_bullet.png' alt='HBullet " + i + "' name='HBullet" + i + "' width='25' height='18' id='HBullet" + i + "'></td>";
				menu_string = menu_string + "<td><a href='" + link_pre + asistente_menu_links[i] + "'>" + asistente_menu[i] + "</a></td>";
				menu_string = menu_string + "</tr>";
			}
			break;
		default:
			for (var i = 0; i < default_menu.length; i++) {
				menu_string = menu_string + "<tr>";
				menu_string = menu_string + "<td width='25'><img src='" + link_pre + "imagenes/footer_bullet.png' alt='HBullet " + i + "' name='HBullet" + i + "' width='25' height='18' id='HBullet" + i + "'></td>";
				menu_string = menu_string + "<td><a href='" + link_pre + default_menu_links[i] + "'>" + default_menu[i] + "</a></td>";
				menu_string = menu_string + "</tr>";
			}
	}
	menu_string = menu_string + "</table>";
	document.write(menu_string);
}
