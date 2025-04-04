<?php
namespace Website\backend\Handlers;

class AmountHandler
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getTotalUserTodos($userId)
    {
        $query = "SELECT COUNT(*) as total FROM planning_board WHERE user_id = :user_id";
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public function getNewAmount($currentAmount, $userId)
    {
        $totalTodos = $this->getTotalUserTodos($userId);
        $newAmount = $currentAmount + 5;

        return ($newAmount > $totalTodos) ? $totalTodos : $newAmount;
    }

    public function formatDate($inputDate)
    {
        $months = [
            'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni',
            'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'
        ];

        list($year, $month, $day) = explode('-', $inputDate);
        return (int)$day . ' ' . $months[(int)$month - 1] . ' ' . $year;
    }
}