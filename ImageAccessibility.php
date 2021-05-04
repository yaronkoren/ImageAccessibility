<?php

class ImageAccessibility {

        public static function addRLModules( OutputPage $out, Skin $skin ) {
                $out->addModules( 'ext.imageaccessibility' );
                return true;
        }

	public static function addLongDescURL( ThumbnailImage $thumbnail, array &$attribs, &$linkAttribs ) {
		global $wgTitle, $wgImageAccessibilitySuffix;

		$imageName = $thumbnail->getFile()->getTitle()->getFullText();
		$longDescPageName = $imageName . $wgImageAccessibilitySuffix;
		$longDescPage = Title::newFromText( $longDescPageName );

		if ( $wgTitle->getNamespace() == NS_FILE ) {
			if ( !$longDescPage->exists() ) {
				$longDescURL = $longDescPage->getInternalURL( [ 'action' => 'edit', 'redlink' => '1' ]);
				$attribs['data-create-long-desc-url'] = $longDescURL;
			} else {
				$longDescURL = $longDescPage->getInternalURL();
				$attribs['data-view-long-desc-url'] = $longDescURL;
			}
			return true;
		}

		if ( !$longDescPage->exists() ) {
			return true;
		}
		$longDescURL = $longDescPage->getInternalURL( [ 'action' => 'render' ]);
		$attribs['data-long-desc-url'] = $longDescURL;

		return true;
	}

}
