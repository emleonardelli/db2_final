<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class Cliente
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     */
    protected $apellido;

    /**
     * @ORM\Column(type="string")
     */
    protected $dni;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
    * @param $nombre
    * @param $apellido
    * @param $dni
    * @param $email
    */
    public function __construct($nombre, $apellido, $dni,  $email)
    {
      $this->id = null;
      $this->nombre = $nombre;
      $this->apellido = $apellido;
      $this->dni = $dni;
      $this->email = $email;
    }

    public function getId(){return $this->id;}

    public function getNombre(){return $this->nombre;}
    public function getApellido(){return $this->apellido;}
    public function getDni(){return $this->dni;}
    public function getEmail(){return $this->email;}

    public function setNombre($data)   {$this->nombre = $data;}
    public function setApellido($data) {$this->apellido = $data;}
    public function setDni($data)      {$this->dni = $data;}
    public function setEmail($data)    {$this->email = $data;}
}