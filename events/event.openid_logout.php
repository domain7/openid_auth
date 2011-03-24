<?php

	require_once TOOLKIT . '/class.event.php';

	class EventOpenID_Logout extends Event{
		
		public static function about(){
			return array(
					 'name' => 'OpenID Logout',
					 'author' => array(
							'name' => 'Stephen Bau',
							'email' => 'stephen@domain7.com'),
					 'version' => '1.0',
					 'release-date' => '2011-03-08');	
		}

		public static function allowEditorToParse(){
			return false;
		}

		public static function documentation(){
			return '
				<p>Log out of an OpenID session.</p>
			';
		}

		public function load(){
			if(isset($_GET['openid-action']['logout'])) return $this->__trigger();
		}

		protected function __trigger() {
			$cookie = new Cookie('openid', TWO_WEEKS, __SYM_COOKIE_PATH__);
			$cookie->expire();
			$member_cookie = new Cookie(Symphony::Configuration()->get('cookie-prefix', 'members'), TWO_WEEKS, __SYM_COOKIE_PATH__);
			$member_cookie->expire();

			$logout_redirect = Symphony::Configuration()->get('logout-redirect', 'openid-auth');
			if($logout_redirect) {
				redirect(URL . $logout_redirect);
			}
		}
	}
