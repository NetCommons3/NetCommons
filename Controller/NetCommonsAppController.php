<?php
/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Controller', 'Controller');

/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller
 */
class NetCommonsAppController extends Controller {

/**
 * use layout
 *
 * @var string
 */
	public $layout = 'NetCommons.default';

/**
 * use theme
 *
 * @var string
 */
	public $theme = 'default';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'Asset',
		'Auth' => array(
			'loginAction' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			),
			'loginRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			),
			'logoutRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			)
		),
		'RequestHandler',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = array('SiteSetting');

/**
 * View class name that is used for singleton helper
 *
 * @var string
 */
	public $viewClass = 'SingletonHelper';

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		if (Configure::read('NetCommons.installed')) {
			//現在のテーマを取得
			$theme = $this->Asset->getSiteTheme($this);
			if ($theme) {
				$this->theme = $theme;
			}
		}
		if (isset($this->request->query['language'])) {
			Configure::write('Config.language', $this->request->query['language']);
			$this->Session->write('Config.language', $this->request->query['language']);
		} elseif ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		}
		$this->Auth->allow('index', 'view');
		Security::setHash('sha512');
	}

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		//theme css指定
		$this->set('bootstrapMinCss', $this->Asset->isThemeBootstrapMinCss($this));
	}

/**
 * Keep connection alive
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return void
 **/
	public function ping() {
		$this->set('result', array('message' => 'OK'));
		$this->set('_serialize', array('result'));
	}

/**
 * json render
 *
 * @param array $results results data
 * @param string $name message
 * @param int $status status code
 * @return void
 */
	public function renderJson($results, $name = 'OK', $status = 200) {
		$this->viewClass = 'Json';
		$this->layout = false;
		$this->response->statusCode($status);
		$result = array(
			'code' => $status,
			'name' => $name,
			'results' => $results,
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');

		$this->render(false);
	}

}
