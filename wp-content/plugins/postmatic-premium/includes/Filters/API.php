<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Repositories;

/**
 * Filter API values.
 * @since 0.1.0
 */
class API {

	/**
	 * Use the default digests list in the API when digests are enabled.
	 *
	 * @since 0.1.0
	 * @param \Prompt_Interface_Subscribable $list Current list value if any.
	 * @return \Prompt_Interface_Subscribable|null
	 */
	public static function digests_list( \Prompt_Interface_Subscribable $list = null ) {
		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return $list;
		}

		$repo = new Repositories\Digest_List();
		return $repo->get_default();
	}
}