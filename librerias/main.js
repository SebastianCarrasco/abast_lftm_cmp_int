
jQuery(document).on('submit','#formLg',function(event){
            event.preventDefault();
            jQuery.ajax({
                url:'main_app/login.php',
                type:'POST',
                dataType:'json',
                data:$(this).serialize(),
                beforeSend:function(){
                  $('.botonlg').val('Validando....');
                }
              })
              .done(function(respuesta){
                console.log(respuesta);
                if (!respuesta.error) {
                  if (respuesta.tipo=='ADMIN') {
                    location='ADMIN/index.php';
                  }else if (respuesta.tipo=='ABSTADM') {
                    location='abast_lftm_cmp_int/indexabast_lftm_cmp_int.php';
                  }else if (respuesta.tipo=='ABSTUSR') {
                    location='abast_lftm_cmp_int/indexabast_lftm_cmp_int_usr.php';
                  }else if (respuesta.tipo=='CVIS') {
                    location='CATAST_PCS_VISUAL/index.php';
                  }
                }else{
                  $('.error').slideDown('slow');
                  setTimeout(function(){
                  $('.error').slideUp('slow');
                },3000);
                $('.botonlg').val('Iniciar Secion');
                }
              })
              .fail(function(resp){
                console.log(resp.responseText);
              })
              .always(function(){
                console.log("complete");
            });
      });
