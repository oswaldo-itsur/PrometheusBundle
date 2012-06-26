<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\Examen
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\ExamenRepository")
 */
class Examen
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
     * @var date $fecha
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var time $hora
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var integer $nounidades
     *
     * @ORM\Column(name="nounidades", type="integer")
     */
    private $nounidades;

    /**
     * @var string $nombreUnidad
     *
     * @ORM\Column(name="nombreUnidad", type="string", length=255)
     */
    private $nombreUnidad;

    /**
     * @var string $opcion
     *
     * @ORM\Column(name="opcion", type="string", length=25)
     */
    private $opcion;

    /**
     * @var decimal $ponderacion
     *
     * @ORM\Column(name="ponderacion", type="decimal")
     */
    private $ponderacion;

    /**
     * @var string $periodo
     *
     * @ORM\Column(name="periodo", type="string", length=15)
     */
    private $periodo;

    /**
     * @var integer $anio
     *
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;
    

    /**
     *
     * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="examanes")
     * @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     */
     private $asignatura;
     
     
    /**
     *
     * @ORM\ManyToOne(targetEntity="Docente",inversedBy="docentes")
     * @ORM\JoinColumn(name="docente_id", referencedColumnName="id")
     */
     private $docente;
     
     
     /**
     *
     * @ORM\ManyToOne(targetEntity="Alumno")
     * @ORM\JoinColumn(name="alumno_id", referencedColumnName="id")
     */
    protected $alumno;
     
     
      /**
     *
     * @ORM\OneToMany(targetEntity="Pregunta", mappedBy="examen")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $preguntas;



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
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return date 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param time $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * Get hora
     *
     * @return time 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set nounidades
     *
     * @param integer $nounidades
     */
    public function setNounidades($nounidades)
    {
        $this->nounidades = $nounidades;
    }

    /**
     * Get nounidades
     *
     * @return integer 
     */
    public function getNounidades()
    {
        return $this->nounidades;
    }

    /**
     * Set nombreUnidad
     *
     * @param string $nombreUnidad
     */
    public function setNombreUnidad($nombreUnidad)
    {
        $this->nombreUnidad = $nombreUnidad;
    }

    /**
     * Get nombreUnidad
     *
     * @return string
     */
    public function getNombreUnidad()
    {
        return $this->nombreUnidad;
    }

    /**
     * Set opcion
     *
     * @param string $opcion
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;
    }

    /**
     * Get opcion
     *
     * @return string 
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set ponderacion
     *
     * @param decimal $ponderacion
     */
    public function setPonderacion($ponderacion)
    {
        $this->ponderacion = $ponderacion;
    }

    /**
     * Get ponderacion
     *
     * @return decimal 
     */
    public function getPonderacion()
    {
        return $this->ponderacion;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * Get anio
     *
     * @return integer 
     */
    public function getAnio()
    {
        return $this->anio;
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
     * Set docente
     *
     * @param Informatica\PrometheusBundle\Entity\Docente $docente
     */
    public function setDocente(\Informatica\PrometheusBundle\Entity\Docente $docente)
    {
        $this->docente = $docente;
    }

    /**
     * Get docente
     *
     * @return Informatica\PrometheusBundle\Entity\Docente 
     */
    public function getDocente()
    {
        return $this->docente;
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
     * @param Informatica\PrometheusBundle\Entity\Pregunta $preguntas
     */
    public function addPregunta(\Informatica\PrometheusBundle\Entity\Pregunta $preguntas)
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