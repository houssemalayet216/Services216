/* 

1. Add your custom JavaScript code below
2. Place the this code in your template:

  

*/


























 $('#option_demande').on('change', function () {
             
                                 var categorie=$("#option_demande option:selected").val();
                                 
                                 if(categorie !==null)
                                 {
                                 $.ajax({

                         url:'/user/home/mission-demande/'+categorie,
                       type:'GET',
                       success:function (data,status,object)
                       {
                       if(data.success==true)
                       {
                          $('#missiondemande').html(data.output);
                        

                       }

                      },error:function()
                      {
                      $('#missiondemande').html("");
                      }

                        });

                                 }else{
                                  $('#missiondemande').html("");
                                 }


                                 });

 


$('#service_demande').on('change', function () {
             
                                 var service=$("#service_demande option:selected").val();
                                 
                                 if(service !==null)
                                 {
                                 $.ajax({

                         url:'/user/home/produit-demande/'+service,
                       type:'GET',
                       success:function (data,status,object)
                       {
                       if(data.success==true)
                       {
                          $('#listedesproduits').html(data.output);
                        

                       }

                      },error:function()
                      {
                      $('#listedesproduits').html("");
                      }

                        });

                                 }else{
                                  $('#listedesproduits').html("");
                                 }


                                 });



                    $('#option_demande').on('change', function () {
             
                                 var categorie=$("#option_demande option:selected").val();
                                 
                                 if(categorie !==null)
                                 {
                                 $.ajax({

                         url:'/user/home/deplacement-demande/'+categorie,
                       type:'GET',
                       success:function (data,status,object)
                       {
                       if(data.success==true)
                       {
                          $('#divdeplacement').html(data.output);
                        

                       }

                      },error:function()
                      {
                      $('#divdeplacement').html("");
                      }

                        });

                                 }else{
                                  $('#divdeplacement').html("");
                                 }


                                 });






 $('#service_demande').on('change', function () {
             
                                 var service=$("#service_demande option:selected").val();
                                 console.log(service);
                                 if(service !==null)
                                 {
                                 $.ajax({

                         url:'/user/home/service-option/'+service,
                       type:'GET',
                       success:function (data,status,object)
                       {
                       if(data.success==true)
                       {
                          $('#option_demande').html(data.output);
                        

                       }

                      },error:function()
                      {
                      $('#option_demande').html("");
                      }

                        });

                                 }else{
                                  $('#option_demande').html("");
                                 }


                                 });








































  /*$('#btn_membre').click(function(e){


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

              $('#list_membre').removeClass('active active_tab1');
           $('#list_membre').removeAttr('href data-toggle');
           $('#membre').removeClass('active');
           $('#list_membre').addClass('inactive_tab1');
           $('#list_demande').removeClass('inactive_tab1');
             $('#list_demande').addClass('active active_tab1');
             $('#list_demande').attr('href','#demande');
             $('#list_demande').attr('data-toggle','tab');
               $('#demande').addClass('active in');
               $('#missiondemande').html('');

                           

              

                $('.alertpublierdemande').html('<div role="alert" class="alert alert-success alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Success!</strong> '+message +' </div>');



                          
                            

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
*/





































































































$(document).ready(function() {
    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;





    
   function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
  return regex.test(email);
}





          $emailvalidation = $('#email_demande_contacter');
    $emailvalidation.blur(function(e){
         emailv= $(this).val();
    
        if (!isEmail(emailv))
        {
            document.getElementById('data.email').textContent='email invalide. ';
            $('#email_demande_contacter').val('');
            $('#email_demande_contacter').focus();
        }else{

           document.getElementById('data.email').textContent='';

        }
    });



















              $telephonevalidation = $('#telephone_demande_contacter');
    $telephonevalidation.blur(function(e){
        phone = $(this).val();
        phone = phone.replace(/[^0-9]/g,'');
        if (phone.length != 8)
        {
            document.getElementById('data.telephone').textContent='telephone doit etre 8 numero. ';
            $('#telephone_demande_contacter').val('');
            $('#telephone_demande_contacter').focus();
        }else{

           document.getElementById('data.telephone').textContent='';

        }
    });





                 $telephoneIIvalidation = $('#telephone2_demande_contacter');
    $telephoneIIvalidation.blur(function(e){
        phonee = $(this).val();
        phonee = phonee.replace(/[^0-9]/g,'');
        if (phonee.length != 8)
        {
            document.getElementById('data.telephoneII').textContent='telephone doit etre 8 numero. ';
            $('#telephone2_demande_contacter').val('');
            $('#telephone2_demande_contacter').focus();
        }else{

           document.getElementById('data.telephoneII').textContent='';

        }
    });



                 $fixvalidation = $('#fix_demande_contacter');
    $fixvalidation.blur(function(e){
        fixs = $(this).val();
        fixs = fixs.replace(/[^0-9]/g,'');
        if (fixs.length != 8)
        {
            document.getElementById('data.fix').textContent='numero fix doit etre 8 numero. ';
            $('#fix_demande_contacter').val('');
            $('#fix_demande_contacter').focus();
        }else{

           document.getElementById('data.fix').textContent='';

        }
    });





                   $cpvalidation = $('#cp_demande_contacter');
    $cpvalidation.blur(function(e){
        cps = $(this).val();
      
        if (cps.length != 4)
        {
            document.getElementById('data.cp').textContent='code postale invalide. ';
            $('#cp_demande_contacter').val('');
            $('#cp_demande_contacter').focus();
        }else{

           document.getElementById('data.cp').textContent='';

        }
    });






































































    $('#next1-contacter').click(function(){


   var rec=$('#recurrence option:selected').val();
                
                  var titre= $('#titrecontacteroffre').val();
                   var description= $('#descriptioncontacteroffre').val();



             if(rec=="")
        {
         document.getElementById('data.recurencebesoin').textContent='Ce champ ne doit pas etre vide ';       
        }


    
          if(titre=="")
        {
         document.getElementById('data.titrecontacteroffre').textContent='Ce champ ne doit pas etre vide ';       
        }


           if(description=="")
        {
         document.getElementById('data.descriptioncontacteroffre').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#recurrence').change(function(){
                  
                 if($.trim(document.getElementById('data.recurencebesoin').textContent) !== "")

                                  {
                                    document.getElementById('data.recurencebesoin').textContent="";
                                  }
                    
                                 });


        




                           $('#titrecontacteroffre').change(function(){
                  
                 if($.trim(document.getElementById('data.titrecontacteroffre').textContent) !== "")

                                  {
                                    document.getElementById('data.titrecontacteroffre').textContent="";
                                  }
                    
                                 });



               
                           $('#descriptioncontacteroffre').change(function(){
                  
                 if($.trim(document.getElementById('data.descriptioncontacteroffre').textContent) !== "")

                                  {
                                    document.getElementById('data.descriptioncontacteroffre').textContent="";
                                  }
                    
                                 });


                  if(rec!==""&&titre!==""&&description!=="")
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





   $('#next2-contacter').click(function(){

       var dates= $('#datesdemande').val();
       var temp= $('#tempdemande').val();



     
          if(dates=="")
        {
         document.getElementById('data.datedemande').textContent='Ce champ ne doit pas etre vide ';       
        }


           if(temp=="")
        {
         document.getElementById('data.tempdemande').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#datesdemande').change(function(){
                  
                 if($.trim(document.getElementById('data.datedemande').textContent) !== "")

                                  {
                                    document.getElementById('data.datedemande').textContent="";
                                  }
                    
                                 });


        




                           $('#tempdemande').change(function(){
                  
                 if($.trim(document.getElementById('data.tempdemande').textContent) !== "")

                                  {
                                    document.getElementById('data.tempdemande').textContent="";
                                  }
                    
                                 });









         if(dates!==""&&temp!=="")
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




   $('#next3-contacter').click(function(){


 
      var membres=$('#membres option:selected').length;

             if(!membres)
        {
         document.getElementById('data.membres').textContent='Ce champ ne doit pas etre vide ';       
        }


         $('#membres').change(function(){
                  
                 if($.trim(document.getElementById('data.membres').textContent) !== "")

                                  {
                                    document.getElementById('data.membres').textContent="";
                                  }
                    
                                 });

                                 if(membres)
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





     



    $('#Enregistrer').click(function(e){


          e.preventDefault();
      
   var ville=$('#ville_demande_contacter option:selected').val();
                
                  var adresse= $('#adresse_demande_contacter').val();
                   var cp= $('#cp_demande_contacter').val();
                    var telephone= $('#telephone_demande_contacter').val();
                     var email= $('#email_demande_contacter').val();
                    

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


              if(telephone=="")
        {
         document.getElementById('data.telephone').textContent='Ce champ ne doit pas etre vide ';       
        }


                if(email=="")
        {
         document.getElementById('data.email').textContent='Ce champ ne doit pas etre vide ';       
        }



         $('#ville_demande_contacter').change(function(){
                  
                 if($.trim(document.getElementById('data.ville').textContent) !== "")

                                  {
                                    document.getElementById('data.ville').textContent="";
                                  }
                    
                                 });


        




                           $('#adresse_demande_contacter').change(function(){
                  
                 if($.trim(document.getElementById('data.adresse').textContent) !== "")

                                  {
                                    document.getElementById('data.adresse').textContent="";
                                  }
                    
                                 });



               
                           $('#cp_demande_contacter').change(function(){
                  
                 if($.trim(document.getElementById('data.cp').textContent) !== "")

                                  {
                                    document.getElementById('data.cp').textContent="";
                                  }
                    
                                 });






               $('#telephone_demande_contacter').change(function(){
                  
                 if($.trim(document.getElementById('data.telephone').textContent) !== "")

                                  {
                                    document.getElementById('data.telephone').textContent="";
                                  }
                    
                                 });


                    $('#email_demande_contacter').change(function(){
                  
                 if($.trim(document.getElementById('data.email').textContent) !== "")

                                  {
                                    document.getElementById('data.email').textContent="";
                                  }
                    
                                 });







     
      
         if(ville!==""&&adresse!==""&&cp!==""&&telephone!==""&&email!=="")
           {   
         $('#Enregistrer').prop('disabled',true);
            $("#spin-contacter-offre").addClass('fa fa-spinner fa-spin fa-register');
            var formcontacteroffre = document.getElementById("formcontacteroffre");

            
           
                      $.ajax({
                       dataType:"json",
                       url:$("#formcontacteroffre").attr('action'),
                       type:$("#formcontacteroffre").attr('method'),
                        data:new FormData(formcontacteroffre),
                       contentType:false,
                       processData:false,
                       cache:false,
                       success:function (data,status,object)
                       {

                       
                       var message=data.message;
                       if(data.success==true)
                          {


                         
                              
                             
                               
                          
                               
                              $('#formcontacteroffre')[0].reset();
                              

                             animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
       
                current_fs.hide();
                animating = false;


           $('.contacterdemandealert').html('<div role="alert" class="alert alert-success alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Success!</strong> '+message +' </div>');
                          
                       
             
                setInterval(function(){
   window.location.reload(1);
}, 10000);




                          }

                          else{

                                  $('.contacterdemandealert').html('<div role="alert" class="alert alert-success alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Success!</strong> '+message +' </div>');



                            if(data.errors)
                            {
                             
                                  $('#Enregistrer').prop('disabled',false);
            $("#spin-contacter-offre").removeClass('fa fa-spinner fa-spin fa-register');

                           

                            }


                          }
                                
                                   $('#Enregistrer').prop('disabled',false);
            $("#spin-contacter-offre").removeClass('fa fa-spinner fa-spin fa-register'); 
                        
                         
                          
                          
                          },
                          error:function (data,status,object)
                          {
                             console.log(data.message);

                                  $('.contacterdemandealert').html('<div role="alert" class="alert alert-success alert-dismissible">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>'+'<strong>Success!</strong> '+data.message +' </div>');




                               $('#Enregistrer').prop('disabled',false);
            $("#spin-contacter-offre").removeClass('fa fa-spinner fa-spin fa-register'); 
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







function permission()
{
  swal("Oops...", "Something went wrong!", "error");

}











 function filter_data(page)
  {



      $('.filter_data').html('<div id="loading" style=""></div>');


      var action='fetch_data';
   
    var opt=$('#option_selected').val();
  
       console.log($('.activite_annonce option:selected').val());
      var type_annonce=get_filter('type_annonce');
      var ville=$('.villeannonce option:selected').val();
      var datefilter=get_filter('time_annonce');
      var option=$('.activite_annonce option:selected').val();
      var type_visite=get_filter('type_visite');
      $.ajax({
       url:'/filtre',
       method:'POST',
  
       data:{action:action,option:option,type_annonce:type_annonce,ville:ville,opt:opt,datefilter:datefilter,page:page},
           success:function(data)
           {
          
            $('.filter_data').html(data);
      
           
           }

      });
  }

    function get_filter(class_name)
  {
    var filter;
    $('.'+class_name+' option:selected').each(function(){

      filter=$(this).val();


    });

    return filter;
  }

 



$('.common_selector').on('change', function() {
    filter_data();
});

$(document).on('click','.pagination_link',function(e){

       e.preventDefault();
		var page=$(this).children("a").attr("id");
		

		filter_data(page);

		return false;

	});


/*$('.villefilter').select2({
                
                   minimumInputLength: 3,
                placeholder:'Ville ',
                allowClear: true,
                 theme: "bootstrap"
              
            });

$('.villeannonce').select2({
                
                   minimumInputLength: 3,
                placeholder:'Ville ',
                allowClear: true,
                theme: "bootstrap"
              
            });
*/


 function filter_data_recherche(page)
  {



      $('.filter_data_recherche').html('<div id="loading_recherche" style=""></div>');


      var action='fetch_data';
      
  
  
     
      var type_annonce=get_filter('type_annonce_recherche');
      var ville=$('.ville_annonce_recherche option:selected').val();
      var datefilter=get_filter('time_annonce_recherche');
      var option=get_filter('activite_annonce_recherche');
      var type_visite=get_filter('type_visite_recherche');
      $.ajax({
       url:'/recherche_service',
       method:'POST',
  
       data:{action:action,option:option,type_annonce:type_annonce,ville:ville,datefilter:datefilter,page:page},
           success:function(data)
           {
          
            $('.filter_data_recherche').html(data);
      
           
           }

      });
  }

  

 



$('.common_selector_recherche').on('change', function() {
    filter_data_recherche();
});

$(document).on('click','.pagination_link_recherche',function(e){

       e.preventDefault();
    var page=$(this).children("a").attr("id");
    

    filter_data_recherche(page);

    return false;

  });
