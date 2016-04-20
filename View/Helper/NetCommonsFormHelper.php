<?php
/**
 * NetCommonsFormHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * NetCommonsFormHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NetCommonsFormHelper extends AppHelper {

/**
 * 使用するFormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'Files.FilesForm',
		'NetCommons.Button',
		'NetCommons.FormInput',
		'NetCommons.NetCommonsHtml',
		'NetCommons.NetCommonsTime',
		'NetCommons.DatetimePicker',
	);

/**
 * 各プラグインFormHelperラップ用マジックメソッド
 *
 * ### NetCommonsForm->uploadFile()
 * Files.FilesFormHelper->uploadFile()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->checkbox() の場合
 * NetCommons.FormInputHelper->checkbox()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->radio() の場合
 * NetCommons.FormInputHelper->radio()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->wysiwyg() の場合
 * Wysiwyg.WysiwygHelper->wysiwyg()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->inlineCheckbox() の場合
 * $paramsに以下を追加して、$this->input()を実行する。ただし、すでに$paramsにあれば、無視する。
 * ```
 *	$params[1] = array(
 *		'type' => 'checkbox',
 *		'class' => false,
 *		'childDiv' => array('class' => 'form-inline')
 *	)
 * ```
 *
 * ### NetCommonsForm->inputWithTitleIcon()
 * NetCommons.TitleIconHelper->inputWithTitleIcon()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->titleIconPicker()
 * NetCommons.TitleIconHelper->titleIconPicker()を実行する。
 * あとでseeを付ける
 *
 * ### NetCommonsForm->ngTitleIconPicker()
 * NetCommons.TitleIconHelper->ngTitleIconPicker()を実行する。
 * あとでseeを付ける
 *
 * ### それ以外
 * FormHelperの各メソッドを実行する
 * あとでseeを付ける
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if ($method === 'uploadFile') {
			//アップロード
			$helper = $this->FilesForm;

		} elseif (in_array($method, ['hidden', 'checkbox', 'radio', 'select'], true)) {
			$helper = $this->FormInput;

		} elseif ($method === 'wysiwyg') {
			//WYSIWYG
			$this->Wysiwyg = $this->_View->loadHelper('Wysiwyg.Wysiwyg');
			$helper = $this->Wysiwyg;

		} elseif ($method === 'inlineCheckbox') {
			//checkbox、radioのインライン
			$helper = $this;
			$type = 'checkbox';
			$method = 'input';

			$params = Hash::insert($params, '1.type', $type);
			$params = Hash::insert($params, '1.class', false);
			$params = Hash::insert($params, '1.childDiv', array('class' => 'form-inline'));

		} elseif (in_array($method,
						['inputWithTitleIcon', 'titleIconPicker', 'ngTitleIconPicker'], true)) {
			//タイトルアイコン
			$this->TitleIcon = $this->_View->loadHelper('NetCommons.TitleIcon');
			$helper = $this->TitleIcon;

		} else {
			//それ以外
			$helper = $this->Form;
		}
		return call_user_func_array(array($helper, $method), $params);
	}

/**
 * 共通のオプションをセットして、FormHelper->create()の結果を出力する
 *
 * * 二重submit防止のため、ng-submit=submit($event)をセットする
 * * エラー出力をNetCommons用の表示をするため、novalidateをOffにする
 *
 * ### 出力結果サンプル
 * ```
 * <form method="post" novalidate="novalidate" ng-submit="submit($event)" action="/auth_general/auth_general/login">
 * ```
 *
 * @param mixed $model モデル名
 * @param array $options オプション
 * @return string HTMLタグ
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::create FormHelper::create()
 */
	public function create($model = null, $options = array()) {
		$options['ng-submit'] = Hash::get($options, 'ng-submit', 'submit($event)');
		$options['novalidate'] = Hash::get($options, 'novalidate', true);

		$output = $this->Form->create($model, $options);

		if (Hash::get($options, 'type') === 'file') {
			$output .= $this->FilesForm->setupFileUploadForm();
		}
		return $output;
	}

/**
 * NetCommons用Htmlを付加して、FormHelper::input()の結果を出力する<br>
 * ※Overwrite FormHelper::input()
 *
 * ### FormHelper->input()の$optionsに対する初期値
 * #### 共通
 * ```
 *	array(
 *		'error' => false,
 *		'required' => null,
 *		'label' => null,
 *	);
 * ```
 * #### type=number の場合
 * ```
 *	array(
 *		'error' => false,
 *		'required' => null,
 *		'label' => null,
 *		'min' => 0,
 *		'div' => array('class' => 'form-group')
 *	);
 * ```
 *
 * ### エラー発生時、入力ボックスの色を変えるためのdivを付与
 * ```
 *	<div class="has-error">
 *	</div>
 * ```
 *
 * ### help=メッセージ（NCオリジナル）
 * ヘルプブロックを付与する
 *
 * #### サンプル
 * ```
 * ```
 * #### 結果サンプル
 * ```
 * ```
 *
 * ### type=text の出力(デフォルト)
 * #### サンプル
 * ```
 *	echo $this->NetCommonsForm->input('Bbs.name',
 *		array(
 *			'type' => 'text',
 *			'label' => __d('bbses', 'Bbs name'),
 *			'required' => true,
 *		)
 *	);
 * ```
 * #### 結果サンプル
 * ```
 *	<div class="form-group">
 *		<label for="BbsName" class="control-label">
 *			掲示板名
 *			<strong class="text-danger h4">*</strong>
 *		</label>
 *		<input name="data[Bbs][name]" class="form-control" maxlength="255" type="text" value="サンプル" id="BbsName"/>
 *		<div class="has-error"></div>
 *	</div>
 * ```
 *
 * ### type=textarea の出力
 * #### サンプル
 * ```
 * ```
 * #### 結果サンプル
 * ```
 * ```
 *
 * ### type=radio の出力
 * #### サンプル
 * ```
 * ```
 * #### 結果サンプル
 * ```
 * ```
 *
 * ### type=select, multiple=checkbox の出力
 * #### サンプル
 * ```
 * ```
 * #### 結果サンプル
 * ```
 * ```
 *
 * ### type=select の出力
 * #### サンプル
 * ```
 * ```
 * #### 結果サンプル
 * ```
 * ```
 *
 * ### type=hidden の出力
 * NetCommons.FormInput->hidden()を実行し、出力する
 * あとでseeを付ける
 *
 * #### サンプル
 * ```
 * echo $this->NetCommonsForm->hidden('Frame.id');
 * ```
 * #### 結果サンプル
 * ```
 * <input type="hidden" name="data[Frame][id]" value="7" id="FrameId"/>
 * ```
 *
 * ### type=datetime の出力
 * datetimepickerのHTMLを出力する
 * あとでseeを付ける
 *
 * #### サンプル
 * ```
 *	echo $this->NetCommonsForm->input('publish_start',
 *		array(
 *			'type' => 'datetime',
 *			'required' => 'required',
 *			'label' => __d('blogs', 'Published datetime')
 *		)
 *	);
 * ```
 * #### 結果サンプル
 * ```
 *	<div class="form-group">
 *		<label for="BlogEntryPublishStart" class="control-label">公開日時
 *			<strong class="text-danger h4">*</strong>
 *		</label>
 *		<input name="data[BlogEntry][publish_start]"
 *			class="form-control"
 *			datetimepicker="1"
 *			convert_timezone="1"
 *			ng-model="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start"
 *			value="2016-04-20 09:00:24"
 *			ng-value="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start"
 *			ng-init="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start=&#039;2016-04-20 09:00:24&#039;"
 *			type="text" id="BlogEntryPublishStart"/>
 *		<div class="has-error"></div>
 *	</div>
 * ```
 *
 * ### TimeZone関係のHTMLを出力する
 * ```
 *	<input type="hidden"
 *		name="data[_NetCommonsTime][user_timezone]"
 *		value="Asia/Tokyo" id="_NetCommonsTimeUserTimezone"/>
 *	<input type="hidden"
 *		name="data[_NetCommonsTime][convert_fields]"
 *		value="BlogEntry.publish_start"
 *		id="_NetCommonsTimeConvertFields"/>
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options オプション配列
 * @return string HTML
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#creating-form-elements
 */
	public function input($fieldName, $options = array()) {
		if (Hash::get($options, 'type') === 'hidden') {
			return $this->FormInput->hidden($fieldName, $options);
		}

		//DatetimePicker用処理
		$options = $this->DatetimePicker->beforeFormInput($fieldName, $options);

		//TimeZoneのコンバートするinputのセットアップ
		$this->NetCommonsTime->beforeFormInput($fieldName, $options);

		$options = Hash::merge(array(
			'error' => array(),
		), $options);

		$defaultOptions = array(
			'error' => false,
			//'class' => 'form-control',
			'required' => null,
			'label' => null,
		);
		if (Hash::get($options, 'type') === 'number') {
			$defaultOptions['min'] = 0;
		}

		$inputOptions = Hash::merge($defaultOptions, $options);
		$inputOptions['error'] = false;

		//Form->inputには含めないため、divの設定を取得しておく
		$type = Hash::get($inputOptions, 'type', 'text');
		$divOption = $this->FormInput->getDivOption(
			$type, $inputOptions, 'div', array('class' => 'form-group')
		);
		$inputOptions = Hash::remove($inputOptions, 'div');
		$inputOptions = Hash::insert(
			$inputOptions, 'div', $this->FormInput->getDivOption($type, $inputOptions, 'childDiv', false)
		);
		$inputOptions = Hash::remove($inputOptions, 'childDiv');

		//errorの有無
		$error = (bool)$this->Form->error($fieldName);
		if (! $error && Hash::get($options, 'type') === 'password') {
			$error = (bool)$this->Form->error($fieldName . '_again');
		}

		//Form->input
		$input = '';
		if ($error) {
			$input .= '<div class="has-error">';
			$input .= $this->_input($fieldName, $inputOptions);
			$input .= '</div>';
		} else {
			$input .= $this->_input($fieldName, $inputOptions);
		}

		if (Hash::get($inputOptions, 'help')) {
			$input .= $this->help(Hash::get($inputOptions, 'help'));
		}

		//error出力
		if (is_array($options['error'])) {
			$input .= $this->error($fieldName, null, $options['error']);
			if (Hash::get($options, 'type') === 'password') {
				$input .= $this->error($fieldName . '_again', null, $options['error']);
			}
		}

		if ($divOption) {
			return $this->NetCommonsHtml->div(null, $input, $divOption);
		} else {
			return $input;
		}
	}

/**
 * <input>の出力
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options inputのオプション配列
 * @return string HTML
 */
	protected function _input($fieldName, $options = array()) {
		$output = '';

		//ラベルの表示
		if (Hash::get($options, 'label')) {
			$label = $this->label($fieldName, $options['label'], ['required' => $options['required']]);
			$options = Hash::remove($options, 'required');
			$options = Hash::insert($options, 'label', false);
			$output .= $label;

			if (in_array(Hash::get($options, 'type'), ['radio'], true) ||
					Hash::get($options, 'multiple') === 'checkbox') {
				$options['outer'] = true;
			}
		}

		$type = Hash::get($options, 'type');
		if (Hash::get($options, 'multiple') === 'checkbox') {
			$type = 'multiple';
		}

		if ($type === 'radio') {
			//ラジオボタン
			$attributes = Hash::remove($options, 'options');
			$output .= $this->FormInput->radio(
				$fieldName, Hash::get($options, 'options', array()), $attributes
			);

		} elseif ($type === 'multiple') {
			//複数チェックボックス
			$output .= $this->FormInput->multipleCheckbox($fieldName, $options);

		} elseif (in_array($type, ['checkbox', 'password'])) {
			//チェックボックス
			$output .= $this->FormInput->$type($fieldName, $options);

		} else {
			if ($type !== 'file' && ! Hash::get($options, 'class')) {
				$options = Hash::insert($options, 'class', 'form-control');
			}
			$output .= $this->Form->input($fieldName, $options);
		}

		return $output;
	}

/**
 * Timezone変換の準備を組み込んだForm::end
 *
 * @param null|array $options オプション
 * @param array $secureAttributes secureAttributes
 * @return string
 */
	public function end($options = null, $secureAttributes = array()) {
		$out = '';

		$this->DatetimePicker->beforeFormEnd();

		$out .= $this->NetCommonsTime->beforeFormEnd();

		$out .= $this->Form->end($options, $secureAttributes);
		return $out;
	}

/**
 * Overwrite FormHelper::error()
 *
 * @param string $fieldName A field name, like "Modelname.fieldname"
 * @param string|array $text Error message as string or array of messages.
 *   If array contains `attributes` key it will be used as options for error container
 * @param array $options Rendering options for <div /> wrapper tag
 * @return string error html
 */
	public function error($fieldName, $text = null, $options = array()) {
		$output = '';

		$output .= '<div class="has-error">';
		$output .= $this->Form->error(
			$fieldName, $text, Hash::merge(['class' => 'help-block'], $options)
		);
		$output .= '</div>';

		return $output;
	}

/**
 * ヘルプブロックの表示
 *
 * @param string $helpText ヘルプテキスト
 * @return string HTML
 */
	public function help($helpText) {
		$output = '';

		if ($helpText) {
			$output .= '<div class="help-block">';
			$output .= $helpText;
			$output .= '</div>';
		}

		return $output;
	}

/**
 * <label>タグの表示
 *
 * @param string $fieldName フィールド名 "Modelname.fieldname"
 * @param string $labelText ラベルテキスト
 * @param array $options オプション
 * @param bool $returnHtml 戻り値をHTMLにするか配列にするか
 * @return string|array HTMLもしくはoption配列
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function label($fieldName = null, $labelText = null, $options = [], $returnHtml = true) {
		if (! $labelText) {
			return $this->Form->label($fieldName, $labelText, $options);
		}

		if (Hash::get($options, 'required', false)) {
			$labelText .= $this->_View->element('NetCommons.required');
		}
		$options = Hash::remove($options, 'required');
		$options = Hash::merge(array('class' => 'control-label'), $options);

		if ($returnHtml) {
			return $this->Form->label($fieldName, $labelText, $options);
		} else {
			$options['text'] = $labelText;
			return $options;
		}
	}

}

