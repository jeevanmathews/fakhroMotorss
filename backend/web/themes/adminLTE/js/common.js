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

    function jcMaterialChange(item_name){ 
        var tabId = $("#jobcardmaterial-material_name:visible").closest(".main-body").attr("tab_id");      
        var sel = item_name;

        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").val(sel.split(" ").reverse()[1]);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").attr("disabled", "disabled");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-num_unit").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").val("");
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-hidden-rate").val("");
    }

    function searchItem(){
        $.ajaxSetup({async: false}); 
        $.post(jc_item_search_url, {item_name: $("[id*='search-info']:visible").find("#item_name").val()})
        .done(function( data ) {
           // $(".grid-view").html($(data).find(".grid-view").html()); 
            $("[id*='search-info']:visible .grid-view").html($(data).find(".grid-view").html());   
        });
        $.ajaxSetup({async: true});
    }

    function selectItem(item_name, item_id){        
      $(".main-body:visible").find("#jobcardmaterial-material_name").val(item_name);
      $(".main-body:visible").find("#jobcardmaterial-material_id").val(item_id);
      jcMaterialChange(item_name);
      $(".close-modal").trigger("click");            
    }

    $(document).on('keyup', "#jobcardmaterial-num_unit:visible", function(){
        var tabId = $(this).closest(".main-body").attr("tab_id");  
        var tot = parseFloat($("[tab_id='"+tabId+"']").find("#jobcardmaterial-unit_rate").val())*parseFloat($("[tab_id='"+tabId+"']").find("#jobcardmaterial-num_unit").val());
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").val(tot);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-hidden-rate").val(tot);
        $("[tab_id='"+tabId+"']").find("#jobcardmaterial-rate").attr("disabled", "disabled");
    });

    $(document).on('click', "[id*='search_item_']", function(){ 
      
        var elemId = "search-item-info-"+ $(this).attr("id").replace("search_item_", "");
       console.log(elemId); 
        $.post(jc_item_search_url, {"item_type": $(".main-body:visible").find("#jobcardmaterial-material_type").val()})
        .done(function( data ) {          
                 $("#"+elemId).html(data);  
                 $("#"+elemId).modal(); 
        });
    });

    // Jobcard Total form scripts

    $(document).on('click', "[id*='confirm-payment']:visible", function(){     
        $("."+$(this).attr("id")).modal().show();         
    });

     $(document).on('click', "[class*='generate-invoice-sales']:visible", function(){  
     // alert();   
        $("[class*='modal']:visible").modal().hide();         
    });

   
    $(document).on('keyup', "#discount_amount,#discount_percent:visible", function(){ 
      var tabId = $(".main-body:visible").attr("tab_id");  

      if (/\D/g.test(this.value))
      {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }else{ 
        if($(this).attr("id") =="discount_percent"){
            if(this.value >= 100)
                $(this).val("");
            else{
                var total_charge = $("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount") - (($("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount"))*$(this).val()/100);       
                $("#total_charge").html(total_charge.toFixed(decimal_places));
            }            
        }else{ 
            if(this.value >= parseFloat($("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount")))
                $(this).val("");
            else{
                var total_charge = $("[tab_id='"+tabId+"']").find("#gross-amount").attr("gross-amount") - $(this).val();      
                $("[tab_id='"+tabId+"']").find("#total_charge").html(total_charge.toFixed(decimal_places));
            }
        }
        var vat_value =vat_rate*total_charge/100;
        var amount_due = total_charge + vat_value;
        $("[tab_id='"+tabId+"']").find("#vat").html(vat_value.toFixed(decimal_places));
        $("[tab_id='"+tabId+"']").find("#amount_due").html(amount_due.toFixed(decimal_places));
      }
    });

    $(document).on('click', "[name='ex_discount']", function(){      
        var tabId = $(".main-body:visible").attr("tab_id");        
        showtotDiscount($(this).val(), tabId);
    });  

    function showtotDiscount(discount, tabId){

        if(discount == "discount_amount"){
            $("[tab_id='"+tabId+"']").find("#discount_amount").removeClass("hide");
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
    $(document).on('keyup', "[id='item_name']", function(){
        searchItem();
    });
    $(document).on('keyup', "[id='advanced_search_item']", function(){    
        searchItem();
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


     // Report search
    $(document).on('keyup', "[name='report_branch_id']", function(){
        searchServiceReport();
    });

    function searchServiceReport(){
      $.ajaxSetup({async: false}); 
        $.post(jc_customer_search_url, {branch_id: $("[name*='report_branch_id']:visible").val(), date_from: $("[name*='date_from']:visible").val(), date_to: $("[name*='date_to']:visible").val()})
        .done(function( data ) {          
            $("[id*='report_service']:visible .grid-view").html($(data).find(".grid-view").html());   
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
          success: function(data) {           
             $(".main-body:visible").find(".grid-view").html($(data).find('.grid-view').html())
          }
        });
    $.ajaxSetup({async: true}); 
    return false;
});
// Jobcard Approval
function reduceStock(jcid){
    $.ajaxSetup({async: false}); 
    $.post(jc_approval_url, {jobcard_id: jcid})
    .done(function( data ) {
        processResponse(data);  
    });
    $.ajaxSetup({async: true});    
}
/* Common click function */
$(document).on('click', "a", function(){
        var pagination = false;
        if($(this).hasClass("page_tab")){
          var tab_id = $(this).closest("li").attr("id");           
          $("#myTab .nav-item").addClass("active");  
          $(this).closest("li").removeClass("active");
          $(".main-body").addClass("hide");
          $(document).find('div[tab_id="'+tab_id+'"]').removeClass("hide");         
          return;
        } else if($(this).hasClass("jc-tabs")){ //Check for other clicks
          return true;
        } else if($(this).hasClass("close-modal")){
          return true;
        }else if($(this).hasClass("generate-invoice")){
          $("[class*='confirm-payment']").modal().hide();
          return true;
        }
        else if($(this).hasClass("change_status")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("search-jcitem")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("generate-quotation")){ //Check for other clicks
          return true;
        }
        else if($(this).hasClass("nav-link")){ //Check for other clicks
          return true;
        }else if($(this).hasClass("navbar-brand")){       
          $(".main-body").addClass("hide");
          $("#site_dashboard").removeClass("hide");
          return false;
        }else if($(this).hasClass("folder-tree")){
          return false;
        }else if($(this).attr("data-page")){
          pagination = true;
        }
        event.preventDefault();        

        //Find requested page id
        //
        var page_id = $(this).attr("href").split("=")[1].replace("%2F","_"); 
        //Extract request action only without arguments
        if(page_id.indexOf("&") != -1){         
          page_id = page_id.replace(page_id.substr(page_id.indexOf("&")),"");
        }

        //Generate Tab        
        if($(this).closest("div").attr("id") == "myNavbar"){
          $("#myTab .nav-item").addClass("active");          
          var tabId = "tab_id_"+($(".page_tab").length+1);
          $( '<li id="'+tabId+'" class="nav-item"><a class="nav-link page_tab" data-toggle="tab" role="tab" aria-controls="task" aria-selected="false"><span>'+page_id.replace("_","/")+'</span></a><b class="close-tab"><i class="fa fa-times-circle" aria-hidden="true"></i></b></li>' ).appendTo( $( "#myTab" ) );
        }

        if(tabId == undefined){
         var tabId = $(this).closest(".main-body").attr("tab_id");         
        }
          
         if($('div[tab_id="'+tabId+'"]').length){
            for(var i=0;i<5;i++){
              $('div[tab_id="'+tabId+'"]').next("script").remove();
            }
          }
          $.ajaxSetup({async: false}); 
          $.ajax({
          url: $(this).attr("href"),
          aSync: false,
          dataType: "html",
          success: function(data) { 
            if(data == 404){
              redirectOnceMore( nopermissionUrl, tabId);
              return false;
            }
            if(pagination && $(".modal").is(":visible")){              
              $(".modal:visible").find(".grid-view").html($(data).find('.grid-view').html())
            }else{
              $(".main-body").addClass("hide");
              $('div[tab_id="'+tabId+'"]').remove();
              $(".container-body").append($(data));
              $(document).find(".main-body:visible").attr("tab_id", tabId);
              $("#"+tabId).find("span").html($(document).find(".main-body:visible").find(".content-header h1").html());
              //$("#"+tabId).find("span").html(page_id.replace("_","/"));
              addMandatoryStar();
            }            
          }});
          $.ajaxSetup({async: true}); 
       
      });

      $(document).on('click', "[class='close-tab']", function(){
        //Next or Previous tab to be shown
        var tab_type = "id";
        var prev_tab_id = $(this).closest("li").prev("li").attr("id");  
        if(prev_tab_id == undefined){
            var prev_tab_id = $(this).closest("li").next("li").attr("id");
          if(prev_tab_id == undefined){
            var prev_tab_id = "navbar-header";
            tab_type = "class";
          }
        } 
        var close_tabId = $(this).closest("li").attr("id");
        for(var i=0;i<5;i++){
          $('div[tab_id="'+close_tabId+'"]').next("script").remove();
        }
        $(this).closest("li").remove(); 
        $('div[tab_id="'+close_tabId+'"]').remove();
        (tab_type == "id")?($("#"+prev_tab_id).find("a").trigger("click")):($("."+prev_tab_id).find("a").trigger("click"));
      })

      function addMandatoryStar(){
        $("[aria-required='true']").each(function(){
          var new_text = "* "+$(this).prev(".input-group-addon").text();
          if($(this).prev(".input-group-addon").text().indexOf("*") == -1){
            $(this).prev(".input-group-addon").text(new_text);
          }
        });
      }

