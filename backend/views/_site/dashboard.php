<?php
use yii\helpers\Html;
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?><h1><?= Html::encode($this->title) ?></h1>
    <section class="dashboard">
      <div class="container-fluid">
        <div class="dashboard-inner">
          <div class="row table-row">
            <div class="col-sm-3">
              <div class="dashboard-left-menu">
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Most Viewed Reports</h4>
                  <a href="#" class="btn-block">New Ledger</a>
                  <a href="#" class="btn-block">Retail: Bill</a>
                  <a href="#" class="btn-block">Change Company</a>
                  <a href="#" class="btn-block">Current Stock</a>
                  <a href="#" class="btn-block">GST Register & Returns</a>
                </div>
                <div class="dashboard-left-menu-inner">
                  <h4 class="">Recently Viewed Reports</h4>
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
                <a href="#" class="btn btn-block">Bill-Wholesale</a>
                <a href="#" class="btn btn-block">Bill-Retail</a>
                <a href="#" class="btn btn-block">S/R Expiry</a>
                <a href="#" class="btn btn-block">P/R Expiry</a>
                <a href="#" class="btn btn-block">Receipt</a>
              </div>
            </div>
          </div>
          <div class="row table-row">
            <div class="col-sm-12">
              <div class="dashboard-bottom-area">
                <div class="row">
                  <div class="col-sm-3">
                    <h4>DEMO COMPANY-DECO</h4>
                    <h5>Ernakulam</h5>
                    <h6>Financial Period: Apr., 2018 - Mar., 2019</h6>
                  </div>
                  <div class="col-sm-6"></div>
                  <div class="col-sm-3">
                    <h4><span>Date</span>: 7 Mar., 2019</h4>
                    <h4><span>Day</span>: Thursday</h4>
                    <h4><span>Time</span>: 14:51:17</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  