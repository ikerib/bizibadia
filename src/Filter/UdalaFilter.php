<?php

namespace App\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class UdalaFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->hasAssociation('udala') && $this->hasParameter('udala_id')) {
            return '('.$targetTableAlias.'.udala_id = '.$this->getParameter('udala_id').')';
        }

        return '';
    }
}
