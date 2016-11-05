<?php
namespace Postmatic\Premium\Models;

class Webhook {

	protected $name;
	protected $email;
	protected $sub_type;
	protected $post_method;
	protected $log_method;

	public function __construct( $user_id, $subscribable_object, $args = array() ) {

		$defaults = array(
			'post_method' => 'wp_remote_post',
			'log_method' => array( 'Prompt_Logging', 'add_error' ),
		);

		$args = wp_parse_args( $args, $defaults );

		// Get data to pass to webhook
		$user = get_userdata( $user_id );
		$this->name = $user->display_name;
		$this->email = $user->user_email;
		$this->sub_type = $subscribable_object->subscribe_phrase();
		$this->post_method = $args['post_method'];
		$this->log_method = $args['log_method'];
	}

	public function execute( $action = '' ) {

		// Pass proper webhook url
		if ( $action == 'subscribe' || $action == 'unsubscribe' ) {
			$webhooks_urls = \Prompt_Core::$options->get( 'webhooks_urls' );

			$res = $this->call( $webhooks_urls[$action], $action );
			return $res;
		}

	}

	public function call( $url = '', $event = '' ) {

		// Make the HTTP request
		if ( empty( $url ) ) {
			return null;
		}

		$args = array(
			'method' => 'POST',
			'headers' => array(),
			'body' => array(
				'name' => $this->name,
				'email' => $this->email,
				'subscription_type' => $this->sub_type,
				'event' => $event,
			),
			'timeout' => 15,
		);

		$response = call_user_func( $this->post_method, $url, $args );

		if ( is_wp_error( $response ) or $response['response']['code'] > 399 ) {
			return call_user_func(
				$this->log_method,
				'postmatic_webhook_error',
				__( 'A web hook failed.', 'postmatic-premium' ),
				compact( 'url', 'args', 'response' )
			);
		}

		return $response;
	}

}