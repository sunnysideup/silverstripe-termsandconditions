<?php
/**
 * EditableCheckbox
 * A user modifiable checkbox on a UserDefinedForm
 *
 * @package userforms
 */

class EditableTermsAndConditionsCheckbox extends EditableFormField {

	static $singular_name = 'Terms and Conditions Checkbox';

	static $plural_name = 'Terms and Conditions Checkboxes';

	static $has_one = array(
		"TandCPage" => "SiteTree"
	);

	public function getFieldConfiguration() {
		$options = parent::getFieldConfiguration();
		$options->push(new CheckboxField("Fields[$this->ID][CustomSettings][Default]", _t('EditableFormField.CHECKEDBYDEFAULT', 'Checked by Default?'), $this->getSetting('Default')));

		$defaultID = ($this->getSetting('TandCPageID')) ? $this->getSetting('TandCPageID') : 0;
		$pages = DataObject::get("TermsAndConditionsPage");
		if($pages) {
			$source = $pages->toDropDownMap("ID", "Title", "--- Make sure to select this ---");
			$options->push(new DropdownField("Fields[$this->ID][CustomSettings][TandCPageID]", "What is your Terms and Conditions page?  This will be added as a link to the end of your field title.", $source, $defaultID));
		}
		else {
			$options->push(new LiteralField("Fields[$this->ID][CustomSettings][TandCPageID]", "<p>You need to add a Terms and Conditions page before you can link to it (which is usually what you do here).</p>"));
		}
		return $options;
	}

	public function getFormField() {
		$id = intval($this->getSetting('TandCPageID')) - 0;
		$page = DataObject::get_by_id("TermsAndConditionsPage", $id);
		$extraHTML = '';
		if($page) {
			$extraHTML = ' <span class="linkToTermsAndConditionsPage"><a href="'.$page->Link().'" class="externalLink" target="_blank">'.$page->Title.'</a></span>';
		}
		return new CheckboxField( $this->Name, $this->Title.$extraHTML, $this->getSetting('Default'));
	}

	public function getValueFromData($data) {
		$value = (isset($data[$this->Name])) ? $data[$this->Name] : false;
		return ($value) ? _t('EditableFormField.YES', 'Yes') : _t('EditableFormField.NO', 'No');
	}

	public function Icon() {
		return 'termsandconditions/images/' . strtolower($this->class) . '.png';
	}

	function onBeforeWrite() {
		parent::onBeforeWrite();
		$this->Required = true;
	}

}
