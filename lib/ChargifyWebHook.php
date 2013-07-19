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

  protected function makeXMLList($ids) {
    $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><ids type = \"array\"/>"); //
    foreach ($ids as $id) {
      $element = $xml->addChild('id', $id);
      $element->addAttribute('type', 'integer');
    }
    return $xml->asXML();
  }  

	public function replay($webhook_ids) {
		//return empty($webhook_ids) ? FALSE : $this->connector->replayWebHooks($this->makeXMLList($webhook_ids));
    return empty($webhook_ids) ? FALSE : $this->connector->replayWebHooks($webhook_ids);
	}
	
	public function getAll($options = array()) {
		return $this->connector->getAllWebHooks($options);
	}
}?>
