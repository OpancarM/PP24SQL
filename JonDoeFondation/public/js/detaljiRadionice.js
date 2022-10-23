
/** Polaznici */
    $( '#uvjet' ).autocomplete({
        source: function(req,res){
           $.ajax({
               url: '/plesac/traziPlesaca/' + req.term + '/' + radionica,
               success:function(odgovor){
                   res(odgovor);
                //console.log(odgovor);
            }
           }); 
        },
        minLength: 2,
        select:function(dogadaj,ui){
            spremi(ui.item);
        }
    }).autocomplete( 'instance' )._renderItem = function( ul, item ) {
        return $( '<li>' )
          .append( '<div><img src="' + item.slika + '" style="max-width: 30px;" > ' + item.ime + ' ' + item.prezime + '</div>')
          .appendTo( ul );
      };

      function spremi(plesac){
          console.log(radionica);
          console.log(plesac.sifra);
          $.ajax({
            url: '/radionica/dodajPlesac/' + radionica + '/' + plesac.sifra,
            success:function(odgovor){
                if(odgovor==='OK'){
                    $('#plesac').append('<tr>' + 
                        '<td>' + plesac.ime +' ' + plesac.prezime +'</td>' + 
                        '<td>' + 
                            '<a onclick="return confirm(\'Sigurno obrisati?\');"  ' + 
                            ' id="b_' + plesac.sifra + '" ' +
                            ' class="brisiPlesaca" ' + 
                            ' href="#"> ' + 
                                '<i style="color: red" title="Obriši" ' + 
                                    'class="fas fa-2x fa-trash"></i>' + 
                            '</a>  ' + 
                        '</td>' + 
                    '</tr>');
                    definirajBrisanjePlesaca();
                }else{
                    alert('Dogodila se pogreška, pokušajte ponovo');
                }
               
             
         }
        }); 
      }


      function definirajBrisanjePlesaca(){
        $('.brisiPlesaca').click(function(){
            let element = $(this);
            let sifra = element.attr('id').split('_')[1];
            $.ajax({
              url: '/radionica/brisiPlesaca/' + radionica + '/' + sifra,
              success:function(odgovor){
                  if(odgovor==='OK'){
                     element.parent().parent().remove();
                  }else{
                      alert('Dogodila se pogreška, pokušajte ponovo');
                  }
                 
               
           }
          }); 
  
          return false;
        });
      }

      definirajBrisanjePlesaca();
      

      /* Završili polaznici */





      /* Predavač */

      $( '#uvjetTrener' ).autocomplete({
        source: function(req,res){
           $.ajax({
               url: '/trener/traziTrener/' + req.term ,
               success:function(odgovor){
                   res(odgovor);
                //console.log(odgovor);
            }
           }); 
        },
        select:function(dogadaj,ui){
           console.log(ui.item);
           $('#trener').val(ui.item.sifra);
           $('#odabraniTrener').html(ui.item.ime + ' ' + ui.item.prezime);
        }
    }).autocomplete( 'instance' )._renderItem = function( ul, item ) {
        return $( '<li>' )
          .append( '<div>' + item.ime + ' ' + item.prezime + '</div>')
          .appendTo( ul );
      };


      $('#uvjetTrener').on('keypress', function (e) {
        if(e.which !== 13){
            return;
        }
          let trener = $('#uvjetTrener').val().split(' ');
          if(trener.length==0){
              return false;
          }
          let ime='';
          let prezime='';
          if(trener.length>1){
              ime = trener[0];
              prezime = trener[1];
          }else{
              prezime=trener[0];
          }

          $.ajax({
            url: '/trener/dodajTrener/' +ime + '/' + prezime ,
            success:function(odgovor){
                $('#trener').val(odgovor);
                $('#odabraniTrener').html(ime + ' ' + prezime);
         }
        }); 

        return false;
  });

  /* Završio predavač */



  /* CKEDIT */
  CKEDITOR.replace('poruka', {
    height: 400,
    baseFloatZIndex: 10005,
    removeButtons: 'PasteFromWord'
  });
  /* završio CKEDIT */