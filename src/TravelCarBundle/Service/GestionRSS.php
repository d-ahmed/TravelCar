<?php
/**
 * Created by PhpStorm.
 * User: danielahmed
 * Date: 08/03/2017
 * Time: 19:20
 */

namespace TravelCarBundle\Service;

use Psr\Log\LoggerInterface;
use TravelCarBundle\Modele\Item;

class GestionRSS
{
    private $link;

    private $logger;

    private $rss;

    public function __construct($link, LoggerInterface $logger)
    {
        $this->link = $link;
        $this->logger = $logger;
    }

    public function load()
    {
        try {
            $this->rss = new \SimpleXMLElement($this->link, null, true);
            $this->logger->debug('load_rss', array('link'=>$this->link, 'response'=>$this->rss));
            $channel = $this->rss->channel;

            $items = array();
            foreach ($channel->item as $item) {
                $itemObject= new Item();
                $itemObject->setDescription((string)$item->description);
                $itemObject->setLink((string)$item->link);
                $itemObject->setTitle((string)$item->title);
                $itemObject->setPubDate((string)$item->pubDate);
                $itemObject->setEnclosure((string)$item->enclosure->attributes()['url']);
                $items [] = $itemObject;
            }



            return $items;
        } catch (\Exception $e) {
            $this->logger->error('load_rss', array('link'=>$this->link, 'message'=> $e->getMessage()));
        }
    }
}
