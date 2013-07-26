<?php
 
//Reference Documentation: http://docs.chargify.com/api-webhooks

class ChargifyWebHook extends ChargifyBase 
{
	//******************************
	//*** OUTPUT ONLY VARIABLES ****
	//******************************	
	var $id;
	var $type;
	var $payload;
	
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
		return "webhook";
	}

	public function replay($webhook_ids) {
    return empty($webhook_ids) ? FALSE : $this->connector->replayWebHooks($webhook_ids);
	}
	
	public function getAll($options = array()) {
		return $this->connector->getAllWebHooks($options);
	}
}?>
