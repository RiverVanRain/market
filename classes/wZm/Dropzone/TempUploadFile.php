<?php

namespace wZm\Dropzone;

use ElggFile;

class TempUploadFile extends ElggFile {
	
	const SUBTYPE = 'temp_file_upload';
	
	/**
	 * @inheritdoc
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggEntity::saveIconFromElggFile()
	 */
	public function saveIconFromElggFile(\ElggFile $file, $type = 'icon', array $coords = array()) {
		return false;
	}
}
