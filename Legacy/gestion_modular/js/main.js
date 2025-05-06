//Confirmacion de eliminacion
function add_job(data,direccion){
	location = direccion+'&val_select=' + document.getElementById('idItemList_'+data).value;
} 
//Confirmacion de eliminacion
function add_sup(direccion){
	location = direccion+'&val_select=' + document.getElementById('idSupervisor').value;
} 
//Confirmacion de eliminacion
function addtemp(direccion, valorid){
	let t0 = document.getElementById('T0_'+valorid).value;
	let t1 = document.getElementById('T1_'+valorid).value;
	let t2 = document.getElementById('T2_'+valorid).value;
	let t3 = document.getElementById('T3_'+valorid).value;
	let t4 = document.getElementById('T4_'+valorid).value;
	let Observacion = document.getElementById('Observacion_'+valorid).value;
	location = direccion+'&T0='+t0+'&T1='+t1+'&T2='+t2+'&T3='+t3+'&T4='+t4+'&Observacion='+Observacion;
}
//Confirmacion de eliminacion
function addaceite(direccion, valorid){
	let idEstadoAceite = document.getElementById('idEstadoAceite_'+valorid).value;
	let idNivelAgua    = document.getElementById('idNivelAgua_'+valorid).value;
	let idNivelAceite  = document.getElementById('idNivelAceite_'+valorid).value;
	let idNivelSilice  = document.getElementById('idNivelSilice_'+valorid).value;
	let TempAceite     = document.getElementById('TempAceite_'+valorid).value;
	let idFlujoAgua    = document.getElementById('idFlujoAgua_'+valorid).value;
	let Observacion    = document.getElementById('Observacion_'+valorid).value;
	location = direccion+'&idEstadoAceite='+idEstadoAceite+'&idNivelAgua='+idNivelAgua+'&idNivelAceite='+idNivelAceite+'&idNivelSilice='+idNivelSilice+'&TempAceite='+TempAceite+'&idFlujoAgua='+idFlujoAgua+'&Observacion='+Observacion;
} 
//Confirmacion de eliminacion
function addrevgen(direccion, valorid){
	location = direccion+'&Observacion=' + document.getElementById('Observacion_'+valorid).value;
}
//Confirmacion de eliminacion
function addfalla(direccion, valorid){
	location = direccion+'&Observacion=' + document.getElementById('Observacion_'+valorid).value;
} 
//Confirmacion de eliminacion
function add_obs(direccion){
	location = direccion+'&val_select=' + document.getElementById('Observaciones').value;
} 
//Confirmacion de eliminacion
function addfter(direccion){
	location = direccion+'&val_select=' + document.getElementById('f_termino').value;
} 
//Confirmacion de eliminacion
function addhoraini(direccion){
	location = direccion+'&val_select=' + document.getElementById('horaInicio').value;
} 
//Confirmacion de eliminacion
function addhoraterm(direccion){
	location = direccion+'&val_select=' + document.getElementById('horaTermino').value;
} 
//Confirmacion de eliminacion
function addconsumo1(direccion, valorid){
	let Grasa_inicial       = document.getElementById('Grasa_inicial_'+valorid).value;
	let Grasa_relubricacion = document.getElementById('Grasa_relubricacion_'+valorid).value;
	let idUml               = document.getElementById('idUml_'+valorid).value;
	let idProducto          = document.getElementById('idProducto_'+valorid).value;
	let Observacion         = document.getElementById('Observacion_'+valorid).value;
	location = direccion+'&Grasa_inicial='+Grasa_inicial+'&Grasa_relubricacion='+Grasa_relubricacion+'&idUml='+idUml+'&idProducto='+idProducto+'&Observacion='+Observacion;
} 
//Confirmacion de eliminacion
function addconsumo2(direccion, valorid){
	let Aceite       = document.getElementById('Aceite_'+valorid).value;
	let idUml        = document.getElementById('idUml_'+valorid).value;
	let idProducto   = document.getElementById('idProducto_'+valorid).value;
	let Observacion  = document.getElementById('Observacion_'+valorid).value;
	location = direccion+'&Aceite='+Aceite+'&idUml='+idUml+'&idProducto='+idProducto+'&Observacion='+Observacion;
} 
//Confirmacion de eliminacion
function addconsumo3(direccion, valorid){
	let Cantidad    = document.getElementById('Cantidad_'+valorid).value;
	let idUml       = document.getElementById('idUml_'+valorid).value;
	let idProducto  = document.getElementById('idProducto_'+valorid).value;
	let Observacion = document.getElementById('Observacion_'+valorid).value;
	location = direccion+'&Cantidad='+Cantidad+'&idUml='+idUml+'&idProducto='+idProducto+'&Observacion='+Observacion;
} 
//Confirmacion de eliminacion
function addfpago(direccion){
	location = direccion+'&val_select=' + document.getElementById('f_pago').value;
} 

