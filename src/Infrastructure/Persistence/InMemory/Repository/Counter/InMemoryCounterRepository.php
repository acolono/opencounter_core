<?php
/**
 * InMemoryCounterRepository.
 *
 * used during tests when we dont want to test the sql layer.
 */

namespace OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class InMemoryCounterRepository
 *
 * @package OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter
 */
class InMemoryCounterRepository implements CounterRepository
{
  /**
   * @var $counters
   */
    private $counters = [];

  /**
   * InMemoryCounterRepository constructor.
   *
   * Create a few counters we can use during tests.
   *
   * @param array $counters
   */
    public function __construct(array $counters)
    {
        foreach ($counters as $item) {
            $this->save($item);
        }
    }

    public function save(Counter $counter)
    {
        $id = (string) $counter->getId();
        $this->counters[$id] = clone $counter;
        return clone $counter;
    }


    public function find(CounterId $counterId)
    {
    }


    public function findAll()
    {
        return $this->counters;
    }

  /**
   * @inheritDoc
   */
    public function remove(Counter $counter)
    {
        //unset($this->counters[$counter->getId()]);
    }

  /**
   * @inheritDoc
   */
    public function getCounterById(CounterId $anId)
    {
        // TODO: Implement getCounterById() method.
    }

  /**
   * @inheritDoc
   */
    public function getCounterByName(CounterName $aName)
    {
        // TODO: Implement getCounterByName() method.
    }

  /**
   * @inheritDoc
   */
    public function getCounterByUuid(CounterId $anId)
    {
        // TODO: Implement getCounterByUuid() method. unset($this->counters[$anId]);
    }

  /**
   * @inheritDoc
   */
    public function query($specification)
    {
        // TODO: Implement query() method.
    }

  /**
   * @inheritDoc
   */

    public function nextIdentity()
    {
        return new CounterId();
    }

  /**
   * @inheritDoc
   */
    public function size()
    {
        // TODO: Implement size() method.
    }

  /**
   * @inheritDoc
   */
    public function counterOfId(CounterId $anId)
    {
        // TODO: Implement counterOfId() method.
    }

  /**
   * removeCounterByName
   *
   * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
   */
    public function removeCounterByName(CounterName $aName)
    {
        unset($this->counters[$aName->name()]);
    }

  /**
   * removeCounterById
   *
   * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
   * @return bool
   */
    public function removeCounterById(CounterId $anId)
    {
        if (!$this->exists($anId)) {
            return false;
        }

        unset($this->counters[$anId->uuid()]);
        // we are lazy and returning true because we tried removing,
        // TODO: where do we deal with removal of nonexisting counters
        return true;
    }

  /**
   * exists
   *
   * @param \OpenCounter\Domain\Model\Counter\CounterId $counterId
   * @return bool
   */
    public function exists(CounterId $counterId)
    {
        $id = (string) $counterId->uuid();
        return array_key_exists($id, $this->counters);
    }
}
