<?php 
  return [
      [
          'attribute' =>'period',
          'vAlign'    =>'middle',
          'format'    =>['date', 'php:M Y']
      ],
      [
          'attribute'=>'business_model',
          'value'=>'businessModel.business_model',
      ],
      'name',
      [
          'attribute' =>'amount',
          'vAlign'    =>'middle',
          'format'    =>['decimal', 2],
      ],
  ];
