<?php

namespace Exodus4D\Pathfinder\Lib\SystemTag;

use Exodus4D\Pathfinder\Model\Pathfinder\ConnectionModel;
use Exodus4D\Pathfinder\Model\Pathfinder\MapModel;
use Exodus4D\Pathfinder\Model\Pathfinder\SystemModel;
use Exodus4D\Pathfinder\Model\Universe\AbstractUniverseModel;

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
        // set target class for new system being added to the map
        $targetClass = $targetSystem->security;
        
        // Get all systems from active map
        $systems = $map->getSystemsData();
                
        // empty array to append tags to
        $tags = array();
        
        // iterate over systems and append tag to $tags if security matches targetSystem security
        foreach ($systems as $system) {
            if ($system->security === $targetClass) {
                array_push($tags, $system->tag);
            }
        };            
        
        // sort tags array and iterate to return first empty value
        sort($tags);
        $i = 0;
        while($tags[$i] == $i + 1) {
            $i++;
        }
        
        // REMOVE DEBUGGING
        $debugfile = fopen("debuglog.txt", "w");
        fwrite($debugfile, "security: $targetClass\n");
        $mapsize = count($systems);
        fwrite($debugfile, "map-size: $mapsize\n");
        fwrite($debugfile, print_r($tags, true));
        fwrite($debugfile, "i: $i\n");
        fclose($debugfile);
        
        return $i + 1;
    }
}
