<?php
/**
 * @var $this LanguageController
 * @var $model OmmuLanguages
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array();
	//$this->widget('AdminDashboardStatistic');
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/custom/custom_wall.js', CClientScript::POS_END);
?>

<div class="table">
	<div class="wall">
		1
	</div>
	<div class="recent">
		2
	</div>
</div>