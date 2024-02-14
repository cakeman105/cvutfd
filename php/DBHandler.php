<?php
/**
 * Class for handling database connections
 *
 * This class is responsible for database connections and associated tasks
 * @author Joshua David Crofts
 * @note MYSQL only!
 * @note Check the self::connection init string before starting to prevent invalid html!
 */
class DBHandler
{
    /**
     * Object used for db tasks
     */
    static private ?PDO $connection;

    public function __construct()
    {
        self::Connect();
    }

    /**
     * Initialize a connection to a db server
     * @return void
     */
    private function Connect(): void
    {
        try
        {
            self::$connection = new PDO("mysql:host=localhost;dbname=croftjos", "croftjos", "webove aplikace");
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
        }
    }

    /**
     * Inserts a new entry into the table
     * @param string $values
     * @param array $realValues
     * @return void
     */
    function InsertIntoTable(string $values, array $realValues) : void
    {
        $stmt = self::$connection -> prepare("INSERT INTO $values");
        $stmt -> execute($realValues);
    }

    /**
     * Runs an update set query on a user profile in the database
     * @param string $tablename
     * @param string $columnname
     * @param array $values
     * @param string $idColumn
     * @return void
     */
    function UpdateEntry(string $tablename, string $columnname, array $values, string $idColumn): void
    {
        $stmt = self::$connection -> prepare("UPDATE $tablename SET $columnname = ? WHERE $idColumn = ?");
        $stmt -> execute($values);
    }

    /**
     * Executes SQL that requires no passed params
     * @param string $sql
     * @param bool $fetchAll
     * @return array|null
     */
    function ExecuteNoParamSQL(string $sql, bool $fetchAll) : ?array
    {
        $stmt = self::$connection -> prepare($sql);
        $stmt -> execute();
        return $fetchAll ? $stmt -> fetchAll(PDO::FETCH_ASSOC) : $stmt -> fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets entries from table with specified offset
     * @param string $tablename
     * @param string $offset
     * @param string $order
     * @param int $limit
     * @return array
     */
    function GetEntriesWithLimit(string $tablename, string $offset, string $order, int $limit) : array
    {
        $stmt = self::$connection -> prepare("SELECT * FROM $tablename ORDER BY $order LIMIT $limit OFFSET :offset");
	$stmt -> bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns the count of a specified table
     * @param string $tableName
     * @return int|null
     */
    function GetDbCount(string $tableName): ?int
    {
        $stmt = self::$connection -> prepare("SELECT COUNT(*) AS Count FROM $tableName");
        $stmt -> execute();

        return $stmt -> fetch(PDO::FETCH_ASSOC)['Count'];
    }

    /**
     * Returns a result with the corresponding ID
     * @param string $tablename
     * @param string $value
     * @param string $columnname
     * @param bool $fetchAll
     * @param string $joinClause
     * @return array|null
     */
    function GetEntryOnId(string $tablename, string $value, string $columnname, bool $fetchAll, string $joinClause = "", string $orderByLimit = "") : mixed
    {
        $stmt = self::$connection -> prepare("SELECT * FROM $tablename $joinClause WHERE $columnname=? $orderByLimit");
        $stmt -> execute([$value]);

        return $fetchAll ? $stmt -> fetchAll(PDO::FETCH_ASSOC) : $stmt -> fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Closes the database connection
     * @return void
     */
    function Close() : void
    {
        self::$connection = null;
    }
}
