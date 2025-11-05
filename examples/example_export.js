// Exported from Adminer
// Date: 2025-11-05 14:30:22
// Database driver: mysql

const sqlQuery = `
SELECT 
    u.id,
    u.username,
    u.email,
    u.created_at,
    COUNT(o.id) as order_count,
    SUM(o.total) as total_spent
FROM 
    users u
LEFT JOIN 
    orders o ON u.id = o.user_id
WHERE 
    u.active = 1
    AND u.created_at >= '2024-01-01'
GROUP BY 
    u.id, u.username, u.email, u.created_at
HAVING 
    COUNT(o.id) > 0
ORDER BY 
    total_spent DESC
LIMIT 100
`;

// Execute this query using your preferred database library
// Example: db.query(sqlQuery);

// Node.js with mysql2 example:
// const mysql = require('mysql2/promise');
// const connection = await mysql.createConnection({
//     host: 'localhost',
//     user: 'root',
//     database: 'mydb'
// });
// const [rows] = await connection.execute(sqlQuery);

// Node.js with pg (PostgreSQL) example:
// const { Pool } = require('pg');
// const pool = new Pool();
// const result = await pool.query(sqlQuery);
