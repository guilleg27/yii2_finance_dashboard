<?php 

use kartik\grid\GridView;
use kartik\export\ExportMenu;

$gridColumns = require(__DIR__.'/grid-columns/_fullGrid.php');

// $fullExportMenu = ExportMenu::widget([
//     'dataProvider'    => $dataProvider,
//     'columns'         => $gridColumns,
//     'pjaxContainerId' => 'kv-grid',
//     'filename'        => 'grid-consolidated',
//     'target'          => ExportMenu::TARGET_BLANK,
//     'fontAwesome'     => true,
//     'clearBuffers'    => true,
//     'exportConfig' => [
//         ExportMenu::FORMAT_HTML => false,
//         ExportMenu::FORMAT_PDF  => false,
//         ExportMenu::FORMAT_TEXT => false,
//     ],
//     'dropdownOptions' => [
//         'label' => 'Full',
//         'class' => 'btn btn-default',
//         'itemsBefore' => [
//             '<li class="dropdown-header">Export All Data</li>',
//         ],
//     ],
// ]);

?>

  <div class="box collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Grid</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
      <?=
          GridView::widget([
              'dataProvider' => $dataProvider,
              'columns'      => $gridColumns,
              'showPageSummary'=>true,
              'pjax'=>true,
              'pjaxSettings' =>[
                  'neverTimeout'=>true,
                  'options'=>[
                          'id'=>'kv-grid',
                      ]
                  ], 
              'panel'=>[
                  'type'=>'info',
              ],
              'export' => [
                  'label' => 'Page',
                  'fontAwesome' => true,
              ],
              'exportConfig' => [
                  GridView::CSV => ['filename' => ('grid-consolidated'),],
                  GridView::EXCEL => ['filename' => ('grid-consolidated'),],
              ],
              // your toolbar can include the additional full export menu
              'toolbar' => [
                  '{export}',
                  // $fullExportMenu,
              ],
          ]); 
      ?>
      <!-- /.row -->
      </div>
      <!-- /.box-body -->
  </div>