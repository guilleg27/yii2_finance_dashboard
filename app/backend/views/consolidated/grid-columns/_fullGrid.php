<?php 
  return [
      [
          'attribute'=>'businessModelName',
          'value'=>'businessModelName',
          'pageSummary'=>'Totals: ',
          'vAlign'=>'middle',
          'width'=>'250px',
      ],
      [
          'attribute'=>'period',
          'vAlign'=>'middle',
          'width'=>'250px',
          'format'=>['date', 'php:M Y']
      ],
      [
          'attribute'=>'revenue_server', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'revenue_transaction', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'agency_commission', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'revenue_to_validate', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'revenue_validated', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'revenue_invoiced', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      // [
      //     'attribute'=>'revenue_manual', 
      //     'vAlign'=>'middle',
      //     'hAlign'=>'right', 
      //     'width'=>'7%',
      //     'format'=>['decimal', 2],
      //     'pageSummary'=>true
      // ],
      [
          'attribute'=>'objective_revenue', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'spend_server', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      // [
      //     'attribute'=>'spend_off', 
      //     'vAlign'=>'middle',
      //     'hAlign'=>'right', 
      //     'width'=>'7%',
      //     'format'=>['decimal', 2],
      //     'pageSummary'=>true
      // ],
      [
          'attribute'=>'spend_transaction', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],  
      [
          'attribute'=>'spend_to_validate', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'spend_validated', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      [
          'attribute'=>'spend_invoiced', 
          'vAlign'=>'middle',
          'hAlign'=>'right', 
          'width'=>'7%',
          'format'=>['decimal', 2],
          'pageSummary'=>true
      ],
      // [
      //     'attribute'=>'spend_manual', 
      //     'vAlign'=>'middle',
      //     'hAlign'=>'right', 
      //     'width'=>'7%',
      //     'format'=>['decimal', 2],
      //     'pageSummary'=>true
      // ],    
      // [
      //     'attribute'=>'profit_manual', 
      //     'vAlign'=>'middle',
      //     'hAlign'=>'right', 
      //     'width'=>'7%',
      //     'format'=>['decimal', 2],
      //     'pageSummary'=>true
      // ],
      // [
      //     'attribute'=>'objective_profit', 
      //     'vAlign'=>'middle',
      //     'hAlign'=>'right', 
      //     'width'=>'7%',
      //     'format'=>['decimal', 2],
      //     'pageSummary'=>true
      // ],     
      [
          'attribute'=>'fixedCost',
          'value'=>'fixedCost',
          'vAlign'=>'middle',
          'width'=>'250px',
          'format'=>['decimal', 2],
          'pageSummary'=>true,
      ],
  ];