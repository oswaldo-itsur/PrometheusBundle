<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\PreguntaEvaluable
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\PreguntaEvaluableRepository")
 */
class PreguntaEvaluable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**
     * @var integer $orden
     *
     * @ORM\Column(name="orden", type="integer")
     */
    protected $orden;
    
    

    /**
     * @var text $respuesta
     *
     * @ORM\Column(name="respuesta", type="text")
     */
    private $respuesta;
    
    
    /**
     * @var text $valor
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     *
     * @ORM\ManyToOne(targetEntity="HojaRespuestas",inversedBy="preguntas")
     * @ORM\JoinColumn(name="hoja_id", referencedColumnName="id")
     */
    protected $hoja;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     */
    protected $pregunta;
    
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set respuesta
     *
     * @param text $respuesta
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;
    }

    /**
     * Get respuesta
     *
     * @return text 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set hoja
     *
     * @param Informatica\PrometheusBundle\Entity\HojaRespuestas $hoja
     */
    public function setHoja(\Informatica\PrometheusBundle\Entity\HojaRespuestas $hoja)
    {
        $this->hoja = $hoja;
    }

    /**
     * Get hoja
     *
     * @return Informatica\PrometheusBundle\Entity\HojaRespuestas 
     */
    public function getHoja()
    {
        return $this->hoja;
    }

    /**
     * Set pregunta
     *
     * @param Informatica\PrometheusBundle\Entity\Pregunta $pregunta
     */
    public function setPregunta(\Informatica\PrometheusBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    }

    /**
     * Get pregunta
     *
     * @return Informatica\PrometheusBundle\Entity\Pregunta 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Get valor
     *
     * @return integer 
     */
    public function getValor()
    {
        return $this->valor;
    }
}