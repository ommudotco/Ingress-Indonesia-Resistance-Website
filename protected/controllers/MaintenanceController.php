<?php
/**
 * MaintenanceController
 * Handle MaintenanceController
 * Copyright (c) 2015, Ommu Platform (ommu.co). All rights reserved.
 * version: 2.0.0
 * Reference start
 *
 * TOC :
 *	Index
 *	Feedback
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class MaintenanceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize public template
	 */
	public function init() 
	{
		$setting = OmmuSettings::model()->findByPk(1,array(
			'select' => 'online, construction_date',
		));

		if($setting->online == 0 && date('Y-m-d', strtotime($setting->construction_date)) > date('Y-m-d')) {
			$arrThemes = Utility::getCurrentTemplate('underconstruction');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];

		} else {
			$this->redirect(Yii::app()->createUrl('site/index'));
		}
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->pageTitle = '';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_index');
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionFeedback()
	{
		$model=new SupportMails;
		if(!Yii::app()->user->isGuest) {
			$user = Users::model()->findByPk(Yii::app()->user->id, array(
				'select' => 'user_id, email, displayname, photo_id',
			));
		}

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['SupportMails'])) {
			$model->attributes=$_POST['SupportMails'];
			$model->scenario = 'contactus';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
				
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						if($model->user_id != 0)
							$url = Yii::app()->controller->createUrl('feedback', array('email'=>$model->email, 'name'=>$model->displayname));
						else
							$url = Yii::app()->controller->createUrl('feedback', array('email'=>$model->email, 'name'=>$model->displayname));
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			
		} else {
		
			$this->pageTitle = isset($_GET['email']) ? Phrase::trans(23121,1) : Phrase::trans(23102,1);
			$this->pageDescription = isset($_GET['email']) ? (isset($_GET['name']) ? Phrase::trans(23123,1, array($_GET['name'], $_GET['email'])) : Phrase::trans(23122,1, array($_GET['email']))) : '';
			$this->pageMeta = '';
			$this->render('front_feedback',array(
				'model'=>$model,
				'user'=>$user,
			));
		}
	}

	
}