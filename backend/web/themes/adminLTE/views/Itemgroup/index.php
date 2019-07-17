<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemgroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Itemgroups';
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
            <p>
                <?= Html::a('Create ', ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
            </p>
        	<div class="container" style="margin-top:30px;">
                <div class="row">
                    <div class="col-md-12">        
                        <?php Yii::$app->common->buildTree($itemgroup, 0, 1);?>
                    </div>
            	</div>
            </div>
        </div>
        </div>
        </div>
        </div>
          <!-- /.box -->
    </section>


<script>
$.fn.extend({
    treed: function (o) {console.log("df")
      
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

 </script>
</div>