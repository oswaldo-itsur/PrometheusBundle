<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\HojaRespuestas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\HojaRespuestasRepository")
 */
class HojaRespuestas
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
     * @var datetime $fecha
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var decimal $calificacion
     *
     * @ORM\Column(name="calificacion", type="decimal")
     */
    private $calificacion;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Examen")
     * @ORM\JoinColumn(name="examen_id", referencedColumnName="id")
     */
    protected $examen;
    
         
     /**
     *
     * @ORM\ManyToOne(targetEntity="Alumno")
     * @ORM\JoinColumn(name="alumno_id", referencedColumnName="id")
     */
    protected $alumno;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="PreguntaEvaluable", mappedBy="hoja", cascade={"persist", "merge"})
     * @ORM\OrderBy({"orden" = "ASC"})
     */
    protected $preguntas;
    
    
    public function __construct() {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set fecha
     *
     * @param datetime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return datetime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set calificacion
     *
     * @param decimal $calificacion
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;
    }

    /**
     * Get calificacion
     *
     * @return decimal 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
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
    
    /**
     * Set alumno
     *
     * @param Informatica\PrometheusBundle\Entity\Alumno $alumno
     */
    public function setAlumno(\Informatica\PrometheusBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;
    }

    /**
     * Get alumno
     *
     * @return Informatica\PrometheusBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Add preguntas
     *
     * @param Informatica\PrometheusBundle\Entity\PreguntaEvaluable $preguntas
     */
    public function addPreguntaEvaluable(\Informatica\PrometheusBundle\Entity\PreguntaEvaluable $preguntas)
    {
        $this->preguntas[] = $preguntas;
    }

    /**
     * Get preguntas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }
}