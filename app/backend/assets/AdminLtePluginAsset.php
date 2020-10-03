<?php
use yii\web\AssetBundle;
class AdminLtePluginAsset extend AssetBundle
{
	public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
	public $js = [
		'datatables/dataTables.boostrap.min.js',
		//more plugin Js here
	];
	public $css = [
		'datatables/dataTables.boostrap.css',
		//more plugin CSS here
	];
	public $depends = [
		'dmstr\web\AdminLteAsset',
	];
}