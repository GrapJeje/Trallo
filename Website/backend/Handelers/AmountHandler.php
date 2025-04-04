<?php

namespace Website\backend\Handelers;

class AmountHandler
{
    public function getNewAmount($amount)
    {
        require __DIR__ . "/../conn.php";
        global $conn;

        $query = "SELECT * FROM planning_board";
        $statement = $conn->prepare($query);
        $statement->execute();

        $todos = $statement->fetchAll(PDO::FETCH_ASSOC);

        $filteredTodos = array_filter($todos, function ($todo) {
            return $todo['user_id'] == $_SESSION['user_id'];
        });

        $maxAmount = count($filteredTodos);

        $amount += 5;
        if ($amount > $maxAmount) {
            $amount = $maxAmount;
        }

        return $amount;
    }

    function formatDate($inputDate)
    {
        $months = [
            'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni',
            'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'
        ];

        list($year, $month, $day) = explode('-', $inputDate);
        return (int)$day . ' ' . $months[(int)$month - 1] . ' ' . $year;
    }
}