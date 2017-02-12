<?php
/**
 * SqlPersistentCounterRepository.
 *
 * a repository for counters using sql.
 */
namespace OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Infrastructure\Persistence\Sql\SqlManager;

/**
 * Class SqlPersistentCounterRepository
 *
 * @package OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter
 */
class SqlPersistentCounterRepository extends SqlCounterRepository implements PersistentCounterRepository
{
    /**
     * The manager
     *
     * @var \OpenCounter\Infrastructure\Persistence\Sql\SqlManager
     */

    protected $manager;

    /**
     * insert statement.
     *
     * @var \PDOStatement
     */

    private $insertStmt;

    /**
     * remove statement.
     *
     * @var \PDOStatement
     */

    private $removeStmt;


    private $removeNamedStmt;

    /**
     * get Statement.
     *
     * @var \PDOStatement
     */

    private $getStmt;

    /**
     * Update statement.
     *
     * @var \PDOStatement
     */

    private $updateStmt;

    /**
     * Constructor.
     *
     * Add prepared statements to be used by our methods.
     *
     * @param \OpenCounter\Infrastructure\Persistence\Sql\SqlManager $manager
     */
    public function __construct(SqlManager $manager)
    {
        $this->manager = $manager;
        $this->removeStmt = $this->manager->prepare(
            sprintf('DELETE FROM %s WHERE uuid = :uuid', self::TABLE_NAME)
        );
        $this->removeNamedStmt = $this->manager->prepare(
          sprintf('DELETE FROM %s WHERE name = :name', self::TABLE_NAME)
        );
        $this->getStmt = $this->manager->prepare(
            sprintf('SELECT * FROM %s WHERE name = :name', self::TABLE_NAME)
        );
        $this->insertStmt = $this->manager->prepare(
            sprintf(
                "INSERT INTO %s (name, uuid, value, status, password) VALUES (:name, :uuid, :value, :status, :password)",
                self::TABLE_NAME
            )
        );
        $this->updateStmt = $this->manager->prepare(
            sprintf(
                'UPDATE %s SET value = :value, status = :status, password = :password WHERE uuid = :uuid',
                self::TABLE_NAME
            )
        );
    }

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


    public function removeCounterByName(CounterName $aName)
    {
        $this->removeNamedStmt->execute(['name' => $aName->name()]);
    }

}
