<?php
/**
 * SqlCounterRepository.
 *
 * saving counters to sql db.
 */
namespace OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Infrastructure\Persistence\Sql\SqlManager;

/**
 * Class SqlCounterRepository
 *
 * @package OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter
 */
class SqlCounterRepository implements CounterRepository, PersistentCounterRepository
{

    const TABLE_NAME = 'counters';
    /**
     * The sql manager that gives us pdo access
     * @var \OpenCounter\Infrastructure\Persistence\Sql\SqlManager
     */
    protected $manager;
    /**
     * updateStmt
     * @var \PDOStatement
     */
    private $updateStmt;
    /**
     * insertStmt
     *
     * @var \PDOStatement
     */
    private $insertStmt;
    /**
     * removeStmt
     * @var \PDOStatement
     */
    private $removeStmt;
    /**
     * removeNamedStmt
     * @var \PDOStatement
     */
    private $removeNamedStmt;
    /**
     * get statement
     * @var \PDOStatement
     */
    private $getStmt;

    /**
     * SqlCounterRepository constructor.
     *
     * @param \OpenCounter\Infrastructure\Persistence\Sql\SqlManager $manager
     */
    public function __construct(SqlManager $manager)
    {
        $this->manager = $manager;
        $this->removeStmt = $this->manager->prepare(
            sprintf('DELETE FROM %s WHERE uuid = :uuid', self::TABLE_NAME)
        );
        $this->getStmt = $this->manager->prepare(
            sprintf('SELECT * FROM %s WHERE name = :name', self::TABLE_NAME)
        );
        $this->removeNamedStmt = $this->manager->prepare(
            sprintf('DELETE FROM %s WHERE name = :name', self::TABLE_NAME)
        );
        $insert_string = 'INSERT INTO %s (name, uuid, value, status, password) 
                          VALUES (:name, :uuid, :value, :status, :password)';
        $this->insertStmt = $this->manager->prepare(

            sprintf($insert_string, self::TABLE_NAME)
        );
        $update_string = 'UPDATE %s SET value = :value, status = :status, password = :password 
                          WHERE uuid = :uuid';
        $this->updateStmt = $this->manager->prepare(
            sprintf($update_string, self::TABLE_NAME)
        );
    }

    /**
     * remove
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     */
    public function remove(Counter $anCounter)
    {
        $this->removeStmt->execute(['uuid' => $anCounter->getId()]);
    }

    /**
     * removeCounterByName()
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     */
    public function removeCounterByName(CounterName $aName)
    {
        $this->removeNamedStmt->execute(['name' => $aName->name()]);
    }

    /**
     * query
     *
     * {@inheritdoc}
     * @param mixed $specification
     *
     * @return array
     */
    public function query($specification)
    {
        if (!$specification instanceof SqlCounterSpecification) {
            throw new \InvalidArgumentException('This argument must be a SQLCounterSpecification');
        }

        return $this->retrieveAll(
            sprintf(
                'SELECT * FROM %s WHERE %s',
                self::TABLE_NAME,
                $specification->toSqlClauses()
            )
        );
    }

    /**
     * Executes the sql given and returns the result in array of counters.
     *
     * @param string $sql The sql query
     * @param array  $parameters Array which contains the parameters
     *
     * @return array
     */
    private function retrieveAll($sql, array $parameters = [])
    {
        $statement = $this->manager->execute($sql, $parameters);

        return array_map(
            function ($row) {
                return $this->buildCounter($row);
            },
            $statement->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    /**
     * Builds an counter object with the given sql row in array format.
     *
     * @param array $row The sql row in array format
     *
     * @return \OpenCounter\Domain\Model\Counter\Counter
     */
    private function buildCounter(array $row)
    {
        // debug
        //    print_r($row);
        return new Counter(
            new CounterId($row['uuid']),
            new CounterName($row['name']),
            new CounterValue($row['value']),
            $row['status'],
            $row['password']
        );
    }

    /**
     * nextIdentity()
     *
     * {@inheritdoc}
     * @param null $uuid
     *
     * @return \OpenCounter\Domain\Model\Counter\CounterId
     */
    public function nextIdentity($uuid = null)
    {
        return new CounterId($uuid);
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
        return $this->manager
          ->execute(sprintf('SELECT COUNT(*) FROM %s', self::TABLE_NAME))
          ->fetchColumn();
    }

    /**
     * Get a list of all counters
     *
     * @return array
     */
    public function findAll()
    {
        $sql = 'SELECT c.uuid, c.name, c.password, c.value
            from counters c';
        $stmt = $this->manager->query($sql);

        $results = [];
        // TODO: implement get counters in sql
        while ($row = $stmt->fetch()) {
            $results[] = new Counter($row->name());
        }

        return $results;
    }

    /**
     *
     * Get a specific counter by id.
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
     *
     * @return bool|\OpenCounter\Domain\Model\Counter\Counter
     */

    public function getCounterById(CounterId $anId)
    {
        $statement = $this->manager->execute(
            sprintf('SELECT * FROM %s WHERE uuid = :uuid', self::TABLE_NAME),
            ['uuid' => $anId->uuid()]
        );
        if (!$row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        return $this->buildCounter($row);
    }

    /**
     * Get a specific counter by name.
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     *
     * @return bool|\OpenCounter\Domain\Model\Counter\Counter
     */

    public function getCounterByName(CounterName $aName)
    {
        $statement = $this->manager->execute(
            sprintf('SELECT * FROM %s WHERE name = :name', self::TABLE_NAME),
            ['name' => $aName->name()]
        );
        if (!$row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        return $this->buildCounter($row);
    }

    /**
     * save()
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     */
    public function save(Counter $anCounter)
    {
        $this->exist($anCounter) ? $this->update($anCounter) : $this->insert($anCounter);
    }

    /**
     * Checks that the counter given exists into database.
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter The counter
     *
     * @return bool
     */
    public function exist(Counter $anCounter)
    {

        return $this->manager->execute(
            sprintf(
                'SELECT COUNT(*) FROM %s WHERE uuid = :uuid',
                self::TABLE_NAME
            ),
            [':uuid' => $anCounter->getId()]
        )->fetchColumn() == 1;
    }

    /**
     * update()
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     *
     * @return bool
     */
    public function update(Counter $anCounter)
    {
        $update = $this->updateStmt->execute(
            [
            'uuid' => $anCounter->getId(),
            'value' => $anCounter->getValue(),
            'status' => $anCounter->getStatus(),
            'password' => 'passwordplaceholder'
            ]
        );

        return $update;
    }

    /**
     * insert new counter
     * {@inheritdoc}
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     *
     * @return bool
     */
    public function insert(Counter $anCounter)
    {
        $insert = $this->insertStmt->execute(
            [
            'name' => $anCounter->getName(),
            'uuid' => $anCounter->getId(),
            'value' => $anCounter->getValue(),
            'status' => $anCounter->getStatus(),
            'password' => 'passwordplaceholder'
            ]
        );

        return $insert;
    }
}
