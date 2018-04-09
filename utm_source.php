<?php
if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) {
	if ($_GET['utm_source']) {
		$paginaAtual = "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
		header("Location: $paginaAtual");
	}
}
else {

	$cookieTime = time() + 3600 * 24 * 7;

	if ($_COOKIE['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
		setcookie('user_agent', $_SERVER['HTTP_USER_AGENT'], $cookieTime, '/');
		$_COOKIE['user_agent']  = $_SERVER['HTTP_USER_AGENT'];
	}

	if ( ! $_COOKIE['utm_source']) {

		if ($_GET['utm_source']) {
			setcookie('utm_source', $_GET['utm_source'], $cookieTime, '/');
			$_COOKIE['utm_source'] = $_GET['utm_source'];
		}
		else {

			$urlPattern = '/^((https?:\/\/www\.)|(https?:\/\/)|(www\.))(rodobensimoveis|rni)\.com/i';
			if ( $_SERVER['HTTP_REFERER'] && ! preg_match($urlPattern, $_SERVER['REFERER']) ) {
				setcookie('utm_source', "Referencia - $_SERVER[HTTP_REFERER]", $cookieTime, '/');
				$_COOKIE['utm_source'] = "Referencia - $_SERVER[HTTP_REFERER]";
			}
			else {
				setcookie('utm_source', 'Direto', $cookieTime, '/');
				$_COOKIE['utm_source'] = 'Direto';
			}
		}

	}
	else {
		if ($_GET['utm_source']) {

			if ($_GET['utm_source'] != $_COOKIE['utm_source']) {

				if ($_COOKIE['utm_source_ini'] == $_GET['utm_source']) {

					$_COOKIE['utm_source_ini'] = '';
					setcookie('utm_source_ini', '', 1, '/');

				}
				else if ($_COOKIE['utm_source_ini']) {

					setcookie('utm_source_ini', $_COOKIE['utm_source_ini'], $cookieTime, '/');
					$_COOKIE['utm_source_ini'] = $_COOKIE['utm_source_ini'];
				}
				else if ($_COOKIE['utm_source'] != 'Direto' && strpos($_COOKIE['utm_source'], 'Referencia - ') === false) {

					setcookie('utm_source_ini', $_COOKIE['utm_source'], $cookieTime, '/');
					$_COOKIE['utm_source_ini'] = $_COOKIE['utm_source'];
				}
			}

			//nao mexer
			setcookie('utm_source', $_GET['utm_source'], $cookieTime, '/');
			$_COOKIE['utm_source'] = $_GET['utm_source'];

			if ( ! $_GET['utm_medium'] && $_COOKIE['utm_medium']) {
				setcookie('utm_medium', '', $cookieTime, '/');
				$_COOKIE['utm_medium'] = '';
			}

			if ( ! $_GET['utm_content'] && $_COOKIE['utm_content']) {
				setcookie('utm_content', '', $cookieTime, '/');
				$_COOKIE['utm_content'] = '';
			}

			if ( ! $_GET['utm_campaign'] && $_COOKIE['utm_campaign']) {
				setcookie('utm_campaign', '', $cookieTime, '/');
				$_COOKIE['utm_campaign'] = '';
			}
		}
	}

	//utm_medium
	if ($_GET['utm_source'] && $_GET['utm_medium']) {

		if ($_GET['utm_medium'] != $_COOKIE['utm_medium']) {

			if ($_COOKIE['utm_medium_ini'] == $_GET['utm_medium']) {

				setcookie('utm_medium_ini', '', 1, '/');
				$_COOKIE['utm_medium_ini'] = '';

			}
			else if ($_COOKIE['utm_medium_ini']) {

				setcookie('utm_medium_ini', $_COOKIE['utm_medium_ini'], $cookieTime, '/');
				$_COOKIE['utm_medium_ini'] = $_COOKIE['utm_medium_ini'];
			}
			else if ($_COOKIE['utm_medium']) {

				setcookie('utm_medium_ini', $_COOKIE['utm_medium'], $cookieTime, '/');
				$_COOKIE['utm_medium_ini'] = $_COOKIE['utm_medium'];
			}
		}

		setcookie('utm_medium', $_GET['utm_medium'], $cookieTime, '/');
		$_COOKIE['utm_medium'] = $_GET['utm_medium'];
	}

	//utm_content
	if ($_GET['utm_source'] && $_GET['utm_content']) {

		if ($_GET['utm_content'] != $_COOKIE['utm_content']) {

			if ($_COOKIE['utm_content_ini'] == $_GET['utm_content']) {

				setcookie('utm_content_ini', '', 1, '/');
				$_COOKIE['utm_content_ini'] = '';

			}
			else if ($_COOKIE['utm_content_ini']) {

				setcookie('utm_content_ini', $_COOKIE['utm_content_ini'], $cookieTime, '/');
				$_COOKIE['utm_content_ini'] = $_COOKIE['utm_content_ini'];
			}
			else if ($_COOKIE['utm_content']) {

				setcookie('utm_content_ini', $_COOKIE['utm_content'], $cookieTime, '/');
				$_COOKIE['utm_content_ini'] = $_COOKIE['utm_content'];
			}
		}

		setcookie('utm_content', $_GET['utm_content'], $cookieTime, '/');
		$_COOKIE['utm_content'] = $_GET['utm_content'];
	}

	//utm_campaign
	if ($_GET['utm_source'] && $_GET['utm_campaign']) {

		if ($_GET['utm_campaign'] != $_COOKIE['utm_campaign']) {

			if ($_COOKIE['utm_campaign_ini'] == $_GET['utm_campaign']) {

				setcookie('utm_campaign_ini', '', 1, '/');
				$_COOKIE['utm_campaign_ini'] = '';

			}
			else if ($_COOKIE['utm_campaign_ini']) {

				setcookie('utm_campaign_ini', $_COOKIE['utm_campaign_ini'], $cookieTime, '/');
				$_COOKIE['utm_campaign_ini'] = $_COOKIE['utm_campaign_ini'];
			}
			else if ($_COOKIE['utm_campaign']) {

				setcookie('utm_campaign_ini', $_COOKIE['utm_campaign'], $cookieTime, '/');
				$_COOKIE['utm_campaign_ini'] = $_COOKIE['utm_campaign'];
			}
		}

		setcookie('utm_campaign', $_GET['utm_campaign'], $cookieTime, '/');
		$_COOKIE['utm_campaign'] = $_GET['utm_campaign'];
	}

	if ( $_COOKIE['utm_source'] && $_COOKIE['utm_source'] != 'Direto' && strpos($_COOKIE['utm_source'], 'Referencia - ') === false) {
		$passSource = '&utm_source='.$_COOKIE['utm_source'];

		if ($_COOKIE['utm_medium']) { $passSource .= '&utm_medium='.urlencode($_COOKIE['utm_medium']); }
		if ($_COOKIE['utm_content']) { $passSource .= '&utm_content='.urlencode($_COOKIE['utm_content']); }
		if ($_COOKIE['utm_campaign']) { $passSource .= '&utm_campaign='.urlencode($_COOKIE['utm_campaign']); }

		if ($_COOKIE['utm_source_ini']) { $passSource .= '&utm_source_ini='.urlencode($_COOKIE['utm_source_ini']); }
		if ($_COOKIE['utm_medium_ini']) { $passSource .= '&utm_medium_ini='.urlencode($_COOKIE['utm_medium_ini']); }
		if ($_COOKIE['utm_content_ini']) { $passSource .= '&utm_content_ini='.urlencode($_COOKIE['utm_content_ini']); }
		if ($_COOKIE['utm_campaign_ini']) { $passSource .= '&utm_campaign_ini='.urlencode($_COOKIE['utm_campaign_ini']); }

		if ($_COOKIE['user_agent']) { $passSource .= '&user_agent='.urlencode($_COOKIE['user_agent']); }
	}
}

if ($_SERVER['REMOTE_ADDR'] == '179.212.90.109') {
	echo "<!--\n";
	print_r($_COOKIE);
	echo "\n-->";
}?>