<?php

use MediaWiki\MediaWikiServices;

class ImageAccessibility {

	public static function registerNamespaces( array &$list ) {
		if ( !defined( 'NS_FILE_DESCRIPTION' ) ) {
			define( 'NS_FILE_DESCRIPTION', 631 );
			define( 'NS_FILE_DESCRIPTION_TALK', 631 );
		}

		$list[NS_FILE_DESCRIPTION] = 'File_description';
		$list[NS_FILE_DESCRIPTION_TALK] = 'File_description_talk';

		return true;
	}

	public static function addRLModules( OutputPage $out, Skin $skin ) {
		$out->addModules( 'ext.imageaccessibility' );
		return true;
	}

	public static function addLongDescURL( ThumbnailImage $thumbnail, array &$attribs, &$linkAttribs ) {
		global $wgTitle;

		$imageName = $thumbnail->getFile()->getName();
		$fileDescPage = Title::makeTitleSafe( NS_FILE_DESCRIPTION, $imageName );

		if ( $wgTitle && $wgTitle->getNamespace() == NS_FILE ) {
			if ( !$fileDescPage->exists() ) {
				$fileDescURL = $fileDescPage->getInternalURL( [ 'action' => 'edit', 'redlink' => '1' ]);
				$attribs['data-create-long-desc-url'] = $fileDescURL;
			} else {
				$fileDescURL = $fileDescPage->getInternalURL();
				$attribs['data-view-long-desc-url'] = $fileDescURL;
			}
			return true;
		}

		if ( !$fileDescPage->exists() ) {
			return true;
		}
		if ( method_exists( 'MediaWiki\MediaWikiServices', 'getSpecialPageFactory' ) ) {
			// MW 1.32+
			$showFileDescPage = MediaWikiServices::getInstance()
				->getSpecialPageFactory()
				->getPage( 'ShowFileDescription' );
		} else {
			/** @phan-suppress-next-line PhanUndeclaredClassMethod */
			$showFileDescPage = SpecialPageFactory::getPage( 'ShowFileDescription' );
		}
		$longDescURL = $showFileDescPage->getPageTitle()->getInternalURL() . '/' . $imageName;
		$attribs['data-long-desc-url'] = $longDescURL;

		return true;
	}

}
