<?php
namespace TYPO3\DocsTypo3Org\Tests\Unit\Command;

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


/**
 * Testcase for the "ContentService"
 *
 */
class ContentServiceTest extends \TYPO3\Flow\Tests\UnitTestCase {

	public function extractDocumentNavigationReturnHeadersWithLevelInformationDataProvider() {
		return array(
			/*
			0 => array(
				'content' => '
					<p>Foo</p>
				',
				'expected' => array()
			),
			1 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					)
				)
			),
			2 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h2>Header #1.1</h2>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 2,
						'label' => 'Header #1.1',
						'parentIdentifier' => 1
					)
				)
			),
			3 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h1>Header #2</h1>
					<p>Foo</p>
					<h2>Header #2.1</h2>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 1,
						'label' => 'Header #2',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 3,
						'level' => 2,
						'label' => 'Header #2.1',
						'parentIdentifier' => 2
					)
				)
			),
			4 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h1>Header #2</h1>
					<p>Foo</p>
					<h2>Header #2.1</h2>
					<p>Foo</p>
					<h3>Header #2.1.1</h3>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 1,
						'label' => 'Header #2',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 3,
						'level' => 2,
						'label' => 'Header #2.1',
						'parentIdentifier' => 2
					),
					array(
						'identifier' => 4,
						'level' => 3,
						'label' => 'Header #2.1.1',
						'parentIdentifier' => 3
					)
				)
			),
			5 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h1>Header #2</h1>
					<p>Foo</p>
					<h2>Header #2.1</h2>
					<p>Foo</p>
					<h3>Header #2.1.1</h3>
					<p>Foo</p>
					<h1>Header #3</h1>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 1,
						'label' => 'Header #2',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 3,
						'level' => 2,
						'label' => 'Header #2.1',
						'parentIdentifier' => 2
					),
					array(
						'identifier' => 4,
						'level' => 3,
						'label' => 'Header #2.1.1',
						'parentIdentifier' => 3
					),
					array(
						'identifier' => 5,
						'level' => 1,
						'label' => 'Header #3',
						'parentIdentifier' => NULL
					)
				)
			),
			6 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h1>Header #2</h1>
					<p>Foo</p>
					<h2>Header #2.1</h2>
					<p>Foo</p>
					<h3>Header #2.1.1</h3>
					<p>Foo</p>
					<h2>Header #2.2</h2>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 1,
						'label' => 'Header #2',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 3,
						'level' => 2,
						'label' => 'Header #2.1',
						'parentIdentifier' => 2
					),
					array(
						'identifier' => 4,
						'level' => 3,
						'label' => 'Header #2.1.1',
						'parentIdentifier' => 3
					),
					array(
						'identifier' => 5,
						'level' => 2,
						'label' => 'Header #2.2',
						'parentIdentifier' => 2
					)
				)
			),
			*/
			7 => array(
				'content' => '
					<h1>Header #1</h1>
					<p>Foo</p>
					<h1>Header #2</h1>
					<p>Foo</p>
					<h2>Header #2.1</h2>
					<p>Foo</p>
					<h5>Header #2.1.1.1.1</h5>
					<p>Foo</p>
					<h4>Header #2.1.1.1</h4>
					<p>Foo</p>
					<h2>Header #2.2</h2>
					<p>Foo</p>
				',
				'expected' => array(
					array(
						'identifier' => 1,
						'level' => 1,
						'label' => 'Header #1',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 2,
						'level' => 1,
						'label' => 'Header #2',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 3,
						'level' => 2,
						'label' => 'Header #2.1',
						'parentIdentifier' => 2
					),
					array(
						'identifier' => 4,
						'level' => 5,
						'label' => 'Header #2.1.1.1.1',
						'parentIdentifier' => 3
					),
					array(
						'identifier' => 5,
						'level' => 4,
						'label' => 'Header #2.1.1.1',
						'parentIdentifier' => 3
					),
					array(
						'identifier' => 6,
						'level' => 2,
						'label' => 'Header #2.2',
						'parentIdentifier' => 2
					)
				)
			)
		);
	}

	/**
	 * @test
	 * @dataProvider extractDocumentNavigationReturnHeadersWithLevelInformationDataProvider
	 */
	public function extractDocumentNavigationReturnHeadersWithLevelInformation($content, $expected) {
		$contentService = new ContentService();
		$this->assertSame($expected, $contentService->extractDocumentNavigation($content));
	}
}
