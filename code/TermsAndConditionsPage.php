<?php

class TermsAndConditionsPage extends Page {

	static $icon = "termsandconditions/images/treeicons/TermsAndConditionsPage";

	public function canCreate($member = null) {
		return DataObject::get_one('TermsAndConditionsPage') == null;
	}
}

class TermsAndConditionsPage_Controller extends Page_Controller {
}
