<?php

function get_from_url($url) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => "CM4025 RSS Reader"
    ]);

    $data = curl_exec($curl);

    curl_close($curl);

    return $data;
}

function parse_rss_data($data) {
    $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA | LIBXML_NOBLANKS);

    $items = [];

    foreach($xml->channel->item as $item) {
        array_push($items, [
            "title" => $item->title->__toString(),
            "link" => $item->link->__toString(),
            "description" => $item->description->__toString(),
            "date" => new DateTime($item->pubDate->__toString()),
            "guid" => $item->guid->__toString(),
        ]);
    }

    return $items;
}

?>