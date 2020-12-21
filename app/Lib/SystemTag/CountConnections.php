<?php

namespace Exodus4D\Pathfinder\Lib\SystemTag;

use Exodus4D\Pathfinder\Model\Pathfinder\ConnectionModel;
use Exodus4D\Pathfinder\Model\Pathfinder\MapModel;
use Exodus4D\Pathfinder\Model\Pathfinder\SystemModel;
use Exodus4D\Pathfinder\Model\Universe\AbstractUniverseModel;
use Exodus4D\Pathfinder\Lib\SystemTag;

class CountConnections implements SystemTagInterface
{
    /**
     * @param SystemModel $targetSystem
     * @param SystemModel $sourceSystem
     * @param MapModel $map
     * @return string|null
     * @throws \Exception
     */
    static function generateFor(SystemModel $targetSystem, SystemModel $sourceSystem, MapModel $map) : ?string
    {                       
        $whConnections = array_filter($sourceSystem->getConnections(), function (ConnectionModel $connection) {
            return $connection->isWormhole();
        });
        $countWhConnections = count($whConnections);
        if($sourceSystem->locked){
            $countWhConnections++;
        }
        $parentTag          = $sourceSystem->tag;
        $systemTag          = "$parentTag$countWhConnections";  
                
        return max($systemTag, 1);
    }
}
