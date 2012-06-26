<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\Asignatura
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\AsignaturaRepository")
 */
class Asignatura
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
     * @var string $clave
     *
     * @ORM\Column(name="clave", type="string", length=8)
     */
    private $clave;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string $carrera
     *
     * @ORM\Column(name="carrera", type="string", length=50)
     */
    private $carrera;

    /**
     * @var string $unidades
     *
     * @ORM\Column(name="unidades", type="string", length=2)
     */
    private $unidades;


    /**
     * @var $docentes
     *
     * @ORM\ManyToMany(targetEntity="Docente", inversedBy="docentes")
     * @ORM\JoinTable(name="docentes_asignaturas")
     */
    private $docentes;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Examen", mappedBy="asignatura")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $examenes;
    
    
     /**
     *
     * @ORM\OneToMany(targetEntity="Pregunta", mappedBy="asignatura")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $preguntas;



    public function __construct() {
        $this->docentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examenes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set clave
     *
     * @param string $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set carrera
     *
     * @param string $carrera
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;
    }

    /**
     * Get carrera
     *
     * @return string 
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set unidades
     *
     * @param string $unidades
     */
    public function setUnidades($unidades)
    {
        $this->unidades = $unidades;
    }

    /**
     * Get unidades
     *
     * @return string 
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Add docentes
     *
     * @param Informatica\PrometheusBundle\Entity\Docente $docentes
     */
    public function addDocente(\Informatica\PrometheusBundle\Entity\Docente $docentes)
    {
        $this->docentes[] = $docentes;
    }

    /**
     * Get docentes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocentes()
    {
        return $this->docentes;
    }

    /**
     * Add examenes
     *
     * @param Informatica\PrometheusBundle\Entity\Examen $examenes
     */
    public function addExamen(\Informatica\PrometheusBundle\Entity\Examen $examenes)
    {
        $this->examenes[] = $examenes;
    }

    /**
     * Get examenes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getExamenes()
    {
        return $this->examenes;
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