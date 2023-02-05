<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Log\Logger;

class SpamFinder
{
    private LoggerInterface $logger;
    private RequestStack $request;
    private array $combinaisons;

    public function __construct(LoggerInterface $l, RequestStack $req)
    {
        $this->logger = $l;
        $this->request = $req;
    }

    public function isSpam(string $text): bool
    {
        $isSpam = false;
        // vérif
        $isAhahahaha = false;
        for($combSize = 1; $combSize < 9 && $combSize < (strlen($text)/2)+1; $combSize++)
        {
            $this->combinaisons = array();
            for($i = 0; ($i+$combSize) < strlen($text); $i+=$combSize)
            {
                $this->incrementCombinaison(substr($text, $i, $combSize));
            }
            //dump($this->combinaisons);
            if(count($this->combinaisons) <= 1)
            {
                $comb = array_keys($this->combinaisons)[0];
                if($comb == 'ah' || $comb == 'ha')
                {
                    $isAhahahaha = true;
                }else{
                    $isSpam = true;
                }
                break;
            }
        }

        $isSpam = $isSpam && !$isAhahahaha;
        if($isSpam)
        {
            $source = $this->request->getCurrentRequest()->getClientIp();
            $this->logger->info('Le message est un spam (' . $source . ') : ' . $text);
        }
        return $isSpam;
    }


    private function incrementCombinaison(string $l) : void
    {
        if(array_key_exists($l, $this->combinaisons))
        {
            $this->combinaisons[$l]++;
        }else{
            $this->combinaisons[$l] = 0;
        }
    }

}