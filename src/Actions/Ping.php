<?php

namespace GammaLibrae\Actions;

use DOMDocument;

class Ping
{
    public function run($request)
    {
        // Create a new DOMDocument
        $doc = new DOMDocument('1.0', 'UTF-8');

        // Create the root element <subsonic-response> and set attributes
        $subsonicResponse = $doc->createElementNS('http://subsonic.org/restapi', 'subsonic-response');
        $subsonicResponse->setAttribute('status', 'ok');
        $subsonicResponse->setAttribute('version', '1.16.0');

        // Append the root element to the document
        $doc->appendChild($subsonicResponse);

        // Format the XML output
        $doc->formatOutput = true;

        // Output the XML
        $body = $doc->saveXML(null, LIBXML_NOEMPTYTAG);
        $etag = 'W/"' . sha1($body) . '"';
        header('access-control-allow-origin: *');
        header('content-type: text/xml; charset=utf-8');
        header('content-length: ' . strlen($body));
        header('etag: ' . $etag);
        echo $body;
    }
}
