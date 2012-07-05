<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\Pregunta
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\PreguntaRepository")
 */
class Pregunta
{
    const SELECCIONMULTIPLE ='Selección Mutliple';
    const SELECCIONUNICA ='Selección Única';
    const ANOTACION='Anotación';
    
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text $sentencia
     *
     * @ORM\Column(name="sentencia", type="text")
     */
    private $sentencia;

    /**
     * @var text $opcion1
     *
     * @ORM\Column(name="opcion1", type="text")
     */
    private $opcion1;

    /**
     * @var text $opcion2
     *
     * @ORM\Column(name="opcion2", type="text")
     */
    private $opcion2;

    /**
     * @var text $opcion3
     *
     * @ORM\Column(name="opcion3", type="text")
     */
    private $opcion3;

    /**
     * @var text $respuesta
     *
     * @ORM\Column(name="respuesta", type="text")
     */
    private $respuesta;

    /**
     * @var decimal $valor
     *
     * @ORM\Column(name="valor", type="decimal")
     */
    private $valor;

    /**
     * @var string $tema
     *
     * @ORM\Column(name="tema", type="string", length=10)
     */
    private $tema;

    /**
     * @var integer $noUnidad
     *
     * @ORM\Column(name="noUnidad", type="integer")
     */
    private $noUnidad;


    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length="20")
     */
    private $tipo;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="preguntas")
     * @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     */
     private $asignatura;

     /**
     *
     * @ORM\ManyToOne(targetEntity="Examen",inversedBy="preguntas")
     * @ORM\JoinColumn(name="examen_id", referencedColumnName="id")
     */
     private $examen;
    
    
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
     * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    
    /**
     * Set sentencia
     *
     * @param text $sentencia
     */
    public function setSentencia($sentencia)
    {
        $this->sentencia = $sentencia;
    }

    /**
     * Get sentencia
     *
     * @return text 
     */
    public function getSentencia()
    {
        return $this->sentencia;
    }

    /**
     * Set opcion1
     *
     * @param text $opcion1
     */
    public function setOpcion1($opcion1)
    {
        $this->opcion1 = $opcion1;
    }

    /**
     * Get opcion1
     *
     * @return text 
     */
    public function getOpcion1()
    {
        return $this->opcion1;
    }

    /**
     * Set opcion2
     *
     * @param text $opcion2
     */
    public function setOpcion2($opcion2)
    {
        $this->opcion2 = $opcion2;
    }

    /**
     * Get opcion2
     *
     * @return text 
     */
    public function getOpcion2()
    {
        return $this->opcion2;
    }

    /**
     * Set opcion3
     *
     * @param text $opcion3
     */
    public function setOpcion3($opcion3)
    {
        $this->opcion3 = $opcion3;
    }

    /**
     * Get opcion3
     *
     * @return text 
     */
    public function getOpcion3()
    {
        return $this->opcion3;
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
     * Set valor
     *
     * @param decimal $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Get valor
     *
     * @return decimal 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set tema
     *
     * @param string $tema
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
    }

    /**
     * Get tema
     *
     * @return string 
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set noUnidad
     *
     * @param integer $noUnidad
     */
    public function setNoUnidad($noUnidad)
    {
        $this->noUnidad = $noUnidad;
    }

    /**
     * Get noUnidad
     *
     * @return integer 
     */
    public function getNoUnidad()
    {
        return $this->noUnidad;
    }

    /**
     * Set asignatura
     *
     * @param Informatica\PrometheusBundle\Entity\Asignatura $asignatura
     */
    public function setAsignatura(\Informatica\PrometheusBundle\Entity\Asignatura $asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Get asignatura
     *
     * @return Informatica\PrometheusBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set examen
     *
     * @param Informatica\PrometheusBundle\Entity\Examen $examen
     */
    public function setExamen(\Informatica\PrometheusBundle\Entity\Examen $examen)
    {
        $this->examen = $examen;
    }

    /**
     * Get examen
     *
     * @return Informatica\PrometheusBundle\Entity\Examen 
     */
    public function getExamen()
    {
        return $this->examen;
    }

}