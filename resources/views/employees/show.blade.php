<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }

        .form-container label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Edit Employee</h2>

            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name',$employee->first_name ) }}" required>
                </div>
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name',$employee->last_name) }}" required>
                </div>
                <label for="company">Company</label>
                <select id="company" name="company" required>
                    <option value="">Select a Company</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}" 
                        {{ $employee->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                   </option>
                    @endforeach   
                </select>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email',$employee->email) }}">
                </div>

                <div class="form-group">
                    <label for="website">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone',$employee->phone) }}">
                </div>
                <button type="submit">Update Employee</button>
            </form>
        </div>
    </div>
</body>
</html>
