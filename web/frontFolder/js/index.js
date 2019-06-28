/* Fundraising Grader
*
* Generic Copyright, yadda yadd yadda
*
* Plug-ins: jQuery Validate, jQuery 
* Easing
*/

$(document).ready(function() {
    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;


     
   function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
  return regex.test(email);
}





          $emailvalidation = $('#email_demande');
    $emailvalidation.blur(function(e){
         emailv= $(this).val();
    
        if (!isEmail(emailv))
        {
            document.getElementById('data.email').textContent='email invalide. ';
            $('#email_demande').val('');
            $('#email_demande').focus();
        }else{

           document.getElementById('data.email').textContent='';

        }
    });



















              $telephonevalidation = $('#telephone_demande');
    $telephonevalidation.blur(function(e){
        phone = $(this).val();
        phone = phone.replace(/[^0-9]/g,'');
        if (phone.length != 8)
        {
            document.getElementById('data.telephone').textContent='telephone doit etre 8 numero. ';
            $('#telephone_demande').val('');
            $('#telephone_demande').focus();
        }else{

           document.getElementById('data.telephone').textContent='';

        }
    });





                 $telephoneIIvalidation = $('#telephone2_demande');
    $telephoneIIvalidation.blur(function(e){
        phonee = $(this).val();
        phonee = phonee.replace(/[^0-9]/g,'');
        if (phonee.length != 8)
        {
            document.getElementById('data.telephoneII').textContent='telephone doit etre 8 numero. ';
            $('#telephone2_demande').val('');
            $('#telephone2_demande').focus();
        }else{

           document.getElementById('data.telephoneII').textContent='';

        }
    });



                 $fixvalidation = $('#fix_demande');
    $fixvalidation.blur(function(e){
        fixs = $(this).val();
        fixs = fixs.replace(/[^0-9]/g,'');
        if (fixs.length != 8)
        {
            document.getElementById('data.fix').textContent='numero fix doit etre 8 numero. ';
            $('#fix_demande').val('');
            $('#fix_demande').focus();
        }else{

           document.getElementById('data.fix').textContent='';

        }
    });





                   $cpvalidation = $('#cp_demande');
    $cpvalidation.blur(function(e){
        cps = $(this).val();
      
        if (cps.length != 4)
        {
            document.getElementById('data.cp').textContent='code postale invalide. ';
            $('#cp_demande').val('');
            $('#cp_demande').focus();
        }else{

           document.getElementById('data.cp').textContent='';

        }
    });





































  $('#next1-annonce').click(function(){

      var serv=$('#service_demande option:selected').val();
                
                  var titre= $('#titre_demande').val();
                   var description= $('#description_demande').val();
        
        if(serv=="")
        {
         document.getElementById('data.service').textContent='Ce champ ne doit pas etre vide ';       
        }
   

     
      

          if(titre=="")
        {
         document.getElementById('data.titre').textContent='Ce champ ne doit pas etre vide ';       
        }


           if(description=="")
        {
         document.getElementById('data.description').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#service_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.service').textContent) !== "")

                                  {
                                    document.getElementById('data.service').textContent="";
                                  }
                    
                                 });


        




                           $('#titre_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.titre').textContent) !== "")

                                  {
                                    document.getElementById('data.titre').textContent="";
                                  }
                    
                                 });



                                    $('#description_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.description').textContent) !== "")

                                  {
                                    document.getElementById('data.description').textContent="";
                                  }
                    
                                 });

                     if(serv!==""&&titre!==""&&description!=="")
                     {                                                                      

                   
     

                         animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
     /*   current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {*/
                current_fs.hide();
                animating = false;
          /*  },
            easing: 'easeInOutExpo'
        });
*/



               }
    });






           $('#next2-annonce').click(function(){

               var tvisite= $('#typevisite_demande').val();
                   
                   var datev=$('#datedemande').val(); 
                   var timev=$('#timedemande').val();



              if(tvisite=="")
        {
         document.getElementById('data.typeVisite').textContent='Ce champ ne doit pas etre vide ';       
        }
   

     

      

          if(datev=="")
        {
         document.getElementById('data.dateVisite').textContent='Ce champ ne doit pas etre vide ';       
        }


           if(timev=="")
        {
         document.getElementById('data.datePrevu').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#typevisite_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.typeVisite').textContent) !== "")

                                  {
                                    document.getElementById('data.typeVisite').textContent="";
                                  }
                    
                                 });


      



 $('#datedemande').change(function(){
                  
                 if($.trim(document.getElementById('data.dateVisite').textContent) !== "")

                                  {
                                    document.getElementById('data.dateVisite').textContent="";
                                  }
                    
                                 });







 $('#timedemande').change(function(){
                  
                 if($.trim(document.getElementById('data.datePrevu').textContent) !== "")

                                  {
                                    document.getElementById('data.datePrevu').textContent="";
                                  }
                    
                                 });

if(tvisite!==""&&datev!==""&&timev!="")
{


         animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
  
                current_fs.hide();
                animating = false;



               }
    });


          $('#next3-annonce').click(function(){
         

            var phone=$('#telephone_demande').val();
                    var ville=$('#ville_demande').val();
                   var adresse=$('#adresse_demande').val();
                   var cp=$('#cp_demande').val();



              
                           
   






















          

              if(phone=="")
        {
         document.getElementById('data.telephone').textContent='Ce champ ne doit pas etre vide ';       
        }
   

        if(ville=="")
        {
         document.getElementById('data.ville').textContent='Ce champ ne doit pas etre vide ';       
        }

      

          if(adresse=="")
        {
         document.getElementById('data.adresse').textContent='Ce champ ne doit pas etre vide ';       
        }


           if(cp=="")
        {
         document.getElementById('data.cp').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#telephone_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.telephone').textContent) !== "")

                                  {
                                    document.getElementById('data.telephone').textContent="";
                                  }
                    
                                 });


       
         $('#ville_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.ville').textContent) !== "")

                                  {
                                    document.getElementById('data.ville').textContent="";
                                  }
                    
                                 });



 $('#adresse_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.adresse').textContent) !== "")

                                  {
                                    document.getElementById('data.adresse').textContent="";
                                  }
                    
                                 });







 $('#cp_demande').change(function(){
                  
                 if($.trim(document.getElementById('data.cp').textContent) !== "")

                                  {
                                    document.getElementById('data.cp').textContent="";
                                  }
                    
                                 });






if(phone!=""&&ville!=""&&adresse!=""&&cp!="")


{

       
     animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
       
                current_fs.hide();
                animating = false;
         














               }
    });















$('#btn_membre').click(function(e){


 e.preventDefault();

       var membresv=$('#selectmembres option:selected').length;

             if(!membresv)
        {
         document.getElementById('data.membres').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#selectmembres').change(function(){
                  
                 if($.trim(document.getElementById('data.membres').textContent) !== "")

                                  {
                                    document.getElementById('data.membres').textContent="";
                                  }
                    
                                 });

                                 if(membresv)
                                 {

















                 
                    $('#btn_membre').prop('disabled',true);
                  $("#spin-add-annonce").addClass('fa fa-spinner fa-spin fa-register');
                   var formannonce = document.getElementById("add-annonce-form");

                 

                      $.ajax({
                       dataType:"json",
                       url:$("#add-annonce-form").attr('action'),
                       type:$("#add-annonce-form").attr('method'),
                        data:new FormData(formannonce),
                       contentType:false,
                       processData:false,
                       cache:false,
                       success:function (data,status,object)
                       {

                       
                       var message=data.message;
                       if(data.success==true)
                          {


                         
                              
                             
                               
                          
                               
                              $('#add-annonce-form')[0].reset();
                              $('#divdeplacement').html("");
                               $('#listedesproduits').html("");
                                 $('#missiondemande').html("");

           
                                 animating = true;
        current_fs = $(this).parent();
       next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();

                current_fs.hide();
                animating = false;

        











































                           

              

                $('.alertpublierdemande').html('<div role="alert" class="alert alert-success alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Success!</strong> '+message +' </div>');



                setInterval(function(){
   window.location.reload(1);
}, 15000);
                          
                            

                          }

                          else{

                           

                              $('.alertpublierdemande').html('<div role="alert" class="alert alert-danger alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Eureur!</strong> '+message +' </div>');





                            if(data.errors)
                            {
                             


                              $("#spin-add-annonce").removeClass('fa fa-spinner fa-spin fa-register');
                          $('#btn_confirmation').prop('disabled',false); 

                            }

                          }
                                
                            $("#spin-add-annonce").removeClass('fa fa-spinner fa-spin fa-register');
                          $('#btn_confirmation').prop('disabled',false); 
                        
                         
                          
                          
                          },
                          error:function (data,status,object)
                          {
                             console.log(data.message);

                            $('.alertpublierdemande').html('<div role="alert" class="alert alert-danger alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Eureur!</strong> '+data.message +' </div>');



                         $("#spin-add-membre").removeClass('fa fa-spinner fa-spin fa-register');
                          $('#btn-add-membre').prop('disabled',false); 
                          }








                       });
}

                  });
















































































    $(".previous").click(function() {
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        previous_fs.show();
      
                current_fs.hide();
                animating = false;
        
    });
});
