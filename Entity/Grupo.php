<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\Grupo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\GrupoRepository")
 */
class Grupo
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
     * @ORM\Column(name="clave", type="string", length=10)
     */
    private $clave;

    /**
     * @var string $periodo
     *
     * @ORM\Column(name="periodo", type="string", length=30)
     */
    private $periodo;

    /**
     * @var integer $anio
     *
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;

    /**
     * @var integer $semestre
     *
     * @ORM\Column(name="semestre", type="integer")
     */
    private $semestre;


    /**
     * @var $alumnos
     *
     * @ORM\ManyToMany(targetEntity="Alumno", inversedBy="alumnos")
     * @ORM\JoinTable(name="alumnos_grupos")
     */
    private $alumnos;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Asignatura")
     * @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     */
    protected $asignatura;
    
    
    
     public function __construct() {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set semestre
     *
     * @param integer $semestre
     */
    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;
    }

    /**
     * Get semestre
     *
     * @return integer 
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Add alumnos
     *
     * @param Informatica\PrometheusBundle\Entity\Alumno $alumnos
     */
    public function addAlumnos(\Informatica\PrometheusBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos[] = $alumnos;
    }

    /**
     * Get alumnos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAlumnos()
    {
        return $this->alumnos;
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
}