<?php
$xml = Xml::fromArray(array('response' => $users));
echo $xml->asXML();
?>