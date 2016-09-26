<?php


namespace AlpineIO\WP;


class Tubolinks {

	const PLUGIN_VERSION = '1.0.0';
	const TURBOLINKS_VERSION = '5.0.0';

	static $excludePaths = [
		'/admin'
	];

	public static function init() {
		static::addActions();
	}

	public static function addActions() {
		add_action( 'template_redirect', [ static::class, 'addLocationHeader' ] );
		add_action( 'wp_enqueue_scripts', [ static::class, 'enqueue' ] );
	}

	public static function addLocationHeader() {
		header( "Turbolinks-Location: " . static::getLocation() );
	}

	public static function getLocation() {
		$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
		return $escaped_url;
	}

	public static function enqueue() {

		$script = 'https://cdnjs.cloudflare.com/ajax/libs/turbolinks/' . static::TURBOLINKS_VERSION .'/turbolinks.min.js';
		wp_register_script( 'alpineio-turbolinks', $script, null, 'aio-tl-' . static::PLUGIN_VERSION, true );
		wp_enqueue_script( 'alpineio-turbolinks' );
	}
}