<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('/assets/styles.css') }}"> 
    <style>
        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f7f7f7;
        }

        .option {
            margin: 20px;
            padding: 20px;
            width: 200px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .option:hover {
            background-color: #45a049;
        }

        h1 {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome to the Dashboard</h1>

        <a href="{{ route('companies.index') }}" class="option">Manage Companies</a>
        <a href="{{ route('employees.index') }}" class="option">Manage Employees</a>
    </div>
</body>
</html>
