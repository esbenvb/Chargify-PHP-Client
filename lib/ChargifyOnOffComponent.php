<?php
 
//Reference Documentation: http://support.chargify.com/faqs/technical/quantity-based-components

class ChargifyOnOffComponent extends ChargifyBase 
{
	//******************************
	//** INPUT & OUTPUT VARIABLES **
	//******************************
	var $enabled;
	var $component_id;
	
	//******************************
	//*** OUTPUT ONLY VARIABLES ****
	//******************************	
	var $name;
	var $kind;
	var $subscription_id;
	var $unit_name;
		
	private $connector;
	public function __construct(SimpleXMLElement $usage_xml_node = null, $test_mode = false)
	{
		$this->connector = new ChargifyConnector($test_mode);
		if ($usage_xml_node) {
			//Load object dynamically and convert SimpleXMLElements into strings
			foreach($usage_xml_node as $key => $element) { 
				$this->$key = (string)$element; 
			}
		}
	}
	
	protected function getName() {
		return "component";
	}

	public function enable($subscription_id, $component_id) {
    $this->enabled = 'on';
		return $this->connector->updateOnOffComponent($subscription_id, $component_id, $this);
	}
	
	public function disable($subscription_id, $component_id) {
    $this->enabled = 'off';
		return $this->connector->updateOnOffComponent($subscription_id, $component_id, $this);
	}
	
	public function get($subscription_id, $component_id) {
		return $this->connector->getOnOffComponent($subscription_id, $component_id, $this);	
	}

}?>