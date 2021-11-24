<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\database\QueryBuilder;
use ProyectoWeb\entity\Entity;
use ProyectoWeb\security\IPasswordGenerator;
use ProyectoWeb\entity\Usuario;
use ProyectoWeb\exceptions\QueryException;
use ProyectoWeb\exceptions\NotFoundException;

class UsuarioRepository extends QueryBuilder
{
    /**
     * Generador de password
     *
     * @var IPasswordGenerator
     */
    private $passwordGenerator;

    public function __construct(IPasswordGenerator $passwordGenerator){
        $this->passwordGenerator = $passwordGenerator;
        parent::__construct('users', 'Usuario');
    }
    /**
     * Devuelve el usuario identificado por $username y $password
     *
     * @param string $username
     * @param string $password
     * @return Usuario
     */
    public function findByUserNameAndPassword(string $username, string $password): Usuario{
        $sql = "SELECT * FROM $this->table WHERE username = :username";
        $parameters = ['username' => $username];

        try {
            $statement = $this->connection->prepare($sql);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "ProyectoWeb\\entity\\" . $this->classEntity);
            $statement->execute($parameters);
            $result =  $statement->fetch();
            if (empty($result)){
                throw new NotFoundException("No se ha encontrado ningún usuario con esas credenciales");
            } else {
                if (!$this->passwordGenerator::passwordVerify($password, $result->getPassword())) {
                    throw new NotFoundException("No se ha encontrado ningún usuario con esas credenciales");
                }
            }
            return $result;
        }catch(\PDOException $pdoException){
            throw new QueryException('No se ha podido ejecutar la consulta solicitada: ' . $pdoException->getMessage());
        }
        return null;
    }

    /** 
    * @param Entity $entity
    * @throws QueryException
    */
    public function save(Entity $entity)
    {
        try{
            $parameters = $entity->toArray();
            $parameters['password'] = $this->passwordGenerator::encrypt($parameters['password']);
            $sql = sprintf(
                'INSERT INTO %s (%s) values (%s)',
                $this->table,
                implode(', ', array_keys($parameters)),
                ':'. implode(', :', array_keys($parameters))
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);

        }catch (\PDOException $pdoException){
            throw new QueryException("Error al insertar en la base de datos: " . $pdoException->getMessage());
        }
    }
}