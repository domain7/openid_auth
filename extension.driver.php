<?php

	class Extension_Openid_Auth extends Extension{

		public function about(){
			return array('name' => 'OpenID Authentication',
						 'version' => '0.2',
						 'release-date' => '2011-02-09',
						 'author' => array('name' => 'Marco Sampellegrini',
										   'email' => 'm@rcosa.mp')
				 		);
		}
		
		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/frontend/',
					'delegate' => 'openidAuthComplete',
					'callback' => 'authenticationComplete'
				),
				array(
					'page' => '/frontend/',
					'delegate' => 'FrontendParamsResolve',
					'callback' => 'addParamsToPage'
				)
			);
		}

		public function authenticationComplete($context)
		{
			$openid_data = $context['openid-data'];
			$cookie = new Cookie('openid', TWO_WEEKS, __SYM_COOKIE_PATH__);
			$cookie->set('identifier', $openid_data->identifier);
			$cookie->set('sreg-data',  $openid_data->sreg_data);
		}

		/**
		 * Add OpenID parameters to parameter pool
		 */
		public function addParamsToPage(array $context=array()){

			$cookie = new Cookie('openid', TWO_WEEKS, __SYM_COOKIE_PATH__);
			$openid_cookie_data = $cookie->get('sreg-data');
			
			if($openid_cookie_data) {
				$context['params']['openid-cookie-email'] = $openid_cookie_data[email];
				$context['params']['openid-cookie-first'] = $openid_cookie_data[first];
				$context['params']['openid-cookie-last'] = $openid_cookie_data[last];
			}

		}
	}
