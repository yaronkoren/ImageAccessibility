<?php

/**
 * A special page for displaying an Image Accessbility "file description".
 *
 * @author Yaron Koren
 */

use MediaWiki\MediaWikiServices;

class IAShowFileDescription extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ShowFileDescription' );
	}

	/** @inheritDoc */
	public function execute( $query ) {
		$this->getOutput()->disable();
		$this->setHeaders();

		$fileName = $query;
		$title = Title::makeTitleSafe( NS_FILE_DESCRIPTION, $fileName );
		if ( $title === null ) {
			return;
		}

		$user = $this->getUser();
		$permissionManager = MediaWikiServices::getInstance()->getPermissionManager();
		if ( !$permissionManager->userCan( 'read', $user, $title ) ) {
			return true;
		}

		$wikiPage = WikiPage::factory( $title );
		$pageText = ContentHandler::getContentText( $wikiPage->getContent() );
		$parser =  MediaWikiServices::getInstance()->getParser();
		$parser->mOptions = ParserOptions::newFromUser( $user );
		$renderedText = $parser->parse( $pageText, $title, $parser->mOptions )->getText();
		$text =<<<END
<html>
<head>
<title>Long description for $fileName</title>
</head>
<body style="margin: 30px; max-width: 960px;">
$renderedText
<hr style="margin: 20px 0;" />
<a href="#" onclick="history.go(-1);return false;">Go back</a>
</body>
</html>

END;
		print $text;
	}

	/** @inheritDoc */
	protected function getGroupName() {
		return 'pagetools';
	}

}
