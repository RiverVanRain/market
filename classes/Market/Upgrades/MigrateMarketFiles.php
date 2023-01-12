<?php
/**
 * River
 * @author Nikolai Shcherbin
 * @package Plugin
 * @license GNU Affero General Public License version 3
 * @copyright (c) Nikolai Shcherbin 2019
 * @link https://wzm.me
**/
namespace Market\Upgrades;

use Elgg\Database\Select;
use Elgg\Database\Update;
use Elgg\Upgrade\AsynchronousUpgrade;
use Elgg\Upgrade\Result;

class MigrateMarketFiles implements AsynchronousUpgrade {
	/**
     * Version of the upgrade
     *
     * @return int
    */
    public function getVersion(): int {
        return 2023011200;
    }

    /**
     * Should the run() method receive an offset representing all processed items?
     *
     * @return bool
    */
    public function needsIncrementOffset(): bool {
        return false;
    }

    /**
     * Should this upgrade be skipped?
     *
     * @return bool
    */
    public function shouldBeSkipped(): bool {
        return empty($this->countItems());
    }
	
	 /**
     * The total number of items to process in the upgrade
     *
     * @return int
    */
    public function countItems(): int {
		return elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () {
			return elgg_count_entities([
				'type' => 'object',
				'subtype' => 'file',
				'metadata_name_value_pairs' => [
					[
						'name' => 'origin',
						'value' => 'market',
					],
				],
			]);
		});
    }

    /**
     * Runs upgrade on a single batch of items
     *
     * @param Result $result Result of the batch (this must be returned)
     * @param int    $offset Number to skip when processing
     *
     * @return Result Instance of \Elgg\Upgrade\Result
    */
    public function run(Result $result, $offset): Result {
		$select = Select::fromTable('metadata', 'md');
		$select->select('entity_guid')
			->where($select->compare('md.name', '=', 'origin', ELGG_VALUE_STRING))
			->andWhere($select->compare('md.value', '=', 'market', ELGG_VALUE_STRING));
			
		$guids = _elgg_services()->db->getData($select, function($row) {
			return (int) $row->entity_guid;
		});
		
		if (!empty($guids)) {
			$update = Update::table('entities');
			$update->set('subtype', '"market_file"')
				->where('subtype = "file"')
				->andWhere($update->compare('guid', 'in', $guids, ELGG_VALUE_GUID));
				
			_elgg_services()->db->updateData($update);
		}
		
		$result->addSuccesses(count($guids));
		
		return $result;
    }
	
}