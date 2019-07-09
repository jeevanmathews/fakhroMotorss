$(document).ready(function() {


  
  $('body').on('click','.btn_add_new',function(e){
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
$('body').on('click','.remove_row',function(e){
 e.preventDefault();
 $(this).closest('tr').remove();
});
$('body').on('click','.btn_select_do',function(){
  var do_id=$("#salesinvoice-do_id").val();
  var url=$('.hiddenurl_create').val();
  if(do_id!='' && do_id!='undefined'){
    window.location.href=url+do_id;
  }
});


$('body').on('change','.select_item_td',function(){
  var item_id=$(this).val();
  var thisrow=$(this).closest('tr');
  var data={'item_id':item_id}
  var url=hiddenurl_itemprice;//$('.hiddenurl_itemprice').val();
  if(item_id!='' && item_id!='undefined'){
    $.ajax({
      'type':'post',
            'url':url,//"<?php echo Yii::$app->getUrlManager()->createUrl(['items/itemprice']);?>",
            'data':data,
            success:function(s){
              //console.log(s);
              var response = JSON.parse(s);
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
                if($(thisrow).find('.qty').val()!='' && $(thisrow).find('.qty').val()!='undefined'){
                  qty=$(thisrow).find('.qty').val();
                }
                if($(thisrow).find('.price').val()!='' && $(thisrow).find('.price').val()!='undefined'){
                  price=$(thisrow).find('.price').val();
                }
                
                total_price=(parseFloat(qty)*parseFloat(price)).toFixed(decimalPlaces);
                $(thisrow).find('.total_price').val(total_price);

    // total=net_amount;

    var type=$('.discount_type:checked').val();
    discount_percentage=$(thisrow).find('.discount_percentage').val();
    if(discount_percentage!='' &&  discount_percentage!='undefined' && typeof discount_percentage!=='undefined' && $.isNumeric(discount_percentage)){
     
     if(type=="percentage"){
       dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
     }else{
      dis=discount_percentage; 
    }
    
  }


    // if($(thisrow).find('.discount_percentage').val()!='' && $(thisrow).find('.discount_percentage').val()!='undefined' && typeof $(thisrow).find('.discount_percentage').val()!=='undefined'){
      
    //     if($(thisrow).find('.discount_percentage').val()=='discount_percent'){
    //     // discount_amount
    //      dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
    //     }else{
    //          dis=discount_percentage; 
    //     }
    
    
    // }
    net_amount=(parseFloat(total_price)-parseFloat(dis)).toFixed(decimalPlaces);

    if($(thisrow).find('.vatrate').val()!='' &&  $(thisrow).find('.vatrate').val()!='undefined' && typeof $(thisrow).find('.vatrate').val()!=='undefined'){
     
      vatrate=$(thisrow).find('.vatrate').val();
      
    }
    vat=(parseFloat(net_amount))*parseFloat(vatrate)/100;
    total=((parseFloat(net_amount))+ parseFloat(vat)).toFixed(decimalPlaces);
    
    $(thisrow).find('.discount_amount').val(dis);
    $(thisrow).find('.tax').val(vat);
    $(thisrow).find('.net_amount').val(net_amount);
    $(thisrow).find('.total').val(total);
    $('.total').trigger('change');
                // $(thisrow).find('#salesinvoiceitems-unit_id').val(response.unit_id);
                
              }
            });
}
}); 
// change the total with quantity and price 
$('body').on('change','.qty,.price,.vatrate,.discount_percentage',function(){
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
  if($(thisrow).find('.qty').val()!='' && $(thisrow).find('.qty').val()!='undefined'){
    qty=$(thisrow).find('.qty').val();
     // console.log(parseFloat($(thisrow).find('.remaining_qty').val()) ,parseFloat($(thisrow).find('.qty').val()));
    if(parseFloat($(thisrow).find('.remaining_qty').val()) < parseFloat($(thisrow).find('.qty').val()) ){
       
        $(thisrow).find('.qty').parent().parent().append('<span class="error">Cannot exceed the ordered quantity</span>').css('color','red');
        $(thisrow).find('.qty').val($(thisrow).find('.remaining_qty').val());
        qty=$(thisrow).find('.remaining_qty').val();
        //$('.qty').prop('disabled',true);
      }else{
        $(thisrow).find('.qty').parent().parent().find('.error').html('');
      }
  }
  if($(thisrow).find('.price').val()!='' && $(thisrow).find('.price').val()!='undefined'){
    price=$(thisrow).find('.price').val();
  }
  
  total_price=(parseFloat(qty)*parseFloat(price)).toFixed(decimalPlaces);
  $(thisrow).find('.total_price').val(total_price);

    // total=net_amount;

    var type=$('.discount_type:checked').val();
    discount_percentage=$(thisrow).find('.discount_percentage').val();
    if(discount_percentage!='' &&  discount_percentage!='undefined' && typeof discount_percentage!=='undefined' && $.isNumeric(discount_percentage)){
     
     if(type=="percentage"){
       dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
     }else{
      dis=discount_percentage; 
    }
    
  }


    // if($(thisrow).find('.discount_percentage').val()!='' && $(thisrow).find('.discount_percentage').val()!='undefined' && typeof $(thisrow).find('.discount_percentage').val()!=='undefined'){
      
    //     if($(thisrow).find('.discount_percentage').val()=='discount_percent'){
    //     // discount_amount
    //      dis=(parseFloat(total_price))*parseFloat(discount_percentage)/100;
    //     }else{
    //          dis=discount_percentage; 
    //     }
    
    
    // }
    net_amount=(parseFloat(total_price)-parseFloat(dis)).toFixed(decimalPlaces);

    if($(thisrow).find('.vatrate').val()!='' &&  $(thisrow).find('.vatrate').val()!='undefined' && typeof $(thisrow).find('.vatrate').val()!=='undefined'){
     
      vatrate=$(thisrow).find('.vatrate').val();
      
    }
    vat=(parseFloat(net_amount))*parseFloat(vatrate)/100;
    total=((parseFloat(net_amount))+ parseFloat(vat)).toFixed(decimalPlaces);
    
    $(thisrow).find('.discount_amount').val(dis);
    $(thisrow).find('.tax').val(vat);
    $(thisrow).find('.net_amount').val(net_amount);
    $(thisrow).find('.total').val(total);
    $('.total').trigger('change');
  });
// sum up totals to get subtotal
$('body').on('change','.total',function(){
  var subtotal=0;
  $('.total').each(function () {
    if($.isNumeric($(this).val())){
      subtotal=(parseFloat(subtotal) + parseFloat($(this).val())).toFixed(decimalPlaces);;
    }
  });
  $('.subtotal').val(subtotal);
  $('.subtotal').trigger('change');
});
$('body').on('change','.subtotal,.discount',function(){
  var gtotal=0;
  var taxtotal=0;
  var subtotal= $('.subtotal').val();
  var discount= $('.discount').val();
  var type=$('.common_discount_type:checked').val();
  console.log(type,subtotal);
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
 $('.net').val(gtotal);
if($('.vatper').val()!='' &&  $('.vatper').val()!='undefined' && typeof $('.vatper').val()!=='undefined'){
  var vat_rate=$('.vatper').val();
  taxtotal=((parseFloat(gtotal)*parseFloat(vat_rate))/100).toFixed(decimalPlaces);
  gtotal=(parseFloat(gtotal)+(parseFloat(gtotal)*parseFloat(vat_rate)/100)).toFixed(decimalPlaces);
}
   // if($.isNumeric(discount)){
   //      gtotal= parseFloat(subtotal)-parseFloat(discount); 
   // }else{
   //      gtotal=subtotal;
   // }
   $('.grandtotal').val(gtotal);
   $('.total_tax').val(taxtotal);
 });
// reduce discount from total

$('body').on('click','.common_discount_type',function(){
  var type=$(this).val();
  var grandtotal=0;
  var taxtotal=0;
  var disamount=0;
  var discount=$('.discount').val();
  var subtotal=$('.subtotal').val(); 
    // console.log(type,discount,subtotal);
    if(discount!=""){
      if(type=="percentage"){
        disamount=parseFloat(subtotal)*parseFloat(discount)/100;
      }else{
        disamount=discount;
      }
    }
  grandtotal=(parseFloat(subtotal)-parseFloat(disamount)).toFixed(decimalPlaces);;
  $('.net').val(grandtotal);
  if($('.vatper').val()!='' &&  $('.vatper').val()!='undefined' && typeof $('.vatper').val()!=='undefined'){
    var vat_rate=$('.vatper').val();
    taxtotal=((parseFloat(grandtotal)*parseFloat(vat_rate))/100).toFixed(decimalPlaces);
    grandtotal=(parseFloat(grandtotal)+(parseFloat(grandtotal)*parseFloat(vat_rate)/100)).toFixed(decimalPlaces);
    
  }
  // console.log(taxtotal,grandtotal,vat_rate);
  $('.total_tax').val(taxtotal);
  $('.grandtotal').val(grandtotal);
});

// $('body').on('change','.discount',function(){
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
// $('body').on('change','.total_tax',function(){
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