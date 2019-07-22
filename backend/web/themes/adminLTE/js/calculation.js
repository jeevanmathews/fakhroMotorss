
$(document).ready(function() {

  
  $(document).on('click','.btn_add_new',function(e){
    e.preventDefault();
    var clone = $('.item_row:last').clone();
    clone.find('a.no-display').removeClass('no-display');
    clone.find(".input-group").children('select').removeClass('select2');
    clone.find(".input-group").children('span').remove();
    clone.find("input").val('');
    clone.find(".input-group").children('select').select2();
         // clone.find(".field-purchaserequestitems-item_id")
         //    .children('select')
         //    // call destroy to revert the changes made by Select2
         //    .select2("destroy")
         //    .end()
            // .append(
            //     // clone the row and insert it in the DOM
            //     $(".field-purchaserequestitems-item_id")
            //     .children("select")
            //     .first()
            //     .clone()
        // );
        // clone.find('select').select2('destroy');
        clone.find('select').select2();
        $('.item_table').append(clone);
      });
$(document).on('click','.remove_row',function(e){
 e.preventDefault();
 $(this).closest('tr').remove();
});
$(document).on('click','.btn_select_do',function(){
  var do_id=$("#salesinvoice-do_id").val();
  var url=$('.hiddenurl_create').val();
  if(do_id!='' && do_id!='undefined'){
    window.location.href=url+do_id;
  }
});


$(document).on('change','.select_item_td',function(){
  var item_id=$(this).val();
  var thisrow=$(this).closest('tr');
  var data={'id':item_id}
  var url=hiddenurl_itemprice;//$('.hiddenurl_itemprice').val();
 
  if(item_id!='' && item_id!='undefined'){
     // console.log(item_id);
    $.ajax({
            type:'post',
            url:url+'&id='+item_id,//"<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>",
            data:data,
            success:function(s){
             
              var response = JSON.parse(s);
              // console.log(response);
              $(thisrow).find('.price').val((response.selling_price).toFixed(decimalPlaces));
              $(thisrow).find('.vatrate').val(response.vat);
                // var thisrow=$(this).closest('tr');
                var net_amount=0;
                var total=0;
                var total_price=0;
                var discount_percentage=0;
                var qty=0;
                var dis=0;
                var price=0;
                var vat=0;
                var vatrate=0;
                if($(thisrow).find('.qty:visible').val()!='' && $(thisrow).find('.qty:visible').val()!='undefined'){
                  qty=$(thisrow).find('.qty:visible').val();
                }
                if($(thisrow).find('.price:visible').val()!='' && $(thisrow).find('.price:visible').val()!='undefined'){
                  price=$(thisrow).find('.price:visible').val();
                }
                
                total_price=(parseFloat(qty)*parseFloat(price)).toFixed(decimalPlaces);
                $(thisrow).find('.total_price:visible').val(total_price);

    // total=net_amount;

    var type=$('.discount_type:visible:checked').val();
    discount_percentage=$(thisrow).find('.discount_percentage:visible').val();
    if(discount_percentage!='' &&  discount_percentage!='undefined' && typeof discount_percentage!=='undefined' && $.isNumeric(discount_percentage)){
     
     if(type=="percentage"){
       dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
     }else{
      dis=discount_percentage; 
    }
    
  }


    net_amount=(parseFloat(total_price)-parseFloat(dis)).toFixed(decimalPlaces);

    if($(thisrow).find('.vatrate:visible').val()!='' &&  $(thisrow).find('.vatrate:visible').val()!='undefined' && typeof $(thisrow).find('.vatrate:visible').val()!=='undefined'){
     
      vatrate=$(thisrow).find('.vatrate:visible').val();
      
    }
    vat=(parseFloat(net_amount))*parseFloat(vatrate)/100;
    total=((parseFloat(net_amount))+ parseFloat(vat)).toFixed(decimalPlaces);
    
    $(thisrow).find('.discount_amount:visible').val(dis);
    $(thisrow).find('.tax:visible').val(vat);
    $(thisrow).find('.net_amount:visible').val(net_amount);
    $(thisrow).find('.total:visible').val(total);
    $('.total:visible').trigger('change');
                // $(thisrow).find('#salesinvoiceitems-unit_id').val(response.unit_id);
                
              }
            });
}
}); 
// change the total with quantity and price 
$(document).on('change','.qty,.price,.vatrate,.discount_percentage',function(){
  var thisrow=$(this).closest('tr');
  var net_amount=0;
  var total=0;
  var total_price=0;
  var discount_percentage=0;
  var qty=0;
  var dis=0;
  var price=0;
  var vat=0;
  var vatrate=0;
  if($(thisrow).find('.qty:visible').val()!='' && $(thisrow).find('.qty:visible').val()!='undefined'){
    qty=$(thisrow).find('.qty:visible').val();
     // console.log(parseFloat($(thisrow).find('.remaining_qty').val()) ,parseFloat($(thisrow).find('.qty').val()));
    if(parseFloat($(thisrow).find('.remaining_qty:visible').val()) < parseFloat($(thisrow).find('.qty:visible').val()) ){
       
        $(thisrow).find('.qty:visible').parent().parent().append('<span class="error">Cannot exceed the ordered quantity</span>').css('color','red');
        $(thisrow).find('.qty:visible').val($(thisrow).find('.remaining_qty:visible').val());
        qty=$(thisrow).find('.remaining_qty:visible').val();
        //$('.qty').prop('disabled',true);
      }else{
        $(thisrow).find('.qty:visible').parent().parent().find('.error').html('');
      }
  }
  if($(thisrow).find('.price:visible').val()!='' && $(thisrow).find('.price:visible').val()!='undefined'){
    price=$(thisrow).find('.price:visible').val();
  }
  
  total_price=(parseFloat(qty)*parseFloat(price)).toFixed(decimalPlaces);
  $(thisrow).find('.total_price').val(total_price);

    // total=net_amount;

    var type=$('.discount_type:visible:checked').val();
    discount_percentage=$(thisrow).find('.discount_percentage:visible').val();
    if(discount_percentage!='' &&  discount_percentage!='undefined' && typeof discount_percentage!=='undefined' && $.isNumeric(discount_percentage)){
     
     if(type=="percentage"){
       dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
     }else{
      dis=discount_percentage; 
    }
    
  }

    net_amount=(parseFloat(total_price)-parseFloat(dis)).toFixed(decimalPlaces);

    if($(thisrow).find('.vatrate:visible').val()!='' &&  $(thisrow).find('.vatrate:visible').val()!='undefined' && typeof $(thisrow).find('.vatrate:visible').val()!=='undefined'){
     
      vatrate=$(thisrow).find('.vatrate:visible').val();
      
    }
    vat=(parseFloat(net_amount))*parseFloat(vatrate)/100;
    total=((parseFloat(net_amount))+ parseFloat(vat)).toFixed(decimalPlaces);
    
    $(thisrow).find('.discount_amount:visible').val(dis);
    $(thisrow).find('.tax:visible').val(vat);
    $(thisrow).find('.net_amount:visible').val(net_amount);
    $(thisrow).find('.total:visible').val(total);
    $('.total:visible').trigger('change');
  });
// sum up totals to get subtotal
$(document).on('change','.total',function(){
  var subtotal=0;
  $('.total:visible').each(function () {
    if($.isNumeric($(this).val())){
      subtotal=(parseFloat(subtotal) + parseFloat($(this).val())).toFixed(decimalPlaces);;
    }
  });
  $('.subtotal:visible').val(subtotal);
  $('.subtotal:visible').trigger('change');
});


$(document).on('change','.subtotal,.discount',function(){
 // var formid=$(this).parents().find('form.aerp-form').attr('id');
  // console.log(formid);
  var gtotal=0;
  var taxtotal=0;
  var subtotal= $('.subtotal:visible').val();
  var discount= $('.discount:visible').val();
  var type=$('.common_discount_type:visible:checked').val();
  //console.log($('.subtotal'),type,subtotal,discount);
  if(discount!='' &&  discount!='undefined' && typeof discount!=='undefined' && $.isNumeric(discount)){
   if(type=="percentage"){
    var disamount=parseFloat(subtotal)*parseFloat(discount)/100;
  }else{
    var disamount=discount;
  }
  gtotal= (parseFloat(subtotal)-parseFloat(disamount)).toFixed(decimalPlaces); 
}else{
  gtotal=parseFloat(subtotal).toFixed(decimalPlaces);
}
 $('.net:visible').val(gtotal);
if($('.vatper').val()!='' &&  $('.vatper').val()!='undefined' && typeof $('.vatper').val()!=='undefined'){
  var vat_rate=$('.vatper').val();
  console.log(vat_rate);
  taxtotal=((parseFloat(gtotal)*parseFloat(vat_rate))/100).toFixed(decimalPlaces);
  gtotal=(parseFloat(gtotal)+(parseFloat(gtotal)*parseFloat(vat_rate)/100)).toFixed(decimalPlaces);
}
   // if($.isNumeric(discount)){
   //      gtotal= parseFloat(subtotal)-parseFloat(discount); 
   // }else{
   //      gtotal=subtotal;
   // }
   $('.grandtotal:visible').val(gtotal);
   $('.total_tax:visible').val(taxtotal);
 });
// reduce discount from total

$(document).on('click','.common_discount_type',function(){
  var type=$(this).val();
  var grandtotal=0;
  var taxtotal=0;
  var disamount=0;
  var discount=$('.discount:visible').val();
  var subtotal=$('.subtotal:visible').val(); 
    // console.log(type,discount,subtotal);
    if(discount!=""){
      if(type=="percentage"){
        disamount=parseFloat(subtotal)*parseFloat(discount)/100;
      }else{
        disamount=discount;
      }
    }
  grandtotal=(parseFloat(subtotal)-parseFloat(disamount)).toFixed(decimalPlaces);;
  $('.net:visible').val(grandtotal);
  if($('.vatper').val()!='' &&  $('.vatper').val()!='undefined' && typeof $('.vatper').val()!=='undefined'){
    var vat_rate=$('.vatper').val();
    taxtotal=((parseFloat(grandtotal)*parseFloat(vat_rate))/100).toFixed(decimalPlaces);
    grandtotal=(parseFloat(grandtotal)+(parseFloat(grandtotal)*parseFloat(vat_rate)/100)).toFixed(decimalPlaces);
    
  }
  // console.log(taxtotal,grandtotal,vat_rate);
  $('.total_tax:visible').val(taxtotal);
  $('.grandtotal:visible').val(grandtotal);
});

// $(document).on('change','.discount',function(){
//   var type=$('.common_discount_type:checked').val();
//   var grandtotal=0;
//   var taxtotal=0;
//   var discount=$(this).val();
//   var subtotal=$('.subtotal').val(); 
//   // console.log(subtotal);
//   if(discount!="" && $.isNumeric(discount)){
//     if(type=="percentage"){
//       var disamount=parseFloat(subtotal)*parseFloat(discount)/100;
//     }else{
//       var disamount=discount;
//     }
//   }else{
//     var disamount=0;
//   }
//   grandtotal=parseFloat(subtotal)-parseFloat(disamount);
//   // console.log(discount,type,disamount,grandtotal,subtotal);
//   $('.net').val(grandtotal);
//   if($('.vatper').val()!='' &&  $('.vatper').val()!='undefined' && typeof $('.vatper').val()!=='undefined'){
//     var vat_rate=$('.vatper').val();
//     taxtotal=((parseFloat(grandtotal)*parseFloat(vat_rate))/100).toFixed(decimalPlaces);
//     grandtotal=(parseFloat(grandtotal)+(parseFloat(grandtotal)*parseFloat(vat_rate)/100)).toFixed(decimalPlaces);
    
//   }
  
//   $('.total_tax').val(taxtotal);
//   $('.grandtotal').val(grandtotal);

// });

  if($('.remaining_qty').val()==$('.qty').val() ){
    $('.qty').prop('disabled',true);
  }
});

$(document).on('change','.supplier_id',function(){
  // alert();
  var supplier_id=$(this).val();
  $('.append_here').html('');   
  var data={'supplier_id':supplier_id}
  if(supplier_id!='' && supplier_id!='undefined'){
    $.ajax({
      'type':'post',
      'url':supplier,
      'data':data,
      success:function(s){
       var res='';
       var response = JSON.parse(s);
       // console.log(response.address);
       if(response.address!=null){
        res+='<div class="form-group field-items-description">';
        res+='<textarea id="supplier_address" class="form-control" disabled name="" rows="6" placeholder="Description">'+response.address+'</textarea>';
        res+='</div>';  
        $('.append_here').html(res);  
       }           
     }
   });
  }
}); 
// $(document).on('change','.total_tax',function(){
//     var type=$('.common_discount_type').val();

//     var discount=$(this).val();
//     var subtotal=$('.subtotal').val(); 
//     if(type=="discount_percent"){
//         var disamount=parseFloat(subtotal)*parseFloat(discount)/100;
//     }else{
//         var disamount=discount;
//     }
//     var grandtotal=parseFloat(subtotal)-parseFloat(disamount); 
//     $('.grandtotal').val(grandtotal);
// });