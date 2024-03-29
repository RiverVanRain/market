<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
 
class ElggMarket extends \ElggObject {
	
	const SUBTYPE = 'market';
	
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	public function canComment(int $user_guid = 0): bool {
		if (!parent::canComment($user_guid)) {
			return false;
		}

		if ($this->comments_on === 'Off' || $this->status === 'sold') {
			return false;
		}
		
		return true;
	}
	
	public function formatAttachments() {

		$attachments = [];

		$attachments[] = $this->html;

		$attachments[] = elgg_view('object/market/attachments', [
			'entity' => $this,
		]);

		$output = (count($attachments)) ? implode('', $attachments) : false;
		return elgg_trigger_event_results('attachments:format', 'market', ['entity' => $this], $output);
	}

	public function getAttachments($format = null, $size = 'small') {
		$attachment_tags = [];

		$attachments = new \ElggBatch('elgg_get_entities', [
			'relationship' => 'attached',
			'relationship_guid' => $this->guid,
			'limit' => false
		]);

		foreach ($attachments as $attachment) {
			$attachment_tags[] = elgg_view_entity_icon($attachment, $size, [
				'use_hover' => false
			]);
		}

		return $attachment_tags;
	}
}
