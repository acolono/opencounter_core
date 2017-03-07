<?php
/**
 * SqlManagerSpec
 *
 * describe sql manager class
 */
namespace spec\OpenCounter\Infrastructure\Persistence\Sql;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class SqlManagerSpec
 * @package spec\OpenCounter\Infrastructure\Persistence\Sql
 */
class SqlManagerSpec extends ObjectBehavior
{

    const TABLE_NAME = 'counters';
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * @param \PDO|\PhpSpec\Wrapper\Collaborator $db
     */
    function let(\PDO $db)
    {

    //    $this->beConstructedWith('mysql:host=172.17.0.4;dbname=countapp', 'root', 'countapp');
        $this->beConstructedWith($db);
        $this->db = $db;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('OpenCounter\Infrastructure\Persistence\Sql\SqlManager');
        $this->shouldImplement('OpenCounter\Infrastructure\Persistence\StorageInterface');
    }

    function it_establishes_pdo_connection()
    {
        $this->connection()->shouldReturnAnInstanceOf('PDO');
    }
}
