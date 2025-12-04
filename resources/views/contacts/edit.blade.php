<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>

    <a href="{{ route('contacts.index') }}">← Back</a>

    <br><br>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $contact->name) }}" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $contact->email) }}" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
