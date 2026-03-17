<!DOCTYPE html>
<html>
<head>
    <title>Admin Contacts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f8f9fa;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #222;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Messages</h1>

        @if($contacts->isEmpty())
            <p>No contact messages found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Issue</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->first_name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->issue }}</td>
                            <td>{{ $contact->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>