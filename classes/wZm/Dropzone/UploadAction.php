<?php

namespace wZm\Dropzone;

use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class UploadAction {

	/**
	 * Upload a file
	 *
	 * @param Request $request Request
	 * @return ResponseBuilder
	 */
	public function __invoke(Request $request) {

		$svc = elgg()->dropzone;
		/* @var $svc \wZm\DropzoneService */

		$result = $svc->handleUploads($request);

		$output = '';
		if (elgg_is_xhr()) {
			$output = json_encode($result);
		}

		return elgg_ok_response($output);
	}
}