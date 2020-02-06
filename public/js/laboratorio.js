function busca_examenes(id) {
   var dir = $('#dir').val();

   $('#exampleModal').modal({
      show:true
  }); 
      $.ajax(
            {
                  dataType: "html",
                  type: "POST",
                  url: dir + "/laboratorio/busca", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                  data: "id=" + id, //Se añade el parametro de busqueda del medico
                  beforeSend: function(data) {

                  },
                  success: function(requestData) {//armar la tabla
                     console.log(requestData);
                     $("#div_examenes").html(requestData);
                     
                  },
                  error: function(requestData, strError, strTipoError) {
                  },
                  complete: function(requestData, exito) { //fin de la llamada ajax.
                     
                  }
            });
            $.ajax(
               {
                     dataType: "json",
                     type: "POST",
                     url: dir + "/laboratorio/buscadatos", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                     data: "id=" + id, //Se añade el parametro de busqueda del medico
                     beforeSend: function(data) {
   
                     },
                     success: function(requestData) {//armar la tabla
                        console.log(requestData.data);
                        //$("#div_examenes").html(requestData);
                        $("#paciente").text(requestData.data.apellido_paterno+" "+requestData.data.apellido_materno+" "
                        +requestData.data.primer_nombre+" "+requestData.data.segundo_nombre);
                        $("#fecha_pedido").text(requestData.data.fecha);

                     },
                     error: function(requestData, strError, strTipoError) {
                     },
                     complete: function(requestData, exito) { //fin de la llamada ajax.
                        
                     }
               });

}