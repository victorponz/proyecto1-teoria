<?php
namespace ProyectoWeb\database;

use  ProyectoWeb\exceptions\QueryException;
use  ProyectoWeb\exceptions\NotFoundException;
use  ProyectoWeb\core\App;
use  ProyectoWeb\entity\Entity;

abstract class QueryBuilder
{
    /**
     *
     * @var PDO
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $classEntity;

    public function __construct(string $table, string $classEntity)
    {
        $this->connection =  App::get('connection');
        $this->table = $table;
        $this->classEntity = $classEntity;
    }
    public function executeQuery($sql){
        try {
            $pdoStatement = $this->connection->prepare($sql);
            $pdoStatement->execute();
            $pdoStatement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "ProyectoWeb\\entity\\" . $this->classEntity);
            return $pdoStatement->fetchAll();
        }catch(\PDOException $pdoException){
            throw new QueryException('No se ha podido ejecutar la consulta solicitada: ' . $pdoException->getMessage());
        }
    }
    public function findAll(){
        $sql = "SELECT * FROM $this->table";
        return $this->executeQuery($sql);
    }

    public function findById(int $id){
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        $result = $this->executeQuery($sql);
        if (empty($result)){
            throw new NotFoundException("No se ha encontrado ningún elemento con id $id");
        }
        return $result [0];
    }
  
    /**
     * @param array $parameters
     * @return string
     */
    private function getUpdates(array $parameters): string
    {
        $updates = "";
        foreach ($parameters as $key => $value) {
            if ($key !== 'id'){
                if ($updates !== ''){
                    $updates .= ", ";
                }
                $updates .= $key . "=:" . $key;
            }
        }
        return $updates;
        
    }

    /**
     * @param Entity $entity
     * @throws QueryException
     */
    public function update(Entity $entity)
    {
    try{
            $parameters = $entity->toArray();
            $sql = sprintf(
                'UPDATE %s SET %s WHERE id = :id ',
                $this->table,
                $this->getUpdates($parameters)
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);

        }catch (\PDOException $pdoException){
            throw new QueryException("Error al actualizar el elemento con id {$parameters['id']}: " . $pdoException->getMessage() );
        }
    }
    /** 
    * @param Entity $entity
    * @throws QueryException
    */
   public function save(Entity $entity)
   {
       try{
           $parameters = $entity->toArray();
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

    public function executeTransaction(callable $fnExecuteQuerys)
    {
        try{
            $this->connection->beginTransaction();
            $fnExecuteQuerys();
            $this->connection->commit();
        }catch (\PDOException $pdoException){
            $this->connection->rollBack();
            throw new QueryException("No se ha podido realizar la operación: " . $pdoException->getMessage());
        }
    }
} 