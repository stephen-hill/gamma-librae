<?php

namespace GammaLibrae\Actions;

use DateTime;
use DOMDocument;

class GetAlbumList2
{
    public function run($request)
    {
        // Create a new DOMDocument
        $doc = new DOMDocument('1.0', 'UTF-8');

        // Create the root element <subsonic-response> and set attributes
        $subsonicResponse = $doc->createElementNS('http://subsonic.org/restapi', 'subsonic-response');
        $subsonicResponse->setAttribute('status', 'ok');
        $subsonicResponse->setAttribute('version', '1.16.0');

        // Create the <albumList2> element and set attributes
        $list = $doc->createElement('albumList2');

        // Loops
        for($i = 1; $i < 10; $i++)
        {
            $album = $doc->createElement('album');
            $album->setAttribute('id', $i);
            $album->setAttribute('name', "Album #{$i}");
            $album->setAttribute('songCount', random_int(1,40));

            $list->appendChild($album);
        }

        $subsonicResponse->appendChild($list);

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
