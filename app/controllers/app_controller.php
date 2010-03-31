<?php
class AppController extends Controller {

	var $components = array('Auth', 'Qdmail');
	var $helpers = array('Html', 'Form', 'Javascript', 'Session', 'ScrumHtml');

	/**
	 * 認証コンポーネント
	 *
	 * @var AuthComponent
	 */
	var $Auth;

	function __construct()
	{

		if (Configure::read('Config.debug') != "0")
		{
		//	array_push($this->components, 'DebugKit.Toolbar');
		}
		parent::__construct();
	}

	function beforeFilter()
	{
		if(get_class($this) == "UsersController"){
			// UsersControllerの認証除外対象
			$this->Auth->allow(array('add'));
		}

		if (isset($this->Auth)) {
			//ログインできるユーザの条件をデータベースのフィールドの値で指定
			$this->Auth->userScope = array("User.disabled" => 0);
			//ログイン処理を行うactionを指定（/users/loginがデフォルト）。
			$this->Auth->loginAction = "/users/login";
			//ログインが失敗した際のエラーメッセージ
			$this->Auth->loginError = "ニックネームかパスワードが誤っているためログインできません";
			//権限が無いactionを実行した際のエラーメッセージ
			$this->Auth->authError = "ログインしてください";
			//ログイン後にリダイレクトするURL
			$this->Auth->loginRedirect = "/users/index";
			//ユーザIDとパスワードがあるmodelを指定(’User’がデフォルト)
			$this->Auth->userModel = "User";
			//ユーザIDとパスワードのフィールドを指定（username、password がデフォルト)
			$this->Auth->fields = array("username" => "loginname", "password" => "password");
			//自動リダイレクトしない
			$this->Auth->autoRedirect = false;

			// ログインユーザ情報をviewに受け渡し
			$login_user = $this->Auth->User();
			$this->set('login_user', $login_user['User']);
		}

	}

	function beforeRender()
	{
		$this->disableCache();
	}

	// メール送信処理(汎用)
	protected function sendmail($mail_setting, $mail_content) {

		// QdmailとDebugKitの共存対応
		$this->view = "View";

		Configure::write("debug", 0);

		mb_language("Japanese");

		$param = array(
			'host'=> Configure::read('Config.mail_smtp'),
			'port'=> 25 ,
			'from'=> Configure::read('Config.mail_from'),
			'protocol'=> Configure::read('Config.mail_protocol'),
			'user'=> '',
			'pass' => '',
			'pop_host' => Configure::read('Config.mail_pop_host'),
			'pop_user' => Configure::read('Config.mail_pop_username'),
			'pop_pass'=> Configure::read('Config.mail_pop_password'),
		);

		$to = $mail_setting['mail_to'];
		$to_array = explode(',', $to);
		$name_array = array();
		for($i=0; $i<count($to_array); $i++)
		{
			$name_array[] = '';
		}
		$this->Qdmail->to($to_array, $name_array);
		$this->Qdmail->subject($mail_setting['mail_subject']);
		$this->Qdmail->from(Configure::read('Config.mail_from') , '');
		$this->Qdmail->smtp(true);
		$this->Qdmail->smtpServer($param);
		$this->Qdmail->logLevel(3);
		$this->Qdmail->errorlogLevel(3);
		$this->Qdmail->smtpLoglevelLink(true);
		$this->Qdmail->logPath(LOGS);
		$this->Qdmail->logFilename("mail.log");
		$this->Qdmail->errorlogPath(LOGS);
		$this->Qdmail->errorlogFilename("error_mail.log");

		//メールの表示情報を渡す
		$this->Qdmail->cakeText($mail_content, $mail_setting['mail_template']);

		if ($this->Qdmail->send() != false)
		{
			$this->log('メール送信完了', LOG_INFO);
			return TRUE;
		}
		else
		{
			$this->log('メール送信失敗', LOG_INFO);
			return FALSE;
		}
	}

	/**
	 * 引数にreturn_urlがついていた場合はそちらを優先する
	 */
	function _redirect($url) 
	{
		$return_url = @$this->params['url']['return_url'];
		if ($return_url != "")
		{
			$this->redirect(urldecode($return_url));
		}
		else
		{
			$this->redirect($url);
		}
	}

}
?>