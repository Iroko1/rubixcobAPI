<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>API Dashboard</h2>
    
    <table>
        <tr>
            <th>API Endpoint</th>
            <th>Request Type</th>
            <th>Description</th>
        </tr>
        <?php include 'model/api_endpoints.php'; ?>
    </table>

    <h2>API Requests</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Request Data</th>
            <th>Delete Records</th>
        </tr>
        <?php include 'model/api_requests.php'; ?>
    </table>
</body>
</html>
