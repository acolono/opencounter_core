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
use Symfony\Component\Validator\Constraints\All;

/**
 * Class InMemoryCounterRepository
 *
 * @package OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter
 */
class InMemoryCounterRepository implements CounterRepository
{
    /**
     * Array of in-memory counters
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

    /**
     * save()
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\Counter $counter
     *
     * @return \OpenCounter\Domain\Model\Counter\Counter
     */
    public function save(Counter $counter)
    {
        $id = (string)$counter->getId();
        $this->counters[$id] = clone $counter;

        return clone $counter;
    }

    /**
     * find()
     *
     * {@inheritdoc}
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $counterId
     */
    public function find(CounterId $counterId)
    {
    }

    /**
     * findAll()
     *
     * {@inheritdoc}
     * @return array
     */
    public function findAll()
    {
        return $this->counters;
    }

    /**
     * remove
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\Counter $counter
     */
    public function remove(Counter $counter)
    {
        unset($this->counters[$counter->getId()]);
    }

    /**
     * getCounterById()
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
     *
     * @return mixed
     */
    public function getCounterById(CounterId $anId)
    {
        if (isset($this->counters[$anId->uuid()])) {
            return $this->counters[$anId->uuid()];
        }
    }

    /**
     * getCounterByName
     *
     * {@inheritdoc}
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     *
     * @return mixed
     */
    public function getCounterByName(CounterName $aName)
    {

        foreach ($this->counters as $counter) {
            if ($counter->getName() === $aName->name()) {
                return $counter;
            }
        }
    }

    /**
     * Next Identity
     *
     * use given id if available otherwise generate.
     * 
     * {@inheritdoc}
     * @param $id
     * @return CounterId
     */

    public function nextIdentity($id)
    {
        return new CounterId();
    }

    /**
     * size()
     *
     * {@inheritdoc}
     * @return int
     */
    public function size()
    {
        return count($this->counters);
    }

    /**
     * removeCounterByName
     * {@inheritdoc}
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     */
    public function removeCounterByName(CounterName $aName)
    {
        unset($this->counters[$aName->name()]);
    }

    /**
     * removeCounterById
     * {@inheritdoc}
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
     *
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
     * {@inheritdoc}
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $counterId
     *
     * @return bool
     */
    public function exists(CounterId $counterId)
    {
        $id = (string)$counterId->uuid();

        return array_key_exists($id, $this->counters);
    }
}
