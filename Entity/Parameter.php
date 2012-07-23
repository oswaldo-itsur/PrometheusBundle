<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenSky\Bundle\RuntimeConfigBundle\Entity\Parameter as BaseParameter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Yaml\Inline;
use Symfony\Component\Yaml\ParserException;

/**
     * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\ParameterRepository")
     * @ORM\Table(
     *     name="parameters",
     *     uniqueConstraints={
     *         @ORM\UniqueConstraint(name="name_unique", columns={"name"})
     *     }
     * )
     * @Assert\Callback(methods={"validateValueAsYaml"})
     */
class Parameter extends BaseParameter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function validateValueAsYaml(ExecutionContext $context)
    {
        try {
            Inline::load($this->value);
        } catch (ParserException $e) {
            $context->setPropertyPath($context->getPropertyPath() . '.value');
            $context->addViolation('This value is not valid YAML syntax', array(), $this->value);
        }
    }
}