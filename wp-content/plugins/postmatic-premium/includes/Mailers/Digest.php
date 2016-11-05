<?php
namespace Postmatic\Premium\Mailers;

use Postmatic\Premium\Email_Batches;
use Postmatic\Premium\Repositories;
use Postmatic\Premium\Lists;
use Postmatic\Premium\Rendering_Contexts;

/**
 * Manage sending a digest.
 * @since 0.1.0
 */
class Digest extends \Prompt_Mailer {

	/** @var  Email_Batches\Digest */
	protected $batch;

	/**
	 * Initiate mailing for a digest list.
	 *
	 * @since 0.1.0
	 *
	 * @param int $plan_id
	 * @param int $retry_wait_seconds Minimum time to wait if a retry is necessary, null for default
	 */
	public static function initiate( $plan_id, $retry_wait_seconds = null ) {

		$digest_repo = new Repositories\Digest_List();
		$digest_plan = $digest_repo->get_by_id( $plan_id );

		if ( !$digest_plan ) {
			\Prompt_Logging::add_error(
				\Prompt_Enum_Error_Codes::DIGEST,
				__( 'Digest plan not found.', 'postmatic-premium' ),
				compact( 'plan_id' )
			);
			return;
		}

		$callback_repo = new Repositories\Scheduled_Callback_HTTP();
		$callback = $callback_repo->get_by_id( $digest_plan->get_callback_id() );
		if ( is_wp_error( $callback ) ) {
			return;
		}

		if ( ! Lists\Posts\Digest::is_due( $digest_plan, $callback ) ) {
			\Prompt_Logging::add_error(
				\Prompt_Enum_Error_Codes::DIGEST,
				__( 'Got digest callback with no digest due.', 'postmatic-premium' ),
				compact( 'digest_plan', 'callback' )
			);
			return;
		}

		$digest_post = Lists\Posts\Digest::create( $digest_plan, array( 'post_status' => 'publish' ) );

		$context = new Rendering_Contexts\Digest( $digest_post, $callback );

		$batch = new Email_Batches\Digest( $context );

		if ( ! $batch->get_context()->get_wp_query()->have_posts() ) {
			// Don't send digests with no posts
			return;
		}

		$mailer = new self( $batch );

		$result = $mailer->set_retry_wait_seconds( $retry_wait_seconds )->send();

		if ( $mailer->reschedule( $result ) ) {
			return;
		}
		
		if ( is_wp_error( $result ) ) {
			\Prompt_Logging::add_error(
				\Prompt_Enum_Error_Codes::DIGEST,
				__( 'Encountered and error while mailing a digest.', 'postmatic-premium' ),
				compact( 'digest_plan', 'callback', 'digest_post', 'batch', 'result' )
			);
		}
	}

	/**
	 * @since 0.1.0
	 *
	 * @param Email_Batches\Digest $batch
	 * @param \Prompt_Api_Client $client
	 */
	public function __construct( Email_Batches\Digest $batch, \Prompt_Api_Client $client = null ) {
		parent::__construct( $batch, $client );
	}

	/**
	 * Add idempotent checks and batch recording to the parent send method.
	 *
	 * @since 0.1.0
	 *
	 * @return null|array|\WP_Error
	 */
	public function send() {

		$this->batch->set_individual_message_values( array() )->add_unsent_recipients()->lock_for_sending();

		$result = parent::send();

		if ( $result and ! is_wp_error( $result ) ) {
			$this->record_successful_outbound_message_batch( $result );
		}

		return $result;
	}

	/**
	 * Schedule a retry if a temporary failure has occurred.
	 *
	 * @since 0.1.0
	 *
	 * @param array $response
	 * @return bool Whether a retry has been rescheduled.
	 */
	protected function reschedule( $response ) {

		$rescheduler = \Prompt_Factory::make_rescheduler( $response, $this->retry_wait_seconds );

		if ( $rescheduler->found_temporary_error() ) {

			$this->batch->clear_for_retry();

			$rescheduler->reschedule(
				'postmatic/premium/mailers/digest/initiate',
				array( $this->batch->get_context()->get_digest_plan()->id() )
			);
			return true;
		}

		return false;
	}

	/**
	 * @since 0.1.0
	 * @param object $data
	 */
	protected function record_successful_outbound_message_batch( $data ) {

		if ( empty( $data->id ) ) {
			\Prompt_Logging::add_error(
				\Prompt_Enum_Error_Codes::OUTBOUND,
				__( 'Got an unrecognized outbound message batch response.', 'postmatic-premium' ),
				array( 'result' => $data, 'post_id' => $this->batch->get_context()->get_digest_post()->id() )
			);
			return;
		}

		$this->batch->record_successful_mailing( $data->id );
	}
}