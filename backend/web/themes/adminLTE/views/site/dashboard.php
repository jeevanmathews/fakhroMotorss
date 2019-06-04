<?php
use yii\helpers\Html;
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>
<div id="site_dashboard" class="main-body">
    <h4><?= Html::encode($this->title) ?></h4>

    <section class="dashboard">
      <div class="">
        <div class="dashboard-inner">
          <div class="row table-row">
            <div class="col-sm-3">
              <div class="dashboard-left-menu">
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Most Viewed </h4>
                  <a href="#" class="btn-block">New Ledger</a>
                  <a href="#" class="btn-block">Retail: Bill</a>
                  <a href="#" class="btn-block">Change Company</a>
                  <a href="#" class="btn-block">Current Stock</a>
                  <a href="#" class="btn-block">GST Register & Returns</a>
                </div>
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Recently Viewed</h4>
                  <a href="#" class="btn-block">Search</a>
                  <a href="#" class="btn-block">Change Company</a>
                  <a href="#" class="btn-block">New Company</a>
                  <a href="#" class="btn-block">Current Stock</a>
                  <a href="#" class="btn-block">GST Register & Returns</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
              <div class="dashboard-right-menu">
                <h4 class="">Shortcuts</h4>
                <a href="#" class="btn btn-block">Bill-Wholesale</a>
                <a href="#" class="btn btn-block">Bill-Retail</a>
                <a href="#" class="btn btn-block">S/R Expiry</a>
                <a href="#" class="btn btn-block">P/R Expiry</a>
                <a href="#" class="btn btn-block">Receipt</a>
                <a href="#" class="btn btn-block">Voucher</a>
                <a href="#" class="btn btn-block">Receipt Note</a>
                 <a href="#" class="pull-right">Manage / Edit Shortcuts</a>
              </div>
            </div>
          </div>
          <div class="row table-row">
            <div class="col-sm-12">
              <div class="dashboard-bottom-area">
                <div class="row">
                  <div class="col-sm-3">
                    <h4> <?= $model['name']?></h4>
                    <h5><?= $model['address']?></h5>
                    <h6>Financial Period: <?=Yii::$app->common->displayDate($model->settings->financial_year)?> - <?=Yii::$app->common->displayEndDate($model->settings->financial_year)?></h6>
                  </div>
                  <div class="col-sm-6"></div>
                  <div class="col-sm-3">
                    <h4><span>Date</span>: <?= date('d M , Y')?></h4>
                    <h4><span>Day</span>: <?= date('l')?></h4>
                    <h4 id="clock"><span>Time</span>: <?= date('h:i:s a')?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <script>
var d = new Date(<?php echo time() * 1000 ?>);

function updateClock() {
  // Increment the date
  d.setTime(d.getTime() + 1000);

  // Translate time to pieces
  var currentHours = d.getHours();
  var currentMinutes = d.getMinutes();
  var currentSeconds = d.getSeconds();

  // Add the beginning zero to minutes and seconds if needed
  currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
  currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

  // Determine the meridian
  var meridian = (currentHours < 12) ? "am" : "pm";

  // Convert the hours out of 24-hour time
  currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
  currentHours = (currentHours == 0) ? 12 : currentHours;

  // Generate the display string
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + meridian;
// console.log(currentTimeString);
  // Update the time
  document.getElementById("clock").innerHTML ='<span>Time</span>: '+currentTimeString;//.firstChild.nodeValue = currentTimeString;
}

window.onload = function() {
  updateClock();
  setInterval('updateClock()', 1000);
}
</script>

<script type="text/javascript">
  $('.btn-block').on('click', function ( e ) {
    e.preventDefault();

    $.toast({
      heading: 'Information',
      text: 'Loaders are enabled by default. Use `loader`, `loaderBg` to change the default behavior',
      icon: 'warning',
      loader: true,        // Change it to false to disable loader
      position: 'top-right',
      loaderBg: '#9EC600'  // To change the background
  })

  });
</script>

</div>