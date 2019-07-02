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
        var tabId = $(this).closest(".main-body").attr("tab_id");
       
        $(this).find(':submit').attr('disabled', true);

        if(($(document).find("[tab_id='"+tabId+"']").find("#"+formId+" .has-error").length > 0?false:true)){
            //$.ajaxSetup({async: false}); 
            $.ajax({
            type: 'POST',
            cache: false,
            url: $("#"+formId).attr("action"),
            data: $(this).serialize() // getting filed value in serialize form
            })
            .done(function(data){ // if getting done then call.
                processResponse(data, tabId); 
                $("#"+formId).find(':submit').attr('disabled', false); 
            });
            //$.ajaxSetup({async: true}); 
        }
        return false;
    });
  //}

  function processResponse(data, tabId){
    var response = jQuery.parseJSON(data);
    var response_head = "";
    if(response.success != undefined){
      response_head = "success";                 
    }else if(response.error != undefined){
      response_head = "error";
    }else{
      response_head = "error";                  
    }
    if(response.redirect != undefined){               
      redirectOnceMore(response.redirect, tabId);
    }
    $.toast({
      heading: (response_head.toUpperCase()),
      text: ((response.message != undefined)?response.message:"No response"),
      icon: response_head,
      loader: true,        // Change it to false to disable loader
      position: 'top-right',
      loaderBg: '#9EC600'  // To change the background
    });
    return true;    
  }

  function redirectOnceMore(redirect_url, tabId){  
    $.get( redirect_url , function( data ) {
      $(".main-body").addClass("hide");
      if($('div[tab_id="'+tabId+'"]').length){
        for(var i=0;i<5;i++){
          $('div[tab_id="'+tabId+'"]').next("script").remove();
        }
      }
      $('div[tab_id="'+tabId+'"]').remove();
      $(".container-body").append($(data));            
      $(document).find(".main-body:visible").attr("tab_id", tabId);                  
    });
  }

  //Jobcard Task Scripts     
      $(document).on('click', "[name='JobcardTask[discount]']:visible", function(){  console.log("df888")
        var tabId = $(this).closest(".main-body").attr("tab_id");    
        showDiscount($(this).val(), tabId);
      });
      function showDiscount(discval, tabId){
        $("[tab_id='"+tabId+"']").find(".field-jobcardtask-discount").removeClass("hide");
          if(discval == "discount_amount"){
              $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_amount]']").removeClass("hide");
              $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_percent]']").addClass("hide");
          }else{
              $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_percent]']").removeClass("hide");
              $("[tab_id='"+tabId+"']").find("[name='JobcardTask[discount_amount]']").addClass("hide");
          }
      }
   
      $(document).on('change', "#jobcardtask-task_id:visible", function(){

        var tabId = $(this).closest(".main-body").attr("tab_id");        
        var sel = $(this).find("option:selected").html();
        if($(this).find("option:selected").val() == "0"){            
            $.ajax({
            url: jc_create_task_url+'&jobcard_id='+$('div[tab_id="'+tabId+'"]').find("[name='jobcard_id']").val(),
            aSync: false,
            dataType: "html",
            success: function(data) {        
                $(".main-body").addClass("hide");
                $('div[tab_id="'+tabId+'"]').remove();
                $(".container-body").append($(data));            
                $(document).find("#"+$(".main-body:visible").attr("id")).attr("tab_id", tabId)
          }});
        }
        loadTaskData(sel, tabId);
    });

    function loadTaskData(sel, tabId){
        if(!sel.split("-")[1]){
            $("[tab_id='"+tabId+"']").find(".field-jobcardtask-billing_rate").addClass("hide");
            $("[tab_id='"+tabId+"']").find(".field-jobcardtask-discount").addClass("hide");
        } else{
            $("[tab_id='"+tabId+"']").find(".field-jobcardtask-billing_rate").removeClass("hide");
            if(sel.split("-")[1]) $("[tab_id='"+tabId+"']").find("#jobcardtask-billing_rate").val(sel.split(" ").reverse()[0]);
            $("[tab_id='"+tabId+"']").find("#jobcardtask-billing_rate").attr("disabled", "disabled"); 
            $("[tab_id='"+tabId+"']").find(".field-jobcardtask-discount").removeClass("hide"); 
        } 
        console.log(sel.split(" ").length)
    }  

    // Jobcard Material Scripts.
 
    $(document).on('click', "[name='JobcardMaterial[discount]']:visible", function(){  
      var tabId = $(this).closest(".main-body").attr("tab_id");       
      showMatDiscount($(this).val(), tabId);
    });
    function showMatDiscount(discval, tabId){
        if(discval == "discount_amount"){
            $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_amount]']").removeClass("hide");
            $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_percent]']").addClass("hide");
        }else{
            $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_percent]']").removeClass("hide");
            $("[tab_id='"+tabId+"']").find("[name='JobcardMaterial[discount_amount]']").addClass("hide");
        }
    }

    $(document).on('change', "#jobcardmaterial-material_type:visible", function(){
        var tabId = $(this).closest(".main-body").attr("tab_id");       
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-material_id").html($("[name='"+$(this).val()+"']").html());
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-num_unit").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-hidden-rate").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").val("");

    });
    $(document).on('change', ".accessory,.spare_part:visible", function(){
        var tabId = $(this).closest(".main-body").attr("tab_id");      
        var sel = $(this).find("option:selected").html();        
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").val(sel.split(" ").reverse()[1]);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").attr("disabled", "disabled");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-num_unit").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-hidden-rate").val("");
    });
    $(document).on('keyup', "#jobcardmaterial-num_unit:visible", function(){
        var tabId = $(this).closest(".main-body").attr("tab_id");  
        var tot = $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").val()*$("[tab_id='"+tabId+"']").find("#jobcardmaterial-num_unit").val();
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").val(tot);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-hidden-rate").val(tot);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").attr("disabled", "disabled");
    });   


    // Jobcard Total form scripts

    $(document).on('click', "[id*='confirm-payment']:visible", function(){     
        $("."+$(this).attr("id")).modal().show();
         console.log("hereeeee")
    });

   
    $(document).on('keyup', "#discount_amount,#discount_percent:visible", function(){ 
      var tabId = $(".main-body:visible").attr("tab_id");  

      if (/\D/g.test(this.value))
      {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }else{
        var vat = "<?php echo Yii::$app->common->company->vat_rate;?>";
        if($(this).attr("id") =="discount_percent"){
            if(this.value >= 100)
                $(this).val("");
            else{
                var total_charge = $("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount") - (($("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount"))*$(this).val()/100);       
                $("#total_charge").html(total_charge);
            }            
        }else{ 
            if(this.value >= parseFloat($("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount")))
                $(this).val("");
            else{
                var total_charge = $("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount") - $(this).val();      
                $("[tab_id='"+tabId+"']").find("#total_charge").html(total_charge);
            }
        }
        var vat_value =vat*total_charge/100;
        var amount_due = total_charge + vat_value;
        $("[tab_id='"+tabId+"']").find("#vat").html(vat_value);
        $("[tab_id='"+tabId+"']").find("#amount_due").html(amount_due);
      }
    });

    $("[name='ex_discount']").click(function(){      
        var tabId = $(".main-body:visible").attr("tab_id");        
        showtotDiscount($(this).val(), tabId);
    });  

    function showtotDiscount(discount, tabId){

        if(discount == "discount_amount"){
            $("[tab_id='"+tabId+"']").find$("#discount_amount").removeClass("hide");
            $("[tab_id='"+tabId+"']").find("#discount_percent").addClass("hide");
        }else{
            $("[tab_id='"+tabId+"']").find("#discount_amount").addClass("hide");
            $("[tab_id='"+tabId+"']").find("#discount_percent").removeClass("hide");
        }
    }

    $(document).on('click', "[id='apply-disount']:visible", function(){     
        var jc_id = $(this).prev("[name='discount_jc_id']").val(); console.log(jc_id)
        var tabId = $(".main-body:visible").attr("tab_id"); 
        var discount = $("[tab_id='"+tabId+"']").find("#"+$("[tab_id='"+tabId+"']").find("input:radio[name=ex_discount]:checked").val()).val();
        if(discount == ""){
            $("[tab_id='"+tabId+"']").find(".alert").removeClass("alert-success").addClass("alert-error").removeClass("hide").html("Please input a discount rate or value.");
        }else{
            $("[tab_id='"+tabId+"']").find(".alert").addClass("hide");
            if($("[tab_id='"+tabId+"']").find("input:radio[name=ex_discount]:checked").val() == "discount_percent"){
            var data_obj = { jobcard_id: jc_id, discount_percent: discount};
            }else{
                var data_obj = { jobcard_id: jc_id, discount_amount: discount};
            } 
            $.post(jc_apply_discount_url, data_obj)
            .done(function( data ) {
                processResponse(data, tabId);                      
                //$("[tab_id='"+tabId+"']").find(".alert").addClass("alert-success").removeClass("alert-error").removeClass("hide").html(data);    
            });   
        } 
             
    });

//Jobcard Search vehicle scripts
    $(document).on('keyup', "[id='advanced_search_veh']", function(){    
        searchVehicle();
    });
    $(document).on('keyup', "[id='reg_num']", function(){
        searchVehicle();
    });

    function selectVehicle(vehicle_id){       
        $.ajaxSetup({async: false}); 
        $.get(jc_vehicle_info_url, {vehicle_id: vehicle_id})
        .done(function( data ) {
            responseData = $.parseJSON(data);
            $.each(responseData, function(key,val) {           
                if($.inArray(key, ["jobcardvehicle-manufacturer", "jobcardvehicle-make_id"]) != -1){
                    $(".main-body:visible").find("#"+key).val(val).trigger("change");
                 }
                $(".main-body:visible").closest(".main-body").find("#"+key).val(val);
            }); 
            $(".close-modal").trigger("click");              
        });
        $.ajaxSetup({async: true});
    }

    function searchVehicle(){      
        $.ajaxSetup({async: false}); 
        $.post(jc_vehicle_search_url, {reg_num: $("[id*='search-info']:visible").find("#reg_num").val()})
        .done(function( data ) {
            $("[id*='search-info']:visible .grid-view").html($(data).find(".grid-view").html());  
        });
        $.ajaxSetup({async: true});
    }

    $(document).on('click', "[id*='search_vehicle']", function(){ 
        var elemId = "search-info-"+ $(this).attr("id").replace("search_vehicle_", "");
        $.post(jc_vehicle_search_url)
        .done(function( data ) {          
                 $("#"+elemId).html(data);  
                 $("#"+elemId).modal(); 
        });
    });
  
    $(document).on('click', "[id*='search_customer']", function(){ 
        var elemId = "search-info-"+ $(this).attr("id").replace("search_customer_", "");
        $.post(jc_customer_search_url)
        .done(function( data ) {          
          $("#"+elemId).html(data);  
          $("#"+elemId).modal(); 
        });
    });  

    //Jobcard search customer
    $(document).on('keyup', "[id='advanced_search']", function(){    
        searchCustomer();
    });
    $(document).on('keyup', "[id='cus_name']", function(){
        searchCustomer();
    });
    function selectCustomer(cus_id){       
        $.ajaxSetup({async: false}); 
        $.get(jc_customer_info_url, {customer_id: cus_id})
        .done(function( data ) {
            responseData = $.parseJSON(data);
            $.each(responseData, function(key,val) {
                $(".main-body:visible").closest(".main-body").find("#"+key).val(val);
            }); 
            $(".close-modal").trigger("click");              
        });
        $.ajaxSetup({async: true});
    }

    function searchCustomer(){
        $.ajaxSetup({async: false}); 
        $.post(jc_customer_search_url, {cus_name: $("[id*='search-info']:visible").find("#cus_name").val()})
        .done(function( data ) {
            $(".grid-view").html($(data).find(".grid-view").html()); 
            $("[id*='searchcus-info']:visible .grid-view").html($(data).find(".grid-view").html());   
        });
        $.ajaxSetup({async: true});
    }

    //status change a tag click
      $(document).on('click', ".change_status", function(e){ 
         var tabId = $(this).closest(".main-body").attr("tab_id");
        e.preventDefault();
      //   $.ajaxSetup({async: false}); 
          $.ajax({
          url: $(this).attr("href"),
          aSync: false,
          dataType: "html",
          success: function(data) {
             processResponse(data, tabId);
             //addMandatoryStar();
          }});
      //     $.ajaxSetup({async: true}); 
       
      });           
  
// Common gridview search filter
$(document).on('beforeFilter', '.grid-view', function(event) {
    console.log($(".main-body:visible").find(".gridview-filter-form").attr("action"));
    $.ajaxSetup({async: false}); 
    $.ajax({
          url: $(".main-body:visible").find(".gridview-filter-form").attr("action"),
          type: 'get',       
          data: $(".main-body:visible").find(".gridview-filter-form").serialize()+'&page_id='+$(".main-body:visible").find(".grid-view").attr("id"),
          success: function(data) {console.log("dfd")
            console.log($(data).find('.grid-view').html())
             $(".main-body:visible").find(".grid-view").html($(data).find('.grid-view').html())
          }
        });
    $.ajaxSetup({async: true}); 
    return false;
});
