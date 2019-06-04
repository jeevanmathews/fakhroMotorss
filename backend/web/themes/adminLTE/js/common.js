/**
* Common JS Functions
*/
$(document).ready(function() {
  //$(".slimScrollDiv, .menu").css("height", "auto");
  $('[data-toggle="tooltip"]').tooltip({placement: "bottom", html: true});
  $('.tooltipstered').tooltipster(
      { contentCloning: true,
        contentAsHTML: true,
        delay: 500,  
        maxWidth: 500
      }
    );
  
  $(function () {
    //Initialize Select2 Elements
    //$("#jobcardtask-task_id").select2({ width: '100%' });
    $(".select2").select2({ width: '100%' });
    });

  var curnturl = window.location.href;
  $(".sidebar-menu li").each(function(){
      var flag = false;
      if($(this).attr("class") == "treeview"){
        $(this).find("ul").children().each(function(){
          if(curnturl.indexOf($(this).find("a").attr("href")) != -1)  {
            if(!( curnturl.indexOf("create") != -1 && $(this).find("a").attr("href").indexOf("create") == -1)){
              flag = true;         
              $(this).addClass("active");
            }          
          } 
        }); 
        if(flag == true )   
          $(this).addClass("active");
      }       
  });

});

/**
* fn. for ajax form validation from server side
* @return boolean
*/
function validateAttribute(modelName, fieldName, fieldValue, mid, scenario){ 
    mid = (typeof mid == "undefined")?"":mid;
    scenario = (typeof scenario == "undefined")?"":scenario;
    $.ajaxSetup({async: false});
    $.post(jsUrl, {modelName: modelName, fieldName: fieldName, fieldValue: fieldValue.val(), mid: mid, scenario: scenario})
      .done(function( data ) {          
          if(data == true){ 
            fieldValue.closest(".form-group").find(".help-block").html("");   
            fieldValue.closest(".form-group").removeClass("has-error");
            return true;
          }
          else{
            fieldValue.closest(".form-group").find(".help-block").html(data);
            fieldValue.closest(".form-group").addClass("has-error");            
            return false;
          }      
      });
    $.ajaxSetup({async: true});
  }

  //function submitData(formId){
    $(document).on('beforeSubmit', "[class='aerp-form']", function(e){

        var formId = $(this).attr("id");
       
        $(this).find(':submit').attr('disabled', true);

        if(($(document).find("#"+formId+" .has-error").length > 0?false:true)){
            //$.ajaxSetup({async: false}); 
            $.ajax({
            type: 'POST',
            cache: false,
            url: $("#"+formId).attr("action"),
            data: $(this).serialize() // getting filed value in serialize form
            })
            .done(function(data){ // if getting done then call.                
                var response = jQuery.parseJSON(data);
                var response_head = "";
                if(response.success != undefined){
                  response_head = "success";                 
                }else if(response.error != undefined){
                  response_head = "error";
                }else{
                  response_head = "error";                  
                }
                $.toast({
                  heading: (response_head.toUpperCase()),
                  text: ((response.message != undefined)?response.message:"No response"),
                  icon: response_head,
                  loader: true,        // Change it to false to disable loader
                  position: 'top-right',
                  loaderBg: '#9EC600'  // To change the background
                });
                $("#"+formId).find(':submit').attr('disabled', false);               
            });
            //$.ajaxSetup({async: true}); 
        }
        return false;
    });
  //}
  