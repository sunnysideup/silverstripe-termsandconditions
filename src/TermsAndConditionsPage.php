<?php

class TermsAndConditionsPage extends Page
{
    private static $icon = "termsandconditions/images/treeicons/TermsAndConditionsPage";

    public function canCreate($member = null)
    {
        return TermsAndConditionsPage::get()->count ? false : true;
    }
}

class TermsAndConditionsPage_Controller extends Page_Controller
{
}
