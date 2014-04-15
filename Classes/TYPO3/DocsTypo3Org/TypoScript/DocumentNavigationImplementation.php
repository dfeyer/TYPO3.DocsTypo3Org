<?php
namespace TYPO3\DocsTypo3Org\TypoScript;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.DocsTypo3Org".    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\DocsTypo3Org\Service\ContentService;
use TYPO3\DocsTypo3Org\Service\TreeService;
use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TypoScript\Exception as TypoScriptException;
use TYPO3\TypoScript\TypoScriptObjects\TemplateImplementation;

/**
 * A TypoScript DocumentNavigation object
 */
class DocumentNavigationImplementation extends TemplateImplementation {

	/**
	 * @Flow\Inject
	 * @var TreeService
	 */
	protected $treeService;

	/**
	 * @Flow\Inject
	 * @var ContentService
	 */
	protected $contentService;

	/**
	 * @var integer
	 */
	protected $itemsCounter;

	/**
	 * @var array
	 */
	protected $items = NULL;

	/**
	 * @return integer
	 */
	public function getItemsCounter() {
		if ($this->items === NULL) {
			$this->buildItems();
		}
		return $this->itemsCounter;
	}

	/**
	 * @return array
	 */
	public function getItems() {
		return $this->buildItems();
	}

	/**
	 * @return array
	 */
	protected function buildItems() {
		if ($this->items !== NULL) {
			return $this->items;
		}
		/** @var NodeInterface $documentNode */
		$documentNode = $this->tsValue('node');
		$rawContent = '';
		$q = new FlowQuery(array($documentNode));
		foreach ($q->children($this->tsValue('nodePath'))->children('[instanceof TYPO3.Neos:Content]')->get() as $node) {
			/** @var NodeInterface $node */
			if ($node->hasProperty('text')) {
				$rawContent .= $node->getProperty('text');
			}
		}
		$items = $this->contentService->extractDocumentNavigation($rawContent);
		$this->itemsCounter = count($items);
		$this->items = $this->treeService->buildTree($items);
		return $this->items;
	}

}