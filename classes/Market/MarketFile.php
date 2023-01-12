<?php

namespace Market;

class MarketFile extends \ElggFile {
	
	const SUBTYPE = 'market_file';
	
	/**
	 * @inheritdoc
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
}
