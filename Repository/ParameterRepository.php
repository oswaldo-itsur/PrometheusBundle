<?php

namespace Informatica\PrometheusBundle\Repository;

use OpenSky\Bundle\RuntimeConfigBundle\Entity\ParameterRepository as BaseParameterRepository;
use Symfony\Component\Yaml\Inline;

class ParameterRepository extends BaseParameterRepository
{
    public function getParametersAsKeyValueHash()
    {
        return array_map(
            function($v){ return Inline::load($v); },
            parent::getParametersAsKeyValueHash()
        );
     }
}