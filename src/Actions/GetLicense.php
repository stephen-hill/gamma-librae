<?php

namespace GammaLibrae\Actions;

use DateTime;
use DOMDocument;

class GetLicense
{
    public function run($request)
    {
        // Create a new DOMDocument
        $doc = new DOMDocument('1.0', 'UTF-8');

        // Create the root element <subsonic-response> and set attributes
        $subsonicResponse = $doc->createElementNS('http://subsonic.org/restapi', 'subsonic-response');
        $subsonicResponse->setAttribute('status', 'ok');
        $subsonicResponse->setAttribute('version', '1.16.0');

        // Create the <license> element and set attributes
        $license = $doc->createElement('license');
        $license->setAttribute('valid', 'true');
        $license->setAttribute('email', 'foo@example.com');
        $license->setAttribute('licenseExpires', (new DateTime('+1year'))->format('Y-m-d\TH:i:s'));
        $subsonicResponse->appendChild($license);

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
