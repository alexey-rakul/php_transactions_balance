PHP sandbox
===========

#### Database structure:
- `users` contains user data;
- `user_accounts` contains a list of user accounts, where each user can have several accounts;
- `transactions` contains information about the transfer of funds from one account to another. Transactions can be between accounts of different users, as well as between different accounts of the same user.

#### Task:
Implement with PHP the display of payment statistics for the selected user by month.
Payment statistics should contain the following information:
- `Monthly balance` - the sum of all incoming transactions on all user accounts minus the sum of all outgoing transactions on all user accounts for a calendar month;
- `Number of transactions` - the total number of transactions on all user accounts for a calendar month.

#### Appearance:
The user should be selected from a drop-down list.
This list should only display those users who have transactions.
The result should be displayed as a table:

| Month   | Balance | Count |
|---------|---------|-------|
| January |   000   |   0   |

#### Requirements:
- Requests without page reloading (AJAX);
- Without frameworks;
- Clean code with comments;
- Use only SQL queries (not loops in the code) to calculate statistics.
