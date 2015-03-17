<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

	'facebook' => [
		'client_id' => '1555428931397998',
		'client_secret' => '14fe549773d1750eaa8167f361d0e69e',
		'redirect' => 'http://leiatrenn.crisp.ee/auth/socialcallback/facebook',
	],

	'google' => [
		'client_id' => '33123042577-k5eg62169njc3v7l2lvqvg6p8pglfs8q.apps.googleusercontent.com',
		'client_secret' => 'pCDiOgpbLy78PSGn800BsRU1',
		'redirect' => 'http://leiatrenn.crisp.ee/auth/socialcallback/google',
	],

];
