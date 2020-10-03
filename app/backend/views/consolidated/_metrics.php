<?php 

use yii\helpers\Html;

?>

  <div class="row">
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h4>USD <?= number_format($totalSum["revenue"]["invoiced"],2) ?> </h4>
          <p>Invoiced Revenue</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h4>USD  <?= number_format($totalSum["spend"]["final"],2) ?> </h4>
          <p>Invoiced Spend</p>
        </div>
          <a href="#" class="small-box-footer">
            <?=
                Html::tag('span', 'More info', [
                'title'=>'Media: $'.number_format($totalSum["spend"]["invoiced"],2).' | Fixed Cost: $'.number_format($totalSum["spend"]["fixed_cost"],2),
                'data-toggle'=>'tooltip',
                'style'=>'cursor:pointer;'
              ]);
            ?>
            <i class="fa fa-arrow-circle-right"></i>
          </a>
      </div>
    </div>
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h4>USD  <?= number_format($totalSum["revenue"]["invoiced"]-($totalSum["spend"]["fixed_cost"]+$totalSum["spend"]["paid"]),2) ?> </h4>
          <p>Profit</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h4>USD  <?= number_format($totalSum["objective"]["profit"],2) ?> </h4>
          <p>Profit Objective</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h4>USD  <?= number_format($totalSum["spend"]["paid"],2) ?> </h4>
          <p>Effective Cost</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-black">
        <div class="inner">
          <h4>USD  <?= number_format($totalSum["spend"]["fixed_cost"]+$totalSum["spend"]["paid"],2) ?> </h4>
          <p>Total Effective Cost</p>
        </div>
          <a href="#" class="small-box-footer">
            <?=
                Html::tag('span', 'More info', [
                'title'=>'Costos fijos + Monto pagado a proveedores',
                'data-toggle'=>'tooltip',
                'style'=>'cursor:pointer;'
              ]);
            ?>
            <i class="fa fa-arrow-circle-right"></i>
          </a>
      </div>
    </div>
  </div>
