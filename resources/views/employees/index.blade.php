<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #3156ee;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .logout-btn-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dashboard-link-container {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .create-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .create-button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .action-button {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px;
        }

        .action-button:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="dashboard-link-container">
            <a href="/dashboard" class="create-button">Dashboard</a>
        </div>

        <div class="logout-btn-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <h1>Employee Directory</h1>

        <a href="{{ route('employees.create') }}" class="create-button">Create Employee</a>

        <table id="employees-table" class="display">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employees.index') }}",
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            let viewButton = '<a href="/employees/' + row.id + '" class="action-button">View</a>';
                            let deleteButton = '<button class="delete-btn" data-id="' + row.id + '">Delete</button>';
                            return viewButton + ' ' + deleteButton;
                        }
                    }
                ]
            });
        });

        $(document).on('click', '.delete-btn', function() {
            let employeeId = $(this).data('id');
            let confirmation = confirm('Are you sure you want to delete this employee?');
            
            if (confirmation) {
                $.ajax({
                    url: '/employees/' + employeeId + '/delete', 
                    type: 'POST', 
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert('Employee deleted successfully');
                        $('#employees-table').DataTable().ajax.reload(); 
                    },
                    error: function(response) {
                        alert('Error deleting Employee');
                    }
                });
            }
        });
    </script>
</body>
</html>
