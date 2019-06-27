    <?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\ActiveForm;
    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Set Permission';
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


<div class="content-main-wrapper itemgroup-index main-body">

    <section class="content-header">
      <h1><?= Html::encode($this->title) ?></h1>
    </section>

    <section class="content">
    <!-- SELECT2 EXAMPLE -->
        <div class="box box-default"> 
        <div class="box-body">
        <div class="row">
        <div class="col-md-12">            
            <div class="container" style="margin-top:30px;">
                <div class="row">
                    <div class="col-md-12">        
                        <ul id="tree2">
                            <li><?php echo Html::checkbox('permission_id[]');?><a href="#">Full Privilege</a>
                                <ul> 
                                    <?php foreach ($site_modules as $module => $actions) {
                                        if(!in_array(($module."Controller"), $skip_modules)){
                                        echo "<li>".Html::checkbox('permission_id[]')."<a href='#'> ". str_replace("Controller", "", $module) ."</a><ul>";
                                        foreach($actions as $action) {
                                             $action_details = explode("-", $action);
                                             $action_name = $action_details[0];
                                             if(!in_array($action_name, $skip_actions)){
                                                $action_name = isset($replace_display_texts[$action_name])?$replace_display_texts[$action_name]:$action_name;
                                                $permission_id = $action_details[1];
                                                echo "<li>".Html::checkbox('permission_id[]', false, ['value' => $permission_id]). $action_name."</li>";
                                            }
                                        }
                                        echo "</ul></li>";
                                    } } ?>                                       
                                </ul>
                            </li>                                
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>
</div>

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

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

     

</script>

    


    <div class="col-md-8">

        <?php $form = ActiveForm::begin(['action' => ['rolepermission/create'],'options' => ['method' => 'post']]); ?>
       <section class="content-header">
          <h1>
            Set Permission        
          </h1>
        </section>
        <!-- <h3>Set Permission</h3> -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],                
            'module',
            'action',
                // ['class' => 'yii\grid\ActionColumn'],

            [
            'class' => 'yii\grid\CheckboxColumn',
                    // 'checkboxOptions' => function ($model) use ($permitted) {
                        // var_dump($permitted);
                        // return in_array($model->id,$permitted)?['checked' => true] : [];//$model->id > 0 ? ['checked' => true] : [];
                    // },
            'name'  =>'permission_id',
            'header' => Html::hiddeninput('selection_all', false, [
                'class' => 'select-on-check-all',
                'label' => 'Check All',
                ]),
            
            ],

            ],
            'tableOptions' => [
        'id' => 'theDatatable',
        'class'=>'table table-striped table-bordered table-hover'
        ],
            ]); ?>
            <?= Html::hiddenInput('role_id', $role_id)?>
            <div class="form-group">
                <?= Html::submitButton('Set Permission', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="permission-master-index col-md-4">
            <section class="content-header">
          <h1>
           Permitted Actions      
          </h1>
        </section>
            <!-- <h3>Permitted Actions</h3> -->
            <?= GridView::widget([
                'dataProvider' => $permitted,
                'columns' => [
                ['class' => 'yii\grid\SerialColumn'],                
                'module',
                'action',
                // ['class' => 'yii\grid\ActionColumn'],

                // [
                //     'class' => 'yii\grid\CheckboxColumn',
                //     'checkboxOptions' => function ($model) use ($permitted) {
                //         // var_dump($permitted);
                //         // return in_array($model->id,$permitted)?['checked' => true] : [];//$model->id > 0 ? ['checked' => true] : [];
                //     },
                //     'name'  =>'permission_id',
                //     'header' => Html::checkBox('selection_all', false, [
                //         'class' => 'select-on-check-all',
                //         'label' => 'Check All',
                //     ]),
                
                // ],

                ],
'tableOptions' => [
        'id' => 'theDatatable',
        'class'=>'table table-striped table-bordered table-hover'
        ],
                ]); ?>

            </div>