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

        // If the source system is locked and has statics we assume it's our home always start from one when the source is locked
        $statics = $sourceSystem->get_statics();
	if($sourceSystem->locked && is_array($statics) && count($statics)) {
	    if($targetSystem->security == "C5") {
		return 1; // always return 1 for C5's from "Home"
	    }
        }

        // New connection did not start in "home" -> tag by counting connections
        // Dont +1 because we don't want to count one "incoming" connection
        // But never use 0 (e.g. when a new chain is opened from a K-space system)
        return max($countWhConnections, 1);                       
    }
}
