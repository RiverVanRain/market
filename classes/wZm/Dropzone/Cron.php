<?php

namespace wZm\Dropzone;

class Cron {
	
	/**
	 * Cleanup temp uploaded files which were left behind
	 *
	 * @param string $event         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return void
	 */
	public static function cleanupTempUploadedFiles(\Elgg\Event $event) {
		
		echo 'Starting Dropzone cleanup' . PHP_EOL;
		elgg_log('Starting Dropzone cleanup', 'NOTICE');
		
		// ignore access
		elgg_call(ELGG_IGNORE_ACCESS, function() {
			// prepare batch
			$batch = new \ElggBatch('elgg_get_entities', [
				'type' => 'object',
				'subtype' => \wZm\Dropzone\TempUploadFile::SUBTYPE,
				'limit' => false,
				'created_before' => '-1 day',
			]);
			$batch->setIncrementOffset(false);
			
			// loop through old files
			/* @var $file \wZm\Dropzone\TempUploadFile */
			foreach ($batch as $file) {
				$file->delete();
			}
		});
		
		echo 'Done with Dropzone cleanup' . PHP_EOL;
		elgg_log('Done with Dropzone cleanup', 'NOTICE');
	}
}
