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
 * 指定されたメソッドにより、各プラグインのFormHelperのメソッドを間接的に呼び出します。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 * ##### $method の内容による出力
 * - <a id="method__input_uploadFile" name="method__input_uploadFile" class="anchor"></a>
 * NetCommonsForm::uploadFile()<br>
 * [Files.FilesFormHelper::uploadFile()](../../Files/classes/FilesFormHelper.html#method_uploadFile)
 * の結果を出力する。
 *
 * - <a id="method__input_checkbox" name="method__input_checkbox" class="anchor"></a>
 * NetCommonsForm::checkbox()<br>
 * [NetCommons.FormInputHelper::checkbox()](./FormInputHelper.html#method_checkbox)
 * の結果を出力する。
 *
 * - <a id="method__input_radio" name="method__input_radio" class="anchor"></a>
 * NetCommonsForm::radio()<br>
 * [NetCommons.FormInputHelper::radio()](./FormInputHelper.html#method_radio)
 * の結果を出力する。
 *
 * - <a id="method__input_wysiwyg" name="method__input_wysiwyg" class="anchor"></a>
 * NetCommonsForm::wysiwyg()<br>
 * [Wysiwyg.WysiwygHelper::wysiwyg()](../../Wysiwyg/classes/WysiwygHelper.html#method_wysiwyg)
 * の結果を出力する。
 *
 * - <a id="method__input_inlineCheckbox" name="method__input_inlineCheckbox" class="anchor"></a>
 * NetCommonsForm::inlineCheckbox()<br>
 * $paramsに以下を追加して、
 * [NetCommons.FormInputHelper::checkbox()](./FormInputHelper.html#method_checkbox)
 * の結果を出力する。ただし、すでに$paramsにあれば、無視する。
 * ```
 * $params[1] = array(
 * 		'class' => false,
 * 		'div' => array('class' => 'form-group')
 * )
 * ```
 *
 * - <a id="method__input_inputWithTitleIcon" name="method__input_inputWithTitleIcon" class="anchor"></a>
 * NetCommonsForm::inputWithTitleIcon()<br>
 * [NetCommons.TitleIconHelper::inputWithTitleIcon()](./TitleIconHelper.html#method_inputWithTitleIcon)
 * の結果を出力する。
 *
 * - <a id="method__input_titleIconPicker" name="method__input_titleIconPicker" class="anchor"></a>
 * NetCommonsForm::titleIconPicker()<br>
 * [NetCommons.TitleIconHelper::titleIconPicker()](./TitleIconHelper.html#method_titleIconPicker)
 * の結果を出力する。
 *
 * - <a id="method__input_ngTitleIconPicker" name="method__input_ngTitleIconPicker" class="anchor"></a>
 * NetCommonsForm::ngTitleIconPicker()<br>
 * [NetCommons.TitleIconHelper::ngTitleIconPicker()](./TitleIconHelper.html#method_ngTitleIconPicker)
 * の結果を出力する。
 *
 * - <a id="method__input_others" name="method__input_others" class="anchor"></a>
 * それ以外<br>
 * [FormHelper](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#formhelper)
 * の各メソッドの結果を出力する。
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
			$helper = $this->FormInput;
			$method = 'checkbox';

			$params = Hash::insert($params, '1.class', false);
			$params = Hash::insert($params, '1.div', array('class' => 'form-group'));

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
 * - 二重submit防止のため、ng-submit=submit($event)をセットする
 * - エラー出力をNetCommons用の表示をするため、novalidateをOffにする
 *
 * @param mixed $model モデル名
 * @param array $options オプション
 * @return string
 * ##### return サンプル
 * ```
 * <form method="post" novalidate="novalidate" ng-submit="submit($event)" action="/auth_general/auth_general/login">
 * ```
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
 * NetCommons用Htmlを付加して、FormHelper::input()の結果を出力する。
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options オプション配列
 * ##### $optionsの初期値
 * - 共通
 * ```
 * array(
 * 		'error' => false,
 * 		'required' => null,
 * 		'label' => null,
 *	);
 * ```
 * - type=number の場合
 * ```
 * array(
 * 		'error' => false,
 * 		'required' => null,
 * 		'label' => null,
 * 		'min' => 0,
 * 		'div' => array('class' => 'form-group')
 * );
 * ```
 *
 * ##### $optionsの値<br>
 * 基本的なオプションについては、[FormHelperのオプション](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#id5)を参照。
 * そのうち、下記が良く使われるオプションである。
 *
 * - 必須マークを付ける場合
 * ```
 * array(
 * 		'required' => true,
 * );
 * ```
 * - <a id="method_input_options_placeholder" name="method_input_options_placeholder" class="anchor"></a>
 * プレースホルダーテキストを表示する場合
 * ```
 * array(
 * 		'placeholder' => 'アンケートを入力してください。',
 * );
 * ```
 * - ヘルプブロックを表示する場合（NetCommonsのみのオプション）<br>
 * 出力内容については、[こちら](#method_input_help) を参照。
 * ```
 * array(
 * 		'help' => 'アンケートを入力してください。',
 * );
 * ```
 *
 * @return string
 * ##### 下記の$optionsに指定した内容に基づきHTMLを出力する。
 * - <a id="method_input_help" name="method_input_help" class="anchor"></a>
 * help=メッセージ（NCオリジナル）<br>
 * このオプションは、ヘルプブロックを出力するオプション。<br>
 * [サンプル]
 *  - 入力
 * ```
 * echo $this->NetCommonsForm->input('Bbs.name',
 * 			array(
 * 				'type' => 'text',
 * 				'label' => __d('bbses', 'Bbs name'),
 * 				'required' => true,
 * 				'help' => '掲示板名を入力してください。',
 * 			)
 * );
 * ```
 *  - 出力
 * ```
 * <div class="form-group">
 * 			<label class="control-label" for="BbsName">
 * 				掲示板名
 * 				<strong class="text-danger h4">*</strong>
 * 			</label>
 * 			<input type="text" id="BbsName" class="form-control" name="data[Bbs][name]">
 * 			<div class="help-block">掲示板名を入力してください。</div>
 * 			<div class="has-error"></div>
 * </div>
 * ```
 *
 * - <a id="method_input_text" name="method_input_text" class="anchor"></a>
 * type=text (typeを省略した場合、デフォルト値)<br>
 * [FormHelper::input()](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#formhelper)
 * の結果を出力する。<br>
 * [サンプル]
 *  - 入力
 * ```
 * echo $this->NetCommonsForm->input('Bbs.name',
 * 			array(
 * 				'type' => 'text',
 * 				'label' => __d('bbses', 'Bbs name'),
 * 				'required' => true,
 * 			)
 * );
 * ```
 *  - 出力
 * ```
 * <div class="form-group">
 * 			<label for="BbsName" class="control-label">
 * 				掲示板名
 * 				<strong class="text-danger h4">*</strong>
 * 			</label>
 * 			<input name="data[Bbs][name]" class="form-control" maxlength="255" type="text" value="サンプル" id="BbsName"/>
 * 			<div class="has-error"></div>
 * </div>
 * ```
 *
 * - <a id="method_input_textarea" name="method_input_textarea" class="anchor"></a>
 * type=textarea<br>
 * [FormHelper::input()](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#formhelper)
 * の結果を出力する。<br>
 * [サンプル]
 *  - 入力
 * ```
 * echo $this->NetCommonsForm->input('Bbs.name',
 * 			array(
 * 				'type' => 'textarea',
 * 				'label' => '内容',
 * 				'required' => true,
 * 			)
 * );
 * ```
 *  - 出力
 * ```
 * <div class="form-group">
 * 			<label class="control-label" for="BbsName">
 * 				内容
 * 				<strong class="text-danger h4">*</strong>
 * 			</label>
 * 			<textarea id="BbsName" rows="6" cols="30" class="form-control" name="data[Bbs][name]"></textarea>
 * 			<div class="has-error"></div>
 * </div>
 * ```
 *
 * - <a id="method_input_radio" name="method_input_radio" class="anchor"></a>
 * type=radio<br>
 * [FormInputHelper::radio()](./FormInputHelper.html#method_radio)
 * の結果を出力する。
 *
 * - <a id="method_input_multiple_checkbox" name="method_input_multiple_checkbox" class="anchor"></a>
 * type=select, multiple=checkbox<br>
 * [FormInputHelper::multipleCheckbox()](./FormInputHelper.html#method_multipleCheckbox)
 * の結果を出力する。
 *
 * - <a id="method_input_checkbox" name="method_input_checkbox" class="anchor"></a>
 * type=checkbox<br>
 * [FormInputHelper::checkbox()](./FormInputHelper.html#method_checkbox)
 * の結果を出力する。
 *
 * - <a id="method_input_select" name="method_input_select" class="anchor"></a>
 * type=select<br>
 * [FormInputHelper::select()](./FormInputHelper.html#method_select)
 * の結果を出力する。
 *
 * - <a id="method_input_hidden" name="method_input_hidden" class="anchor"></a>
 * type=hidden<br>
 * [FormInputHelper::hidden()](./FormInputHelper.html#method_hidden)
 * の結果を出力する。
 *
 * - <a id="method_input_datetime" name="method_input_datetime" class="anchor"></a>
 * type=datetime<br>
 * [datetimepicker](./DatetimePickerHelper.html)
 * の結果を出力する。<br>
 * [サンプル]
 *  - 入力
 * ```
 * echo $this->NetCommonsForm->input('publish_start',
 * 			array(
 * 				'type' => 'datetime',
 * 				'required' => 'required',
 * 				'label' => __d('blogs', 'Published datetime')
 * 			)
 * );
 * ```
 *  - 出力
 * ```
 * <div class="form-group">
 * 			<label for="BlogEntryPublishStart" class="control-label">公開日時
 * 				<strong class="text-danger h4">*</strong>
 * 			</label>
 * 			<input name="data[BlogEntry][publish_start]"
 * 				class="form-control"
 * 				datetimepicker="1"
 * 				convert_timezone="1"
 * 				ng-model="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start"
 * 				value="2016-04-20 09:00:24"
 * 				ng-value="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start"
 * 				ng-init="NetCommonsFormDatetimePickerModel_BlogEntry_publish_start=&#039;2016-04-20 09:00:24&#039;"
 * 				type="text" id="BlogEntryPublishStart"/>
 * 			<div class="has-error"></div>
 * </div>
 * ```
 * <br>
 *
 * ##### $optionsの内容の他に、下記のHTMLを強制的に出力する。
 * - TimeZone関係のHTML
 * ```
 * <input type="hidden"
 * 		name="data[_NetCommonsTime][user_timezone]"
 * 		value="Asia/Tokyo" id="_NetCommonsTimeUserTimezone"/>
 * <input type="hidden"
 * 		name="data[_NetCommonsTime][convert_fields]"
 * 		value="BlogEntry.publish_start"
 * 		id="_NetCommonsTimeConvertFields"/>
 * ```
 * - エラー発生時、入力ボックスの色を変えるためのdiv
 * ```
 * <div class="has-error">
 * 		・・・
 * </div>
 * ```
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

		$help = Hash::get($options, 'help', false);
		$options = Hash::remove($options, 'help');

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
		if (Hash::get($options, 'type') === 'password') {
			$error = $error || (bool)$this->Form->error($fieldName . '_again');
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

		//ヘルプブロックの追加
		$input .= $this->help($help);

		//error出力
		if (is_array($options['error'])) {
			$options['error']['again'] = Hash::get($options, 'type') === 'password';
			$input .= $this->error($fieldName, null, $options['error']);
		}

		if ($divOption) {
			return $this->NetCommonsHtml->div(null, $input, $divOption);
		} else {
			return $input;
		}
	}

/**
 * <input>の出力
 * このメソッドは、NetCommonsFormHelper->input()から実行される。
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options inputのオプション配列
 * @return string HTML
 */
	protected function _input($fieldName, $options = array()) {
		$output = '';

		$type = Hash::get($options, 'type');
		if (Hash::get($options, 'multiple') === 'checkbox') {
			$type = 'multiple';
		}

		//ラベルの表示
		if (Hash::get($options, 'label')) {
			$label = $this->label($fieldName, $options['label'], ['required' => $options['required']]);
			$options = Hash::remove($options, 'required');
			$options = Hash::insert($options, 'label', false);
			$output .= $label;

			if (in_array($type, ['radio', 'multiple'], true)) {
				$options['outer'] = true;
			}
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
 * [FormHelper::end()](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::end)と
 * [DatetimePickerHelper::beforeFormEnd()](./DatetimePickerHelper.html#method_beforeFormEnd)と
 * [NetCommonsTimeHelper::beforeFormEnd()](./NetCommonsTimeHelper.html#method_beforeFormEnd)の内容を出力する
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::end FormHelper::end()
 */
	public function end($options = null, $secureAttributes = array()) {
		$out = '';

		$this->DatetimePicker->beforeFormEnd();

		$out .= $this->NetCommonsTime->beforeFormEnd();

		$out .= $this->Form->end($options, $secureAttributes);
		return $out;
	}

/**
 * エラーの出力
 *
 * @param string $fieldName フィールド名 "Modelname.fieldname"
 * @param string|array $text エラーメッセージ
 * @param array $options <div>の属性オプション
 * @return string
 * ##### return サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 */
	public function error($fieldName, $text = null, $options = array()) {
		$output = '';

		$again = Hash::get($options, 'again', false);
		$options = Hash::remove($options, 'again');

		$output .= '<div class="has-error">';
		$output .= $this->Form->error(
			$fieldName, $text, Hash::merge(['class' => 'help-block'], $options)
		);

		if ($again) {
			$output .= $this->Form->error(
				$fieldName . '_again', $text, Hash::merge(['class' => 'help-block'], $options)
			);
		}

		$output .= '</div>';

		return $output;
	}

/**
 * ヘルプブロックの表示
 *
 * @param string $helpText ヘルプテキスト
 * @return string
 * ##### return サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
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
 * ##### return サンプル（$returnHtml=true）
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * ##### return サンプル（$returnHtml=false）
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
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
