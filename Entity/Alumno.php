<?php

namespace Informatica\PrometheusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informatica\PrometheusBundle\Entity\Alumno
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Informatica\PrometheusBundle\Repository\AlumnoRepository")
 */
class Alumno
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
     * @var string $nocontrol
     *
     * @ORM\Column(name="nocontrol", type="string", length=10)
     */
    private $nocontrol;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string $correo
     *
     * @ORM\Column(name="correo", type="string", length=100)
     */
    private $correo;

    /**
     * @var string $contrasena
     *
     * @ORM\Column(name="contrasena", type="string", length=10)
     */
    private $contrasena;
    
    
    
    /**
     * @var $grupos
     *
     * @ORM\ManyToMany(targetEntity="Grupo", mappedBy="alumnos")
     */
    private $grupos;
    
    
    public function __construct() {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nocontrol
     *
     * @param string $nocontrol
     */
    public function setNocontrol($nocontrol)
    {
        $this->nocontrol = $nocontrol;
    }

    /**
     * Get nocontrol
     *
     * @return string 
     */
    public function getNocontrol()
    {
        return $this->nocontrol;
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
     * Set correo
     *
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Add grupos
     *
     * @param Informatica\PrometheusBundle\Entity\Grupo $grupos
     */
    public function addGrupo(\Informatica\PrometheusBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;
    }

    /**
     * Get grupos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set contrasena
     *
     * @param string $contrasena
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    /**
     * Get contrasena
     *
     * @return string 
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }
    
}