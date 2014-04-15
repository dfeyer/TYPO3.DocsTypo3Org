<?php
namespace TYPO3\DocsTypo3Org\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.DocsTypo3Org".    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TypoScript\Exception as TypoScriptException;
use TYPO3\TypoScript\TypoScriptObjects\TemplateImplementation;

/**
 * Content Service
 */
class ContentService {

	/**
	 * @param string $content
	 * @return array
	 */
	public function extractDocumentNavigation($content) {
		$items = $matches = array();
		$previousLevel = 1;
		$identifier = $previousIdentifier = 0;
		$parentIdentifier = NULL;
		preg_match_all('/<h(\d)>([^<]*)<\/h\d>/iU', $content, $matches);
		$identifierStack = array();
		foreach ($matches[1] as $key => $level) {
			$level = (int)$level;
			$identifier++;
			$identifierStack[$level] = $identifier;
			if ($level > $previousLevel) {
				$parentIdentifier = $previousIdentifier;
			} elseif ($level === 1) {
				$parentIdentifier = NULL;
			} elseif ($level < $previousLevel) {
				$levels = array_keys($identifierStack);
				$levels = array_reverse($levels);
				foreach ($levels as $upperLevel) {
					if ($upperLevel < $level) {
						$parentIdentifier = $identifierStack[$upperLevel];
						break;
					}
				}
			}

			$items[] = array(
				'identifier' => $identifier,
				'level' => (int)$level,
				'label' => html_entity_decode($matches[2][$key]),
				'parentIdentifier' => $parentIdentifier
			);
			$previousLevel = $level;
			$previousIdentifier = $identifier;
		}

		return $items;
	}

}