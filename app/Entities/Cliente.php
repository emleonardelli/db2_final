<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
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

    private function setNombre($data)   {$this->nombre = $data;}
    private function setApellido($data) {$this->apellido = $data;}
    private function setDni($data)      {$this->dni = $data;}
    private function setEmail($data)    {$this->email = $data;}

    public function actualizarDatos($nombre, $apellido, $dni, $email){
      $this->nombre = $nombre;
      $this->apellido = $apellido;
      $this->dni = $dni;
      $this->email = $email;
    }
}