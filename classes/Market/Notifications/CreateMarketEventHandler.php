<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market\Notifications;

use Elgg\Notifications\NotificationEventHandler;

class CreateMarketEventHandler extends NotificationEventHandler {
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('market:notify:subject', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('market:notify:summary', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->event->getObject();

		return elgg_echo('market:notify:body', [
			$this->event->getActor()->getDisplayName(),
			$entity->getDisplayName(),
			$entity->description,
			$entity->getURL(),
		], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected static function isConfigurableForGroup(\ElggGroup $group): bool {
		return $group->isToolEnabled('market');
	}
}
