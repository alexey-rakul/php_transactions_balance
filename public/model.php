<?php

/**
 * Return list of users with transactions.
 */
function get_users($conn)
{
    $query = "
        SELECT DISTINCT u.id, u.name
        FROM users u
        JOIN user_accounts a ON u.id = a.user_id
        JOIN transactions t ON a.id = t.account_from OR a.id = t.account_to
    ";

    $statement = $conn->prepare($query);
    if (!$statement) {
        throw new Exception("Error preparing request");
    }

    if (!$statement->execute()) {
        throw new Exception("Error executing request");
    }

    $users = [];
    while ($row = $statement->fetch()) {
        $users[$row['id']] = $row['name'];
    }

    return $users;
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{
    $query = "
        SELECT
            strftime('%Y-%m', t.trdate) AS month,
            SUM(CASE 
                WHEN a1.user_id = ? AND a2.user_id != ? THEN -t.amount
                WHEN a2.user_id = ? AND a1.user_id != ? THEN t.amount
                ELSE 0 
            END) AS balance,
            COUNT(t.id) AS transaction_count
        FROM transactions t
        JOIN user_accounts a1 ON t.account_from = a1.id
        JOIN user_accounts a2 ON t.account_to = a2.id
        WHERE (a1.user_id = ? OR a2.user_id = ?)
        GROUP BY month
        ORDER BY month ASC
    ";

    $statement = $conn->prepare($query);
    if (!$statement) {
        throw new Exception("Error preparing request");
    }

    $params = array_fill(0, 6, $user_id);
    if (!$statement->execute($params)) {
        throw new Exception("Error executing request");
    }

    $balances = [];
    while ($row = $statement->fetch()) {
        $balances[] = [
            'month' => $row['month'],
            'balance' => $row['balance'],
            'transaction_count' => $row['transaction_count']
        ];
    }

    return $balances;
}
