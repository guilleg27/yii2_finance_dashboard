<?php 

  $this->title = 'Finance Dashboard ' . date("F Y",strtotime($startDate)) . ' to ' . date("F Y",strtotime($endDate));
  // $this->params['breadcrumbs'][] = $this->title;

?>

  <?= $this->render('_search', ['model'=>$searchModel, 'startDate'=>$startDate, 'endDate'=>$endDate, 'businessModelId'=>$businessModelId]) ?>
  
  <?= $this->render('_metrics', ['totalSum'=>$totalSum]) ?>
  
  <?= $this->render('_charts', ['dataGraphic'=>$dataGraphic, 'goalCompletionByModel'=>$goalCompletionByModel, 'businessModelId'=>$businessModelId]) ?>

  <?= $this->render('_revenueInfo', ['dataProvider'=>$dataProviderGridAverages,'dataProviderPendingInvoiceRevenue'=>$dataProviderPendingInvoiceRevenue, 'totalSum'=>$totalSum, 'avgRevenue'=>$avgRevenue]) ?>

   <?= $this->render('_spendInfo', ['dataProvider'=>$dataProviderGridAverages,'dataProviderPendingInvoiceSpend'=>$dataProviderPendingInvoiceSpend, 'totalSum'=>$totalSum, 'avgSpend'=>$avgSpend,'dataChartFixedCostsByCategory'=>$dataChartFixedCostsByCategory, 'dataChartFixedCostsByModel'=>$dataChartFixedCostsByModel, 'startDate'=>$startDate, 'endDate'=>$endDate, 'businessModelId'=>$businessModelId]) ?>

  <?= $this->render('_grid', ['dataProvider'=>$dataProviderGrid, 'searchModel'=>$searchModel]) ?>