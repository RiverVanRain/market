<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain, Rohit Gupta
 * @copyright slyhne 2010-2015, wZm 2017
 * @link https://wzm.me
 * @version 3.0
 */
class ElggMarket extends ElggObject {
	
	const SUBTYPE = 'market';
	
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	public function formatAttachments() {

		$attachments = array();

		$attachments[] = $this->html;

		$attachments[] = elgg_view('object/market/attachments', [
			'entity' => $this,
		]);

		$output = (count($attachments)) ? implode('', $attachments) : false;
		return elgg_trigger_plugin_hook('attachments:format', 'market', ['entity' => $this], $output);
	}

	public function getAttachments($format = null, $size = 'small') {
		$attachment_tags = array();

		$attachments = new ElggBatch('elgg_get_entities', [
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
