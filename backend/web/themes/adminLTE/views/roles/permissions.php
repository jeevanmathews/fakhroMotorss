    <?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use common\components\AutoForm;
    use yii\widgets\Breadcrumbs;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = $role. ' : Set Permission';
    $this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['roles/index']];
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    
<style>
.tree, .tree ul {
    margin:0;
    padding:0;
    list-style:none
}
.tree ul {
    margin-left:1em;
    position:relative
}
.tree ul ul {
    margin-left:.5em
}
.tree ul:before {
    content:"";
    display:block;
    width:0;
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    border-left:1px solid
}
.tree li {
    margin:0;
    padding:0 1em;
    line-height:2em;
    color:#369;
    font-weight:700;
    position:relative
}
.tree ul li:before {
    content:"";
    display:block;
    width:10px;
    height:0;
    border-top:1px solid;
    margin-top:-1px;
    position:absolute;
    top:1em;
    left:0
}
.tree ul li:last-child:before {
    background:#fff;
    height:auto;
    top:1em;
    bottom:0
}
.indicator {
    margin-right:5px;
}
.tree li a {
    text-decoration: none;
    color:#369;
}
.tree li button, .tree li button:active, .tree li button:focus {
    text-decoration: none;
    color:#369;
    border:none;
    background:transparent;
    margin:0px 0px 0px 0px;
    padding:0px 0px 0px 0px;
    outline: 0;
}
</style>


<div class="content-main-wrapper rolepermission-index main-body">

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

    <section class="content-header">
      <h1><?= Html::encode($this->title) ?></h1>
    </section>

    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default"> 
        <div class="box-body">
        <div class="row">
        <div class="col-md-8"> 
        <?php $form = AutoForm::begin(["id" => "rolepermission-".time(), 'action' => ['rolepermission/create'],'options' => ['method' => 'post']]); ?>        
        <ul id="tree2<?php echo time();?>">
            <li class="first-node"><?php echo Html::checkbox('permission_id[]', false, ['value' => '', 'id' => 'full-prev'.time()]);?><a class="folder-tree" href="#">Full Privilege</a>
                <ul> 
                    <?php foreach ($site_modules as $module => $actions) {
                        $module_name = str_replace("Controller", "", $module);
                        if(!in_array($module_name, $skip_modules)){                            
                            echo "<li>".Html::checkbox('permission_id[]', false, ['value' => '', 'class' => 'module-prevlg'])."<a href='#' class='folder-tree'> ". $module_name ."</a><ul>";
                            foreach($actions as $action) {
                                
                                 $action_details = explode("-", $action);
                                 $action_name = $action_details[0];

                                 if(!in_array($action_name, $skip_actions)){
                                    $action_name = isset($replace_display_texts[$action_name])?$replace_display_texts[$action_name]:$action_name;
                                    $permission_id = $action_details[1];
                                    $argu_ary = in_array($permission_id, $activePermissions)?['checked' => 'checked', 'value' => $permission_id]:['value' => $permission_id];
                                    echo "<li>".Html::checkbox('permission_id[]', false, $argu_ary). $action_name."</li>";
                                }
                            }
                        echo "</ul></li>";
                    } } ?>                                       
                </ul>
            </li>                                
        </ul>
        <?= Html::hiddenInput('role_id', $role_id)?>
       
        <?= Html::submitButton('Set Permission', ['class' => 'btn btn-success pull-left']) ?>
       
        <?php AutoForm::end(); ?>
                   
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>


<script>
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$("[id*='tree1']:visible").treed();

$("[id*='tree2']:visible").treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$("[id*='tree3']:visible").treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

$("[id*='full-prev']:visible").click(function(){
    this.checked = (this.checked)?false:true;
    var chck = (this.checked)?false:true;     
    $(".tree:visible").find("[type=checkbox]").each(function() { 
        this.checked = chck;
    });
});  

$(".module-prevlg").click(function(){
    if(this.checked){
        $(this).closest("li").find("ul").find("[type=checkbox]").each(function() { 
            this.checked = true; 
        });
    }else{
        $(this).closest("li").find("ul").find("[type=checkbox]").each(function() { 
            this.checked = false; 
        });
    }
});
$(".first-node").trigger("click");

$(".module-prevlg").each(function(){ var module_flag = false; $(this).closest("li").find("ul>li").each(function(){ module_flag = $(this).find('input[type="checkbox"]').prop("checked");  }); 

    if(module_flag){
        $(this).attr("checked",true);
        return;
    }

});

if($(".module-prevlg:checked").length == $(".module-prevlg:visible").length){
    $("[id*='full-prev']:visible").attr("checked",true);
}
</script>


</div>
    
